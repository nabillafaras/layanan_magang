<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Pendaftaran;

class UserAuthController extends Controller
{
    // Handle login user
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'nomor_pendaftaran' => 'required',
            'password' => 'required'
        ]);

        // First check if the user exists with status "diterima"
        $pendaftaran = Pendaftaran::where('nomor_pendaftaran', $credentials['nomor_pendaftaran'])
                                  ->whereIn('status', ['diterima', 'selesai'])
                                  ->first();

         // If user doesn't exist with status "diterima", return error
         if (!$pendaftaran) {
            return back()->withErrors([
                'nomor_pendaftaran' => 'Login gagal. Akun Anda belum disetujui atau nomor pendaftaran tidak valid.',
            ]);
        }

        // Cek kredensial untuk login sebagai user
        if (Auth::guard('web')->attempt([
            'nomor_pendaftaran' => $credentials['nomor_pendaftaran'],
            'password' => $credentials['password'],
            'role' => 'user'
        ])) {
            $request->session()->regenerate();
            Log::info('User logged in: ' . $credentials['nomor_pendaftaran']);
            return redirect()->intended('/user');
        }

        return back()->withErrors([
            'nomor_pendaftaran' => 'Nomor pendaftaran atau password salah',
        ]);
    }

    // Handle logout untuk user
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
