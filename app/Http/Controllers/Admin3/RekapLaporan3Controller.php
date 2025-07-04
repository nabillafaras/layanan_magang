<?php

namespace App\Http\Controllers\Admin3;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pendaftaran;
use App\Models\Laporan;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Exports\RekapLaporanExport;
use Maatwebsite\Excel\Facades\Excel;

class RekapLaporan3Controller extends Controller
{
    public function __construct()
    {
        // Middleware untuk memastikan hanya admin yang bisa mengakses
        $this->middleware('auth:admin');
        $this->middleware(function ($request, $next) {
            if (auth('admin')->user()->role !== 'admin3') {
                abort(403, 'Unauthorized');
            }
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        // Set default ke bulan dan tahun sekarang jika tidak ada filter
        $filterDate = $request->bulan ?? date('Y-m');

        list($tahun, $bulan) = explode('-', $filterDate);
        $bulanNama = Carbon::createFromDate($tahun, $bulan, 1)->locale('id')->isoFormat('MMMM YYYY');

        // Query untuk mendapatkan peserta magang dengan direktorat dan status yang diinginkan
        $query = Pendaftaran::where('direktorat', 'Direktorat Jenderal Rehabilitasi Sosial')
                           ->whereIn('status', ['diterima', 'selesai'])
                   // Peserta sudah mulai magang sebelum akhir bulan yang dipilih
                   ->where('tanggal_mulai', '<=', Carbon::createFromDate($tahun, $bulan)->endOfMonth())
                   // Peserta belum selesai ATAU selesai setelah awal bulan yang dipilih
                   ->where(function($q) use ($tahun, $bulan) {
                       $q->whereNull('tanggal_selesai')
                         ->orWhere('tanggal_selesai', '>=', Carbon::createFromDate($tahun, $bulan)->startOfMonth());
                   })
                   ->with(['attendances' => function($query) use ($tahun, $bulan) {
                       $query->whereYear('date', $tahun)
                             ->whereMonth('date', $bulan);
                   }]);

        // Filter berdasarkan pencarian
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nomor_pendaftaran', 'like', "%{$search}%")
                  ->orWhere('asal_universitas', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan unit kerja
        if ($request->has('unit_kerja') && $request->unit_kerja) {
            $query->where('unit_kerja', $request->unit_kerja);
        }
        
        $sekjen_units = [
            "Sekretariat Direktorat Jenderal",
        "Direktorat Rehabilitasi Sosial Anak",
        "Direktorat Rehabilitasi Sosial Penyandang Disabilitas",
        "Direktorat Rehabilitasi Sosial Tuna Sosial dan Korban Perdagangan Orang",
        "Direktorat Rehabilitasi Sosial Korban Penyalahgunaan Napza, Psikotropika, Zat Adiktif Lainnya, dan ODHA (HIV)",
        "Direktorat Rehabilitasi Sosial Lanjut Usia"
        ];
        
        $unit_kerja = Pendaftaran::where('direktorat', 'Direktorat Jenderal Rehabilitasi Sosial')
                     ->whereIn('unit_kerja', $sekjen_units)
                     ->distinct()
                     ->pluck('unit_kerja');
        
        $peserta = $query->get();
        
        // Mendapatkan laporan bulanan dan akhir untuk setiap peserta
        foreach ($peserta as $p) {
            // Laporan bulanan pada periode bulan yang dipilih
            $p->laporan_bulanan = Laporan::where('user_id', $p->id)
                                    ->where('jenis_laporan', 'bulanan')
                                    ->whereRaw("DATE_FORMAT(periode_bulan, '%Y-%m') = ?", [$filterDate])
                                    ->first();
                                    
            // Laporan akhir (tidak perlu filter bulan untuk laporan akhir)
            $p->laporan_akhir = Laporan::where('user_id', $p->id)
                                 ->where('jenis_laporan', 'akhir')
                                 ->first();
        }

        // Hitung total status laporan - penting untuk tampilan dan statistik
        $totalPeserta = count($peserta);
        $totalBulananMenunggu = 0;
        $totalBulananAcc = 0;
        $totalBulananDitolak = 0;
        $totalBulananBelum = 0;
        
        $totalAkhirMenunggu = 0;
        $totalAkhirAcc = 0;
        $totalAkhirDitolak = 0;
        $totalAkhirBelum = 0;

        foreach ($peserta as $p) {
            // Hitung status laporan bulanan
            if ($p->laporan_bulanan) {
                if ($p->laporan_bulanan->status == 'Menunggu') {
                    $totalBulananMenunggu++;
                } elseif ($p->laporan_bulanan->status == 'Acc') {
                    $totalBulananAcc++;
                } elseif ($p->laporan_bulanan->status == 'Ditolak') {
                    $totalBulananDitolak++;
                }
            } else {
                $totalBulananBelum++;
            }
            
            // Hitung status laporan akhir
            if ($p->laporan_akhir) {
                if ($p->laporan_akhir->status == 'Menunggu') {
                    $totalAkhirMenunggu++;
                } elseif ($p->laporan_akhir->status == 'Acc') {
                    $totalAkhirAcc++;
                } elseif ($p->laporan_akhir->status == 'Ditolak') {
                    $totalAkhirDitolak++;
                }
            } else {
                $totalAkhirBelum++;
            }
        }

        return view('admin3.rekap_laporan3', compact(
            'peserta',
            'tahun',
            'bulan',
            'bulanNama',
            'unit_kerja',
            'totalPeserta',
            'totalBulananMenunggu',
            'totalBulananAcc',
            'totalBulananDitolak',
            'totalBulananBelum',
            'totalAkhirMenunggu',
            'totalAkhirAcc',
            'totalAkhirDitolak',
            'totalAkhirBelum'
        ));
    }

    public function exportExcel(Request $request)
    {
        $filterDate = $request->bulan ?? date('Y-m');
        $direktorat = 'Direktorat Jenderal Rehabilitasi Sosial';

        list($tahun, $bulan) = explode('-', $filterDate);
        $bulanNama = Carbon::createFromDate($tahun, $bulan, 1)->locale('id')->isoFormat('MMMM YYYY');

        $fileName = 'RekapitulasiLaporan_' . $bulanNama;
        $fileName .= '_' . str_replace(' ', '', $direktorat);
        $fileName .= '.xlsx';

        return Excel::download(new RekapLaporanExport($tahun, $bulan, $direktorat), $fileName);
    }
}