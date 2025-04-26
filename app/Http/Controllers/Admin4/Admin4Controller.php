<?php

namespace App\Http\Controllers\Admin4;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\Pendaftaran;
use App\Models\Attendance;
use App\Models\Laporan;
use App\Models\Admin;
use Carbon\Carbon;

class admin4Controller extends Controller
{
    public function __construct()
    {
        // Middleware untuk memastikan hanya admin yang bisa mengakses
        $this->middleware('auth:admin');
        $this->middleware(function ($request, $next) {
            if (auth('admin')->user()->role !== 'admin4') {
                abort(403, 'Unauthorized');
            }
            return $next($request);
        });
    }

    public function index()
{
    try {
        // Log aktivitas admin
        Log::info('Admin mengakses dashboard', [
            'admin_id' => Auth::guard('admin')->id(),
            'admin_username' => Auth::guard('admin')->user()->username
        ]);

        // 1. Total Peserta Magang yang Diterima (hanya dari Direktorat Jenderal Pemberdayaan Sosial)
        $totalPeserta = Pendaftaran::where('status', 'diterima')
            ->where('direktorat', 'Direktorat Jenderal Pemberdayaan Sosial')
            ->count();

        // 2. Total Absensi Hari Ini untuk Peserta Diterima dari Direktorat Jenderal Pemberdayaan Sosial
        $today = Carbon::today()->format('Y-m-d');
        $totalAbsensiHariIni = Attendance::whereDate('date', $today)
            ->whereHas('pendaftaran', function($query) {
                $query->where('status', 'diterima')
                      ->where('direktorat', 'Direktorat Jenderal Pemberdayaan Sosial');
            })
            ->count();

        // 3. Total Laporan untuk Peserta Diterima dari Direktorat Jenderal Pemberdayaan Sosial
        $totalLaporan = Laporan::whereHas('pendaftaran', function($query) {
                $query->where('status', 'diterima')
                      ->where('direktorat', 'Direktorat Jenderal Pemberdayaan Sosial');
            })
            ->count();

        // 4. Total Admin
        $totalAdmin = Admin::count();

        // Ambil aktivitas terbaru (hanya dari Direktorat Jenderal Pemberdayaan Sosial)
        $recentActivities = $this->getRecentActivities();
            
        return view('admin4.admin4', compact(
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

private function getRecentActivities()
{
    // Gabungkan aktivitas dari absensi dan laporan (hanya dari Direktorat Jenderal Pemberdayaan Sosial)
    $absensiActivities = Attendance::select(
            'attendances.date as tanggal',
            'pendaftaran.nama_lengkap as nama',
            'pendaftaran.direktorat as direktorat',
            DB::raw("'Absensi' as jenis"),
            DB::raw("CASE 
                WHEN attendances.check_in_time IS NOT NULL THEN 'Melakukan check in' 
                ELSE 'Mengajukan izin/sakit' 
            END as aktivitas"),
            'attendances.status as status'
        )
        ->join('pendaftaran', 'pendaftaran.id', '=', 'attendances.user_id')
        ->where('pendaftaran.status', 'diterima')
        ->where('pendaftaran.direktorat', 'Direktorat Jenderal Pemberdayaan Sosial')
        ->orderBy('attendances.date', 'desc');
        
    $laporanActivities = Laporan::select(
            'laporan.created_at as tanggal',
            'pendaftaran.nama_lengkap as nama',
            'pendaftaran.direktorat as direktorat',
            DB::raw("'Laporan' as jenis"),
            DB::raw("CONCAT('Mengumpulkan laporan ', laporan.jenis_laporan) as aktivitas"),
            'laporan.status as status'
        )
        ->join('pendaftaran', 'pendaftaran.id', '=', 'laporan.user_id')
        ->where('pendaftaran.status', 'diterima')
        ->where('pendaftaran.direktorat', 'Direktorat Jenderal Pemberdayaan Sosial')
        ->orderBy('laporan.created_at', 'desc');
        
    // Gabungkan dan ambil 10 aktivitas terbaru
    $activities = $absensiActivities->union($laporanActivities)
        ->orderBy('tanggal', 'desc')
        ->limit(10)
        ->get();
        
    return $activities;
}
}