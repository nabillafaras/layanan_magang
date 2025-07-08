<?php

namespace App\Http\Controllers\Admin3;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Pendaftaran;
use App\Models\Attendance;
use App\Models\Laporan;

class Direktorat3Controller extends Controller
{

    public function __construct()
    {
        // Middleware untuk memastikan hanya admin yang bisa mengakses
        $this->middleware('auth:admin');
        $this->middleware(function ($request, $next) {
            if (auth('admin')->user()->role !== 'admin3') {
                abort(403, 'Unauthorized');
            }
            return $next($request);
        });
    }

    public function mapDirektorat($direktorat)
{
    // Kode untuk menampilkan peta direktorat
    // Contoh:
    return view('admin3.direktorat.map', compact('direktorat'));
}

    public function direktorat3()
    {
        // Hitung jumlah peserta magang aktif di Direktorat 3
        $jumlahPeserta = Pendaftaran::where('direktorat', 'Direktorat Jenderal Rehabilitasi Sosial')
                                    ->where('status', 'diterima')
                                    ->count();
        
        // Ambil data absensi dengan relasi pendaftaran
        $absensi = Attendance::whereHas('pendaftaran', function($query) {
                        $query->where('direktorat', 'Direktorat Jenderal Rehabilitasi Sosial')
                              ->whereIn('status', ['diterima', 'selesai']);
                    })
                    ->with('pendaftaran')
                    ->latest('date') // Menambahkan latest berdasarkan tanggal
                    ->latest('created_at') // Jika tanggal sama, urutkan berdasarkan created_at
                    ->get();
        
        // Ambil data laporan dengan relasi pendaftaran
        $laporan = Laporan::whereHas('pendaftaran', function($query) {
                        $query->where('direktorat', 'Direktorat Jenderal Rehabilitasi Sosial')
                              ->whereIn('status', ['diterima', 'selesai']);
                    })
                    ->with('pendaftaran')
                    ->orderBy('periode_bulan', 'desc')
                    ->get();
                    session(['previous_direktorat' => 'Direktorat Jenderal Rehabilitasi Sosial']);
        return view('admin3.direktorat3', compact('jumlahPeserta', 'absensi', 'laporan'));
    }



        public function detailLaporan($id)
    {
        $laporan = Laporan::with('pendaftaran')->findOrFail($id);
        
        if (!$laporan) {
            return redirect()->back()->with('error', 'Laporan tidak ditemukan.');
        }
        if (!session('previous_direktorat')) {
            session(['previous_direktorat' => $laporan->pendaftaran->direktorat]);
        }
        return view('admin3.detail_laporan3', compact('laporan'));
    }

    public function showDirektorat($id)
    {
        // Panggil method yang sesuai berdasarkan nomor direktorat
        $method = 'direktorat' . $id;
        if (method_exists($this, $method)) {
            return $this->$method();
        }
        return redirect()->route('admin3.dashboard')->with('error', 'Direktorat tidak ditemukan');
    }
    public function submitFeedback(Request $request, $id)
    {
        $request->validate([
            'feedback' => 'required|string'
        ]);
        
        $laporan = Laporan::findOrFail($id);
        $laporan->feedback = $request->feedback;
        $laporan->save();
        
        return redirect()->back()->with('success', 'Feedback berhasil disimpan.');
    }

    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:Menunggu,Acc,Ditolak',
            'sk_selesai' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120', // Maksimal 5MB
            'sertifikat' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120', // Maksimal 5MB
            'nilai_magang' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);
        
        $laporan = Laporan::with('pendaftaran')->findOrFail($id);
        $oldStatus = $laporan->status;
        $laporan->status = $request->status;
        
        // Jika laporan jenis "akhir" dan status diubah menjadi "Acc"
        if ($laporan->jenis_laporan == 'akhir' && $request->status == 'Acc') {
            // Jika status sebelumnya bukan "Acc" (baru diubah menjadi "Acc")
            if ($oldStatus != 'Acc') {
                // Validasi apakah kedua file sudah diupload
                if (!$request->hasFile('sk_selesai') || !$request->hasFile('sertifikat')|| !$request->hasFile('nilai_magang')) {
                    return redirect()->back()->with('error', 'Harap upload file SK Selesai dan Sertifikat untuk laporan akhir.');
                }
                
                // Upload file SK Selesai
                if ($request->hasFile('sk_selesai')) {
                    $skFile = $request->file('sk_selesai');
                    $skFileName = time() . '_' . $laporan->pendaftaran->nama_lengkap . '_sk_selesai.' . $skFile->getClientOriginalExtension();
                    $skFilePath = $skFile->storeAs('sk_selesai', $skFileName, 'public');
                    $laporan->sk_selesai = 'storage/' . $skFilePath;
                }
                
                // Upload file Sertifikat
                if ($request->hasFile('sertifikat')) {
                    $sertifikatFile = $request->file('sertifikat');
                    $sertifikatFileName = time() . '_' . $laporan->pendaftaran->nama_lengkap . '_sertifikat.' . $sertifikatFile->getClientOriginalExtension();
                    $sertifikatFilePath = $sertifikatFile->storeAs('sertifikat', $sertifikatFileName, 'public');
                    $laporan->sertifikat = 'storage/' . $sertifikatFilePath;
                }

                // Upload file nilai
                if ($request->hasFile('nilai_magang')) {
                    $nilaiFile = $request->file('nilai_magang');
                    $nilaiFileName = time() . '_' . $laporan->pendaftaran->nama_lengkap . '_nilai_magang.' . $nilaiFile->getClientOriginalExtension();
                    $nilaiFilePath = $nilaiFile->storeAs('nilai_magang', $nilaiFileName, 'public');
                    $laporan->nilai_magang= 'storage/' . $nilaiFilePath;
                }
                
                // Ubah status peserta menjadi "Selesai"
                $pendaftaran = $laporan->pendaftaran;
                $pendaftaran->status = 'Selesai';
                $pendaftaran->save();
            }
        }
        
        $laporan->save();
        
        $message = 'Status laporan berhasil diperbarui menjadi ' . ucfirst($request->status);
        if ($laporan->jenis_laporan == 'akhir' && $request->status == 'Acc' && $oldStatus != 'Acc') {
            $message .= ' dan status peserta telah diubah menjadi Selesai';
        }
        
        return redirect()->back()->with('success', $message);
    }
}