<?php

namespace App\Http\Controllers\Admin1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Pendaftaran;
use App\Models\Attendance;
use App\Models\Laporan;

class Direktorat1Controller extends Controller
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

    public function mapDirektorat($direktorat)
{
    // Kode untuk menampilkan peta direktorat
    // Contoh:
    return view('admin1.direktorat.map', compact('direktorat'));
}

    public function direktorat1()
    {
        // Hitung jumlah peserta magang aktif di Direktorat 3
        $jumlahPeserta = Pendaftaran::where('direktorat', 'Sekretariat Jenderal')
                                    ->where('status', 'diterima')
                                    ->count();
        
        // Ambil data absensi dengan relasi pendaftaran
        $absensi = Attendance::whereHas('pendaftaran', function($query) {
                        $query->where('direktorat', 'Sekretariat Jenderal')
                              ->where('status', 'diterima');
                    })
                    ->with('pendaftaran')
                    ->orderBy('date', 'desc')
                    ->get();
        
        // Ambil data laporan dengan relasi pendaftaran
        $laporan = Laporan::whereHas('pendaftaran', function($query) {
                        $query->where('direktorat', 'Sekretariat Jenderal')
                              ->where('status', 'diterima');
                    })
                    ->with('pendaftaran')
                    ->orderBy('periode_bulan', 'desc')
                    ->get();
                    session(['previous_direktorat' => 'Sekretariat Jenderal']);
        return view('admin1.direktorat1', compact('jumlahPeserta', 'absensi', 'laporan'));
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
        return view('admin1.detail_laporan1', compact('laporan'));
    }

    public function showDirektorat($id)
    {
        // Panggil method yang sesuai berdasarkan nomor direktorat
        $method = 'direktorat' . $id;
        if (method_exists($this, $method)) {
            return $this->$method();
        }
        return redirect()->route('admin1.dashboard')->with('error', 'Direktorat tidak ditemukan');
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
        'status' => 'required|in:Menunggu,Acc,Ditolak'
    ]);
    
    $laporan = Laporan::findOrFail($id);
    $laporan->status = $request->status;
    $laporan->save();
    
    return redirect()->back()->with('success', 'Status laporan berhasil diperbarui menjadi ' . ucfirst($request->status));
}
}