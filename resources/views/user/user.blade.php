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
                                    <p class="h2">15</p>
                                    <small>Hari ini: 1</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="stat-card">
                                    <h3>Total Izin</h3>
                                    <p class="h2">2</p>
                                    <small>Bulan ini</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="stat-card">
                                    <h3>Total Sakit</h3>
                                    <p class="h2">1</p>
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
                                                        <th>Status</th>
                                                        <th>Keterangan</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>{{ date('Y-m-d') }}</td>
                                                        <td>Masuk</td>
                                                        <td><span class="badge bg-success">Hadir</span></td>
                                                        <td>Absensi tepat waktu</td>
                                                    </tr>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @endsection