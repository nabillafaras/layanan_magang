<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AdminAuthController extends Controller
{
    public function adminAuthenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);
        
        // Tambahkan logging untuk debug
        Log::info('Admin/Pimpinan login attempt:', ['username' => $credentials['username']]);
        
        if (Auth::guard('admin')->attempt($credentials)) {
            $user = Auth::guard('admin')->user();
            Log::info('Login successful for: ' . $user->role);
            
            $request->session()->regenerate();
            
            // Validasi dan autentikasi
            if (Auth::guard('admin')->user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif (Auth::guard('admin')->user()->role === 'pimpinan') {
                return redirect()->route('pimpinan.dashboard');
            }
        }
        
        Log::info('Login failed');
        return back()->withErrors([
            'username' => 'Username atau password salah',
        ])->withInput($request->except('password'));
    }

    // Handle logout untuk admin dan pimpinan
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
}