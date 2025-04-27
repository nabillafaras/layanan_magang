<?php

namespace App\Http\Controllers\Admin1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pendaftaran;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DataPesertaAdminExport;

class Peserta1Controller extends Controller
{

    public function __construct()
    {
        // Middleware untuk memastikan hanya admin yang bisa mengakses
        $this->middleware('auth:admin');
        $this->middleware(function ($request, $next) {
            if (auth('admin')->user()->role !== 'admin1') {
                abort(403, 'Unauthorized');
            }
            return $next($request);
        });
    }
    public function index(Request $request)
{
    // Filter untuk status
    $status = $request->status ? $request->status : null;
    
    // Query dasar
    $query = Pendaftaran::query();
    
    // Filter tetap hanya menampilkan direktorat Sekretariat Jenderal
    $query->where('direktorat', 'Sekretariat Jenderal');
    
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
    if ($request->has('unit_kerja') && $request->unit_kerja) {
        $query->where('unit_kerja', $request->unit_kerja);
    }

    // Dapatkan peserta
    $pendaftaran = $query->orderBy('created_at', 'desc')->get();
    
    $sekjen_units = [
        "Biro Perencanaan",
        "Biro Keuangan",
        "Biro Organisasi dan Sumber Daya Manusia",
        "Biro Hukum",
        "Biro Umum",
        "Biro Hubungan Masyarakat",
        "Pusat Pendidikan, Pelatihan, dan Pengembangan Profesi Kesejahteraan Sosial",
        "Pusat Data dan Informasi Kesejahteraan Sosial"
    ];
    
    $unit_kerja = Pendaftaran::whereIn('unit_kerja', $sekjen_units)
                    ->distinct()
                    ->pluck('unit_kerja');
    
    return view('admin1.peserta1', compact('pendaftaran', 'unit_kerja', 'status'));
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
        
        return redirect()->route('admin1.peserta1')->with('success', 'Status peserta berhasil diperbarui');
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
        
        return view('admin1.peserta1.show', compact(
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
    $status = $request->status ?? null;
    $direktorat = $request->direktorat ?? 'Sekretariat Jenderal'; // Default jika tidak ada
    $search = $request->search ?? null;
    
    // Format tanggal sesuai dengan struktur source
    $tanggal = Carbon::now();
    $bulanNama = $tanggal->locale('id')->isoFormat('MMMM YYYY');
    
    // Buat nama file dengan format yang sama
    $fileName = 'DataPesertaMagang_' . $bulanNama;
    
    if ($direktorat) {
        $fileName .= '_' . str_replace(' ', '', $direktorat);
    }
    
    if ($status) {
        $fileName .= '_Status_' . str_replace(' ', '', $status);
    }
    
    $fileName .= '.xlsx';
    
    // Export ke Excel dengan struktur parameter yang sama (mengikuti urutan parameter di constructor)
    return Excel::download(new DataPesertaAdminExport($status, $direktorat, $search), $fileName);
}
}