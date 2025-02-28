<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function __construct()
    {
        // Cukup gunakan middleware saja
        $this->middleware('auth:admin');
    }

    public function index()
    {
        try {
            // Tambahkan logging untuk debug
            Log::info('Admin accessing dashboard', [
                'admin_id' => Auth::guard('admin')->id(),
                'admin_username' => Auth::guard('admin')->user()->username
            ]);

            // Data dummy untuk tampilan admin
            $totalPeserta = 150;
            $totalAbsensiHariIni = 45;
            $totalLaporan = 85;
            $totalAdmin = 5;

            $recentActivities = collect([
                (object)[
                    'tanggal' => date('Y-m-d'),
                    'nama' => 'Budi Santoso',
                    'aktivitas' => 'Login',
                    'status' => 'Sukses'
                ],
                (object)[
                    'tanggal' => date('Y-m-d'),
                    'nama' => 'Siti Aminah',
                    'aktivitas' => 'Submit Laporan',
                    'status' => 'Diproses'
                ],
                (object)[
                    'tanggal' => date('Y-m-d', strtotime('-1 day')),
                    'nama' => 'Ahmad Rizki',
                    'aktivitas' => 'Absensi',
                    'status' => 'Hadir'
                ]
            ]);

            return view('admin.admin', compact(
                'totalPeserta',
                'totalAbsensiHariIni',
                'totalLaporan',
                'totalAdmin',
                'recentActivities'
            ));

        } catch (\Exception $e) {
            Log::error('Error in admin dashboard:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan saat memuat halaman admin');
        }
    }
}