<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pendaftaran;
use Illuminate\Support\Facades\Storage;

class PesertaController extends Controller
{
    public function index()
    {
        $pendaftaran = Pendaftaran::orderBy('created_at', 'desc')->get();
        return view('admin.peserta', compact('pendaftaran'));
    }
    
    public function update(Request $request, $id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);
        
        $validated = $request->validate([
            'status' => 'required|in:Diproses,Diterima,Ditolak',
            'catatan' => 'nullable|string|max:500',
            'surat_balasan' => 'nullable|file|mimes:pdf|max:2048',
        ]);
        
        $pendaftaran->status = $request->status;
        
        if ($request->status === 'Ditolak') {
            $pendaftaran->catatan = $request->catatan;
            $pendaftaran->surat_balasan = null; // Hapus surat jika ada
        } elseif ($request->status === 'Diterima') {
            $pendaftaran->catatan = null; // Hapus catatan jika ada
            
            // Upload surat balasan jika ada
            if ($request->hasFile('surat_balasan')) {
                // Hapus file lama jika ada
                if ($pendaftaran->surat_balasan) {
                    Storage::disk('public')->delete($pendaftaran->surat_balasan);
                }
                
                // Upload file baru
                $path = $request->file('surat_balasan')->store('surat_balasan', 'public');
                $pendaftaran->surat_balasan = $path;
            }
            
            
        }
        
        $pendaftaran->save();
        
        return redirect()->route('admin.peserta')->with('success', 'Status peserta berhasil diperbarui');
    }
}