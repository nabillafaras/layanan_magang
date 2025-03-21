<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\Attendance;
use App\Models\Pendaftaran;
use Carbon\Carbon;
use File;

class IzinController extends Controller
{
    /**
     * Constructor untuk memastikan user sudah login
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Mendapatkan data pendaftaran berdasarkan nomor pendaftaran
     */
    private function getPendaftaran()
    {
        $nomorPendaftaran = auth()->id();
        return Pendaftaran::where('nomor_pendaftaran', $nomorPendaftaran)->first();
    }

    
    /**
     * Menampilkan halaman form izin
     */
    public function index()
    {
        // Dapatkan pendaftaran user
        $pendaftaran = $this->getPendaftaran();
        
        if (!$pendaftaran) {
            return abort(403, 'Anda belum terdaftar.');
        }
        
        // Cek apakah user sudah memiliki absensi atau izin untuk hari besok
        $tomorrow = Carbon::tomorrow()->format('Y-m-d');
        $hasAttendance = Attendance::where('user_id', $pendaftaran->id)
            ->where('date', $tomorrow)
            ->exists();
        
        // Ambil riwayat izin user
        $riwayatIzin = Attendance::where('user_id', $pendaftaran->id)
            ->where('status', 'izin')
            ->orderBy('date', 'desc')
            ->get();

            
        
        return view('user.izin', [
            'canSubmitIzin' => !$hasAttendance, 
            'riwayatIzin' => $riwayatIzin
        ]);
    }
    
    /**
     * Memproses pengajuan izin
     */
    public function submit(Request $request)
    {
        $user = Auth::user();
        
        // Validasi input
        $validator = Validator::make($request->all(), [
            'tanggal' => 'required|date|after:today',
            'keterangan' => 'required|string|max:255',
            'bukti' => 'required|file|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ]);
        }
        
        // Cek apakah tanggal minimal H-1
        $requestDate = Carbon::parse($request->tanggal);
        $today = Carbon::today();
        
        if ($requestDate->lte($today)) {
            return response()->json([
                'success' => false,
                'message' => 'Pengajuan izin harus dilakukan minimal 1 hari sebelum hari izin'
            ]);
        }
        
        // Cek apakah sudah ada absensi pada tanggal tersebut
        $existingAttendance = Attendance::where('user_id', $user->id)
            ->where('date', $request->tanggal)
            ->first();
            
        if ($existingAttendance) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah memiliki absensi atau izin pada tanggal tersebut'
            ]);
        }
        
        try {
                        
            // Pastikan folder public/storage/bukti_izin juga ada
            $publicPath = public_path('storage/bukti_izin');
            if (!File::isDirectory($publicPath)) {
                // Buat direktori jika belum ada
                File::makeDirectory($publicPath, 0777, true, true);
            }
            
            // Upload bukti izin
            $buktiFile = $request->file('bukti');
            $buktiName = time() . '_' . $user->id . '.' . $buktiFile->getClientOriginalExtension();
            
            // Simpan file di kedua lokasi untuk memastikan file tersedia
            $buktiFile->storeAs('public/storage/bukti_izin', $buktiName);
            $buktiFile->move($publicPath, $buktiName);
            
            // Simpan data izin
            $attendance = new Attendance();
            $attendance->user_id = $user->id;
            $attendance->date = $request->tanggal;
            $attendance->status = 'izin';
            $attendance->ket_izin = $request->keterangan;
            $attendance->bukti_izin = 'bukti_izin/' . $buktiName;
            
            // Tambahkan semua field yang wajib diisi
            $attendance->check_in_location = '-';
            $attendance->check_out_location = '-';
            $attendance->check_in_photo = 'default.jpg';
            $attendance->check_out_photo = 'default.jpg';
            $attendance->check_in_latitude = 0.0;
            $attendance->check_in_longitude = 0.0;
            $attendance->check_out_latitude = 0.0;
            $attendance->check_out_longitude = 0.0;
            
            // Waktu absensi dibuat dengan nilai default
            $currentDateTime = Carbon::now();
            $attendance->check_in_time = null;
            $attendance->check_out_time = null;
            
            $attendance->created_at = $currentDateTime;
            $attendance->updated_at = $currentDateTime;
            $attendance->save();
            
            return response()->json([
                'success' => true,
                'message' => 'Pengajuan izin berhasil disimpan'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }
}