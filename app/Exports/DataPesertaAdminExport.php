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
    protected $jenis_waktu;
    protected $tanggal_pendaftaran;
    protected $bulan_pendaftaran;
    
    public function __construct($status = null, $direktorat = null, $search = null, $jenis_waktu = null, $tanggal_pendaftaran = null, $bulan_pendaftaran = null)
    {
        $this->status = $status;
        $this->direktorat = $direktorat;
        $this->search = $search;
        $this->jenis_waktu = $jenis_waktu;
        $this->tanggal_pendaftaran = $tanggal_pendaftaran;
        $this->bulan_pendaftaran = $bulan_pendaftaran;
        
        // Log parameter untuk memastikan nilai diterima dengan benar
        \Illuminate\Support\Facades\Log::info('Export Parameters in Export Class', [
            'status' => $this->status,
            'direktorat' => $this->direktorat,
            'search' => $this->search,
            'jenis_waktu' => $this->jenis_waktu,
            'tanggal_pendaftaran' => $this->tanggal_pendaftaran,
            'bulan_pendaftaran' => $this->bulan_pendaftaran
        ]);
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
        
        // Filter berdasarkan tanggal atau bulan pendaftaran
        if ($this->jenis_waktu == 'tanggal' && $this->tanggal_pendaftaran) {
            $query->whereDate('created_at', $this->tanggal_pendaftaran);
        } elseif ($this->jenis_waktu == 'bulan' && $this->bulan_pendaftaran) {
            $bulan = $this->bulan_pendaftaran; // Format: YYYY-MM
            $tahun = substr($bulan, 0, 4);
            $bulan_angka = substr($bulan, 5, 2);
            $query->whereYear('created_at', $tahun)
                ->whereMonth('created_at', $bulan_angka);
        } elseif (!$this->jenis_waktu && $this->tanggal_pendaftaran) {
            // Backward compatibility dengan filter lama
            $query->whereDate('created_at', $this->tanggal_pendaftaran);
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
            'Asal Institusi',
            'Jurusan',
            'Keahlian yang Diambil',
            'Durasi Magang',
            'Tanggal Mulai',
            'Tanggal Selesai',
            'Direktorat',
            'Unit Kerja',
            'Status',
            'Tanggal Pendaftaran'
        ];
    }

    /**
     * Menghitung durasi magang dalam bulan berdasarkan tanggal mulai dan selesai
     * 
     * @param string|null $tanggal_mulai
     * @param string|null $tanggal_selesai
     * @return string
     */
    private function hitungDurasiMagang($tanggal_mulai, $tanggal_selesai)
    {
        if (!$tanggal_mulai || !$tanggal_selesai) {
            return '-';
        }

        $mulai = Carbon::parse($tanggal_mulai);
        $selesai = Carbon::parse($tanggal_selesai);
        
        // Jika tanggal selesai sebelum tanggal mulai, return 0
        if ($selesai->lt($mulai)) {
            return '0 Bulan';
        }
        
        // Hitung selisih bulan
        $diffInMonths = $mulai->diffInMonths($selesai);
        
        // Hitung sisa hari setelah menambahkan bulan penuh
        $setelahDitambahBulan = (clone $mulai)->addMonths($diffInMonths);
        $sisaHari = $setelahDitambahBulan->diffInDays($selesai);
        
        // Jika ada sisa hari dan tanggal akhir >= tanggal mulai, tambahkan 1 bulan
        if ($sisaHari > 0 && $selesai->format('d') >= $mulai->format('d')) {
            $diffInMonths += 1;
        }
        
        return $diffInMonths . ' Bulan';
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
        
        // Hitung durasi magang berdasarkan tanggal mulai dan selesai
        $durasiMagang = $this->hitungDurasiMagang(
            $pendaftaran->tanggal_mulai, 
            $pendaftaran->tanggal_selesai
        );
         
        return [
            static::rowNumber(),
            $pendaftaran->nomor_pendaftaran,
            $pendaftaran->nama_lengkap,
            $pendaftaran->email,
            $pendaftaran->no_hp,
            $pendaftaran->asal_universitas,
            $pendaftaran->jurusan,
            $pendaftaran->prodi,
            $durasiMagang,
            $pendaftaran->tanggal_mulai ? Carbon::parse($pendaftaran->tanggal_mulai)->format('d-m-Y') : '-',
            $pendaftaran->tanggal_selesai ? Carbon::parse($pendaftaran->tanggal_selesai)->format('d-m-Y') : '-',
            $pendaftaran->direktorat,
            $pendaftaran->unit_kerja,
            $pendaftaran->status,
            Carbon::parse($pendaftaran->created_at)->format('d-m-Y'),
        ];
    }

    /**
     * @return string
     */
    public function title(): string
    {
        // Tambahkan informasi filter ke judul worksheet
        $title = 'Data Peserta Magang';
        
        if ($this->jenis_waktu == 'tanggal' && $this->tanggal_pendaftaran) {
            $tanggal = Carbon::parse($this->tanggal_pendaftaran)->format('d-m-Y');
            $title .= ' (' . $tanggal . ')';
        } elseif ($this->jenis_waktu == 'bulan' && $this->bulan_pendaftaran) {
            $bulan = Carbon::parse($this->bulan_pendaftaran . '-01')->format('F Y');
            $title .= ' (' . $bulan . ')';
        }
        
        return $title;
    }

    /**
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        // Ubah style header ke baris 2, karena baris 1 untuk judul laporan
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
            // Style untuk judul laporan di baris 1
            1 => [
                'font' => [
                    'bold' => true,
                    'size' => 14
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ],
            // Style untuk heading kolom di baris 2
            2 => [
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

                // Sisipkan baris judul di baris pertama dan geser data ke bawah
                $event->sheet->insertNewRowBefore(1, 1);
                
                // Atur judul laporan di baris 1
                $event->sheet->mergeCells('A1:' . $lastColumn . '1');
                $judulLaporan = 'DATA PESERTA MAGANG';
                
                // Tambahkan informasi filter ke judul laporan
                if ($this->status) {
                    $judulLaporan .= ' - Status: ' . ucfirst($this->status);
                }
                
                if ($this->direktorat) {
                    $judulLaporan .= ' - Direktorat: ' . $this->direktorat;
                }
                
                if ($this->jenis_waktu == 'tanggal' && $this->tanggal_pendaftaran) {
                    $tanggal = Carbon::parse($this->tanggal_pendaftaran)->format('d-m-Y');
                    $judulLaporan .= ' - Tanggal: ' . $tanggal;
                } elseif ($this->jenis_waktu == 'bulan' && $this->bulan_pendaftaran) {
                    $bulan = Carbon::parse($this->bulan_pendaftaran . '-01')->format('F Y');
                    $judulLaporan .= ' - Bulan: ' . $bulan;
                }
                
                $event->sheet->setCellValue('A1', $judulLaporan);
                $event->sheet->getRowDimension(1)->setRowHeight(30);

                // Tambahkan status highlight jika diperlukan
                // Kolom status sekarang ada di kolom 14, karena kita menambahkan baris tambahan
                for ($row = 3; $row <= $lastRow + 1; $row++) {
                    $cellValue = $event->sheet->getCellByColumnAndRow(14, $row)->getValue(); // Status column
                    $columnLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(14);
                    
                    if (strtolower($cellValue) == 'diterima') {
                        $event->sheet->getStyle($columnLetter . $row)->getFill()
                            ->setFillType(Fill::FILL_SOLID)
                            ->getStartColor()->setRGB('28A745');
                    } elseif (strtolower($cellValue) == 'ditolak') {
                        $event->sheet->getStyle($columnLetter . $row)->getFill()
                            ->setFillType(Fill::FILL_SOLID)
                            ->getStartColor()->setRGB('DC3545');
                    } elseif (strtolower($cellValue) == 'menunggu' || strtolower($cellValue) == 'diproses') {
                        $event->sheet->getStyle($columnLetter . $row)->getFill()
                            ->setFillType(Fill::FILL_SOLID)
                            ->getStartColor()->setRGB('FFC107');
                    }
                }

                // Tambahkan border untuk seluruh tabel (mulai dari baris 2 - header)
                $event->sheet->getStyle('A2:' . $lastColumn . ($lastRow + 1))->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                        ],
                    ],
                ]);

                // Align center untuk kolom nomor dan status (sekarang dimulai dari baris 3 untuk data)
                $event->sheet->getStyle('A3:A' . ($lastRow + 1))->applyFromArray([
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                    ],
                ]);

                $event->sheet->getStyle('L3:N' . ($lastRow + 1))->applyFromArray([
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                    ],
                ]);
            },
        ];
    }

    /**
     * Get last column letter
     * @return string
     */
    private function getLastColumn()
    {
        return \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(15); // Total kolom adalah 15
    }
}