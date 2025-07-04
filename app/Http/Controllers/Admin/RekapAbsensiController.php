<?php

namespace App\Http\Controllers\Admin;

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

    public function __construct()
    {
        // Middleware untuk memastikan hanya admin yang bisa mengakses
        $this->middleware('auth:admin');
        $this->middleware(function ($request, $next) {
        if (auth('admin')->user()->role !== 'admin') {
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
        $query = Pendaftaran::whereIn('status', ['diterima', 'selesai'])
              // Filter tanggal mulai: sudah mulai sebelum atau pada bulan yang dipilih
              ->where(function($q) use ($tahun, $bulan) {
                  $q->whereYear('tanggal_mulai', '<', $tahun)
                    ->orWhere(function($q2) use ($tahun, $bulan) {
                        $q2->whereYear('tanggal_mulai', '=', $tahun)
                           ->whereMonth('tanggal_mulai', '<=', $bulan);
                    });
              })
              // Filter tanggal selesai: belum selesai atau selesai setelah bulan yang dipilih
              ->where(function($q) use ($tahun, $bulan) {
                  $q->whereNull('tanggal_selesai') // Belum ada tanggal selesai
                    ->orWhereYear('tanggal_selesai', '>', $tahun) // Selesai di tahun setelah tahun yang dipilih
                    ->orWhere(function($q2) use ($tahun, $bulan) {
                        $q2->whereYear('tanggal_selesai', '=', $tahun)
                           ->whereMonth('tanggal_selesai', '>=', $bulan); // Selesai di bulan yang sama atau setelah bulan yang dipilih
                    });
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

        return view('admin.rekap_absensi', compact(
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