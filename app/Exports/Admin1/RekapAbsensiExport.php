<?php

namespace App\Exports;

use App\Models\Pendaftaran;
use App\Models\Attendance;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Carbon\Carbon;

class RekapAbsensiExport implements FromCollection, WithHeadings, WithTitle, ShouldAutoSize, WithStyles, WithMapping, WithEvents
{
    protected $tahun;
    protected $bulan;
    protected $direktorat;
    protected $totalDays;
    protected $bulanNama;

    public function __construct($tahun, $bulan, $direktorat = null)
    {
        $this->tahun = $tahun;
        $this->bulan = $bulan;
        $this->direktorat = $direktorat;
        $this->totalDays = Carbon::createFromDate($tahun, $bulan)->daysInMonth;
        $this->bulanNama = Carbon::createFromDate($tahun, $bulan, 1)->locale('id')->isoFormat('MMMM YYYY');
    }

    public function collection()
    {
        $query = Pendaftaran::where('status', 'diterima')
                     ->with(['attendances' => function($query) {
                         $query->whereYear('date', $this->tahun)
                               ->whereMonth('date', $this->bulan);
                     }]);

        if ($this->direktorat) {
            $query->where('direktorat', $this->direktorat);
        }

        return $query->get();
    }

    public function map($pendaftaran): array
    {
        $row = [
            $pendaftaran->nama_lengkap,
            $pendaftaran->direktorat,
            $pendaftaran->unit_kerja,
            $pendaftaran->asal_universitas,
        ];

        // Tambahkan data kehadiran per hari
        for ($day = 1; $day <= $this->totalDays; $day++) {
            $date = $this->tahun . '-' . $this->bulan . '-' . str_pad($day, 2, '0', STR_PAD_LEFT);
            $attendance = $pendaftaran->attendances->where('date', $date)->first();
            $row[] = $attendance ? $attendance->status : '-';
        }

        // Tambahkan rekapitulasi
        $row[] = $pendaftaran->attendances->where('status', 'H')->count();
        $row[] = $pendaftaran->attendances->where('status', 'S')->count();
        $row[] = $pendaftaran->attendances->where('status', 'I')->count();
        $row[] = $pendaftaran->attendances->where('status', 'A')->count();

        return $row;
    }

    public function headings(): array
    {
        $headings = [
            'Nama Lengkap',
            'Direktorat',
            'Unit Kerja',
            'Asal Institusi',
        ];

        // Tambahkan heading untuk setiap tanggal
        for ($day = 1; $day <= $this->totalDays; $day++) {
            $headings[] = $day;
        }

        // Tambahkan heading untuk rekapitulasi
        $headings[] = 'Hadir (H)';
        $headings[] = 'Sakit (S)';
        $headings[] = 'Izin (I)';
        $headings[] = 'Alpha (A)';

        return $headings;
    }

    public function title(): string
    {
        return 'Rekapitulasi Absensi ' . $this->bulanNama;
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:' . $this->getLastColumn() . '1')->applyFromArray([
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
                $lastColumn = $this->getLastColumn();
                $lastRow = $event->sheet->getHighestRow();

                // Kode warna untuk status absensi
                for ($row = 2; $row <= $lastRow; $row++) {
                    for ($col = 4; $col <= 3 + $this->totalDays; $col++) {
                        $cellValue = $event->sheet->getCellByColumnAndRow($col, $row)->getValue();
                        $columnLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col);

                        if ($cellValue == 'H') {
                            $event->sheet->getStyle($columnLetter . $row)->getFill()
                                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                                ->getStartColor()->setRGB('28A745');
                        } elseif ($cellValue == 'S') {
                            $event->sheet->getStyle($columnLetter . $row)->getFill()
                                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                                ->getStartColor()->setRGB('FFC107');
                        } elseif ($cellValue == 'I') {
                            $event->sheet->getStyle($columnLetter . $row)->getFill()
                                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                                ->getStartColor()->setRGB('17A2B8');
                        } elseif ($cellValue == 'A') {
                            $event->sheet->getStyle($columnLetter . $row)->getFill()
                                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                                ->getStartColor()->setRGB('DC3545');
                        }
                    }
                }

                // Tambahkan border untuk seluruh tabel
                $event->sheet->getStyle('A1:' . $lastColumn . $lastRow)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                    ],
                ]);

                // Align center untuk seluruh kolom tanggal dan rekapitulasi
                $event->sheet->getStyle('D1:' . $lastColumn . $lastRow)->applyFromArray([
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                ]);

                // Tambahkan judul laporan
                $event->sheet->mergeCells('A1:C1');
                $event->sheet->setCellValue('A1', 'Rekapitulasi Absensi Peserta Magang ' . $this->bulanNama);
            },
        ];
    }

    private function getLastColumn()
    {
        return \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(3 + $this->totalDays + 4); // +4 untuk kolom rekapitulasi
    }
}