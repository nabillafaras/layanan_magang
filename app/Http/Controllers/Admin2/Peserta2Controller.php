<?php

namespace App\Http\Controllers\Admin2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pendaftaran;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DataPesertaAdminExport;

class Peserta2Controller extends Controller
{

    public function __construct()
    {
        // Middleware untuk memastikan hanya admin yang bisa mengakses
        $this->middleware('auth:admin');
        $this->middleware(function ($request, $next) {
            if (auth('admin')->user()->role !== 'admin2') {
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
    
    // Filter tetap hanya menampilkan direktorat Direktorat Jenderal Perlindungan dan Jaminan Sosial
    $query->where('direktorat', 'Direktorat Jenderal Perlindungan dan Jaminan Sosial');
    
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
    
    // Filter berdasarkan unit kerja
        if ($request->filled('unit_kerja')) {
            $query->where('unit_kerja', $request->unit_kerja);
        }
        
        // Filter berdasarkan tanggal atau bulan pendaftaran
        if ($request->filled('jenis_waktu')) {
            if ($request->jenis_waktu == 'tanggal' && $request->filled('tanggal_pendaftaran')) {
                $query->whereDate('created_at', $request->tanggal_pendaftaran);
            } elseif ($request->jenis_waktu == 'bulan' && $request->filled('bulan_pendaftaran')) {
                $bulan = $request->bulan_pendaftaran; // Format: YYYY-MM
                $tahun = substr($bulan, 0, 4);
                $bulan_angka = substr($bulan, 5, 2);
                $query->whereYear('created_at', $tahun)
                    ->whereMonth('created_at', $bulan_angka);
            }
        } elseif ($request->filled('tanggal_pendaftaran')) {
            // Backward compatibility dengan filter lama
            $query->whereDate('created_at', $request->tanggal_pendaftaran);
        }

        // Dapatkan data peserta setelah semua filter diterapkan
        $pendaftaran = $query->orderBy('created_at', 'desc')->get();
        
    $sekjen_units = [
        "Sekretariat Direktorat Jenderal",
        "Direktorat Jaminan Sosial",
        "Direktorat Perlindungan Sosial Non Kebencanaan",
        "Direktorat Perlindungan Sosial Korban Bencana"
    ];
    
    $unit_kerja = Pendaftaran::whereIn('unit_kerja', $sekjen_units)
                    ->distinct()
                    ->pluck('unit_kerja');
    session([
            'filter_status' => $request->status,
            'filter_direktorat' => 'Direktorat Jenderal Perlindungan dan Jaminan Sosial',
            'filter_search' => $request->search,
            'filter_unit_kerja' => $request->unit_kerja,
            'filter_jenis_waktu' => $request->jenis_waktu,
            'filter_tanggal_pendaftaran' => $request->tanggal_pendaftaran,
            'filter_bulan_pendaftaran' => $request->bulan_pendaftaran
        ]);

    return view('admin2.peserta2', compact('pendaftaran', 'unit_kerja', 'status'));
}
    
    public function update(Request $request, $id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);
        
        $validated = $request->validate([
            'status' => 'required|in:Diproses,Diterima,Ditolak',
            'catatan' => 'nullable|string|max:500',
            'surat_balasan' => 'nullable|file|mimes:pdf|max:2048',
            'surat_ditolak' => 'nullable|file|mimes:pdf|max:2048', // Tambahkan validasi untuk surat_ditolak
        ]);
        
        $pendaftaran->status = $request->status;
        
        if ($request->status === 'Ditolak') {
            $pendaftaran->catatan = $request->catatan;
            $pendaftaran->surat_balasan = null; // Hapus surat balasan jika ada
            
            // Upload surat penolakan jika ada
            if ($request->hasFile('surat_ditolak')) {
                // Hapus file lama jika ada
                if ($pendaftaran->surat_ditolak) {
                    Storage::disk('public')->delete($pendaftaran->surat_ditolak);
                }
                
                // Upload file baru
                $path = $request->file('surat_ditolak')->store('surat_ditolak', 'public');
                $pendaftaran->surat_ditolak = $path;
            }
        } 
        elseif ($request->status === 'Diterima') {
            $pendaftaran->catatan = null; // Hapus catatan jika ada
            $pendaftaran->surat_ditolak = null; // Hapus surat penolakan jika ada
            
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
        
        return redirect()->route('admin2.peserta2')->with('success', 'Status peserta berhasil diperbarui');
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
        $persentaseKehadiran = $totalAbsensi > 0 ? round(($hadir / $totalAbsensi) * 200) : 0;
        
        // Ambil laporan terbaru
        $laporanTerbaru = $peserta->laporan()->orderBy('created_at', 'desc')->limit(5)->get();
        
        return view('admin2.peserta2.show', compact(
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
        // Ambil parameter filter dari request atau session
        $status = $request->status ?? session('filter_status');
        $direktorat = $request->direktorat ?? session('filter_direktorat');
        $search = $request->search ?? session('filter_search');
        $jenis_waktu = $request->jenis_waktu ?? session('filter_jenis_waktu');
        $tanggal_pendaftaran = $request->tanggal_pendaftaran ?? session('filter_tanggal_pendaftaran');
        $bulan_pendaftaran = $request->bulan_pendaftaran ?? session('filter_bulan_pendaftaran');
        
        // Log parameter untuk debugging
        \Illuminate\Support\Facades\Log::info('Export Parameters from Controller', [
            'status' => $status,
            'direktorat' => $direktorat,
            'search' => $search,
            'jenis_waktu' => $jenis_waktu,
            'tanggal_pendaftaran' => $tanggal_pendaftaran,
            'bulan_pendaftaran' => $bulan_pendaftaran
        ]);
        
        // Buat nama file dengan format tanggal hari ini
        $tanggal = Carbon::now()->locale('id')->isoFormat('DD MMMM YYYY');
        $fileName = 'Data_Peserta_Magang_' . $tanggal;
        
        // Tambahkan informasi filter ke nama file
        if ($status) {
            $fileName .= '_Status_' . str_replace(' ', '', $status);
        }
        
        if ($direktorat) {
            $fileName .= '_' . str_replace(' ', '', $direktorat);
        }
        
        // Tambahkan informasi filter tanggal/bulan ke nama file jika ada
        if ($jenis_waktu === 'tanggal' && $tanggal_pendaftaran) {
            $formatTanggal = Carbon::parse($tanggal_pendaftaran)->format('dmY');
            $fileName .= '_Tanggal_' . $formatTanggal;
        } elseif ($jenis_waktu === 'bulan' && $bulan_pendaftaran) {
            $formatBulan = str_replace('-', '', $bulan_pendaftaran);
            $fileName .= '_Bulan_' . $formatBulan;
        }
        
        $fileName .= '.xlsx';
        
        // Export ke Excel dengan semua parameter filter
        return Excel::download(
            new DataPesertaAdminExport(
                $status, 
                $direktorat, 
                $search, 
                $jenis_waktu,
                $tanggal_pendaftaran,
                $bulan_pendaftaran
            ), 
            $fileName
        );
    }
}