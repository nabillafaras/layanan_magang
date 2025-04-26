<?php
// app/Http/Controllers/AdminAuthController.php

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
        
        // Log untuk debugging
        Log::info('Login attempt:', ['username' => $credentials['username']]);
        
        if (Auth::guard('admin')->attempt($credentials)) {
            $user = Auth::guard('admin')->user();
            Log::info('Login successful for: ' . $user->username . ' with role: ' . $user->role);
            
            $request->session()->regenerate();
            
            // Redirect berdasarkan role
            if ($user->role === 'admin') {
                return redirect()->intended(route('admin.dashboard'));
            } elseif ($user->role === 'pimpinan') {
                return redirect()->intended(route('pimpinan.dashboard'));
            } elseif ($user->role === 'admin1') {
                return redirect()->intended(route('admin1.dashboard'));
            } elseif ($user->role === 'admin2') {
                return redirect()->intended(route('admin2.dashboard'));
            } elseif ($user->role === 'admin3') {
                return redirect()->intended(route('admin3.dashboard'));
            } elseif ($user->role === 'admin4') {
                return redirect()->intended(route('admin4.dashboard'));
            } elseif ($user->role === 'admin5') {
                return redirect()->intended(route('admin5.dashboard'));
            }
        }
        
        Log::info('Login failed for: ' . $credentials['username']);
        return back()->withErrors([
            'username' => 'Username atau password salah',
        ])->withInput($request->except('password'));
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
}