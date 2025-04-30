<?php

namespace App\Http\Controllers\Admin5;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pendaftaran;
use App\Models\Attendance;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RekapAbsensiExport;

class RekapAbsensi5Controller extends Controller
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

        // Hitung jumlah hari dalam bulan tersebut
        $totalDays = Carbon::createFromDate($tahun, $bulan)->daysInMonth;

        // Query untuk mendapatkan peserta magang dengan direktorat dan status yang diinginkan
        $query = Pendaftaran::where('direktorat', 'Inspektorat Jenderal')
                           ->whereIn('status', ['diterima', 'selesai'])
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

        return view('admin5.rekap_absensi5', compact(
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
        $direktorat = 'Inspektorat Jenderal';

        list($tahun, $bulan) = explode('-', $filterDate);
        $bulanNama = Carbon::createFromDate($tahun, $bulan, 1)->locale('id')->isoFormat('MMMM YYYY');

        $fileName = 'RekapitulasiAbsensi' . $bulanNama;
        $fileName .= '_' . str_replace(' ', '', $direktorat);
        $fileName .= '.xlsx';

        return Excel::download(new RekapAbsensiExport($tahun, $bulan, $direktorat), $fileName);
    }
}