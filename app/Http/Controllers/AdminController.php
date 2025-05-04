<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
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
        $this->middleware(function ($request, $next) {
            if (auth('admin')->user()->role !== 'admin') {
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

            // 1. Total Peserta Magang yang Diterima
            $totalPeserta = Pendaftaran::where('status', 'diterima')->count();

            // 2. Total Absensi Hari Ini untuk Peserta Diterima
            $today = Carbon::today()->format('Y-m-d');
            $totalAbsensiHariIni = Attendance::whereDate('date', $today)
                ->whereHas('pendaftaran', function($query) {
                    $query->where('status', 'diterima');
                })
                ->count();

            // 3. Total Laporan untuk Peserta Diterima
            $totalLaporan = Laporan::whereHas('pendaftaran', function($query) {
                    $query->where('status', 'diterima');
                })
                ->count();

            // 4. Total Admin
            $totalAdmin = Admin::count();

            // Ambil aktivitas terbaru
            $recentActivities = $this->getRecentActivities();
                
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

    private function getRecentActivities()
    {
        // Aktivitas check-in
        $checkInActivities = Attendance::select(
                DB::raw("CONCAT(attendances.date, ' ', attendances.check_in_time) as tanggal"),
                'pendaftaran.nama_lengkap as nama',
                'pendaftaran.direktorat as direktorat',
                DB::raw("'Absensi' as jenis"),
                DB::raw("'Melakukan check in' as aktivitas"),
                'attendances.status as status'
            )
            ->join('pendaftaran', 'pendaftaran.id', '=', 'attendances.user_id')
            ->where('pendaftaran.status', 'diterima')
            ->whereNotNull('attendances.check_in_time')
            ->orderBy('attendances.date', 'desc')
            ->orderBy('attendances.check_in_time', 'desc');
        
        // Aktivitas check-out
        $checkOutActivities = Attendance::select(
                DB::raw("CONCAT(attendances.date, ' ', attendances.check_out_time) as tanggal"),
                'pendaftaran.nama_lengkap as nama',
                'pendaftaran.direktorat as direktorat',
                DB::raw("'Absensi' as jenis"),
                DB::raw("'Melakukan check out' as aktivitas"),
                'attendances.status as status'
            )
            ->join('pendaftaran', 'pendaftaran.id', '=', 'attendances.user_id')
            ->where('pendaftaran.status', 'diterima')
            ->whereNotNull('attendances.check_out_time')
            ->orderBy('attendances.date', 'desc')
            ->orderBy('attendances.check_out_time', 'desc');
            
        // Aktivitas izin/sakit
        $permissionActivities = Attendance::select(
                'attendances.date as tanggal',
                'pendaftaran.nama_lengkap as nama',
                'pendaftaran.direktorat as direktorat',
                DB::raw("'Absensi' as jenis"),
                DB::raw("'Mengajukan izin/sakit' as aktivitas"),
                'attendances.status as status'
            )
            ->join('pendaftaran', 'pendaftaran.id', '=', 'attendances.user_id')
            ->where('pendaftaran.status', 'diterima')
            ->whereNull('attendances.check_in_time')
            ->orderBy('attendances.date', 'desc');
            
        // Aktivitas laporan
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
            ->orderBy('laporan.created_at', 'desc');
            
        // Gabungkan dan ambil 10 aktivitas terbaru
        $activities = $checkInActivities
            ->union($checkOutActivities)
            ->union($permissionActivities)
            ->union($laporanActivities)
            ->orderBy('tanggal', 'desc')
            ->limit(10)
            ->get();
            
        return $activities;
    }
}