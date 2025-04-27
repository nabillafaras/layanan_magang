<?php

namespace App\Exports;

use App\Models\Pendaftaran;
use App\Models\Laporan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Carbon\Carbon;

class RekapLaporanExport implements WithMultipleSheets
{
    protected $tahun;
    protected $bulan;
    protected $direktorat;
    protected $filterDate;
    protected $bulanNama;

    public function __construct($tahun, $bulan, $direktorat = null)
    {
        $this->tahun = $tahun;
        $this->bulan = $bulan;
        $this->direktorat = $direktorat;
        $this->filterDate = $tahun . '-' . $bulan;
        $this->bulanNama = Carbon::createFromDate($tahun, $bulan, 1)->locale('id')->isoFormat('MMMM YYYY');
    }

    public function sheets(): array
    {
        return [
            new LaporanBulananExport($this->tahun, $this->bulan, $this->direktorat, $this->filterDate, $this->bulanNama),
            new LaporanAkhirExport($this->tahun, $this->bulan, $this->direktorat, $this->filterDate, $this->bulanNama)
        ];
    }
}

// Sheet untuk Laporan Bulanan
class LaporanBulananExport implements FromCollection, WithHeadings, WithTitle, WithMapping, ShouldAutoSize, WithStyles, WithEvents
{
    protected $tahun;
    protected $bulan;
    protected $direktorat;
    protected $filterDate;
    protected $bulanNama;

    public function __construct($tahun, $bulan, $direktorat, $filterDate, $bulanNama)
    {
        $this->tahun = $tahun;
        $this->bulan = $bulan;
        $this->direktorat = $direktorat;
        $this->filterDate = $filterDate;
        $this->bulanNama = $bulanNama;
    }

    public function collection()
    {
        $query = Pendaftaran::where('status', 'diterima');

        if ($this->direktorat) {
            $query->where('direktorat', $this->direktorat);
        }

        $peserta = $query->get();

        foreach ($peserta as $p) {
            $p->laporan_bulanan = Laporan::where('user_id', $p->id)
                                    ->where('jenis_laporan', 'bulanan')
                                    ->whereRaw("DATE_FORMAT(periode_bulan, '%Y-%m') = ?", [$this->filterDate])
                                    ->first();
        }

        return $peserta;
    }

    public function headings(): array
    {
        return [
            'Nama Lengkap',
            'Direktorat',
            'Unit Kerja',
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
            $row->unit_kerja,
            $row->asal_universitas,
            $row->laporan_bulanan ? $row->laporan_bulanan->judul : 'Belum Upload',
            $row->laporan_bulanan ? $row->laporan_bulanan->status : 'Belum Upload',
            $row->laporan_bulanan ? ($row->laporan_bulanan->feedback ?: '-') : '-',
            $row->laporan_bulanan ? $row->laporan_bulanan->created_at->format('d/m/Y H:i') : '-'
        ];
    }

    public function title(): string
    {
        return 'Laporan Bulanan';
    }
    
    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:H1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '8B0000'],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ]);

        return [
            1 => [
                'font' => ['bold' => true],
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $lastRow = $event->sheet->getHighestRow();

                // Kode warna untuk status laporan
                for ($row = 2; $row <= $lastRow; $row++) {
                    $status = $event->sheet->getCell('F' . $row)->getValue();
                    if ($status == 'Acc') {
                        $event->sheet->getStyle('F' . $row)->getFill()
                            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                            ->getStartColor()->setRGB('28A745'); // Hijau
                    } elseif ($status == 'Menunggu') {
                        $event->sheet->getStyle('F' . $row)->getFill()
                            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                            ->getStartColor()->setRGB('FFC107'); // Kuning
                    } elseif ($status == 'Ditolak') {
                        $event->sheet->getStyle('F' . $row)->getFill()
                            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                            ->getStartColor()->setRGB('DC3545'); // Merah
                    } elseif ($status == 'Belum Upload') {
                        $event->sheet->getStyle('F' . $row)->getFill()
                            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                            ->getStartColor()->setRGB('6C757D'); // Abu-abu
                    }
                }

                // Tambahkan border untuk seluruh tabel
                $event->sheet->getStyle('A1:H' . $lastRow)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                    ],
                ]);

                // Align center untuk kolom status
                $event->sheet->getStyle('F1:F' . $lastRow)->applyFromArray([
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                ]);

                // Tambahkan judul laporan
                $event->sheet->mergeCells('A1:D1');
                $event->sheet->setCellValue('A1', 'Rekapitulasi Laporan Bulanan ' . $this->bulanNama);
            },
        ];
    }
}

// Sheet untuk Laporan Akhir
class LaporanAkhirExport implements FromCollection, WithHeadings, WithTitle, WithMapping, ShouldAutoSize, WithStyles, WithEvents
{
    protected $tahun;
    protected $bulan;
    protected $direktorat;
    protected $filterDate;
    protected $bulanNama;

    public function __construct($tahun, $bulan, $direktorat, $filterDate, $bulanNama)
    {
        $this->tahun = $tahun;
        $this->bulan = $bulan;
        $this->direktorat = $direktorat;
        $this->filterDate = $filterDate;
        $this->bulanNama = $bulanNama;
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
            'Unit Kerja',
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
            $row->unit_kerja,
            $row->asal_universitas,
            $row->laporan_akhir ? $row->laporan_akhir->judul : 'Belum Upload',
            $row->laporan_akhir ? $row->laporan_akhir->status : 'Belum Upload',
            $row->laporan_akhir ? ($row->laporan_akhir->feedback ?: '-') : '-',
            $row->laporan_akhir ? $row->laporan_akhir->created_at->format('d/m/Y H:i') : '-'
        ];
    }

    public function title(): string
    {
        return 'Laporan Akhir';
    }
    
    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:H1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '8B0000'],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ]);

        return [
            1 => [
                'font' => ['bold' => true],
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $lastRow = $event->sheet->getHighestRow();

                // Kode warna untuk status laporan
                for ($row = 2; $row <= $lastRow; $row++) {
                    $status = $event->sheet->getCell('F' . $row)->getValue();
                    if ($status == 'Acc') {
                        $event->sheet->getStyle('F' . $row)->getFill()
                            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                            ->getStartColor()->setRGB('28A745'); // Hijau
                    } elseif ($status == 'Menunggu') {
                        $event->sheet->getStyle('F' . $row)->getFill()
                            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                            ->getStartColor()->setRGB('FFC107'); // Kuning
                    } elseif ($status == 'Ditolak') {
                        $event->sheet->getStyle('F' . $row)->getFill()
                            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                            ->getStartColor()->setRGB('DC3545'); // Merah
                    } elseif ($status == 'Belum Upload') {
                        $event->sheet->getStyle('F' . $row)->getFill()
                            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                            ->getStartColor()->setRGB('6C757D'); // Abu-abu
                    }
                }

                // Tambahkan border untuk seluruh tabel
                $event->sheet->getStyle('A1:H' . $lastRow)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                    ],
                ]);

                // Align center untuk kolom status
                $event->sheet->getStyle('F1:F' . $lastRow)->applyFromArray([
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                ]);

                // Tambahkan judul laporan
                $event->sheet->mergeCells('A1:D1');
                $event->sheet->setCellValue('A1', 'Rekapitulasi Laporan Akhir ' . $this->bulanNama);
            },
        ];
    }
}