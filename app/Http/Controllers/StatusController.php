<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendaftaran;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt; // Tambahkan import Crypt

class StatusController extends Controller
{
    public function form()
    {
        return view('status.form');
    }
    
    public function check(Request $request)
    {
        $request->validate([
            'nomor_pendaftaran' => 'required|string|max:20',
        ]);
        
        $pendaftaran = Pendaftaran::where('nomor_pendaftaran', $request->nomor_pendaftaran)->first();
        
        if (!$pendaftaran) {
            return redirect()->route('status.form')
                ->with('error', 'Nomor pendaftaran tidak ditemukan.');
        }
        
        // Cek apakah status Diterima dan plain_password tersedia
        if ($pendaftaran->status == 'Diterima' && isset($pendaftaran->plain_password)) {
            try {
                // Mencoba mendekripsi password
                $pendaftaran->decrypted_password = Crypt::decryptString($pendaftaran->plain_password);
            } catch (\Exception $e) {
                // Jika terjadi kesalahan dekripsi, gunakan password asli
                $pendaftaran->decrypted_password = $pendaftaran->plain_password;
            }
        }
        
        return view('status.result', compact('pendaftaran'));
    }
}