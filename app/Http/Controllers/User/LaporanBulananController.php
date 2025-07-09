<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

use App\Models\Laporan;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class LaporanBulananController extends Controller
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
     * Menampilkan halaman laporan bulanan
     */
    public function index()
    {
        // Dapatkan pendaftaran user
        $pendaftaran = $this->getPendaftaran();
        
        if (!$pendaftaran) {
            return abort(403, 'Anda belum terdaftar.');
        }
        
        $user = Auth::user();
        $laporan = Laporan::where('user_id', $pendaftaran->id)
                        ->where('jenis_laporan', 'bulanan')
                        ->orderBy('created_at', 'desc')
                        ->get();
        
        // Hitung bulan sejak diterima
        $tanggalDiterima = Carbon::parse($user->tanggal_mulai);
        $bulanBerjalan = Carbon::now()->startOfMonth();
        $bulanSejakDiterima = [];
        
        $currentMonth = clone $tanggalDiterima->startOfMonth();
        while ($currentMonth->lte($bulanBerjalan)) {
            $bulanSejakDiterima[] = [
                'bulan' => $currentMonth->format('Y-m'),
                'nama_bulan' => $currentMonth->translatedFormat('F Y'),
                'sudah_upload' => $laporan->contains('periode_bulan', $currentMonth->format('Y-m-d'))
            ];
            $currentMonth->addMonth();
        }
         // Tambahkan definisi untuk $laporanBulanIni
        $bulanIni = Carbon::now()->format('Y-m');
        $laporanBulanIni = Laporan::where('user_id', $user->id)
                        ->where('jenis_laporan', 'bulanan')
                        ->whereYear('created_at', Carbon::now()->year)
                        ->whereMonth('created_at', Carbon::now()->month)
                        ->first();
        return view('user.laporan_bulanan', compact('laporan', 'bulanSejakDiterima', 'laporanBulanIni'));
    }
    
    /**
     * Mengupload laporan bulanan
     */
    public function upload(Request $request)
    {
        // Dapatkan pendaftaran user
        $pendaftaran = $this->getPendaftaran();
        
        if (!$pendaftaran) {
            return abort(403, 'Anda belum terdaftar.');
        }
        
        // Validasi periode magang
        $today = Carbon::today();
        $tanggalMulai = Carbon::parse($pendaftaran->tanggal_mulai);
        $tanggalSelesai = Carbon::parse($pendaftaran->tanggal_selesai);

        if ($today->lt($tanggalMulai)) {
            return response()->json([
                'success' => false, 
                'message' => 'Periode magang Anda belum dimulai. Magang akan dimulai pada ' . $tanggalMulai->format('d-m-Y') . '.'
            ], 400);
        }

        if ($today->gt($tanggalSelesai)) {
            return response()->json([
                'success' => false, 
                'message' => 'Periode magang Anda telah berakhir pada ' . $tanggalSelesai->format('d-m-Y') . '.'
            ], 400);
        }

        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'file_laporan' => 'required|file|mimes:pdf,doc,docx|max:10240', // Maksimal 10MB
            'keterangan' => 'nullable|string',
            'periode_bulan' => 'required|date'
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
        
        // Format: user_id-bulanan-timestamp.extension
        $fileName = $user->id . '-bulanan-' . time() . '.' . $extension;
        
        // Simpan file
        $path = $file->storeAs('laporan/' . $user->id, $fileName, 'public');
        
        // Simpan data ke database
        $laporan = new Laporan();
        $laporan->user_id = $user->id;
        $laporan->jenis_laporan = 'bulanan';
        $laporan->judul = $request->judul;
        $laporan->file_path = $path;
        $laporan->keterangan = $request->keterangan;
        $laporan->periode_bulan = Carbon::parse($request->periode_bulan)->format('Y-m-d');
        
        $laporan->save();
        
        return redirect()->route('laporan.bulanan')->with('success', 'Laporan bulanan berhasil diupload!');
    }
    /**
 * Download template laporan bulanan
 */
public function downloadTemplate()
{
    // Dapatkan pendaftaran user
    $pendaftaran = $this->getPendaftaran();
    
    if (!$pendaftaran) {
        return abort(403, 'Anda belum terdaftar.');
    }
    
    // Path file template (sesuaikan dengan lokasi file template Anda)
    $templatePath = 'templates/Laporan Magang Bulanan.docx';
    
    // Cek apakah file template ada
    if (!Storage::disk('public')->exists($templatePath)) {
        return redirect()->back()->with('error', 'Template laporan bulanan tidak ditemukan!');
    }
    
    // Download file template dengan nama yang user-friendly
    return Storage::disk('public')->download(
        $templatePath, 
        'Laporan Magang Bulanan.docx'
    );
}
    /**
     * Mengunduh laporan bulanan
     */
    public function download($id)
    {
        // Dapatkan pendaftaran user
        $pendaftaran = $this->getPendaftaran();
        
        if (!$pendaftaran) {
            return abort(403, 'Anda belum terdaftar.');
        }
        
        // Perbaikan: Cari laporan berdasarkan ID laporan, bukan ID pendaftaran
        $laporan = Laporan::where('id', $id)
                        ->where('jenis_laporan', 'bulanan')
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
     * Menghapus laporan bulanan
     */
    public function delete($id)
    {
        // Dapatkan pendaftaran user
        $pendaftaran = $this->getPendaftaran();
        
        if (!$pendaftaran) {
            return abort(403, 'Anda belum terdaftar.');
        }
        
        // Perbaikan: Cari laporan berdasarkan ID laporan, bukan ID pendaftaran
        $laporan = Laporan::where('id', $id)
                        ->where('jenis_laporan', 'bulanan')
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
        
        return redirect()->route('laporan.bulanan')->with('success', 'Laporan bulanan berhasil dihapus!');
    }
}