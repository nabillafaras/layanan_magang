@extends('layouts.header_admin3')

@section('title', 'Rekapitulasi Laporan Peserta Magang - Kementerian Sosial RI')

@section('additional_css')
<style>
    /* Dashboard Specific Styles */
    .dashboard-header {
        margin-bottom: 30px;
        position: relative;
    }
    
    .dashboard-header h2 {
        font-weight: 700;
        color: var(--primary-color);
        position: relative;
        display: inline-block;
        padding-bottom: 10px;
    }
    
    .dashboard-header h2::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: 0;
        height: 4px;
        width: 60px;
        background: linear-gradient(90deg, var(--primary-color), #c13030);
        border-radius: 2px;
    }

    .breadcrumb {
        background-color: transparent;
        padding: 0;
        margin-bottom: 20px;
    }
    
    .breadcrumb-item a {
        color: var(--primary-color);
        text-decoration: none;
        transition: all 0.3s;
    }
    
    .breadcrumb-item a:hover {
        color: #c13030;
        text-decoration: underline;
    }
    
    .breadcrumb-item.active {
        color: #6c757d;
    }
    
    .breadcrumb-item + .breadcrumb-item::before {
        content: ">";
        color: #6c757d;
    }
    
    .dashboard-card {
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        transition: all 0.3s;
        margin-bottom: 25px;
        overflow: hidden;
        border: none;
    }
    
    .dashboard-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1);
    }
    
    .card-header {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-bottom: 1px solid #e0e0e0;
        padding: 18px 25px;
    }
    
    .card-header h5 {
        margin: 0;
        font-weight: 600;
        color: #333;
        display: flex;
        align-items: center;
    }
    
    .card-header h5 i, .card-header i {
        margin-right: 10px;
        color: var(--primary-color);
    }
    
    .table {
        width: 100%;
        margin-bottom: 0;
    }
    
    .table th {
        background-color: #f8f9fa;
        color: #333;
        font-weight: 600;
        padding: 15px;
        border-bottom: 2px solid #e0e0e0;
        white-space: nowrap;
    }
    
    .table td {
        padding: 15px;
        vertical-align: middle;
        border-bottom: 1px solid #e0e0e0;
        transition: all 0.3s;
    }
    
    .table tr:hover td:not([class*="bg-"]) {
        background-color: rgba(139, 0, 0, 0.02);
    }
    
    .table tr:last-child td {
        border-bottom: none;
    }
    
    .table-dark th {
        background-color: var(--primary-color);
        color: white;
        border-color: #5a0000;
    }
    
    .form-control, .form-select {
        border-radius: 8px;
        padding: 0.75rem 1rem;
        border: 1px solid #ced4da;
        transition: all 0.3s;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.25rem rgba(139, 0, 0, 0.25);
    }
    
    .btn {
        font-weight: 600;
        padding: 0.6rem 1.2rem;
        border-radius: 50px;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: none;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        position: relative;
        overflow: hidden;
        z-index: 1;
    }
    
    .btn::after {
        content: '';
        position: absolute;
        width: 0;
        height: 100%;
        top: 0;
        left: 0;
        transition: width 0.3s ease;
        z-index: -1;
        border-radius: 50px;
    }
    
    .btn:hover::after {
        width: 100%;
    }
    
    .btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }
    
    .btn-primary {
        background: linear-gradient(135deg, var(--primary-color), #5a0000);
        color: white;
    }
    
    .btn-primary::after {
        background-color: rgba(255, 255, 255, 0.2);
    }
    
    .btn-success {
        background: linear-gradient(135deg, #28a745, #218838);
        color: white;
    }
    
    .btn-success::after {
        background-color: rgba(255, 255, 255, 0.2);
    }
    
    .list-group-item {
        border-radius: 8px;
        margin-bottom: 5px;
        border: 1px solid rgba(0,0,0,0.125);
        transition: all 0.3s;
    }
    
    .list-group-item:hover {
        transform: translateX(5px);
        background-color: rgba(139, 0, 0, 0.02);
    }
    
    .badge {
        padding: 8px 12px;
        font-weight: 500;
        border-radius: 30px;
        font-size: 0.85rem;
    }
    
    .bg-success {
        background-color: #28a745 !important;
    }
    
    .bg-warning {
        background-color: #ffc107 !important;
    }
    
    .bg-info {
        background-color: #17a2b8 !important;
    }
    
    .bg-danger {
        background-color: #dc3545 !important;
    }
    
    /* Animation Classes */
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    @keyframes slideInLeft {
        from { transform: translateX(-50px); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    
    @keyframes slideInRight {
        from { transform: translateX(50px); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    
    @keyframes slideInUp {
        from { transform: translateY(50px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
    
    @keyframes bounceIn {
        0% { transform: scale(0.8); opacity: 0; }
        50% { transform: scale(1.05); opacity: 0.8; }
        100% { transform: scale(1); opacity: 1; }
    }
    
    .fade-in {
        animation: fadeIn 0.5s ease-in-out;
    }
    
    .slide-in-left {
        animation: slideInLeft 0.5s ease-in-out;
    }
    
    .slide-in-right {
        animation: slideInRight 0.5s ease-in-out;
    }
    
    .slide-in-up {
        animation: slideInUp 0.5s ease-in-out;
    }
    
    .bounce-in {
        animation: bounceIn 0.6s ease-in-out;
    }
    
    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .table-responsive {
            border-radius: 15px;
        }
        
        .filter-form {
            flex-direction: column;
        }
        
        .filter-form .col-auto {
            margin-bottom: 10px;
            width: 100%;
        }
    }
    
    /* DataTables Custom Styling */
    .dataTables_wrapper .dataTables_length, 
    .dataTables_wrapper .dataTables_filter {
        margin-bottom: 15px;
    }
    
    .dataTables_wrapper .dataTables_length select, 
    .dataTables_wrapper .dataTables_filter input {
        border-radius: 8px;
        padding: 8px 12px;
        border: 1px solid #ced4da;
    }
    
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        border-radius: 50px;
        padding: 5px 12px;
        margin: 0 3px;
    }
    
    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: var(--primary-color);
        color: white !important;
        border: none;
    }
    
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: rgba(139, 0, 0, 0.1);
        color: var(--primary-color) !important;
        border: none;
    }

    .filter-card {
        background-color: #f8f9fa;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        margin-bottom: 25px;
    }
    
    .filter-card .card-body {
        padding: 20px 25px;
    }
    
    .filter-card label {
        font-weight: 600;
        color: #555;
        margin-bottom: 8px;
    }
    
    .filter-card .form-control,
    .filter-card .form-select {
        border-radius: 8px;
        border: 1px solid #e0e0e0;
        padding: 10px 15px;
        transition: all 0.3s;
    }
    
    .filter-card .form-control:focus,
    .filter-card .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.25rem rgba(139, 0, 0, 0.25);
    }

    /* Button Styling */
    .btn-filter {
        background-color: #8b0000;
        color: white;
        border-radius: 8px;
        padding: 10px 20px;
        font-weight: 600;
        transition: all 0.3s;
        border: none;
    }
    
    .btn-filter:hover {
        background-color: #6d0000;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(139, 0, 0, 0.2);
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-4">
    <div class="dashboard-header fade-in">
        <h2 class="mt-4">Rekapitulasi Laporan Peserta Magang</h2>
        <ol class="breadcrumb mb-4 slide-in-right">
            <li class="breadcrumb-item"><a href="{{ route('admin3.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Rekapitulasi Laporan Direktorat Jenderal Rehabilitasi Sosial</li>
        </ol>
    </div>

    <!-- Filters -->
<div class="card filter-card mb-4 slide-in-up" style="animation-delay: 0.1s">
    <div class="card-header">
        <h5><i class="fas fa-filter"></i> Filter Data</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin3.rekapitulasi-laporan3') }}" method="GET">
            <div class="row">
                <div class="col-md-3 mb-2">
                    <label for="bulan" class="form-label">Bulan</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                        <input type="month" class="form-control" id="bulan" name="bulan" value="{{ request('bulan', date('Y-m')) }}">
                    </div>
                </div>
                <div class="col-md-3 mb-2">
                        <label for="unit_kerja" class="form-label">Unit Kerja</label>
                        <select class="form-select" id="unit_kerja" name="unit_kerja">
                            <option value="">Semua Unit Kerja</option>
                            @foreach($unit_kerja ?? [] as $d)
                                <option value="{{ $d }}" {{ request('unit_kerja') == $d ? 'selected' : '' }}>{{ $d }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 mb-2">
                        <label for="search" class="form-label">Pencarian</label>
                        <input type="text" class="form-control" id="search" name="search" value="{{ request('search') }}" placeholder="Cari nama, nomor pendaftaran, universitas...">
                    </div>
                    <div class="col-md-2 mb-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-filter w-100">
                            <i class="fas fa-search me-1"></i> Filter
                        </button>
                    </div>
                </div>
        </form>
    </div>
</div>

<!-- Laporan Bulanan Section -->
<div class="card bounce-in" style="animation-delay: 0.2s">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h5><i class="fas fa-calendar-alt"></i> Rekapitulasi Laporan Bulanan - {{ $bulanNama ?? 'Semua Periode' }}</h5>
            <div class="col-md-2 mb-2 d-flex align-items-end">
                    <a href="{{ route('admin3.export-laporan3') }}?bulan={{ request('bulan', date('Y-m')) }}&direktorat={{ request('direktorat', '') }}" class="btn btn-success w-100">
                        <i class="fas fa-file-excel me-1"></i> Export Excel
                    </a>
                </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="laporanBulananTable">
                <thead class="table-dark">
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Nama Lengkap</th>
                        <th class="text-center">Unit Kerja</th>
                        <th class="text-center">Institusi Pendidikan</th>
                        <th class="text-center">Judul Laporan</th>
                        <th class="text-center">File</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Feedback</th>
                        <th class="text-center">Tanggal Upload</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($peserta as $index => $p)
                    <tr class="fade-in" style="animation-delay: {{ $index * 0.05 }}s">
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm me-2" style="width: 32px; height: 32px; border-radius: 50%; background-color: #f0f0f0; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-user text-primary"></i>
                                </div>
                                <span>{{ $p->nama_lengkap }}</span>
                            </div>
                        </td>
                        <td>{{ $p->unit_kerja }}</td>
                        <td>{{ $p->asal_universitas }}</td>
                        
                        @if ($p->laporan_bulanan)
                        <td>{{ $p->laporan_bulanan->judul }}</td>
                        <td class="text-center">
                            <a href="{{ asset('storage/'.$p->laporan_bulanan->file_path) }}" target="_blank" class="btn btn-sm btn-info">
                                <i class="fas fa-file-download me-1"></i> Unduh
                            </a>
                        </td>
                        <td class="text-center">
                            @if ($p->laporan_bulanan->status == 'Menunggu')
                                <span class="badge bg-warning">{{ $p->laporan_bulanan->status }}</span>
                            @elseif ($p->laporan_bulanan->status == 'Acc')
                                <span class="badge bg-success">{{ $p->laporan_bulanan->status }}</span>
                            @elseif ($p->laporan_bulanan->status == 'Ditolak')
                                <span class="badge bg-danger">{{ $p->laporan_bulanan->status }}</span>
                            @endif
                        </td>
                        <td>{{ $p->laporan_bulanan->feedback ?? '-' }}</td>
                        <td class="text-center">{{ $p->laporan_bulanan->created_at->format('d/m/Y H:i') }}</td>
                        @else
                        <td colspan="5" class="text-center">
                            <span class="badge bg-secondary">Belum Upload Laporan</span>
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
<div class="card bounce-in" style="animation-delay: 0.3s">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h5><i class="fas fa-file-signature"></i> Rekapitulasi Laporan Akhir</h5>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="laporanAkhirTable">
                <thead class="table-dark">
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Nama Lengkap</th>
                        <th class="text-center">Unit Kerja</th>
                        <th class="text-center">Institusi Pendidikan</th>
                        <th class="text-center">Judul Laporan</th>
                        <th class="text-center">File</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Feedback</th>
                        <th class="text-center">Tanggal Upload</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($peserta as $index => $p)
                    <tr class="fade-in" style="animation-delay: {{ $index * 0.05 }}s">
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm me-2" style="width: 32px; height: 32px; border-radius: 50%; background-color: #f0f0f0; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-user text-primary"></i>
                                </div>
                                <span>{{ $p->nama_lengkap }}</span>
                            </div>
                        </td>
                        <td>{{ $p->unit_kerja}}</td>
                        <td>{{ $p->asal_universitas }}</td>
                        
                        @if ($p->laporan_akhir)
                        <td>{{ $p->laporan_akhir->judul }}</td>
                        <td class="text-center">
                            <a href="{{ asset('storage/'.$p->laporan_akhir->file_path) }}" target="_blank" class="btn btn-sm btn-info">
                                <i class="fas fa-file-download me-1"></i> Unduh
                            </a>
                        </td>
                        <td class="text-center">
                            @if ($p->laporan_akhir->status == 'Menunggu')
                                <span class="badge bg-warning">{{ $p->laporan_akhir->status }}</span>
                            @elseif ($p->laporan_akhir->status == 'Acc')
                                <span class="badge bg-success">{{ $p->laporan_akhir->status }}</span>
                            @elseif ($p->laporan_akhir->status == 'Ditolak')
                                <span class="badge bg-danger">{{ $p->laporan_akhir->status }}</span>
                            @endif
                        </td>
                        <td>{{ $p->laporan_akhir->feedback ?? '-' }}</td>
                        <td class="text-center">{{ $p->laporan_akhir->created_at->format('d/m/Y H:i') }}</td>
                        @else
                        <td colspan="5" class="text-center">
                            <span class="badge bg-secondary">Belum Upload Laporan</span>
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
            <div class="dashboard-card slide-in-left" style="animation-delay: 0.4s">
                <div class="card-header">
                    <h5><i class="fas fa-chart-pie"></i> Statistik Laporan Bulanan</h5>
                </div>
                <div class="card-body">
                    <canvas id="laporanBulananChart" width="100%" height="50"></canvas>
                </div>
            </div>
        </div>
        
        <!-- Statistik Laporan Akhir -->
        <div class="col-md-6">
            <div class="dashboard-card slide-in-right" style="animation-delay: 0.4s">
                <div class="card-header">
                    <h5><i class="fas fa-chart-pie"></i> Statistik Laporan Akhir</h5>
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
            <div class="dashboard-card slide-in-up" style="animation-delay: 0.5s">
                <div class="card-header bg-primary text-white">
                    <h5><i class="fas fa-info-circle"></i> Status Laporan Bulanan - {{ $bulanNama }}</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center slide-in-right" style="animation-delay: 0.1s">
                            <div>
                                <i class="fas fa-times-circle text-secondary me-2"></i> Belum Upload
                            </div>
                            <span class="badge bg-secondary rounded-pill">{{ $totalBulananBelum }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center slide-in-right" style="animation-delay: 0.2s">
                            <div>
                                <i class="fas fa-clock text-warning me-2"></i> Menunggu Konfirmasi
                            </div>
                            <span class="badge bg-warning rounded-pill">{{ $totalBulananMenunggu }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center slide-in-right" style="animation-delay: 0.3s">
                            <div>
                                <i class="fas fa-check-circle text-success me-2"></i> Acc
                            </div>
                            <span class="badge bg-success rounded-pill">{{ $totalBulananAcc }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center slide-in-right" style="animation-delay: 0.4s">
                            <div>
                                <i class="fas fa-times-circle text-danger me-2"></i> Ditolak
                            </div>
                            <span class="badge bg-danger rounded-pill">{{ $totalBulananDitolak }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center slide-in-right" style="animation-delay: 0.5s">
                            <div class="fw-bold">
                                <i class="fas fa-users text-primary me-2"></i> Total Peserta
                            </div>
                            <span class="badge bg-primary rounded-pill">{{ $totalPeserta }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        
        <!-- Keterangan Laporan Akhir -->
        <div class="col-md-6">
            <div class="dashboard-card slide-in-up" style="animation-delay: 0.6s">
                <div class="card-header bg-primary text-white">
                    <h5><i class="fas fa-info-circle"></i> Status Laporan Akhir</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center slide-in-right" style="animation-delay: 0.1s">
                            <div>
                                <i class="fas fa-times-circle text-secondary me-2"></i> Belum Upload
                            </div>
                            <span class="badge bg-secondary rounded-pill">{{ $totalAkhirBelum }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center slide-in-right" style="animation-delay: 0.2s">
                            <div>
                                <i class="fas fa-clock text-warning me-2"></i> Menunggu Konfirmasi
                            </div>
                            <span class="badge bg-warning rounded-pill">{{ $totalAkhirMenunggu }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center slide-in-right" style="animation-delay: 0.3s">
                            <div>
                                <i class="fas fa-check-circle text-success me-2"></i> Acc
                            </div>
                            <span class="badge bg-success rounded-pill">{{ $totalAkhirAcc }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center slide-in-right" style="animation-delay: 0.4s">
                            <div>
                                <i class="fas fa-times-circle text-danger me-2"></i> Ditolak
                            </div>
                            <span class="badge bg-danger rounded-pill">{{ $totalAkhirDitolak }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center slide-in-right" style="animation-delay: 0.5s">
                            <div class="fw-bold">
                                <i class="fas fa-users text-primary me-2"></i> Total Peserta
                            </div>
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
        // Inisialisasi DataTables untuk kedua tabel dengan animasi
        $('#laporanBulananTable').DataTable({
            "scrollX": true,
            "searching": false,
            "language": {
                "lengthMenu": "Tampilkan _MENU_ data per halaman",
                "zeroRecords": "Tidak ada data yang ditemukan",
                "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
                "infoEmpty": "Tidak ada data yang tersedia",
                "infoFiltered": "(difilter dari _MAX_ total data)",
                
                "paginate": {
                    "first": "Pertama",
                    "last": "Terakhir",
                    "next": "Selanjutnya",
                    "previous": "Sebelumnya"
                }
            },
            "pageLength": 10,
            "responsive": true,
            "drawCallback": function() {
                $('.dataTables_paginate .paginate_button').addClass('fade-in');
            }
        });
        
        $('#laporanAkhirTable').DataTable({
            "scrollX": true,
            "searching": false,
            "language": {
                "lengthMenu": "Tampilkan _MENU_ data per halaman",
                "zeroRecords": "Tidak ada data yang ditemukan",
                "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
                "infoEmpty": "Tidak ada data yang tersedia",
                "infoFiltered": "(difilter dari _MAX_ total data)",
                
                "paginate": {
                    "first": "Pertama",
                    "last": "Terakhir",
                    "next": "Selanjutnya",
                    "previous": "Sebelumnya"
                }
            },
            "pageLength": 10,
            "responsive": true,
            "drawCallback": function() {
                $('.dataTables_paginate .paginate_button').addClass('fade-in');
            }
        });

        // Pie Chart untuk Laporan Bulanan dengan animasi
        var ctxBulanan = document.getElementById('laporanBulananChart');
        var bulananChart = new Chart(ctxBulanan, {
            type: 'doughnut',
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
                    borderWidth: 0
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
                },
                animation: {
                    animateScale: true,
                    animateRotate: true,
                    duration: 2000,
                    easing: 'easeOutQuart'
                }
            }
        });
        
        // Pie Chart untuk Laporan Akhir dengan animasi
        var ctxAkhir = document.getElementById('laporanAkhirChart');
        var akhirChart = new Chart(ctxAkhir, {
            type: 'doughnut',
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
                    borderWidth: 0
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
                },
                animation: {
                    animateScale: true,
                    animateRotate: true,
                    duration: 2000,
                    easing: 'easeOutQuart'
                }
            }
        });
        
        // Tambahkan efek hover pada baris tabel
        const tableRows = document.querySelectorAll('#laporanBulananTable tbody tr, #laporanAkhirTable tbody tr');
        tableRows.forEach(row => {
            row.addEventListener('mouseenter', function() {
                this.style.transform = 'translateX(5px)';
                this.style.transition = 'transform 0.3s ease';
            });
            
            row.addEventListener('mouseleave', function() {
                this.style.transform = 'translateX(0)';
            });
        });
    });

</script>
@endsection