<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance; // Pastikan untuk mengimpor model Attendance
use Carbon\Carbon; // Untuk manipulasi tanggal

class UserController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $userId = $user->id;
        
        // Hitung total kehadiran
        $totalKehadiran = Attendance::where('user_id', $userId)
                                    ->where('status', 'hadir')
                                    ->count();
        
        // Hitung kehadiran hari ini
        $kehadiranHariIni = Attendance::where('user_id', $userId)
                                      ->where('status', 'hadir')
                                      ->whereDate('created_at', Carbon::today())
                                      ->count();
        
        // Hitung total izin bulan ini
        $totalIzin = Attendance::where('user_id', $userId)
                               ->where('status', 'izin')
                               ->whereMonth('created_at', Carbon::now()->month)
                               ->count();
        
        // Hitung total sakit bulan ini
        $totalSakit = Attendance::where('user_id', $userId)
                                ->where('status', 'sakit')
                                ->whereMonth('created_at', Carbon::now()->month)
                                ->count();
        
        // Ambil data riwayat aktivitas
        $aktivitasRiwayat = Attendance::where('user_id', $userId)
                                     ->orderBy('created_at', 'desc')
                                     ->take(10) // Ambil 10 data terakhir
                                     ->get();
        
        return view('user.user', compact('user', 'totalKehadiran', 'kehadiranHariIni', 
                                         'totalIzin', 'totalSakit', 'aktivitasRiwayat'));
    }
}