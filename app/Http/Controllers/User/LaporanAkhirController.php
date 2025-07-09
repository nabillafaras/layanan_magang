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

        // Tambahkan informasi apakah sudah bisa upload laporan akhir
        $tanggalSekarang = Carbon::now();
        $tanggalSelesai = Carbon::parse($pendaftaran->tanggal_selesai);
        $bisaUpload = $tanggalSekarang->gte($tanggalSelesai);
        
        // Cek apakah sudah pernah upload dan belum dihapus
        $sudahUpload = $laporan->count() > 0;
        
        return view('user.laporan_akhir', compact('laporan', 'pendaftaran', 'bisaUpload', 'tanggalSelesai', 'sudahUpload'));
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
        
        $user = Auth::user();
        
        // Cek apakah sudah melewati tanggal_selesai
        $tanggalSekarang = Carbon::now();
        $tanggalSelesai = Carbon::parse($pendaftaran->tanggal_selesai);
        
        if ($tanggalSekarang->lt($tanggalSelesai)) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Laporan akhir hanya bisa diupload setelah tanggal selesai: ' . $tanggalSelesai->format('d-m-Y') . '.'
                ], 400);
            }
            
            return redirect()->back()->with('error', 'Laporan akhir hanya bisa diupload setelah tanggal selesai: ' . $tanggalSelesai->format('d-m-Y') . '.');
        }
        
        // Cek apakah sudah pernah upload laporan akhir
        $sudahUpload = Laporan::where('user_id', $user->id)
                        ->where('jenis_laporan', 'akhir')
                        ->exists();
                        
        if ($sudahUpload) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Anda sudah mengupload laporan akhir. Jika ingin mengupload ulang, silakan hapus laporan sebelumnya terlebih dahulu.'
                ], 400);
            }
            
            return redirect()->back()->with('error', 'Anda sudah mengupload laporan akhir. Jika ingin mengupload ulang, silakan hapus laporan sebelumnya terlebih dahulu.');
        }
        
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'file_laporan' => 'required|file|mimes:pdf,doc,docx|max:10240', // Maksimal 10MB
            'keterangan' => 'nullable|string'
        ]);
        
        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }
            
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        
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
        
        
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Laporan akhir berhasil diupload!',
                'data' => $laporan
            ]);
        }
        
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
 * Download template laporan akhir
 */
public function downloadTemplate()
{
    // Dapatkan pendaftaran user
    $pendaftaran = $this->getPendaftaran();
    
    if (!$pendaftaran) {
        return abort(403, 'Anda belum terdaftar.');
    }
    
    // Path file template (sesuaikan dengan lokasi file template Anda)
    $templatePath = 'templates/Laporan Magang Pusdatin.docx';
    
    // Cek apakah file template ada
    if (!Storage::disk('public')->exists($templatePath)) {
        return redirect()->back()->with('error', 'Template laporan akhir tidak ditemukan!');
    }
    
    // Download file template dengan nama yang user-friendly
    return Storage::disk('public')->download(
        $templatePath, 
        'Laporan Magang Pusdatin.docx'
    );
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
        
        
        if (Auth::user()->id == $laporan->user_id && !Auth::user()->isAdmin()) {
            // Cek apakah masih ada laporan akhir lain
            $masihAdaLaporanAkhir = Laporan::where('user_id', Auth::user()->id)
                                        ->where('jenis_laporan', 'akhir')
                                        ->exists();
        }
        
        return redirect()->route('laporan.akhir')->with('success', 'Laporan akhir berhasil dihapus! Anda dapat mengupload laporan akhir kembali.');
    }
}