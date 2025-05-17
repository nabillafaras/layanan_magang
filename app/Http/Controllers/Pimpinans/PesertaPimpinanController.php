<?php

namespace App\Http\Controllers\Pimpinans;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DataPesertaPimpinanExport;
use App\Exports\DataPesertaAdminExport;

class PesertaPimpinanController extends Controller
{

    public function __construct()
    {
        // Menggunakan guard admin tapi memeriksa role pimpinan
        $this->middleware('auth:admin');
        $this->middleware(function ($request, $next) {
            if (auth('admin')->user()->role !== 'pimpinan') {
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

        // Filter berdasarkan tanggal atau bulan pendaftaran
        if ($request->has('jenis_waktu')) {
            if ($request->jenis_waktu == 'tanggal' && $request->tanggal_pendaftaran) {
                $tanggal = $request->tanggal_pendaftaran;
                $query->whereDate('created_at', $tanggal);
            } elseif ($request->jenis_waktu == 'bulan' && $request->bulan_pendaftaran) {
                $bulan = $request->bulan_pendaftaran; // Format: YYYY-MM
                $tahun = substr($bulan, 0, 4);
                $bulan_angka = substr($bulan, 5, 2);
                $query->whereYear('created_at', $tahun)
                    ->whereMonth('created_at', $bulan_angka);
            }
        } else if ($request->has('tanggal_pendaftaran') && $request->tanggal_pendaftaran) {
            // Backward compatibility dengan filter lama
            $query->whereDate('created_at', $request->tanggal_pendaftaran);
        }
        
        // Dapatkan peserta
        $peserta = $query->orderBy('created_at', 'desc')->get();
        
        // Dapatkan list direktorat untuk filter
        $direktorat = Pendaftaran::distinct('direktorat')->pluck('direktorat');
        
        // Simpan parameter filter ke session untuk digunakan saat export
        session([
            'filter_status' => $request->status,
            'filter_direktorat' => $request->direktorat,
            'filter_search' => $request->search,
            'filter_jenis_waktu' => $request->jenis_waktu,
            'filter_tanggal_pendaftaran' => $request->tanggal_pendaftaran,
            'filter_bulan_pendaftaran' => $request->bulan_pendaftaran
        ]);
        
        return view('pimpinan.peserta', compact('peserta', 'direktorat', 'status'));
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
    
    return view('pimpinan.peserta.show', compact(
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