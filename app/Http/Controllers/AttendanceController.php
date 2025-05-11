<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Pendaftaran;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AttendanceController extends Controller
{
    // Definisi lokasi-lokasi kantor yang diizinkan
    private const OFFICE_LOCATIONS = [
        [
            'name' => 'Kantor Pusat Salemba',
            'latitude' => -6.199498,
            'longitude' => 106.851660,
            'max_distance' => 0.19 // 100 meter (0.1 km)
        ],
        [
            'name' => 'Kantor Cawang',
            'latitude' =>  -6.254756,
            'longitude' =>  106.870493, 
            'max_distance' => 0.07 // 100 meter (0.1 km)
        ],
        [
            'name' => 'Kantor Cabang 2',
            'latitude' =>  -6.363546, 
            'longitude' => 106.876109, 
            'max_distance' => 0.1 // 100 meter (0.1 km)
        ]
    ];

    public function index()
    {
        // Ambil nomor pendaftaran user yang sedang login
        $nomorPendaftaran = auth()->id();
        
        // Ambil data pendaftaran berdasarkan nomor pendaftaran
        $pendaftaran = Pendaftaran::where('nomor_pendaftaran', $nomorPendaftaran)->first();
        
        if (!$pendaftaran) {
            return abort(403, 'Anda belum terdaftar.');
        }

        // Validasi periode magang
        $today = Carbon::today();
        $tanggalMulai = Carbon::parse($pendaftaran->tanggal_mulai);
        $tanggalSelesai = Carbon::parse($pendaftaran->tanggal_selesai);
        
        $isInInternshipPeriod = $today->gte($tanggalMulai) && $today->lte($tanggalSelesai);
        $periodStatus = [
            'isActive' => $isInInternshipPeriod,
            'startDate' => $tanggalMulai->format('d-m-Y'),
            'endDate' => $tanggalSelesai->format('d-m-Y'),
            'message' => ''
        ];
        
        if ($today->lt($tanggalMulai)) {
            $periodStatus['message'] = 'Periode magang Anda belum dimulai. Magang akan dimulai pada ' . $tanggalMulai->format('d-m-Y') . '.';
        } elseif ($today->gt($tanggalSelesai)) {
            $periodStatus['message'] = 'Periode magang Anda telah berakhir pada ' . $tanggalSelesai->format('d-m-Y') . '.';
        }

        // Gunakan id dari pendaftaran untuk mencari attendance
        $attendanceHistory = Attendance::where('user_id', $pendaftaran->id)
            ->whereIn('status', ['hadir', 'terlambat'])
            ->orderBy('date', 'desc')
            ->get();

        $todayAttendance = Attendance::where('user_id', $pendaftaran->id)
            ->whereDate('date', today())
            ->first();

        $hasCheckedIn = $todayAttendance && $todayAttendance->check_in_time;
        $hasCheckedOut = $todayAttendance && $todayAttendance->check_out_time;

        return view('user.attendance', compact('attendanceHistory', 'hasCheckedIn', 'hasCheckedOut', 'periodStatus'));
    }


    public function checkIn(Request $request)
    {
        $request->validate([
            'real_time' => 'required|string',
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

        // Periksa apakah sudah absen menggunakan ID dari pendaftaran
        if (Attendance::where('user_id', $pendaftaran->id)->whereDate('date', today())->exists()) {
            return response()->json(['success' => false, 'message' => 'Anda sudah absen hari ini.'], 400);
        }

        try {
            // Periksa apakah lokasi pengguna berada di dalam radius salah satu kantor
            $locationCheck = $this->isWithinOfficeRadius($request->latitude, $request->longitude);
            
            if (!$locationCheck['within_radius']) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Anda berada di luar radius semua kantor yang diizinkan.'
                ], 400);
            }

            $photoPath = $request->file('photo')->store('attendance-photos', 'public');
            $clientTime = Carbon::parse($request->real_time);
            
            $attendance = Attendance::create([
                'user_id' => $pendaftaran->id,
                'date' => today(),
                'check_in_time' => now(),
                'check_in_location' => $request->location,
                'check_in_latitude' => $request->latitude,
                'check_in_longitude' => $request->longitude,
                'check_in_photo' => $photoPath,
                'check_in_office' => $locationCheck['office_name'], // Simpan nama kantor
                'status' => now()->gt(Carbon::createFromTimeString('08:00:00')) ? 'terlambat' : 'hadir'
            ]);

            return response()->json([
                'success' => true, 
                'message' => 'Absen masuk berhasil di ' . $locationCheck['office_name'], 
                'data' => $attendance
            ]);
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

            // Periksa apakah lokasi pengguna berada di dalam radius salah satu kantor
            $locationCheck = $this->isWithinOfficeRadius($request->latitude, $request->longitude);
            
            if (!$locationCheck['within_radius']) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Anda berada di luar radius semua kantor yang diizinkan.'
                ], 400);
            }

            $photoPath = $request->file('photo')->store('attendance-photos', 'public');
            
            $attendance->update([
                'check_out_time' => now(),
                'check_out_location' => $request->location,
                'check_out_latitude' => $request->latitude,
                'check_out_longitude' => $request->longitude,
                'check_out_photo' => $photoPath,
                'check_out_office' => $locationCheck['office_name'] // Simpan nama kantor
            ]);

            return response()->json([
                'success' => true, 
                'message' => 'Absen pulang berhasil di ' . $locationCheck['office_name'], 
                'data' => $attendance
            ]);
        } catch (\Exception $e) {
            Log::error('Error saat absen pulang: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

    // Metode untuk memeriksa apakah pengguna berada dalam radius salah satu kantor
    private function isWithinOfficeRadius($userLatitude, $userLongitude)
    {
        foreach (self::OFFICE_LOCATIONS as $office) {
            $distance = $this->calculateDistance(
                $userLatitude, 
                $userLongitude, 
                $office['latitude'], 
                $office['longitude']
            );
            
            Log::info('Perhitungan jarak:', [
                'kantor' => $office['name'],
                'latitude_pengguna' => $userLatitude,
                'longitude_pengguna' => $userLongitude,
                'latitude_kantor' => $office['latitude'],
                'longitude_kantor' => $office['longitude'],
                'jarak_terhitung' => $distance,
                'jarak_maksimum' => $office['max_distance']
            ]);
            
            // Jika pengguna berada dalam radius kantor manapun, return true
            if ($distance <= $office['max_distance']) {
                return [
                    'within_radius' => true,
                    'office_name' => $office['name'],
                    'distance' => $distance
                ];
            }
        }
        
        // Jika tidak dalam radius kantor manapun
        return [
            'within_radius' => false,
            'office_name' => null,
            'distance' => null
        ];
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