<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Pendaftaran;
use App\Models\Attendance;
use App\Models\Laporan;
use App\Models\Admin;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function __construct()
    {
        // Middleware untuk memastikan hanya admin yang bisa mengakses
        $this->middleware('auth:admin');
    }

    public function index()
    {
        try {
            // Log aktivitas admin
            Log::info('Admin mengakses dashboard', [
                'admin_id' => Auth::guard('admin')->id(),
                'admin_username' => Auth::guard('admin')->user()->username
            ]);

            // 1. Total Peserta Magang yang Diterima
            $totalPeserta = Pendaftaran::where('status', 'diterima')->count();

            // 2. Total Absensi Hari Ini untuk Peserta Diterima
            $totalAbsensiHariIni = Attendance::whereHas('pendaftaran', function($query) {
                $query->where('status', 'diterima');
            })
            ->whereDate('date', Carbon::today())
            ->count();

            // 3. Total Laporan Bulan Ini untuk Peserta Diterima
            $totalLaporan = Laporan::whereHas('pendaftaran', function($query) {
                $query->where('status', 'diterima');
            })
            ->whereMonth('created_at', Carbon::now()->month)
            ->count();

            // 4. Total Admin
            $totalAdmin = Admin::count();

            $recentActivities = collect(); // Inisialisasi collection kosong

// Ambil data absensi
$attendanceActivities = Attendance::with('pendaftaran')
    ->whereHas('pendaftaran', function($query) {
        $query->where('status', 'diterima');
    })
    ->orderBy('created_at', 'desc')
    ->take(5)
    ->get()
    ->map(function($activity) {
        return (object)[
            'tanggal' => $activity->created_at,
            'nama' => $activity->pendaftaran->nama_lengkap,
            'aktivitas' => 'Absensi',
            'status' => $activity->status ?? 'Hadir'
        ];
    });

// Ambil data laporan
$reportActivities = Laporan::with('pendaftaran')
    ->whereHas('pendaftaran', function($query) {
        $query->where('status', 'diterima');
    })
    ->orderBy('created_at', 'desc')
    ->take(5)
    ->get()
    ->map(function($report) {
        return (object)[
            'tanggal' => $report->created_at,
            'nama' => $report->pendaftaran->nama_lengkap,
            'aktivitas' => $report->jenis_laporan, // Misalnya "Laporan Bulanan" atau "Laporan Akhir"
            'status' => $report->status ?? 'Menunggu'
        ];
        
    });


// Gabungkan kedua aktivitas dan urutkan berdasarkan tanggal terbaru
$recentActivities = $attendanceActivities->merge($reportActivities)
    ->sortByDesc('tanggal')
    ->take(5);
                
            return view('admin.admin', compact(
                'totalPeserta',
                'totalAbsensiHariIni', 
                'totalLaporan',
                'totalAdmin',
                'recentActivities'
            ));

        } catch (\Exception $e) {
            // Catat error untuk debugging
            Log::error('Kesalahan di dashboard admin:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan saat memuat halaman admin');
        }
    }
}