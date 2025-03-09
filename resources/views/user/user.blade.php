@extends('layouts.header_user')

@section('title', 'Dashboard User - Kementerian Sosial RI')

@section('additional_css')
<style>
        body {
            font-family: 'Calibri', sans-serif;
            background-color: #f8f9fa;
        }

        .dashboard-card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: transform 0.2s;
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
        }
        
        .stat-card p {
            color: #666;
            margin-bottom: 0;
        }
    </style>
@endsection

@section('content')

                <!-- Page Content -->
                <div class="main-content">
                    <div class="container-fluid">
                        <h2 class="mb-4">Dashboard</h2>
                        
                        <!-- Statistics Row -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="stat-card">
                                <h3>Total Kehadiran</h3>
                                <p class="h2">{{ $totalKehadiran }}</p>
                                <small>Hari ini: {{ $kehadiranHariIni }}</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="stat-card">
                                <h3>Total Izin</h3>
                                <p class="h2">{{ $totalIzin }}</p>
                                <small>Bulan ini</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="stat-card">
                                <h3>Total Sakit</h3>
                                <p class="h2">{{ $totalSakit }}</p>
                                <small>Bulan ini</small>
                            </div>
                        </div>
                    </div>
                        
                        <!-- Quick Actions -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h4 class="mb-3">Absensi Cepat</h4>
                            </div>
                            <div class="col-md-4">
                                <div class="card dashboard-card">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">Absen Masuk</h5>
                                        <p class="card-text">Lakukan absensi masuk hari ini</p>
                                        <a href="#xx" class="btn btn-primary">Absen Masuk</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card dashboard-card">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">Izin</h5>
                                        <p class="card-text">Ajukan izin tidak masuk</p>
                                        <a href="#xx" class="btn btn-warning">Ajukan Izin</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card dashboard-card">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">Sakit</h5>
                                        <p class="card-text">Laporkan ketidakhadiran karena sakit</p>
                                        <a href="#xx" class="btn btn-danger">Lapor Sakit</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Recent Activity -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Aktivitas Terakhir</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Tanggal</th>
                                                        <th>Jenis</th>
                                                        <th>Waktu Masuk</th>
                                                        <th>Waktu Pulang</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($aktivitasRiwayat as $aktivitas)
                                                        <tr>
                                                            <td>{{ $aktivitas->created_at->format('Y-m-d') }}</td>
                                                            <td>{{ $aktivitas->type ?? 'Absensi' }}</td>
                                                            <td>
                                                                @if($aktivitas->status == 'hadir' || $aktivitas->status == 'terlambat')
                                                                    {{ $aktivitas->check_in_time }}
                                                                @else
                                                                    -
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if($aktivitas->status == 'hadir' || $aktivitas->status == 'terlambat')
                                                                    {{ $aktivitas->check_out_time }}
                                                                @else
                                                                    -
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if($aktivitas->status == 'hadir')
                                                                    <span class="badge bg-success">Hadir</span>
                                                                @elseif($aktivitas->status == 'izin')
                                                                    <span class="badge bg-warning">Izin</span>
                                                                @elseif($aktivitas->status == 'sakit')
                                                                    <span class="badge bg-danger">Sakit</span>
                                                                @elseif($aktivitas->status == 'terlambat')
                                                                    <span class="badge bg-secondary">Terlambat</span>
                                                                @else
                                                                    <span class="badge bg-secondary">{{ $aktivitas->status }}</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="6" class="text-center">Tidak ada aktivitas</td>
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
            </div>
        </div>
    </div>
    @endsection


