@extends('layouts.header_admin1')

@section('title', 'Dashboard Admin - Kementerian Sosial RI')

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
    
    .stat-card h5 {
        color: #6c757d;
        margin-bottom: 15px;
        font-weight: 600;
        font-size: 1.1rem;
        position: relative;
        z-index: 1;
    }
    
    .stat-card h2 {
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: 0;
        font-size: 2.2rem;
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
    
    .card-header h5 i {
        margin-right: 10px;
        color: var(--primary-color);
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
    
    .badge {
        padding: 8px 12px;
        font-weight: 500;
        border-radius: 30px;
        font-size: 0.85rem;
    }
    
    .badge-success {
        background-color: #28a745;
        color: white;
    }
    
    .badge-warning {
        background-color: #ffc107;
        color: #212529;
    }
    
    .badge-danger {
        background-color: #dc3545;
        color: white;
    }
    
    .badge-info {
        background-color: #17a2b8;
        color: white;
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
    
    /* Pulse Animation for Notifications */
    @keyframes pulse {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(139, 0, 0, 0.7); }
        70% { transform: scale(1); box-shadow: 0 0 0 10px rgba(139, 0, 0, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(139, 0, 0, 0); }
    }
    
    .pulse {
        animation: pulse 2s infinite;
    }
    
    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .stat-card h2 {
            font-size: 1.8rem;
        }
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-4">
    <div class="dashboard-header fade-in">
        <h2 class="mt-4">Dashboard Admin</h2>
        <ol class="breadcrumb mb-4 slide-in-right">
            <li class="breadcrumb-item"><a href="{{ route('admin1.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Dashboard Admin Sekretariat Jenderal</li>
        </ol>
    </div>
    
    <!-- Statistics Cards -->
    <div class="row">
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stat-card slide-in-up" style="animation-delay: 0.1s">
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <h5>Total Peserta Magang</h5>
                <h2 class="counter">{{ $totalPeserta ?? 0 }}</h2>
                <div class="progress mt-3" style="height: 5px;">
                    <div class="progress-bar bg-primary progress-animate" role="progressbar" style="width: 0%;" data-width="75%"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stat-card slide-in-up" style="animation-delay: 0.2s">
                <div class="icon">
                    <i class="fas fa-clipboard-check"></i>
                </div>
                <h5>Total Absensi Hari Ini</h5>
                <h2 class="counter">{{ $totalAbsensiHariIni ?? 0 }}</h2>
                <div class="progress mt-3" style="height: 5px;">
                    <div class="progress-bar bg-success progress-animate" role="progressbar" style="width: 0%;" data-width="60%"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stat-card slide-in-up" style="animation-delay: 0.3s">
                <div class="icon">
                    <i class="fas fa-file-alt"></i>
                </div>
                <h5>Total Laporan</h5>
                <h2 class="counter">{{ $totalLaporan ?? 0 }}</h2>
                <div class="progress mt-3" style="height: 5px;">
                    <div class="progress-bar bg-warning progress-animate" role="progressbar" style="width: 0%;" data-width="45%"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stat-card slide-in-up" style="animation-delay: 0.4s">
                <div class="icon">
                    <i class="fas fa-user-shield"></i>
                </div>
                <h5>Total Admin</h5>
                <h2 class="counter">{{ $totalAdmin ?? 0 }}</h2>
                <div class="progress mt-3" style="height: 5px;">
                    <div class="progress-bar bg-danger progress-animate" role="progressbar" style="width: 0%;" data-width="90%"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="row">
        <div class="col-12">
            <div class="dashboard-card bounce-in">
                <div class="card-header">
                    <h5><i class="fas fa-history"></i> Aktivitas Terbaru</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="activity-table">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Nama</th>
                                    <th>Unit Kerja</th>
                                    <th>Aktivitas</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentActivities ?? [] as $activity)
                                <tr class="fade-in" style="animation-delay: {{ $loop->index * 0.1 }}s">
                                    <td>
                                        <i class="far fa-calendar-alt me-2 text-primary"></i>
                                        {{ \Carbon\Carbon::parse($activity->tanggal)->format('d-m-Y H:i') }}
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm me-2" style="width: 32px; height: 32px; border-radius: 50%; background-color: #f0f0f0; display: flex; align-items: center; justify-content: center;">
                                                <i class="fas fa-user text-primary"></i>
                                            </div>
                                            <span>{{ $activity->nama }}</span>
                                        </div>
                                    </td>
                                    <td>{{ $activity->unit_kerja }}</td>
                                    <td>
                                        @if(strpos(strtolower($activity->aktivitas), 'absen') !== false)
                                            <i class="fas fa-clipboard-check me-2 text-success"></i>
                                        @elseif(strpos(strtolower($activity->aktivitas), 'laporan') !== false)
                                            <i class="fas fa-file-alt me-2 text-warning"></i>
                                        @elseif(strpos(strtolower($activity->aktivitas), 'izin') !== false)
                                            <i class="fas fa-calendar-times me-2 text-danger"></i>
                                        @else
                                            <i class="fas fa-tasks me-2 text-info"></i>
                                        @endif
                                        {{ $activity->aktivitas }}
                                    </td>
                                    <td>
                                        @if($activity->status == 'hadir')
                                            <span class="badge bg-success">Hadir</span>
                                        @elseif($activity->status == 'terlambat')
                                            <span class="badge bg-danger">Terlambat</span>
                                        @elseif($activity->status == 'izin')
                                            <span class="badge bg-warning">Izin</span>
                                        @elseif($activity->status == 'sakit')
                                            <span class="badge bg-info">Sakit</span>
                                        @elseif($activity->status == 'Menunggu')
                                            <span class="badge bg-warning">Menunggu</span>
                                        @elseif($activity->status == 'Acc')
                                            <span class="badge bg-success">Acc</span>
                                        @elseif($activity->status == 'Ditolak')
                                            <span class="badge bg-danger">Ditolak</span>
                                        @else
                                            <span class="badge bg-secondary">{{ $activity->status }}</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">Tidak ada aktivitas terbaru</td>
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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Animate progress bars
        setTimeout(function() {
            const progressBars = document.querySelectorAll('.progress-animate');
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
    });
</script>
@endsection