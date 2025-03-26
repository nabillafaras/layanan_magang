<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance; // Pastikan untuk mengimpor model Attendance
use App\Models\Laporan;
use App\Models\Pendaftaran;
use Carbon\Carbon; // Untuk manipulasi tanggal

class UserController extends Controller
{
    public function index()
{
    $user = auth()->user();
    $userId = $user->id;
    
    // Hitung total kehadiran
    $totalKehadiran = Attendance::where('user_id', $userId)
                                ->whereIn('status', ['hadir', 'terlambat'])
                                ->count();
    
    // Hitung kehadiran hari ini
    $kehadiranHariIni = Attendance::where('user_id', $userId)
                                  ->whereIn('status', ['hadir', 'terlambat'])
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

    // Ambil data absensi
    $aktivitasAbsensi = Attendance::where('user_id', $userId)
        ->select('id', 'created_at', 'status', 'check_in_time', 'check_out_time')
        ->selectRaw("'Absensi' as type")
        ->selectRaw("NULL as jenis_laporan")
        ->orderBy('created_at', 'desc');

    // Ambil data laporan
    $aktivitasLaporan = Laporan::where('user_id', $userId)
        ->select('id', 'created_at', 'status', 'created_at as check_in_time', 'jenis_laporan')
        ->selectRaw("NULL as check_out_time")
        ->selectRaw("'Laporan' as type")
        ->orderBy('created_at', 'desc');
    
    // Gabungkan data absensi dan laporan
    $aktivitasRiwayat = $aktivitasAbsensi->union($aktivitasLaporan)
                                        ->orderBy('created_at', 'desc')
                                        ->take(10)
                                        ->get();
    
     // Tambahkan kode untuk mengambil data periode magang
     $periodeData = Pendaftaran::where('id', $userId)
     ->select('tanggal_mulai', 'tanggal_selesai')
     ->first();

    // Ubah format tanggal untuk tampilan
    $tanggalMulai = null;
    $tanggalSelesai = null;
    $sisaHari = null;

    if ($periodeData && $periodeData->tanggal_mulai && $periodeData->tanggal_selesai) {
    $tanggalMulai = Carbon::parse($periodeData->tanggal_mulai)->format('d M Y');
    $tanggalSelesai = Carbon::parse($periodeData->tanggal_selesai)->format('d M Y');

    // Hitung sisa hari magang
    $today = Carbon::parse($periodeData->tanggal_mulai);
    $endDate = Carbon::parse($periodeData->tanggal_selesai);
    $sisaHari = ($endDate->gt($today)) ? $today->diffInDays($endDate) : 0;
    }

    return view('user.user', compact('user', 'totalKehadiran', 'kehadiranHariIni', 
    'totalIzin', 'totalSakit', 'aktivitasRiwayat',
    'tanggalMulai', 'tanggalSelesai', 'sisaHari'));
    }
}