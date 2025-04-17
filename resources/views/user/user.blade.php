@extends('layouts.header_user')

@section('title', 'Dashboard User - Kementerian Sosial RI')

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
    
    .stat-card {
        background: white;
        padding: 25px;
        border-radius: 15px;
        margin-bottom: 25px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        transition: all 0.3s;
        border: none;
        position: relative;
        overflow: hidden;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1);
    }
    
    .stat-card::before {
        content: '';
        position: absolute;
        top: -20px;
        right: -20px;
        width: 120px;
        height: 120px;
        background: rgba(139, 0, 0, 0.05);
        border-radius: 50%;
        z-index: 0;
    }
    
    .stat-card h3 {
        color: #6c757d;
        margin-bottom: 10px;
        font-weight: 600;
        font-size: 1.1rem;
        position: relative;
        z-index: 1;
    }
    
    .stat-card p.h2 {
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: 5px;
        font-size: 2.2rem;
        position: relative;
        z-index: 1;
    }
    
    .stat-card small {
        font-size: 0.85rem;
        position: relative;
        z-index: 1;
    }
    
    .stat-card .icon {
        position: absolute;
        top: 20px;
        right: 20px;
        font-size: 2.5rem;
        color: rgba(139, 0, 0, 0.1);
        z-index: 0;
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
    
    .card-header h5 i {
        margin-right: 10px;
        color: var(--primary-color);
    }

    .icon-circle {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        transition: all 0.3s;
    }
    
    .icon-circle:hover {
        transform: scale(1.1);
    }

    .periode-magang-card {
        border-left: 5px solid #FFC107;
        background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%);
    }

    .section-title {
        position: relative;
        padding-bottom: 12px;
        margin-bottom: 25px;
        font-weight: 600;
        color: var(--primary-color);
    }

    .section-title::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: 0;
        height: 3px;
        width: 60px;
        background: linear-gradient(90deg, var(--primary-color), #c13030);
        border-radius: 2px;
    }

    .action-card {
        height: 100%;
        transition: all 0.3s;
        border: none;
        border-radius: 15px;
        overflow: hidden;
    }

    .action-card .card-body {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 100%;
        padding: 30px;
        background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%);
    }
    
    .action-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.15);
    }
    
    .action-card:hover .icon-wrapper i {
        transform: scale(1.2);
    }

    .badge {
        padding: 8px 12px;
        font-weight: 500;
        border-radius: 30px;
        font-size: 0.85rem;
    }

    .timeline-status-container {
        overflow-x: auto;
        padding: 15px 0;
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
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background-color: #ccc;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 14px;
        transition: all 0.3s;
    }

    .timeline-node.active .node-circle {
        background-color: #4CAF50;
        box-shadow: 0 0 0 5px rgba(76, 175, 80, 0.2);
    }

    .timeline-connector {
        height: 3px;
        background-color: #ccc;
        width: 60px;
        margin: 0 5px;
        align-self: center;
        margin-top: -16px;
        transition: all 0.3s;
    }

    .timeline-node.active + .timeline-connector {
        background-color: #4CAF50;
    }

    .node-label {
        font-size: 14px;
        white-space: nowrap;
        font-weight: 500;
    }

    .statistics-row {
        margin-top: 40px;
    }

    .small-text {
        font-size: 12px;
        color: #666;
    }

    .activity-table {
        border-collapse: separate;
        border-spacing: 0;
        width: 100%;
    }
    
    .activity-table th {
        background-color: #f8f9fa;
        color: #333;
        font-weight: 600;
        padding: 15px;
        border-bottom: 2px solid #e0e0e0;
    }
    
    .activity-table td {
        padding: 15px;
        vertical-align: middle;
        border-bottom: 1px solid #e0e0e0;
        transition: all 0.3s;
    }
    
    .activity-table tr:hover td {
        background-color: rgba(139, 0, 0, 0.02);
    }
    
    .activity-table tr:last-child td {
        border-bottom: none;
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
    
    .icon-wrapper {
        margin-bottom: 20px;
    }
    
    .icon-wrapper i {
        font-size: 3rem;
        transition: all 0.3s;
    }
    
    .progress {
        height: 12px;
        border-radius: 6px;
        overflow: hidden;
        background-color: #e9ecef;
        box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);
    }
    
    .progress-bar {
        transition: width 1.5s ease;
        background: linear-gradient(90deg, var(--primary-color), #c13030);
    }
    
    /* Pulse Animation for Buttons */
    @keyframes pulse-button {
        0% {
            box-shadow: 0 0 0 0 rgba(139, 0, 0, 0.7);
        }
        70% {
            box-shadow: 0 0 0 10px rgba(139, 0, 0, 0);
        }
        100% {
            box-shadow: 0 0 0 0 rgba(139, 0, 0, 0);
        }
    }
    
    .btn-pulse {
        animation: pulse-button 2s infinite;
    }
    
    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .icon-circle {
            width: 50px;
            height: 50px;
            font-size: 1.5rem;
        }
        
        .stat-card p.h2 {
            font-size: 1.8rem;
        }
    }
</style>
@endsection

@section('content')
<!-- Page Content -->
<div class="container-fluid px-4">
    <div class="dashboard-header fade-in">
        <h2 class="mb-4">Dashboard</h2>
        <ol class="breadcrumb mb-4 slide-in-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Selamat datang kembali, {{ auth()->user()->nama_lengkap }}!</li>
        </ol>
    </div>
    
    <!-- Periode Magang Card - Full Width -->
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card dashboard-card periode-magang-card bounce-in">
                <div class="card-header">
                    <h5><i class="fas fa-calendar-alt"></i> Periode Magang</h5>
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
                                <div class="progress mt-2 progress-animate" style="height: 12px;">
                                    <div class="progress-bar" role="progressbar" 
                                        style="width: 0%;" 
                                        data-width="{{ $sisaHari > 0 ? (1 - ($sisaHari / Carbon\Carbon::parse($tanggalMulai)->diffInDays(Carbon\Carbon::parse($tanggalSelesai)))) * 100 : 100 }}%">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 text-end">
                                <p class="text-danger mb-0 fade-in" style="animation: pulse 2s infinite;">
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
            <h4 class="section-title fade-in">Statistik Kehadiran</h4>
        </div>
        <div class="col-md-4">
            <div class="stat-card slide-in-up" style="animation-delay: 0.1s">
                <div class="icon">
                    <i class="fas fa-user-check"></i>
                </div>
                <h3>Total Kehadiran</h3>
                <p class="h2 counter">{{ $totalKehadiran }}</p>
                <small class="text-muted">Hari ini: <span class="text-success">{{ $kehadiranHariIni }}</span></small>
                <div class="progress mt-3" style="height: 5px;">
                    <div class="progress-bar bg-success progress-animate" role="progressbar" style="width: 0%;" data-width="75%"></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card slide-in-up" style="animation-delay: 0.2s">
                <div class="icon">
                    <i class="fas fa-file-alt"></i>
                </div>
                <h3>Total Izin</h3>
                <p class="h2 counter">{{ $totalIzin }}</p>
                <small class="text-muted">Bulan ini</small>
                <div class="progress mt-3" style="height: 5px;">
                    <div class="progress-bar bg-warning progress-animate" role="progressbar" style="width: 0%;" data-width="45%"></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card slide-in-up" style="animation-delay: 0.3s">
                <div class="icon">
                    <i class="fas fa-procedures"></i>
                </div>
                <h3>Total Sakit</h3>
                <p class="h2 counter">{{ $totalSakit }}</p>
                <small class="text-muted">Bulan ini</small>
                <div class="progress mt-3" style="height: 5px;">
                    <div class="progress-bar bg-danger progress-animate" role="progressbar" style="width: 0%;" data-width="30%"></div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Quick Actions -->
    <div class="row mt-5">
        <div class="col-12">
            <h4 class="section-title fade-in">Absensi Cepat</h4>
        </div>
        <div class="col-md-4">
            <div class="card dashboard-card action-card bounce-in" style="animation-delay: 0.1s">
                <div class="card-body text-center">
                    <div class="icon-wrapper">
                        <i class="fas fa-sign-in-alt text-primary"></i>
                    </div>
                    <h5 class="card-title mb-3">Absen Masuk</h5>
                    <p class="card-text mb-4">Lakukan absensi masuk hari ini</p>
                    <a href="{{ route('attendance') }}" class="btn btn-primary w-100 btn-pulse">Absen Masuk</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card dashboard-card action-card bounce-in" style="animation-delay: 0.2s">
                <div class="card-body text-center">
                    <div class="icon-wrapper">
                        <i class="fas fa-calendar-times text-warning"></i>
                    </div>
                    <h5 class="card-title mb-3">Izin</h5>
                    <p class="card-text mb-4">Ajukan izin tidak masuk</p>
                    <a href="{{ route('izin') }}" class="btn btn-warning w-100">Ajukan Izin</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card dashboard-card action-card bounce-in" style="animation-delay: 0.3s">
                <div class="card-body text-center">
                    <div class="icon-wrapper">
                        <i class="fas fa-heartbeat text-danger"></i>
                    </div>
                    <h5 class="card-title mb-3">Sakit</h5>
                    <p class="card-text mb-4">Laporkan ketidakhadiran karena sakit</p>
                    <a href="{{ route('sakit') }}" class="btn btn-danger w-100">Lapor Sakit</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="row mt-5">
        <div class="col-12">
            <h4 class="section-title fade-in">Aktivitas Terakhir</h4>
            <div class="card dashboard-card bounce-in">
                <div class="card-header">
                    <h5><i class="fas fa-history"></i> Riwayat Aktivitas</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table activity-table">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Aktivitas</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($aktivitasRiwayat as $aktivitas)
                                    <tr class="fade-in" style="animation-delay: {{ $loop->index * 0.1 }}s">
                                        <td>
                                            <i class="far fa-calendar-alt me-2 text-primary"></i>
                                            {{ $aktivitas->tanggal }}
                                        </td>
                                        <td>
                                            @if(strpos($aktivitas->aktivitas, 'Absensi') !== false)
                                                <i class="fas fa-clipboard-check me-2 text-primary"></i>
                                            @elseif(strpos($aktivitas->aktivitas, 'Laporan') !== false)
                                                <i class="fas fa-file-alt me-2 text-info"></i>
                                            @elseif(strpos($aktivitas->aktivitas, 'Izin') !== false)
                                                <i class="fas fa-calendar-times me-2 text-warning"></i>
                                            @elseif(strpos($aktivitas->aktivitas, 'Sakit') !== false)
                                                <i class="fas fa-procedures me-2 text-danger"></i>
                                            @else
                                                <i class="fas fa-tasks me-2 text-secondary"></i>
                                            @endif
                                            {{ $aktivitas->aktivitas }}
                                        </td>
                                        <td>
                                            @switch(strtolower($aktivitas->status))
                                                @case('hadir')
                                                    <span class="badge bg-success">Hadir</span>
                                                    @break
                                                @case('izin')
                                                    <span class="badge bg-warning">Izin</span>
                                                    @break
                                                @case('sakit')
                                                    <span class="badge bg-info">Sakit</span>
                                                    @break
                                                @case('terlambat')
                                                    <span class="badge bg-danger">Terlambat</span>
                                                    @break
                                                @case('menunggu')
                                                    <span class="badge bg-warning">Menunggu</span>
                                                    @break
                                                @case('acc')
                                                    <span class="badge bg-success">Acc</span>
                                                    @break
                                                @case('ditolak')
                                                    <span class="badge bg-danger">Ditolak</span>
                                                    @break
                                                @default
                                                    <span class="badge bg-secondary">{{ ucfirst($aktivitas->status) }}</span>
                                            @endswitch
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
@endsection

@section('additional_scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Animate progress bar
        setTimeout(function() {
            const progressBars = document.querySelectorAll('.progress-animate .progress-bar');
            progressBars.forEach(function(bar) {
                const width = bar.getAttribute('data-width');
                bar.style.width = width;
            });
        }, 500);
        
        // Counter animation
        const counters = document.querySelectorAll('.counter');
        counters.forEach(counter => {
            const target = parseInt(counter.innerText);
            let count = 0;
            const duration = 2000; // 2 seconds
            const increment = target / (duration / 30); // Update every 30ms
            
            const updateCount = () => {
                if (count < target) {
                    count += increment;
                    counter.innerText = Math.ceil(count);
                    setTimeout(updateCount, 30);
                } else {
                    counter.innerText = target;
                }
            };
            
            updateCount();
        });
        
        // Hover effects for action cards
        const actionCards = document.querySelectorAll('.action-card');
        actionCards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.querySelector('.icon-wrapper i').classList.add('animate__animated', 'animate__heartBeat');
            });
            
            card.addEventListener('mouseleave', function() {
                this.querySelector('.icon-wrapper i').classList.remove('animate__animated', 'animate__heartBeat');
            });
        });
    });
</script>
@endsection