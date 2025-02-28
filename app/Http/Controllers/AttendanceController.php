<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Pendaftaran;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AttendanceController extends Controller
{
    private const OFFICE_LATITUDE = -6.2488576;
    private const OFFICE_LONGITUDE = 106.7843584;
    private const MAX_DISTANCE = 0.1; // 100 meter (0.1 km)

    public function index()
{
    // Ambil nomor pendaftaran user yang sedang login
    $nomorPendaftaran = auth()->id();
    
    // Ambil data pendaftaran berdasarkan nomor pendaftaran
    $pendaftaran = Pendaftaran::where('nomor_pendaftaran', $nomorPendaftaran)->first();
    
    if (!$pendaftaran) {
        return abort(403, 'Anda belum terdaftar.');
    }

    // Gunakan id dari pendaftaran untuk mencari attendance
    $attendanceHistory = Attendance::where('user_id', $pendaftaran->id)
        ->orderBy('date', 'desc')
        ->get();

        $todayAttendance = Attendance::where('user_id', $pendaftaran->id)
            ->whereDate('date', today())
            ->first();

        $hasCheckedIn = $todayAttendance && $todayAttendance->check_in_time;
        $hasCheckedOut = $todayAttendance && $todayAttendance->check_out_time;

        return view('user.attendance', compact('attendanceHistory', 'hasCheckedIn', 'hasCheckedOut'));
    }

    public function checkIn(Request $request)
    {
        $request->validate([
            'location' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'photo' => 'required|image|max:2048'
        ]);

        // Ambil nomor pendaftaran user yang sedang login
    $nomorPendaftaran = auth()->id();
    
    // Ambil data pendaftaran berdasarkan nomor pendaftaran
    $pendaftaran = Pendaftaran::where('nomor_pendaftaran', $nomorPendaftaran)->first();
    
    if (!$pendaftaran) {
        return response()->json(['success' => false, 'message' => 'Anda belum terdaftar.'], 403);
    }

        // Periksa apakah sudah absen menggunakan ID dari pendaftaran
        if (Attendance::where('user_id', $pendaftaran->id)->whereDate('date', today())->exists()) {
            return response()->json(['success' => false, 'message' => 'Anda sudah absen hari ini.'], 400);
        }

        try {
            $distance = $this->calculateDistance($request->latitude, $request->longitude, self::OFFICE_LATITUDE, self::OFFICE_LONGITUDE);
            Log::info('Check-in distance calculation:', [
                'user_latitude' => $request->latitude,
                'user_longitude' => $request->longitude,
                'office_latitude' => self::OFFICE_LATITUDE,
                'office_longitude' => self::OFFICE_LONGITUDE,
                'calculated_distance' => $distance,
                'max_distance' => self::MAX_DISTANCE
            ]);
            if ($distance > self::MAX_DISTANCE) {
                return response()->json(['success' => false, 'message' => 'Anda berada di luar radius kantor.'], 400);
            }

            $photoPath = $request->file('photo')->store('attendance-photos', 'public');

            $attendance = Attendance::create([
                'user_id' => $pendaftaran->id,
                'date' => today(),
                'check_in_time' => now(),
                'check_in_location' => $request->location,
                'check_in_latitude' => $request->latitude,
                'check_in_longitude' => $request->longitude,
                'check_in_photo' => $photoPath,
                'status' => now()->gt(Carbon::createFromTimeString('08:00:00')) ? 'terlambat' : 'hadir'
            ]);

            return response()->json(['success' => true, 'message' => 'Absen masuk berhasil', 'data' => $attendance]);
        } catch (\Exception $e) {
            Log::error('Error saat absen: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

    public function checkOut(Request $request)
    {
        $request->validate([
            'location' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'photo' => 'required|image|max:2048'
        ]);

        // Ambil nomor pendaftaran user yang sedang login
    $nomorPendaftaran = auth()->id();
    
    // Ambil data pendaftaran berdasarkan nomor pendaftaran
    $pendaftaran = Pendaftaran::where('nomor_pendaftaran', $nomorPendaftaran)->first();
    
    if (!$pendaftaran) {
        return response()->json(['success' => false, 'message' => 'Anda belum terdaftar.'], 403);
    }
        
        try {
            // Gunakan ID dari model Pendaftaran
            $attendance = Attendance::where('user_id', $pendaftaran->id)
                ->whereDate('date', today())
                ->first();
                
            if (!$attendance || !$attendance->check_in_time) {
                return response()->json(['success' => false, 'message' => 'Anda belum melakukan absen masuk hari ini.'], 400);
            }

            if ($attendance->check_out_time) {
                return response()->json(['success' => false, 'message' => 'Anda sudah absen pulang hari ini.'], 400);
            }

            $photoPath = $request->file('photo')->store('attendance-photos', 'public');
            $attendance->update([
                'check_out_time' => now(),
                'check_out_location' => $request->location,
                'check_out_latitude' => $request->latitude,
                'check_out_longitude' => $request->longitude,
                'check_out_photo' => $photoPath
            ]);

            return response()->json(['success' => true, 'message' => 'Absen pulang berhasil', 'data' => $attendance]);
        } catch (\Exception $e) {
            Log::error('Error saat absen pulang: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
{
    // Radius bumi dalam km
    $r = 6371;
    
    // Konversi koordinat ke radian
    $lat1 = deg2rad(floatval($lat1));
    $lon1 = deg2rad(floatval($lon1));
    $lat2 = deg2rad(floatval($lat2));
    $lon2 = deg2rad(floatval($lon2));
    
    // Hitung selisih koordinat
    $dLat = $lat2 - $lat1;
    $dLon = $lon2 - $lon1;
    
    // Rumus Haversine
    $a = sin($dLat/2) * sin($dLat/2) + cos($lat1) * cos($lat2) * sin($dLon/2) * sin($dLon/2);
    $c = 2 * atan2(sqrt($a), sqrt(1-$a));
    $distance = $r * $c; // Jarak dalam km
    
    return $distance;
}
}