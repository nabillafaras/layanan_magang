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
    protected $filterDate;
    protected $bulanNama;

    public function __construct($tahun, $bulan, $direktorat = null)
    {
        $this->tahun = $tahun;
        $this->bulan = $bulan;
        $this->direktorat = $direktorat;
        $this->totalDays = Carbon::createFromDate($tahun, $bulan)->daysInMonth;
        $this->filterDate = $tahun . '-' . $bulan;
        $this->bulanNama = Carbon::createFromDate($tahun, $bulan, 1)->locale('id')->isoFormat('MMMM YYYY');
    }

    public function collection()
    {
        $tahun = date('Y', strtotime($this->filterDate . '-01'));
        $bulan = date('n', strtotime($this->filterDate . '-01'));

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
        // Load relasi attendances untuk bulan yang dipilih
        ->with(['attendances' => function($attendanceQuery) use ($tahun, $bulan) {
            $attendanceQuery->whereYear('date', $tahun)
                           ->whereMonth('date', $bulan);
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
        $row[] = $pendaftaran->attendances->where('status', 'hadir')->count();
        $row[] = $pendaftaran->attendances->where('status', 'sakit')->count();
        $row[] = $pendaftaran->attendances->where('status', 'izin')->count();
        $row[] = $pendaftaran->attendances->where('status', 'terlambat')->count();

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
        $headings[] = 'Terlambat (T)'; // Menambahkan kolom Alpha yang sebelumnya hilang
        

        return $headings;
    }

    public function title(): string
    {
        return 'Rekapitulasi Absensi ' . $this->bulanNama;
    }

    public function styles(Worksheet $sheet)
    {
        // Style untuk header tabel
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

        // Style untuk judul absensi
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

        return [];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $lastColumn = $this->getLastColumn();
                $lastRow = $event->sheet->getHighestRow();

                // Tambahkan baris untuk judul absensi
                $event->sheet->insertNewRowBefore(1, 1);
                
                // Gabungkan sel untuk judul absensi
                $event->sheet->mergeCells('A1:' . $lastColumn . '1');
                $event->sheet->setCellValue('A1', 'Rekapitulasi Absensi Peserta Magang ' . $this->bulanNama);
                
                // Tinggi baris judul
                $event->sheet->getRowDimension(1)->setRowHeight(30);

                // Kode warna untuk status absensi (perhatikan offset baris +1 karena ada judul di baris 1)
                for ($row = 3; $row <= $lastRow + 1; $row++) {
                    for ($col = 5; $col <= 4 + $this->totalDays; $col++) {
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
                                ->getStartColor()->setRGB('DC3545'); // Warna merah untuk Alpha
                        }
                    }
                }

                // Tambahkan border untuk seluruh tabel termasuk judul
                $event->sheet->getStyle('A1:' . $lastColumn . ($lastRow + 1))->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                    ],
                ]);

                // Align center untuk seluruh kolom tanggal dan rekapitulasi
                $event->sheet->getStyle('E3:' . $lastColumn . ($lastRow + 1))->applyFromArray([
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                ]);
            },
        ];
    }

    private function getLastColumn()
    {
        return \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(4 + $this->totalDays + 4); // +4 untuk kolom rekapitulasi
    }
}