<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Laporan;

class BerkasSelesaiController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Mencari dokumen selesai dari tabel laporan
        // Sesuaikan dengan struktur database yang ada
        $dokumen_selesai = Laporan::where('user_id', $user->id)
                            ->where(function($query) {
                                $query->whereNotNull('sk_selesai')
                                      ->orWhereNotNull('sertifikat')
                                      ->orWhereNotNull('nilai_magang');
                            })
                            ->latest()
                            ->first();
        
        return view('user.berkas_selesai', compact('dokumen_selesai'));
    }
}