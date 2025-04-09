<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Pendaftaran; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use File;

class SakitController extends Controller
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

    public function index()
    {
        // Dapatkan pendaftaran user
        $pendaftaran = $this->getPendaftaran();
        
        if (!$pendaftaran) {
            return abort(403, 'Anda belum terdaftar.');
        }
        
        // Cek apakah user sudah melakukan absensi hari ini
        $today = Carbon::now()->format('Y-m-d');
        $attendance = Attendance::where('user_id', $pendaftaran->id)
                               ->whereDate('date', $today)
                               ->first();
        
        // Ambil riwayat sakit user
        $riwayatSakit = Attendance::where('user_id', $pendaftaran->id)
            ->where('status', 'sakit')
            ->orderBy('date', 'desc')
            ->get();
        
        return view('user.sakit', [
            'canSubmitSakit' => !$attendance || !in_array($attendance->status, ['hadir', 'izin', 'sakit']),
            'riwayatSakit' => $riwayatSakit
        ]);
    }

    public function store(Request $request)
    {

        // Mendapatkan data pendaftaran user
        $pendaftaran = $this->getPendaftaran();
        
        // Validasi periode magang
        $today = Carbon::today();
        $tanggalMulai = Carbon::parse($pendaftaran->tanggal_mulai);
        $tanggalSelesai = Carbon::parse($pendaftaran->tanggal_selesai);

        if ($today->lt($tanggalMulai)) {
            return response()->json([
                'success' => false, 
                'message' => 'Periode magang Anda belum dimulai. Magang akan dimulai pada ' . $tanggalMulai->format('d-m-Y') . '.'
            ], 400);
        }

        if ($today->gt($tanggalSelesai)) {
            return response()->json([
                'success' => false, 
                'message' => 'Periode magang Anda telah berakhir pada ' . $tanggalSelesai->format('d-m-Y') . '.'
            ], 400);
        }

        try {
            // Validasi input
            $validator = Validator::make($request->all(), [
                'ket_sakit' => 'required|string|max:255',
                'bukti_sakit' => 'required|file|mimes:jpeg,png,jpg,pdf|max:2048',
            ]);
            
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->first()
                ]);
            }
            
            // Dapatkan pendaftaran user
            $pendaftaran = $this->getPendaftaran();
            
            if (!$pendaftaran) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda belum terdaftar.'
                ], 403);
            }
            
            // Cek apakah user sudah melakukan absensi hari ini
            $today = Carbon::now()->format('Y-m-d');
            $attendance = Attendance::where('user_id', $pendaftaran->id)
                                   ->whereDate('date', $today)
                                   ->first();
            
            // Jika sudah ada status yang terisi, kembalikan error
            if ($attendance && in_array($attendance->status, ['hadir', 'izin', 'sakit'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda sudah melakukan absensi hari ini'
                ]);
            }
            
            // Buat direktori bukti_sakit jika belum ada
            $path = public_path('bukti_sakit');
            if (!File::isDirectory($path)) {
                File::makeDirectory($path, 0777, true, true);
            }
            
            // Upload bukti sakit
            $buktiSakit = $request->file('bukti_sakit');
            $fileName = time() . '_' . $pendaftaran->id . '.' . $buktiSakit->getClientOriginalExtension();
            $buktiSakit->move($path, $fileName);
            
            // Simpan atau update data absensi
            $currentDateTime = Carbon::now();
            
            if ($attendance) {
                $attendance->update([
                    'status' => 'sakit',
                    'ket_sakit' => $request->ket_sakit,
                    'bukti_sakit' => 'bukti_sakit/' . $fileName,
                    'updated_at' => $currentDateTime
                ]);
            } else {
                // Pastikan semua kolom yang required terisi dengan nilai yang benar
                Attendance::create([
                    'user_id' => $pendaftaran->id,
                    'date' => $today,
                    'status' => 'sakit',
                    'ket_sakit' => $request->ket_sakit,
                    'bukti_sakit' => 'bukti_sakit/' . $fileName,
                    // Tambahkan nilai untuk semua kolom yang wajib diisi
                    'check_in_location' => 'Sakit', // Menambahkan nilai default untuk kolom ini
                    'check_out_location' => 'Sakit',
                    'check_in_photo' => 'default.jpg', // Berikan nilai default untuk foto
                    'check_out_photo' => 'default.jpg',
                    'check_in_latitude' => 0.0, // Berikan koordinat default
                    'check_in_longitude' => 0.0,
                    'check_out_latitude' => 0.0,
                    'check_out_longitude' => 0.0,
                    'check_in_time' => $currentDateTime->format('H:i:s'),
                    'check_out_time' => $currentDateTime->format('H:i:s'),
                    'created_at' => $currentDateTime,
                    'updated_at' => $currentDateTime
                ]);
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Izin sakit berhasil disubmit'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }
}