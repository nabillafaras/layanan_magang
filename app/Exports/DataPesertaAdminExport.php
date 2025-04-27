<?php

namespace App\Exports;

use App\Models\Pendaftaran;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Carbon\Carbon;

class DataPesertaAdminExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle, ShouldAutoSize, WithEvents
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
        $sheet->getStyle('A1:' . $this->getLastColumn() . '1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '8B0000'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        return [
            1 => [
                'font' => ['bold' => true],
            ],
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

    /**
     * Register events for after sheet creation
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $lastColumn = $this->getLastColumn();
                $lastRow = $event->sheet->getHighestRow();

                // Tambahkan status highlight jika diperlukan
                // Contoh: Highlight status 'diterima' dengan warna hijau
                for ($row = 2; $row <= $lastRow; $row++) {
                    $cellValue = $event->sheet->getCellByColumnAndRow(13, $row)->getValue(); // Status column
                    $columnLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(13);
                    
                    if ($cellValue == 'diterima') {
                        $event->sheet->getStyle($columnLetter . $row)->getFill()
                            ->setFillType(Fill::FILL_SOLID)
                            ->getStartColor()->setRGB('28A745');
                    } elseif ($cellValue == 'ditolak') {
                        $event->sheet->getStyle($columnLetter . $row)->getFill()
                            ->setFillType(Fill::FILL_SOLID)
                            ->getStartColor()->setRGB('DC3545');
                    } elseif ($cellValue == 'menunggu') {
                        $event->sheet->getStyle($columnLetter . $row)->getFill()
                            ->setFillType(Fill::FILL_SOLID)
                            ->getStartColor()->setRGB('FFC107');
                    }
                }

                // Tambahkan border untuk seluruh tabel
                $event->sheet->getStyle('A1:' . $lastColumn . $lastRow)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                        ],
                    ],
                ]);

                // Align center untuk kolom nomor dan status
                $event->sheet->getStyle('A1:A' . $lastRow)->applyFromArray([
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                    ],
                ]);

                $event->sheet->getStyle('L1:N' . $lastRow)->applyFromArray([
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                    ],
                ]);

                // Tambahkan judul laporan
                $event->sheet->mergeCells('A1:B1');
                $event->sheet->setCellValue('A1', 'Data Peserta Magang');
            },
        ];
    }

    /**
     * Get last column letter
     * @return string
     */
    private function getLastColumn()
    {
        return \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(14); // Total kolom adalah 14
    }
}