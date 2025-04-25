<?php

namespace App\Http\Controllers\Pimpinans;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RekapAbsensiExport;

class AbsensiPimpinanController extends Controller
{

    public function __construct()
{
    // Menggunakan guard admin tapi memeriksa role pimpinan
    $this->middleware('auth:admin');
    $this->middleware(function ($request, $next) {
        if (auth('admin')->user()->role !== 'pimpinan') {
            abort(403, 'Unauthorized');
        }
        return $next($request);
    });
}
    public function index(Request $request)
    {
        // Set default ke bulan dan tahun sekarang jika tidak ada filter
        $filterDate = $request->bulan ?? date('Y-m');
        $direktorat = $request->direktorat;

        list($tahun, $bulan) = explode('-', $filterDate);

        // Hitung jumlah hari dalam bulan tersebut
        $totalDays = Carbon::createFromDate($tahun, $bulan)->daysInMonth;

        // Query untuk mendapatkan peserta magang dengan status diterima
        $query = Pendaftaran::where('status', 'diterima')
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
        
        // Filter berdasarkan direktorat
        if ($request->has('direktorat') && $request->direktorat) {
            $query->where('direktorat', $request->direktorat);
        }
        
        
        // Dapatkan list direktorat untuk filter
        $direktorat = Pendaftaran::distinct('direktorat')->pluck('direktorat');
        

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

        return view('pimpinan.absensi_pimpinan', compact(
            'pesertaAbsensi',
            'totalDays',
            'tahun',
            'bulan',
            'totalHadir',
            'totalSakit',
            'totalIzin',
            'totalTerlambat',
            'direktorat'
        ));
    }

    public function exportExcel(Request $request)
    {
        $filterDate = $request->bulan ?? date('Y-m');
        $direktorat = $request->direktorat;

        list($tahun, $bulan) = explode('-', $filterDate);
        $bulanNama = Carbon::createFromDate($tahun, $bulan, 1)->locale('id')->isoFormat('MMMM YYYY');

        $fileName = 'RekapitulasiAbsensi' . $bulanNama;
        if ($direktorat) {
            $fileName .= '_' . str_replace(' ', '', $direktorat);
        }
        $fileName .= '.xlsx';

        return Excel::download(new RekapAbsensiExport($tahun, $bulan, $direktorat), $fileName);
    }
}