@extends('layouts.header_admin')

@section('title', 'Dashboard Admin - Kementerian Sosial RI')

@section('additional_css')
<style>
        body {
            font-family: 'Calibri', sans-serif;
        }
        .card {
            box-shadow: 0 0 1px rgba(0,0,0,0.125), 0 1px 3px rgba(0,0,0,0.2);
        }
    </style>
    @endsection

@section('content')
                <!-- Content -->
                <div class="container-fluid px-4">
                    <div class="row">
                        <div class="col-lg-3 col-6 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5>Total Peserta Magang</h5>
                                    <h2>{{ $totalPeserta ?? 0 }}</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5>Total Absensi Hari Ini</h5>
                                    <h2>{{ $totalAbsensiHariIni ?? 0 }}</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5>Total Laporan</h5>
                                    <h2>{{ $totalLaporan ?? 0 }}</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5>Total Admin</h5>
                                    <h2>{{ $totalAdmin ?? 0 }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Activities -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Aktivitas Terbaru</h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Tanggal</th>
                                                    <th>Nama</th>
                                                    <th>Aktivitas</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($recentActivities ?? [] as $activity)
                                                <tr>
                                                    <td>{{ $activity->tanggal }}</td>
                                                    <td>{{ $activity->nama }}</td>
                                                    <td>{{ $activity->aktivitas }}</td>
                                                    <td>{{ $activity->status }}</td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="4" class="text-center">Tidak ada aktivitas terbaru</td>
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
  

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @endsection