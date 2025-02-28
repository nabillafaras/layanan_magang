<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AdminAuthController extends Controller
{

    // Handle login admin
    public function adminAuthenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        // Tambahkan logging untuk debug
        Log::info('Admin login attempt:', ['username' => $credentials['username']]);

        if (Auth::guard('admin')->attempt($credentials)) {
            Log::info('Admin login successful');
            $request->session()->regenerate();
            return redirect()->intended('/admin');
        }

        Log::info('Admin login failed');
        return back()->withErrors([
            'username' => 'Username atau password salah',
        ])->withInput($request->except('password'));
    }

    // Handle logout untuk admin
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
}
