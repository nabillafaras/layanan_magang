<?php
namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class LaporanAkhirController extends Controller
{
    /**
     * Constructor untuk memastikan user sudah login
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Mendapatkan data pendaftaran berdasarkan nomor pendaftaran
     */
    private function getPendaftaran()
    {
        $nomorPendaftaran = auth()->id();
        return Pendaftaran::where('nomor_pendaftaran', $nomorPendaftaran)->first();
    }
    
    /**
     * Menampilkan halaman laporan akhir
     */
    public function index()
    {
        // Dapatkan pendaftaran user
        $pendaftaran = $this->getPendaftaran();
        
        if (!$pendaftaran) {
            return abort(403, 'Anda belum terdaftar.');
        }
        
        $user = Auth::user();
        $laporan = Laporan::where('user_id', $user->id)
                        ->where('jenis_laporan', 'akhir')
                        ->orderBy('created_at', 'desc')
                        ->get();
        
        return view('user.laporan_akhir', compact('laporan'));
    }
    
    /**
     * Mengupload laporan akhir
     */
    public function upload(Request $request)
    {
        // Dapatkan pendaftaran user
        $pendaftaran = $this->getPendaftaran();
        
        if (!$pendaftaran) {
            return abort(403, 'Anda belum terdaftar.');
        }
        
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'file_laporan' => 'required|file|mimes:pdf,doc,docx|max:10240', // Maksimal 10MB
            'keterangan' => 'nullable|string'
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        
        $user = Auth::user();
        $file = $request->file('file_laporan');
        $originalName = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        
        // Format: user_id-akhir-timestamp.extension
        $fileName = $user->id . '-akhir-' . time() . '.' . $extension;
        
        // Simpan file
        $path = $file->storeAs('laporan/' . $user->id, $fileName, 'public');
        
        // Simpan data ke database
        $laporan = new Laporan();
        $laporan->user_id = $user->id;
        $laporan->jenis_laporan = 'akhir';
        $laporan->judul = $request->judul;
        $laporan->file_path = $path;
        $laporan->keterangan = $request->keterangan;
        
        $laporan->save();
        
        return redirect()->route('laporan.akhir')->with('success', 'Laporan akhir berhasil diupload!');
    }
    
    /**
     * Mengunduh laporan akhir
     */
    public function download($id)
    {
        // Dapatkan pendaftaran user
        $pendaftaran = $this->getPendaftaran();
        
        if (!$pendaftaran) {
            return abort(403, 'Anda belum terdaftar.');
        }
        
        $laporan = Laporan::where('id', $id)
                        ->where('jenis_laporan', 'akhir')
                        ->firstOrFail();
        
        // Cek apakah user berwenang
        if (Auth::user()->id != $laporan->user_id && !Auth::user()->isAdmin()) {
            return abort(403);
        }
        
        if (!Storage::disk('public')->exists($laporan->file_path)) {
            return redirect()->back()->with('error', 'File tidak ditemukan!');
        }
        
        return Storage::disk('public')->download($laporan->file_path);
    }
    
    /**
     * Menghapus laporan akhir
     */
    public function delete($id)
    {
        // Dapatkan pendaftaran user
        $pendaftaran = $this->getPendaftaran();
        
        if (!$pendaftaran) {
            return abort(403, 'Anda belum terdaftar.');
        }
        
        $laporan = Laporan::where('id', $id)
                        ->where('jenis_laporan', 'akhir')
                        ->firstOrFail();
        
        // Cek apakah user berwenang
        if (Auth::user()->id != $laporan->user_id && !Auth::user()->isAdmin()) {
            return abort(403);
        }
        
        // Hapus file
        if (Storage::disk('public')->exists($laporan->file_path)) {
            Storage::disk('public')->delete($laporan->file_path);
        }
        
        $laporan->delete();
        
        return redirect()->route('laporan.akhir')->with('success', 'Laporan akhir berhasil dihapus!');
    }
}