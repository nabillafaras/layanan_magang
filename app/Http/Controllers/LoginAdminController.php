<?php
// app/Http/Controllers/LoginAdminController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginAdminController extends Controller
{
    public function index()
    {
        // Pastikan user belum login di sistem admin
        if (Auth::guard('admin')->check()) {
            $user = Auth::guard('admin')->user();
            
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($user->role === 'pimpinan') {
                return redirect()->route('pimpinan.dashboard');
            } elseif ($user->role === 'admin1') {
                return redirect()->route('admin1.dashboard');
            } elseif ($user->role === 'admin2') {
                return redirect()->route('admin2.dashboard');
            } elseif ($user->role === 'admin3') {
                return redirect()->route('admin3.dashboard');
            } elseif ($user->role === 'admin4') {
                return redirect()->route('admin4.dashboard');
            } elseif ($user->role === 'admin5') {
                return redirect()->route('admin5.dashboard');
            }
        }
        
        return view('admin.login');
    }
}