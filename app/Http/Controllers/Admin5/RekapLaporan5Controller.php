<?php

namespace App\Http\Controllers\Admin5;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pendaftaran;
use App\Models\Laporan;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Exports\RekapLaporanExport;
use Maatwebsite\Excel\Facades\Excel;

class RekapLaporan5Controller extends Controller
{
    public function __construct()
    {
        // Middleware untuk memastikan hanya admin yang bisa mengakses
        $this->middleware('auth:admin');
        $this->middleware(function ($request, $next) {
            if (auth('admin')->user()->role !== 'admin5') {
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
        $query = Pendaftaran::where('direktorat', 'Inspektorat Jenderal')
                           ->where('status', 'diterima')
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
            "Sekretariat Inspektorat Jenderal",
        "Inspektorat Bidang Investigasi",
        "Inspektorat Bidang Perlindungan dan Jaminan Sosial",
        "Inspektorat Bidang Rehabilitasi Sosial",
        "Inspektorat Bidang Pemberdayaan Sosial",
        "Inspektorat Bidang Penunjang"
        ];
        
        $unit_kerja = Pendaftaran::where('direktorat', 'Inspektorat Jenderal')
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

        return view('admin5.rekap_laporan5', compact(
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
        $direktorat = 'Inspektorat Jenderal';

        list($tahun, $bulan) = explode('-', $filterDate);
        $bulanNama = Carbon::createFromDate($tahun, $bulan, 1)->locale('id')->isoFormat('MMMM YYYY');

        $fileName = 'RekapitulasiLaporan_' . $bulanNama;
        $fileName .= '_' . str_replace(' ', '', $direktorat);
        $fileName .= '.xlsx';

        return Excel::download(new RekapLaporanExport($tahun, $bulan, $direktorat), $fileName);
    }
}