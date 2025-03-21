@extends('layouts.header_pimpinan')

@section('title', 'Dashboard Pimpinan - Kementerian Sosial RI')

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
<div class="container-fluid px-4">
    <h1 class="mt-4">Dashboard Pimpinan</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('pimpinan.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Dashboard Pimpinan</li>
    </ol>
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
                                                    <th>Direktorat</th>
                                                    <th>Aktivitas</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($recentActivities ?? [] as $activity)
                                                <tr>
                                                    <td>{{ \Carbon\Carbon::parse($activity->tanggal)->format('d-m-Y H:i') }}</td>
                                                    <td>{{ $activity->nama }}</td>
                                                    <td>{{ $activity->direktorat }}</td>
                                                    <td>{{ $activity->aktivitas }}</td>
                                                    <td>
                                                        @if($activity->status == 'hadir')
                                                            <span class="badge bg-success">Hadir</span>
                                                        @elseif($activity->status == 'izin')
                                                            <span class="badge bg-warning">Izin</span>
                                                        @elseif($activity->status == 'sakit')
                                                            <span class="badge bg-info">Sakit</span>
                                                        @elseif($activity->status == 'menunggu')
                                                            <span class="badge bg-warning">Menunggu</span>
                                                        @elseif($activity->status == 'diterima')
                                                            <span class="badge bg-success">Diterima</span>
                                                        @elseif($activity->status == 'ditolak')
                                                            <span class="badge bg-danger">Ditolak</span>
                                                        @else
                                                            <span class="badge bg-secondary">{{ $activity->status }}</span>
                                                        @endif
                                                    </td>
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
    @endsection