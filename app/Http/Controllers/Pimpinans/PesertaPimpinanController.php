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
        $status = $request->status ;
        
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
        $peserta = $query->orderBy('created_at', 'desc')->get();
        
        // Dapatkan list direktorat untuk filter
        $direktorat = Pendaftaran::distinct('direktorat')->pluck('direktorat');
        
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