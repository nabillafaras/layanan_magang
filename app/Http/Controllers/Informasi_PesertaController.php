<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendaftaran;
use Illuminate\Support\Facades\DB;

class Informasi_PesertaController extends Controller
{
    public function index()
    {
        // Ambil data peserta yang diterima
        $peserta = Pendaftaran::where('status', 'Diterima')
                    ->orderBy('direktorat')
                    ->orderBy('nama_lengkap')
                    ->get();
        
        // Hitung jumlah peserta per direktorat
        $statistik = Pendaftaran::where('status', 'Diterima')
                    ->select('direktorat', DB::raw('count(*) as total'))
                    ->groupBy('direktorat')
                    ->get();
        
        // Hitung total peserta yang diterima
        $totalPeserta = Pendaftaran::where('status', 'Diterima')->count();
        
        return view('informasi_peserta', compact('peserta', 'statistik', 
        'totalPeserta'));
    }
}