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
        // Gabungkan aktivitas dari absensi dan laporan
        $absensiActivities = Attendance::select(
                'attendances.date as tanggal',
                'pendaftaran.nama_lengkap as nama',
                'pendaftaran.direktorat as direktorat',  // Tambahkan kolom direktorat
                DB::raw("'Absensi' as jenis"),
                DB::raw("CASE 
                    WHEN attendances.check_in_time IS NOT NULL THEN 'Melakukan check in' 
                    ELSE 'Mengajukan izin/sakit' 
                END as aktivitas"),
                'attendances.status as status'
            )
            ->join('pendaftaran', 'pendaftaran.id', '=', 'attendances.user_id')
            ->where('pendaftaran.status', 'diterima')
            ->orderBy('attendances.date', 'desc');
            
        $laporanActivities = Laporan::select(
                'laporan.created_at as tanggal',
                'pendaftaran.nama_lengkap as nama',
                'pendaftaran.direktorat as direktorat',  // Tambahkan kolom direktorat
                DB::raw("'Laporan' as jenis"),
                DB::raw("CONCAT('Mengumpulkan laporan ', laporan.jenis_laporan) as aktivitas"),
                'laporan.status as status'
            )
            ->join('pendaftaran', 'pendaftaran.id', '=', 'laporan.user_id')
            ->where('pendaftaran.status', 'diterima')
            ->orderBy('laporan.created_at', 'desc');
            
        // Gabungkan dan ambil 10 aktivitas terbaru
        $activities = $absensiActivities->union($laporanActivities)
            ->orderBy('tanggal', 'desc')
            ->limit(10)
            ->get();
            
        return $activities;
    }

}