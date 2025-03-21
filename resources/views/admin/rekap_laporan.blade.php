@extends('layouts.header_admin')

@section('title', 'Rekapitulasi Laporan Peserta Magang - Kementerian Sosial RI')

@section('additional_css')
<style>
    body {
        font-family: 'Calibri', sans-serif;
    }
    .card {
        box-shadow: 0 0 1px rgba(0,0,0,0.125), 0 1px 3px rgba(0,0,0,0.2);
    }
    .badge.text-bg-warning {
        background-color: #ffc107 !important;
        color: #212529 !important;
    }
    .badge.text-bg-success {
        background-color: #28a745 !important;
        color: white !important;
    }
    .badge.text-bg-danger {
        background-color: #dc3545 !important;
        color: white !important;
    }
    .badge.text-bg-secondary {
        background-color: #6c757d !important;
        color: white !important;
    }
    
    /* Fallback untuk Bootstrap 4.x jika diperlukan */
    .badge-warning {
        background-color: #ffc107 !important;
        color: #212529 !important;
    }
    .badge-success {
        background-color: #28a745 !important;
        color: white !important;
    }
    .badge-danger {
        background-color: #dc3545 !important;
        color: white !important;
    }
    .badge-secondary {
        background-color: #6c757d !important;
        color: white !important;
    }
    .badge.bg-secondary {
        background-color: #6c757d !important;
        color: white !important;
    }
    .badge.bg-warning {
        background-color: #ffc107 !important;
        color: #212529 !important;
    }
    .badge.bg-success {
        background-color: #28a745 !important;
        color: white !important;
    }
    .badge.bg-danger {
        background-color: #dc3545 !important;
        color: white !important;
    }
    .badge.bg-primary {
        background-color: #0d6efd !important;
        color: white !important;
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Rekapitulasi Laporan Peserta Magang</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Rekapitulasi Laporan</li>
    </ol>

    <!-- Filter Section -->
    <div class="card mb-4">
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <i class="fas fa-file-alt me-1"></i>
                    Filter Data Laporan
                </div>
                <div class="col-md-6 text-end">
                    <form action="{{ route('admin.rekapitulasi-laporan') }}" method="GET" class="row g-3 justify-content-end">
                        <div class="col-auto">
                            <input type="month" class="form-control" id="bulan" name="bulan" value="{{ request('bulan', date('Y-m')) }}">
                        </div>
                        <div class="col-auto">
                            <select class="form-select" name="direktorat" id="direktorat">
                                <option value="">Semua Direktorat</option>
                                <option value="Direktorat 1" {{ request('direktorat') == 'Direktorat 1' ? 'selected' : '' }}>Direktorat Rehabilitasi Sosial</option>
                                <option value="Direktorat 2" {{ request('direktorat') == 'Direktorat 2' ? 'selected' : '' }}>Direktorat Perlindungan Sosial</option>
                                <option value="Direktorat 3" {{ request('direktorat') == 'Direktorat 3' ? 'selected' : '' }}>Direktorat Pemberdayaan Sosial</option>
                                <option value="Direktorat 4" {{ request('direktorat') == 'Direktorat 4' ? 'selected' : '' }}>Direktorat Penanganan Fakir Miskin</option>
                                <option value="Direktorat 5" {{ request('direktorat') == 'Direktorat 5' ? 'selected' : '' }}>Direktorat Jaminan Sosial</option>
                            </select>
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </div>
                        <div class="col-auto">
                            <a href="{{ route('admin.export-laporan') }}?bulan={{ request('bulan', date('Y-m')) }}&direktorat={{ request('direktorat', '') }}" class="btn btn-success">
                                <i class="fas fa-file-excel me-1"></i> Export Excel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Laporan Bulanan Section -->
<div class="card mb-4">
    <div class="card-header">
        <div class="row align-items-center">
            <div class="col">
                <i class="fas fa-calendar-alt me-1"></i>
                Rekapitulasi Laporan Bulanan - {{ $bulanNama ?? 'Semua Periode' }}
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered" id="laporanBulananTable">
                <thead class="table-dark">
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Nama Lengkap</th>
                        <th class="text-center">Direktorat</th>
                        <th class="text-center">Asal Instansi</th>
                        <th class="text-center">Judul Laporan</th>
                        <th class="text-center">File</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Feedback</th>
                        <th class="text-center">Tanggal Upload</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($peserta as $index => $p)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $p->nama_lengkap }}</td>
                        <td>{{ $p->direktorat }}</td>
                        <td>{{ $p->asal_universitas }}</td>
                        
                        @if ($p->laporan_bulanan)
                        <td>{{ $p->laporan_bulanan->judul }}</td>
                        <td class="text-center">
                            <a href="{{ asset('storage/'.$p->laporan_bulanan->file_path) }}" target="_blank" class="btn btn-sm btn-info">
                                <i class="fas fa-file-download"></i> Unduh
                            </a>
                        </td>
                        <td class="text-center">
                            @if ($p->laporan_bulanan->status == 'Menunggu')
                                <span class="badge text-bg-warning">{{ $p->laporan_bulanan->status }}</span>
                            @elseif ($p->laporan_bulanan->status == 'Acc')
                                <span class="badge text-bg-success">{{ $p->laporan_bulanan->status }}</span>
                            @elseif ($p->laporan_bulanan->status == 'Ditolak')
                                <span class="badge text-bg-danger">{{ $p->laporan_bulanan->status }}</span>
                            @endif
                        </td>
                        <td>{{ $p->laporan_bulanan->feedback ?? '-' }}</td>
                        <td class="text-center">{{ $p->laporan_bulanan->created_at->format('d/m/Y H:i') }}</td>
                        @else
                        <td colspan="5" class="text-center">
                            <span class="badge text-bg-secondary">Belum Upload Laporan</span>
                        </td>
                        @endif
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center">Tidak ada data laporan bulanan peserta magang yang tersedia.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Laporan Akhir Section -->
<div class="card mb-4">
    <div class="card-header">
        <div class="row align-items-center">
            <div class="col">
                <i class="fas fa-file-signature me-1"></i>
                Rekapitulasi Laporan Akhir
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered" id="laporanAkhirTable">
                <thead class="table-dark">
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Nama Lengkap</th>
                        <th class="text-center">Direktorat</th>
                        <th class="text-center">Asal Instansi</th>
                        <th class="text-center">Judul Laporan</th>
                        <th class="text-center">File</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Feedback</th>
                        <th class="text-center">Tanggal Upload</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($peserta as $index => $p)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $p->nama_lengkap }}</td>
                        <td>{{ $p->direktorat }}</td>
                        <td>{{ $p->asal_universitas }}</td>
                        
                        @if ($p->laporan_akhir)
                        <td>{{ $p->laporan_akhir->judul }}</td>
                        <td class="text-center">
                        <a href="{{ asset('storage/'.$p->laporan_akhir->file_path) }}" target="_blank" class="btn btn-sm btn-info">
                                <i class="fas fa-file-download"></i> Unduh
                            </a>
                        </td>
                        <td class="text-center">
                            @if ($p->laporan_akhir->status == 'Menunggu')
                                <span class="badge text-bg-warning">{{ $p->laporan_akhir->status }}</span>
                            @elseif ($p->laporan_akhir->status == 'Acc')
                                <span class="badge text-bg-success">{{ $p->laporan_akhir->status }}</span>
                            @elseif ($p->laporan_akhir->status == 'Ditolak')
                                <span class="badge text-bg-danger">{{ $p->laporan_akhir->status }}</span>
                            @endif
                        </td>
                        <td>{{ $p->laporan_akhir->feedback ?? '-' }}</td>
                        <td class="text-center">{{ $p->laporan_akhir->created_at->format('d/m/Y H:i') }}</td>
                        @else
                        <td colspan="5" class="text-center">
                            <span class="badge text-bg-secondary">Belum Upload Laporan</span>
                        </td>
                        @endif
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center">Tidak ada data laporan akhir peserta magang yang tersedia.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

    <!-- Statistik Laporan -->
    <div class="row">
        <!-- Statistik Laporan Bulanan -->
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-pie me-1"></i>
                    Statistik Laporan Bulanan
                </div>
                <div class="card-body">
                    <canvas id="laporanBulananChart" width="100%" height="50"></canvas>
                </div>
            </div>
        </div>
        
        <!-- Statistik Laporan Akhir -->
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-pie me-1"></i>
                    Statistik Laporan Akhir
                </div>
                <div class="card-body">
                    <canvas id="laporanAkhirChart" width="100%" height="50"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Keterangan -->
    <div class="row mt-4">
    <!-- Keterangan Laporan Bulanan -->
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <i class="fas fa-info-circle me-1"></i>
                Status Laporan Bulanan - {{ $bulanNama }}
            </div>
            <div class="card-body">
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Belum Upload
                        <span class="badge bg-secondary rounded-pill">{{ $totalBulananBelum }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Menunggu Konfirmasi
                        <span class="badge bg-warning text-dark rounded-pill">{{ $totalBulananMenunggu }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Acc
                        <span class="badge bg-success rounded-pill">{{ $totalBulananAcc }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Ditolak
                        <span class="badge bg-danger rounded-pill">{{ $totalBulananDitolak }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center fw-bold">
                        Total Peserta
                        <span class="badge bg-primary rounded-pill">{{ $totalPeserta }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    
    <!-- Keterangan Laporan Akhir -->
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <i class="fas fa-info-circle me-1"></i>
                Status Laporan Akhir
            </div>
            <div class="card-body">
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Belum Upload
                        <span class="badge bg-secondary rounded-pill">{{ $totalAkhirBelum }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Menunggu Konfirmasi
                        <span class="badge bg-warning text-dark rounded-pill">{{ $totalAkhirMenunggu }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Acc
                        <span class="badge bg-success rounded-pill">{{ $totalAkhirAcc }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Ditolak
                        <span class="badge bg-danger rounded-pill">{{ $totalAkhirDitolak }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center fw-bold">
                        Total Peserta
                        <span class="badge bg-primary rounded-pill">{{ $totalPeserta }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
</div>
@endsection

@section('additional_scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">

<script>
    $(document).ready(function() {
        // Inisialisasi DataTables untuk kedua tabel
        $('#laporanBulananTable').DataTable({
            "scrollX": true,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/id.json"
            }
        });
        
        $('#laporanAkhirTable').DataTable({
            "scrollX": true,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/id.json"
            }
        });

        // Pie Chart untuk Laporan Bulanan
        var ctxBulanan = document.getElementById('laporanBulananChart');
        var bulananChart = new Chart(ctxBulanan, {
            type: 'pie',
            data: {
                labels: ['Belum Upload', 'Menunggu', 'Acc', 'Ditolak'],
                datasets: [{
                    data: [
                        {{ $totalBulananBelum ?? 0 }}, 
                        {{ $totalBulananMenunggu ?? 0 }}, 
                        {{ $totalBulananAcc ?? 0 }}, 
                        {{ $totalBulananDitolak ?? 0 }}
                    ],
                    backgroundColor: [
                        '#6c757d',  // Belum Upload (abu-abu)
                        '#ffc107',  // Menunggu (kuning)
                        '#28a745',  // Diterima (hijau)
                        '#dc3545'   // Ditolak (merah)
                    ],
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                var label = context.label || '';
                                var value = context.raw || 0;
                                var total = context.dataset.data.reduce((a, b) => a + b, 0);
                                var percentage = Math.round((value / total) * 100);
                                return label + ': ' + value + ' (' + percentage + '%)';
                            }
                        }
                    }
                }
            }
        });
        
        // Pie Chart untuk Laporan Akhir
        var ctxAkhir = document.getElementById('laporanAkhirChart');
        var akhirChart = new Chart(ctxAkhir, {
            type: 'pie',
            data: {
                labels: ['Belum Upload', 'Menunggu', 'Acc', 'Ditolak'],
                datasets: [{
                    data: [
                        {{ $totalAkhirBelum ?? 0 }}, 
                        {{ $totalAkhirMenunggu ?? 0 }}, 
                        {{ $totalAkhirAcc ?? 0 }}, 
                        {{ $totalAkhirDitolak ?? 0 }}
                    ],
                    backgroundColor: [
                        '#6c757d',  // Belum Upload (abu-abu)
                        '#ffc107',  // Menunggu (kuning)
                        '#28a745',  // Diterima (hijau)
                        '#dc3545'   // Ditolak (merah)
                    ],
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                var label = context.label || '';
                                var value = context.raw || 0;
                                var total = context.dataset.data.reduce((a, b) => a + b, 0);
                                var percentage = Math.round((value / total) * 100);
                                return label + ': ' + value + ' (' + percentage + '%)';
                            }
                        }
                    }
                }
            }
        });
    });
</script>
@endsection