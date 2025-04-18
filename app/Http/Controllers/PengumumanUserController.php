<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengumumanUserController extends Controller
{
    public function index()
    {
        // Ambil informasi direktorat user yang sedang login
        $userDirektorat = Auth::user()->direktorat;
        
        // Ambil pengumuman yang statusnya published, dan:
        // - Kategorinya "semua direktorat" ATAU
        // - Kategorinya sesuai dengan direktorat user
        $pengumuman = Pengumuman::published()
            ->where(function ($query) use ($userDirektorat) {
                $query->where('kategori', 'semua direktorat')
                      ->orWhere('kategori', $userDirektorat);
            })
            ->orderBy('published_at', 'desc')
            ->paginate(10);
        
        return view('user.pengumuman.index', compact('pengumuman'));
    }
    
    public function show($id)
    {
        // Ambil informasi direktorat user yang sedang login
        $userDirektorat = Auth::user()->direktorat;
        
        // Ambil pengumuman berdasarkan ID
        $pengumuman = Pengumuman::published()
            ->where('id', $id)
            ->where(function ($query) use ($userDirektorat) {
                $query->where('kategori', 'semua direktorat')
                      ->orWhere('kategori', $userDirektorat);
            })
            ->firstOrFail();
        
        return view('user.pengumuman.show', compact('pengumuman'));
    }
}