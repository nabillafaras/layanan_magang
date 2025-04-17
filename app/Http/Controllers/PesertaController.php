<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pendaftaran;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DataPesertaAdminExport;

class PesertaController extends Controller
{

    public function __construct()
    {
        // Middleware untuk memastikan hanya admin yang bisa mengakses
        $this->middleware('auth:admin');
    }
    public function index(Request $request)
    {
        // Filter untuk status
        $status = $request->status ? $request->status : null;
        
        // Query dasar
        $query = Pendaftaran::query();
        
        // Filter berdasarkan status
        if ($status) {
            $query->where('status', $status);
        }
        
        // Filter berdasarkan pencarian
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nomor_pendaftaran', 'like', "%{$search}%")
                  ->orWhere('asal_universitas', 'like', "%{$search}%");
            });
        }
        
        // Filter berdasarkan direktorat
        if ($request->has('direktorat') && $request->direktorat) {
            $query->where('direktorat', $request->direktorat);
        }
        
        // Dapatkan peserta
        $pendaftaran = $query->orderBy('created_at', 'desc')->paginate(10);
        
        // Dapatkan list direktorat untuk filter
        $direktorat = Pendaftaran::distinct('direktorat')->pluck('direktorat');
        
        return view('admin.peserta', compact('pendaftaran', 'direktorat', 'status'));
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
        } 
        elseif ($request->status === 'Diterima') {
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
    
    public function show($id)
    {
        $peserta = Pendaftaran::findOrFail($id);
        
        // Hitung statistik kehadiran
        $totalAbsensi = $peserta->attendances()->count();
        $hadir = $peserta->attendances()->where('status', 'hadir')->count();
        $izin = $peserta->attendances()->where('status', 'izin')->count();
        $sakit = $peserta->attendances()->where('status', 'sakit')->count();
        
        // Hitung persentase kehadiran
        $persentaseKehadiran = $totalAbsensi > 0 ? round(($hadir / $totalAbsensi) * 100) : 0;
        
        // Ambil laporan terbaru
        $laporanTerbaru = $peserta->laporan()->orderBy('created_at', 'desc')->limit(5)->get();
        
        return view('admin.peserta.show', compact(
            'peserta', 
            'totalAbsensi', 
            'hadir', 
            'izin', 
            'sakit', 
            'persentaseKehadiran',
            'laporanTerbaru'
        ));
    }
    public function exportExcel(Request $request)
    {
        // Ambil parameter filter
        $status = $request->status;
        $direktorat = $request->direktorat;
        $search = $request->search;
        $tanggal = Carbon::now()->locale('id')->isoFormat('DD MMMM YYYY');
        
        // Buat nama file
        $fileName = 'Data_Peserta_Magang_' . $tanggal;
        
        if ($status) {
            $fileName .= '_Status_' . str_replace(' ', '', $status);
        }
        
        if ($direktorat) {
            $fileName .= '_' . str_replace(' ', '', $direktorat);
        }
        
        $fileName .= '.xlsx';
        
        // Export ke Excel
        return Excel::download(new DataPesertaAdminExport($status, $direktorat, $search), $fileName);
    }
}