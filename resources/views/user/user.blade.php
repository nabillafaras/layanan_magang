@extends('layouts.header_user')

@section('title', 'Dashboard User - Kementerian Sosial RI')

@section('additional_css')
<style>
    body {
        font-family: 'Calibri', sans-serif;
        background-color: #f8f9fa;
    }

    .dashboard-header {
        margin-bottom: 30px;
    }

    .dashboard-card {
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        transition: transform 0.2s;
        margin-bottom: 20px;
        overflow: hidden;
    }
    
    .dashboard-card:hover {
        transform: translateY(-5px);
    }
    
    .stat-card {
        background: white;
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 20px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .stat-card h3 {
        color: #8b0000;
        margin-bottom: 5px;
        font-size: 1.2rem;
    }
    
    .stat-card p {
        color: #666;
        margin-bottom: 0;
    }

    .stat-card .h2 {
        font-weight: bold;
        color: #333;
        margin-bottom: 5px;
    }

    .card-header {
        background-color: #f1f1f1;
        border-bottom: 1px solid #e0e0e0;
        padding: 15px 20px;
    }

    .card-header h5 {
        margin: 0;
        font-weight: 600;
        color: #333;
    }

    .icon-circle {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    .periode-magang-card {
        border-left: 4px solid #FFC107;
    }

    .section-title {
        position: relative;
        padding-bottom: 10px;
        margin-bottom: 20px;
        font-weight: 600;
    }

    .section-title:after {
        content: '';
        position: absolute;
        left: 0;
        bottom: 0;
        height: 3px;
        width: 50px;
        background-color: #8b0000;
    }

    .action-card {
        height: 100%;
    }

    .action-card .card-body {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 100%;
    }

    .badge {
        padding: 6px 10px;
        font-weight: 500;
    }

    .timeline-status-container {
        overflow-x: auto;
        padding: 10px 0;
    }

    .timeline-status {
        display: flex;
        align-items: center;
        min-width: max-content;
    }

    .timeline-node {
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
    }

    .node-circle {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background-color: #ccc;
        margin-bottom: 8px;
    }

    .timeline-node.active .node-circle {
        background-color: #4CAF50;
    }

    .timeline-connector {
        height: 2px;
        background-color: #ccc;
        width: 50px;
        margin: 0 5px;
        align-self: center;
        margin-top: -16px;
    }

    .timeline-node.active + .timeline-connector {
        background-color: #4CAF50;
    }

    .node-label {
        font-size: 14px;
        white-space: nowrap;
    }

    .statistics-row {
        margin-top: 30px;
    }

    .small-text {
        font-size: 12px;
        color: #666;
    }

    .activity-table th, .activity-table td {
        padding: 12px 15px;
        vertical-align: middle;
    }
</style>
@endsection

@section('content')
<!-- Page Content -->
<div class="main-content">
    <div class="container-fluid">
        <div class="dashboard-header">
            <h2 class="mb-4">Dashboard</h2>
        </div>
        
        <div class="row">
            <!-- Periode Magang Card - Full Width -->
            <div class="col-12 mb-4">
                <div class="card dashboard-card periode-magang-card">
                    <div class="card-header">
                        <h5><i class="fas fa-calendar-alt me-2"></i> Periode Magang</h5>
                    </div>
                    <div class="card-body">
                        @if($tanggalMulai && $tanggalSelesai)
                            <div class="row align-items-center">
                                <div class="col-md-4">
                                    <div class="d-flex align-items-center">
                                        <div class="icon-circle bg-warning">
                                            <i class="fas fa-calendar-alt text-white"></i>
                                        </div>
                                        <div class="ms-3">
                                            <h5 class="mb-1">Durasi Magang</h5>
                                            <p class="text-muted mb-0">{{ $tanggalMulai }} s/d {{ $tanggalSelesai }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="progress mt-2" style="height: 10px;">
                                        <div class="progress-bar bg-warning" role="progressbar" 
                                            style="width: {{ $sisaHari > 0 ? (1 - ($sisaHari / Carbon\Carbon::parse($tanggalMulai)->diffInDays(Carbon\Carbon::parse($tanggalSelesai)))) * 100 : 100 }}%;" 
                                            aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 text-end">
                                    <p class="text-danger mb-0">
                                        <i class="fas fa-clock me-1"></i>
                                        <strong>{{ $sisaHari }} hari</strong> lagi
                                    </p>
                                </div>
                            </div>
                        @else
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i> Belum ada periode magang yang ditentukan.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Row -->
        <div class="row statistics-row">
            <div class="col-12">
                <h4 class="section-title">Statistik Kehadiran</h4>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <h3>Total Kehadiran</h3>
                        <i class="fas fa-user-check text-success fa-2x"></i>
                    </div>
                    <p class="h2">{{ $totalKehadiran }}</p>
                    <small class="text-muted">Hari ini: <span class="text-success">{{ $kehadiranHariIni }}</span></small>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <h3>Total Izin</h3>
                        <i class="fas fa-file-alt text-warning fa-2x"></i>
                    </div>
                    <p class="h2">{{ $totalIzin }}</p>
                    <small class="text-muted">Bulan ini</small>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <h3>Total Sakit</h3>
                        <i class="fas fa-procedures text-danger fa-2x"></i>
                    </div>
                    <p class="h2">{{ $totalSakit }}</p>
                    <small class="text-muted">Bulan ini</small>
                </div>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="row mt-4">
            <div class="col-12">
                <h4 class="section-title">Absensi Cepat</h4>
            </div>
            <div class="col-md-4">
                <div class="card dashboard-card action-card">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <i class="fas fa-sign-in-alt fa-3x text-primary"></i>
                        </div>
                        <h5 class="card-title">Absen Masuk</h5>
                        <p class="card-text mb-4">Lakukan absensi masuk hari ini</p>
                        <a href="#xx" class="btn btn-primary w-100">Absen Masuk</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card dashboard-card action-card">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <i class="fas fa-calendar-times fa-3x text-warning"></i>
                        </div>
                        <h5 class="card-title">Izin</h5>
                        <p class="card-text mb-4">Ajukan izin tidak masuk</p>
                        <a href="#xx" class="btn btn-warning w-100">Ajukan Izin</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card dashboard-card action-card">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <i class="fas fa-heartbeat fa-3x text-danger"></i>
                        </div>
                        <h5 class="card-title">Sakit</h5>
                        <p class="card-text mb-4">Laporkan ketidakhadiran karena sakit</p>
                        <a href="#xx" class="btn btn-danger w-100">Lapor Sakit</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="row mt-4">
            <div class="col-12">
                <h4 class="section-title">Aktivitas Terakhir</h4>
                <div class="card dashboard-card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover activity-table">
                                <thead>
                                    <tr>
                                        <th width="25%">Tanggal</th>
                                        <th width="35%">Jenis</th>
                                        <th width="40%">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($aktivitasRiwayat as $aktivitas)
                                        <tr>
                                            <td>{{ $aktivitas->created_at->format('d M Y, H:i') }}</td>
                                            <td>
                                                @if($aktivitas->type == 'Absensi')
                                                    <i class="fas fa-clipboard-check me-2 text-primary"></i>
                                                @elseif($aktivitas->type == 'Laporan')
                                                    <i class="fas fa-file-alt me-2 text-info"></i>
                                                @endif
                                                {{ $aktivitas->type }}
                                            </td>
                                            <td>
                                                @if($aktivitas->type == 'Absensi')
                                                    @if($aktivitas->status == 'hadir')
                                                        <span class="badge bg-success">Hadir</span>
                                                    @elseif($aktivitas->status == 'izin')
                                                        <span class="badge bg-warning">Izin</span>
                                                    @elseif($aktivitas->status == 'sakit')
                                                        <span class="badge bg-info">Sakit</span>
                                                    @elseif($aktivitas->status == 'terlambat')
                                                        <span class="badge bg-warning">Terlambat</span>
                                                    @else
                                                        <span class="badge bg-secondary">{{ $aktivitas->status }}</span>
                                                    @endif
                                                @elseif($aktivitas->type == 'Laporan')
                                                    @if($aktivitas->status == 'menunggu')
                                                        <span class="badge bg-warning">Menunggu</span>
                                                    @elseif($aktivitas->status == 'diterima')
                                                        <span class="badge bg-success">Diterima</span>
                                                    @elseif($aktivitas->status == 'ditolak')
                                                        <span class="badge bg-danger">Ditolak</span>
                                                    @else
                                                        <span class="badge bg-secondary">{{ $aktivitas->status }}</span>
                                                    @endif
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center">Tidak ada aktivitas</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection