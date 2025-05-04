<?php

namespace App\Http\Controllers\Pimpinans;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use App\Models\Attendance;
use App\Models\Laporan;
use App\Models\Admin;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PimpinanController extends Controller
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
    public function index()
    {
        // Hitung total peserta magang yang diterima
        $totalPeserta = Pendaftaran::where('status', 'diterima')->count();
        
        // Hitung total absensi hari ini
        $today = Carbon::today()->format('Y-m-d');
        $totalAbsensiHariIni = Attendance::whereDate('date', $today)
            ->whereHas('pendaftaran', function($query) {
                $query->where('status', 'diterima');
            })
            ->count();
        
        // Hitung total laporan
        $totalLaporan = Laporan::whereHas('pendaftaran', function($query) {
                $query->where('status', 'diterima');
            })
            ->count();
        
        // Hitung total admin
        $totalAdmin = Admin::count();
        
        // Ambil aktivitas terbaru
        $recentActivities = $this->getRecentActivities();
        
        return view('pimpinan.pimpinan', compact(
            'totalPeserta', 
            'totalAbsensiHariIni', 
            'totalLaporan', 
            'totalAdmin',
            'recentActivities'
        ));
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