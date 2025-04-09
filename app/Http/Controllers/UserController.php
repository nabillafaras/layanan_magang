<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance; // Pastikan untuk mengimpor model Attendance
use App\Models\Laporan;
use App\Models\Pendaftaran;
use Carbon\Carbon; // Untuk manipulasi tanggal
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function index()
{
    try {
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

        // Ambil data absensi dengan metode yang lebih jelas
        $attendanceActivities = Attendance::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function($activity) {
                // Kapitalisasi status untuk tampilan yang lebih baik
                $statusDisplay = ucfirst($activity->status);
                
                return (object)[
                    'tanggal' => $activity->created_at->format('d M Y, H:i'),
                    'nama' => auth()->user()->name, // Jika diperlukan
                    'aktivitas' => 'Absensi ' . $statusDisplay,
                    'status' => $activity->status,
                    'type' => 'Absensi'
                ];
            });

        // Ambil data laporan dengan format yang sama
        $reportActivities = Laporan::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function($report) {
                // Pastikan jenis_laporan adalah string yang tepat
                $jenis = ucfirst($report->jenis_laporan ?? 'Bulanan');
                
                return (object)[
                    'tanggal' => $report->created_at->format('d M Y, H:i'),
                    'nama' => auth()->user()->name, // Jika diperlukan
                    'aktivitas' => 'Laporan ' . $jenis,
                    'status' => $report->status,
                    'type' => 'Laporan'
                ];
            });
        
        // Gabungkan data absensi dan laporan
        $aktivitasRiwayat = $attendanceActivities->merge($reportActivities)
                                                ->sortByDesc('tanggal')
                                                ->take(10);
        
        // Ambil data periode magang
        $periodeData = Pendaftaran::where('id', $userId)
            ->select('tanggal_mulai', 'tanggal_selesai')
            ->first();

        // Pastikan data tanggal mulai dan selesai ada
        $tanggalMulai = null;
        $tanggalSelesai = null;
        $sisaHari = null;

        if ($periodeData && $periodeData->tanggal_mulai && $periodeData->tanggal_selesai) {
            // Format tanggal untuk tampilan
            $tanggalMulai = Carbon::parse($periodeData->tanggal_mulai)->format('d M Y');
            $tanggalSelesai = Carbon::parse($periodeData->tanggal_selesai)->format('d M Y');

            // Hitung sisa hari magang dari hari ini ke tanggal selesai
            $today = Carbon::today();
            $endDate = Carbon::parse($periodeData->tanggal_selesai);

            // Sisa hari dari hari ini sampai tanggal selesai
            $sisaHari = $today->diffInDays($endDate, false);
            // Jika nilai negatif, berarti masa magang sudah selesai
            $sisaHari = max(0, $sisaHari);
        }

        return view('user.user', compact('user', 'totalKehadiran', 'kehadiranHariIni', 
        'totalIzin', 'totalSakit', 'aktivitasRiwayat',
        'tanggalMulai', 'tanggalSelesai', 'sisaHari'));
        
    } catch (\Exception $e) {
        // Catat error untuk debugging
        Log::error('Kesalahan di dashboard user:', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        
        return redirect()
            ->back()
            ->with('error', 'Terjadi kesalahan saat memuat halaman dashboard');
    }
}
}