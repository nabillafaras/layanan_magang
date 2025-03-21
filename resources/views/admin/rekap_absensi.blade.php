@extends('layouts.header_admin')

@section('title', 'Rekapitulasi Absensi Peserta Magang - Kementerian Sosial RI')

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
    <h1 class="mt-4">Rekapitulasi Absensi Peserta Magang</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Rekapitulasi Absensi</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <i class="fas fa-calendar-check me-1"></i>
                    Data Absensi Peserta Magang
                </div>
                <div class="col-md-6 text-end">
                    <form action="{{ route('admin.rekapitulasi-absensi') }}" method="GET" class="row g-3 justify-content-end">
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
                            <a href="{{ route('admin.export-absensi') }}?bulan={{ request('bulan', date('Y-m')) }}&direktorat={{ request('direktorat', '') }}" class="btn btn-success">
                                <i class="fas fa-file-excel me-1"></i> Export Excel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="absensiTable">
                    <thead class="table-dark">
                        <tr>
                            <th rowspan="2" class="text-center align-middle">No</th>
                            <th rowspan="2" class="text-center align-middle">Nama Lengkap</th>
                            <th rowspan="2" class="text-center align-middle">Direktorat</th>
                            <th rowspan="2" class="text-center align-middle">Asal Instansi</th>
                            <th colspan="{{ $totalDays ?? 31 }}" class="text-center">Tanggal</th>
                            <th colspan="4" class="text-center">Rekapitulasi</th>
                        </tr>
                        <tr>
                            @for ($i = 1; $i <= ($totalDays ?? 31); $i++)
                                <th class="text-center">{{ $i }}</th>
                            @endfor
                            <th class="text-center">H</th>
                            <th class="text-center">S</th>
                            <th class="text-center">I</th>
                            <th class="text-center">A</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pesertaAbsensi as $index => $peserta)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $peserta->nama_lengkap }}</td>
                            <td>{{ $peserta->direktorat }}</td>
                            <td>{{ $peserta->asal_universitas }}</td>

                            @for ($i = 1; $i <= ($totalDays ?? 31); $i++)
                                @php
                                    $date = $tahun . '-' . $bulan . '-' . str_pad($i, 2, '0', STR_PAD_LEFT);
                                    $attendance = $peserta->attendances->where('date', $date)->first();
                                    $status = $attendance ? $attendance->status : '-';
                                    $colorClass = '';

                                    if ($status == 'H') {
                                        $colorClass = 'bg-success text-white';
                                    } elseif ($status == 'S') {
                                        $colorClass = 'bg-warning';
                                    } elseif ($status == 'I') {
                                        $colorClass = 'bg-info text-white';
                                    } elseif ($status == 'A') {
                                        $colorClass = 'bg-danger text-white';
                                    }
                                @endphp
                                <td class="text-center {{ $colorClass }}">{{ $status }}</td>
                            @endfor

                            <td class="text-center">{{ $peserta->attendances->where('status', 'H')->count() }}</td>
                            <td class="text-center">{{ $peserta->attendances->where('status', 'S')->count() }}</td>
                            <td class="text-center">{{ $peserta->attendances->where('status', 'I')->count() }}</td>
                            <td class="text-center">{{ $peserta->attendances->where('status', 'A')->count() }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="{{ ($totalDays ?? 31) + 8 }}" class="text-center">Tidak ada data absensi peserta magang yang tersedia.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-pie me-1"></i>
                    Statistik Absensi Peserta Magang
                </div>
                <div class="card-body">
                    <canvas id="absensiChart" width="100%" height="50"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
        <div class="card">
    <div class="card-header">
        <h5><i class="fas fa-info-circle"></i> Keterangan</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Hadir (H)
                        <span class="badge bg-success rounded-pill">{{ $totalHadir ?? 0 }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Sakit (S)
                        <span class="badge bg-warning rounded-pill">{{ $totalSakit ?? 0 }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Izin (I)
                        <span class="badge bg-info rounded-pill">{{ $totalIzin ?? 0 }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Alpha (A)
                        <span class="badge bg-danger rounded-pill">{{ $totalAlpha ?? 0 }}</span>
                    </li>
                </ul>
            </div>
        </div>
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
        $('#absensiTable').DataTable({
            "scrollX": true,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/id.json"
            }
        });

        // Chart Data
        var ctx = document.getElementById('absensiChart');
        var myPieChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Hadir', 'Sakit', 'Izin', 'Alpha'],
                datasets: [{
                    data: [
                        {{ $totalHadir ?? 0 }}, 
                        {{ $totalSakit ?? 0 }}, 
                        {{ $totalIzin ?? 0 }}, 
                        {{ $totalAlpha ?? 0 }}
                    ],
                    backgroundColor: [
                        '#28a745',  // success
                        '#ffc107',  // warning
                        '#17a2b8',  // info
                        '#dc3545'   // danger
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