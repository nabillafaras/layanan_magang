<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pendaftaran;
use App\Models\Laporan;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Exports\RekapLaporanExport;
use Maatwebsite\Excel\Facades\Excel;

class RekapLaporanController extends Controller
{

    public function __construct()
    {
        // Middleware untuk memastikan hanya admin yang bisa mengakses
        $this->middleware('auth:admin');
        $this->middleware(function ($request, $next) {
        if (auth('admin')->user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
        return $next($request);
    });
    }
    public function index(Request $request)
    {
        // Set default ke bulan dan tahun sekarang jika tidak ada filter
        $filterDate = $request->bulan ?? date('Y-m');
        $direktorat = $request->direktorat;

        list($tahun, $bulan) = explode('-', $filterDate);
        $bulanNama = Carbon::createFromDate($tahun, $bulan, 1)->locale('id')->isoFormat('MMMM YYYY');

        // Query untuk mendapatkan peserta magang dengan status diterima
       $query = Pendaftaran::whereIn('status', ['diterima', 'selesai'])
              // Filter tanggal mulai: sudah mulai sebelum atau pada bulan yang dipilih
              ->where(function($q) use ($tahun, $bulan) {
                  $q->whereYear('tanggal_mulai', '<', $tahun)
                    ->orWhere(function($q2) use ($tahun, $bulan) {
                        $q2->whereYear('tanggal_mulai', '=', $tahun)
                           ->whereMonth('tanggal_mulai', '<=', $bulan);
                    });
              })
              // Filter tanggal selesai: belum selesai atau selesai setelah bulan yang dipilih
              ->where(function($q) use ($tahun, $bulan) {
                  $q->whereNull('tanggal_selesai') // Belum ada tanggal selesai
                    ->orWhereYear('tanggal_selesai', '>', $tahun) // Selesai di tahun setelah tahun yang dipilih
                    ->orWhere(function($q2) use ($tahun, $bulan) {
                        $q2->whereYear('tanggal_selesai', '=', $tahun)
                           ->whereMonth('tanggal_selesai', '>=', $bulan); // Selesai di bulan yang sama atau setelah bulan yang dipilih
                    });
              })
              ->with(['attendances' => function($query) use ($tahun, $bulan) {
                  $query->whereYear('date', $tahun)
                        ->whereMonth('date', $bulan);
              }]);


        // Filter berdasarkan direktorat
        if ($request->has('direktorat') && $request->direktorat) {
            $query->where('direktorat', $request->direktorat);
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

       
        // Dapatkan list direktorat untuk filter
        $direktorat = Pendaftaran::distinct('direktorat')->pluck('direktorat');
        

        $peserta = $query->get();
        
        // Mendapatkan laporan bulanan dan akhir untuk setiap peserta
        foreach ($peserta as $p) {
            // Laporan bulanan pada periode bulan yang dipilih
            $p->laporan_bulanan = Laporan::where('user_id', $p->id)
                                    ->where('jenis_laporan', 'bulanan')
                                    ->whereRaw("DATE_FORMAT(periode_bulan, '%Y-%m') = ?", [$filterDate])
                                    ->first();
                                    
            // Laporan akhir (tidak perlu filter bulan untuk laporan akhir)
            $p->laporan_akhir = Laporan::where('user_id', $p->id)
                                 ->where('jenis_laporan', 'akhir')
                                 ->first();
        }

        // Hitung total status laporan - penting untuk tampilan dan statistik
        $totalPeserta = count($peserta);
        $totalBulananMenunggu = 0;
        $totalBulananAcc = 0;
        $totalBulananDitolak = 0;
        $totalBulananBelum = 0;
        
        $totalAkhirMenunggu = 0;
        $totalAkhirAcc = 0;
        $totalAkhirDitolak = 0;
        $totalAkhirBelum = 0;

        foreach ($peserta as $p) {
            // Hitung status laporan bulanan
            if ($p->laporan_bulanan) {
                if ($p->laporan_bulanan->status == 'Menunggu') {
                    $totalBulananMenunggu++;
                } elseif ($p->laporan_bulanan->status == 'Acc') {
                    $totalBulananAcc++;
                } elseif ($p->laporan_bulanan->status == 'Ditolak') {
                    $totalBulananDitolak++;
                }
            } else {
                $totalBulananBelum++;
            }
            
            // Hitung status laporan akhir
            if ($p->laporan_akhir) {
                if ($p->laporan_akhir->status == 'Menunggu') {
                    $totalAkhirMenunggu++;
                } elseif ($p->laporan_akhir->status == 'Acc') {
                    $totalAkhirAcc++;
                } elseif ($p->laporan_akhir->status == 'Ditolak') {
                    $totalAkhirDitolak++;
                }
            } else {
                $totalAkhirBelum++;
            }
        }

        // Tambahkan data total peserta
        $data = [
            'peserta' => $peserta,
            'tahun' => $tahun,
            'bulan' => $bulan,
            'bulanNama' => $bulanNama,
            'direktorat' => $direktorat,
            'totalPeserta' => $totalPeserta,
            'totalBulananMenunggu' => $totalBulananMenunggu,
            'totalBulananAcc' => $totalBulananAcc,
            'totalBulananDitolak' => $totalBulananDitolak,
            'totalBulananBelum' => $totalBulananBelum,
            'totalAkhirMenunggu' => $totalAkhirMenunggu,
            'totalAkhirAcc' => $totalAkhirAcc,
            'totalAkhirDitolak' => $totalAkhirDitolak,
            'totalAkhirBelum' => $totalAkhirBelum
        ];

        // Debug - untuk memastikan data tersedia
        // dd($data);

        return view('admin.rekap_laporan', $data);
    }

    // Fungsi export Excel jika diperlukan
    public function exportExcel(Request $request)
    {
        $filterDate = $request->bulan ?? date('Y-m');
        $direktorat = $request->direktorat;

        list($tahun, $bulan) = explode('-', $filterDate);
        $bulanNama = Carbon::createFromDate($tahun, $bulan, 1)->locale('id')->isoFormat('MMMM YYYY');

        $fileName = 'RekapitulasiLaporan_' . str_replace(' ', '_', $bulanNama);
        if ($direktorat) {
            $fileName .= '_' . str_replace(' ', '_', $direktorat);
        }
        $fileName .= '.xlsx';

        return Excel::download(new RekapLaporanExport($filterDate, $direktorat), $fileName);
    }
}