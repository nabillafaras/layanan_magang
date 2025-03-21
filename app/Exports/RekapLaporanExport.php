<?php

namespace App\Exports;

use App\Models\Pendaftaran;
use App\Models\Laporan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Illuminate\Support\Collection;

class RekapLaporanExport implements WithMultipleSheets
{
    protected $filterDate;
    protected $direktorat;

    public function __construct($filterDate, $direktorat = null)
    {
        $this->filterDate = $filterDate;
        $this->direktorat = $direktorat;
    }

    public function sheets(): array
    {
        $sheets = [
            new LaporanBulananExport($this->filterDate, $this->direktorat),
            new LaporanAkhirExport($this->filterDate, $this->direktorat)
        ];

        return $sheets;
    }
}

// Sheet untuk Laporan Bulanan
class LaporanBulananExport implements FromCollection, WithHeadings, WithTitle, WithMapping, ShouldAutoSize
{
    protected $filterDate;
    protected $direktorat;

    public function __construct($filterDate, $direktorat = null)
    {
        $this->filterDate = $filterDate;
        $this->direktorat = $direktorat;
    }

    public function collection()
    {
        // Set default ke bulan dan tahun sekarang jika tidak ada filter
        $filterDate = $request->bulan ?? date('Y-m');
        

        $query = Pendaftaran::where('status', 'diterima');

        if ($this->direktorat) {
            $query->where('direktorat', $this->direktorat);
        }

        $peserta = $query->get();

        foreach ($peserta as $p) {
            $p->laporan_bulanan = Laporan::where('user_id', $p->id)
                                    ->where('jenis_laporan', 'bulanan')
                                    ->whereRaw("DATE_FORMAT(periode_bulan, '%Y-%m') = ?", [$filterDate])
                                    ->first();
        }

        return $peserta;
    }

    public function headings(): array
    {
        return [
            'Nama Lengkap',
            'Direktorat',
            'Asal Instansi',
            'Judul Laporan',
            'Status',
            'Feedback',
            'Tanggal Upload'
        ];
    }

    public function map($row): array
    {
        return [
            $row->nama_lengkap,
            $row->direktorat,
            $row->asal_universitas,
            $row->laporan_bulanan ? $row->laporan_bulanan->judul : 'Belum Upload',
            $row->laporan_bulanan ? $row->laporan_bulanan->status : 'Belum Upload',
            $row->laporan_bulanan ? $row->laporan_bulanan->feedback : '-',
            $row->laporan_bulanan ? $row->laporan_bulanan->created_at->format('d/m/Y H:i') : '-'
        ];
    }

    public function title(): string
    {
        return 'Laporan Bulanan';
    }
}

// Sheet untuk Laporan Akhir
class LaporanAkhirExport implements FromCollection, WithHeadings, WithTitle, WithMapping, ShouldAutoSize
{
    protected $filterDate;
    protected $direktorat;

    public function __construct($filterDate, $direktorat = null)
    {
        $this->filterDate = $filterDate;
        $this->direktorat = $direktorat;
    }

    public function collection()
    {
        $query = Pendaftaran::where('status', 'diterima');

        if ($this->direktorat) {
            $query->where('direktorat', $this->direktorat);
        }

        $peserta = $query->get();

        foreach ($peserta as $p) {
            $p->laporan_akhir = Laporan::where('user_id', $p->id)
                                   ->where('jenis_laporan', 'akhir')
                                   ->first();
        }

        return $peserta;
    }

    public function headings(): array
    {
        return [
            'Nama Lengkap',
            'Direktorat',
            'Asal Instansi',
            'Judul Laporan',
            'Status',
            'Feedback',
            'Tanggal Upload'
        ];
    }

    public function map($row): array
    {
        return [
            $row->nama_lengkap,
            $row->direktorat,
            $row->asal_universitas,
            $row->laporan_akhir ? $row->laporan_akhir->judul : 'Belum Upload',
            $row->laporan_akhir ? $row->laporan_akhir->status : 'Belum Upload',
            $row->laporan_akhir ? $row->laporan_akhir->feedback : '-',
            $row->laporan_akhir ? $row->laporan_akhir->created_at->format('d/m/Y H:i') : '-'
        ];
    }

    public function title(): string
    {
        return 'Laporan Akhir';
    }
}