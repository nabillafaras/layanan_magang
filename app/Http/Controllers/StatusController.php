<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendaftaran;

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
        
        return view('status.result', compact('pendaftaran'));
    }
}