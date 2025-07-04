<?php

namespace App\Http\Controllers\Admin2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pendaftaran;
use App\Models\Attendance;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RekapAbsensiExport;

class RekapAbsensi2Controller extends Controller
{
    public function __construct()
    {
        // Middleware untuk memastikan hanya admin yang bisa mengakses
        $this->middleware('auth:admin');
        $this->middleware(function ($request, $next) {
            if (auth('admin')->user()->role !== 'admin2') {
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

        // Hitung jumlah hari dalam bulan tersebut
        $totalDays = Carbon::createFromDate($tahun, $bulan)->daysInMonth;

        // Query untuk mendapatkan peserta magang dengan direktorat dan status yang diinginkan
        $query = Pendaftaran::where('direktorat', 'Direktorat Jenderal Perlindungan dan Jaminan Sosial')
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
            "Direktorat Jaminan Sosial",
            "Direktorat Perlindungan Sosial Non Kebencanaan",
            "Direktorat Perlindungan Sosial Korban Bencana"
        ];
        
        $unit_kerja = Pendaftaran::where('direktorat', 'Direktorat Jenderal Perlindungan dan Jaminan Sosial')
                     ->whereIn('unit_kerja', $sekjen_units)
                     ->distinct()
                     ->pluck('unit_kerja');
        
        $pesertaAbsensi = $query->get();

        // Hitung total untuk setiap status absensi
        $totalHadir = 0;
        $totalSakit = 0;
        $totalIzin = 0;
        $totalTerlambat = 0;

        foreach ($pesertaAbsensi as $peserta) {
            $totalHadir += $peserta->attendances->where('status', 'hadir')->count();
            $totalSakit += $peserta->attendances->where('status', 'sakit')->count();
            $totalIzin += $peserta->attendances->where('status', 'izin')->count();
            $totalTerlambat += $peserta->attendances->where('status', 'terlambat')->count();
        }

        return view('admin2.rekap_absensi2', compact(
            'pesertaAbsensi',
            'totalDays',
            'tahun',
            'bulan',
            'totalHadir',
            'totalSakit',
            'totalIzin',
            'totalTerlambat',
            'unit_kerja'
        ));
    }

    public function exportExcel(Request $request)
    {
        $filterDate = $request->bulan ?? date('Y-m');
        $direktorat = 'Direktorat Jenderal Perlindungan dan Jaminan Sosial';

        list($tahun, $bulan) = explode('-', $filterDate);
        $bulanNama = Carbon::createFromDate($tahun, $bulan, 1)->locale('id')->isoFormat('MMMM YYYY');

        $fileName = 'RekapitulasiAbsensi' . $bulanNama;
        $fileName .= '_' . str_replace(' ', '', $direktorat);
        $fileName .= '.xlsx';

        return Excel::download(new RekapAbsensiExport($tahun, $bulan, $direktorat), $fileName);
    }
}