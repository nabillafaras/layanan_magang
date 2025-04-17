<?php

namespace App\Exports;

use App\Models\Pendaftaran;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;

class DataPesertaAdminExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle, ShouldAutoSize
{
    protected $status;
    protected $direktorat;
    protected $search;

    public function __construct($status = null, $direktorat = null, $search = null)
    {
        $this->status = $status;
        $this->direktorat = $direktorat;
        $this->search = $search;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $query = Pendaftaran::query();
        
        // Filter berdasarkan status
        if ($this->status) {
            $query->where('status', $this->status);
        }
        
        // Filter berdasarkan direktorat
        if ($this->direktorat) {
            $query->where('direktorat', $this->direktorat);
        }
        
        // Filter berdasarkan pencarian
        if ($this->search) {
            $query->where(function($q) {
                $q->where('nama_lengkap', 'like', "%{$this->search}%")
                  ->orWhere('nomor_pendaftaran', 'like', "%{$this->search}%")
                  ->orWhere('asal_universitas', 'like', "%{$this->search}%");
            });
        }
        
        return $query->orderBy('created_at', 'desc')->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'No',
            'Nomor Pendaftaran',
            'Nama Lengkap',
            'Email',
            'No. Telepon',
            'Asal Universitas',
            'Program Studi',
            'Jenis Magang',
            'Durasi Magang',
            'Tanggal Mulai',
            'Tanggal Selesai',
            'Direktorat',
            'Status',
            'Tanggal Pendaftaran'
        ];
    }

    /**
     * @param mixed $pendaftaran
     * @return array
     */
    public function map($pendaftaran): array
    {
        // Hitung total absensi dan persentase
        $totalAbsensi = $pendaftaran->attendances()->count();
        $hadir = $pendaftaran->attendances()->where('status', 'hadir')->count();
        $persentaseKehadiran = $totalAbsensi > 0 ? round(($hadir / $totalAbsensi) * 100) : 0;
         
        return [
            static::rowNumber(),
            $pendaftaran->nomor_pendaftaran,
            $pendaftaran->nama_lengkap,
            $pendaftaran->email,
            $pendaftaran->no_telp,
            $pendaftaran->asal_universitas,
            $pendaftaran->program_studi,
            $pendaftaran->jenis_magang,
            $pendaftaran->durasi_magang . ' Bulan',
            $pendaftaran->tanggal_mulai ? Carbon::parse($pendaftaran->tanggal_mulai)->format('d-m-Y') : '-',
            $pendaftaran->tanggal_selesai ? Carbon::parse($pendaftaran->tanggal_selesai)->format('d-m-Y') : '-',
            $pendaftaran->direktorat,
            $pendaftaran->status,
            Carbon::parse($pendaftaran->created_at)->format('d-m-Y'),
        ];
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Data Peserta Magang';
    }

    /**
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text
            1 => ['font' => ['bold' => true]],
        ];
    }

    /**
     * Track row number
     * @return int
     */
    private static function rowNumber()
    {
        static $rowNumber = 0;
        return ++$rowNumber;
    }
}