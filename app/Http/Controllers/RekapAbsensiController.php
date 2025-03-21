<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pendaftaran;
use App\Models\Attendance;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RekapAbsensiExport;

class RekapAbsensiController extends Controller
{
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

        // Filter berdasarkan direktorat jika ada
        if ($direktorat) {
            $query->where('direktorat', $direktorat);
        }

        $pesertaAbsensi = $query->get();

        // Hitung total untuk setiap status absensi
        $totalHadir = 0;
        $totalSakit = 0;
        $totalIzin = 0;
        $totalAlpha = 0;

        foreach ($pesertaAbsensi as $peserta) {
            $totalHadir += $peserta->attendances->where('status', 'H')->count();
            $totalSakit += $peserta->attendances->where('status', 'S')->count();
            $totalIzin += $peserta->attendances->where('status', 'I')->count();
            $totalAlpha += $peserta->attendances->where('status', 'A')->count();
        }

        return view('admin.rekap_absensi', compact(
            'pesertaAbsensi',
            'totalDays',
            'tahun',
            'bulan',
            'totalHadir',
            'totalSakit',
            'totalIzin',
            'totalAlpha'
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