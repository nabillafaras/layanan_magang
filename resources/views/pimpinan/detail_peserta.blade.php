@extends('layouts.header_pimpinan')

@section('title', 'Detail Peserta Magang - Kementerian Sosial RI')

@section('additional_css')
<link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
<style>
    .card {
        box-shadow: 0 0 1px rgba(0,0,0,0.125), 0 1px 3px rgba(0,0,0,0.2);
        margin-bottom: 1rem;
    }
    .profile-section {
        background-color: #f8f9fa;
        border-radius: 10px;
    }
    .profile-img {
        width: 120px;
        height: 120px;
        background-color: #8b0000;
        border-radius: 50%;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 48px;
        font-weight: bold;
    }
    .stats-card {
        border-radius: 10px;
        transition: all 0.2s;
    }
    .stats-card:hover {
        transform: translateY(-5px);
    }
    .stats-icon {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .doc-icon {
        font-size: 24px;
    }
    .doc-link {
        text-decoration: none;
        color: inherit;
    }
    .doc-link:hover {
        color: #8b0000;
    }
    .progress {
        height: 8px;
    }
    .attendance-stat {
        text-align: center;
        padding: 10px;
        border-radius: 10px;
        margin-bottom: 10px;
        color: white;
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Detail Peserta Magang</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('pimpinan.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('pimpinan.peserta') }}">Data Peserta Magang</a></li>
        <li class="breadcrumb-item active">Detail Peserta</li>
    </ol>

    <!-- Back Button -->
    <div class="mb-3">
        <a href="{{ route('pimpinan.peserta') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <!-- Profile Section -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <!-- Profile Image -->
                        <div class="col-md-3 text-center">
                            <div class="d-flex flex-column align-items-center">
                                <div class="profile-img mb-3">
                                    {{ substr($peserta->nama_lengkap, 0, 1) }}
                                </div>
                                <h4>{{ $peserta->nama_lengkap }}</h4>
                                <p class="text-muted">{{ $peserta->nomor_pendaftaran }}</p>
                                <div class="mb-2">
                                    @if($peserta->status == 'diterima')
                                        <span class="badge bg-success p-2">Diterima</span>
                                    @elseif($peserta->status == 'diproses')
                                        <span class="badge bg-warning p-2">Diproses</span>
                                    @elseif($peserta->status == 'ditolak')
                                        <span class="badge bg-danger p-2">Ditolak</span>
                                    @else
                                        <span class="badge bg-secondary p-2">{{ $peserta->status }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <!-- Profile Info -->
                        <div class="col-md-5">
                            <h5 class="border-bottom pb-2 mb-3">Informasi Pribadi</h5>
                            
                            <div class="row mb-2">
                                <div class="col-md-5 text-muted">Email:</div>
                                <div class="col-md-7 fw-bold">{{ $peserta->email }}</div>
                            </div>
                            
                            <div class="row mb-2">
                                <div class="col-md-5 text-muted">No. HP:</div>
                                <div class="col-md-7">{{ $peserta->no_hp }}</div>
                            </div>
                            
                            <div class="row mb-2">
                                <div class="col-md-5 text-muted">Tanggal Lahir:</div>
                                <div class="col-md-7">{{ $peserta->ttl }}</div>
                            </div>
                            
                            <div class="row mb-2">
                                <div class="col-md-5 text-muted">Jenis Kelamin:</div>
                                <div class="col-md-7">{{ $peserta->jenis_kelamin }}</div>
                            </div>
                            
                            <h5 class="border-bottom pb-2 mb-3 mt-4">Informasi Akademik</h5>
                            
                            <div class="row mb-2">
                                <div class="col-md-5 text-muted">Universitas:</div>
                                <div class="col-md-7">{{ $peserta->asal_universitas }}</div>
                            </div>
                            
                            <div class="row mb-2">
                                <div class="col-md-5 text-muted">Jurusan:</div>
                                <div class="col-md-7">{{ $peserta->jurusan }}</div>
                            </div>
                            
                            <div class="row mb-2">
                                <div class="col-md-5 text-muted">Program Studi:</div>
                                <div class="col-md-7">{{ $peserta->prodi }}</div>
                            </div>
                            
                            <div class="row mb-2">
                                <div class="col-md-5 text-muted">Semester:</div>
                                <div class="col-md-7">{{ $peserta->semester }}</div>
                            </div>
                            
                            <div class="row mb-2">
                                <div class="col-md-5 text-muted">IPK:</div>
                                <div class="col-md-7">{{ $peserta->ipk }}</div>
                            </div>
                        </div>
                        
                        <!-- Magang Info & Documents -->
                        <div class="col-md-4">
                            <h5 class="border-bottom pb-2 mb-3">Informasi Magang</h5>
                            
                            <div class="row mb-2">
                                <div class="col-md-5 text-muted">Direktorat:</div>
                                <div class="col-md-7">{{ $peserta->direktorat }}</div>
                            </div>
                            
                            <div class="row mb-2">
                                <div class="col-md-5 text-muted">Unit Kerja:</div>
                                <div class="col-md-7">{{ $peserta->unit_kerja }}</div>
                            </div>
                            
                            <h5 class="border-bottom pb-2 mb-3 mt-4">Dokumen</h5>
                            
                            <div class="row mb-3">
                                <div class="col-2">
                                    <div class="doc-icon text-primary">
                                        <i class="fas fa-file-pdf"></i>
                                    </div>
                                </div>
                                <div class="col-10">
                                    <a href="{{ asset('storage/' . $peserta->surat_pengantar) }}" class="doc-link" target="_blank">
                                        <div class="fw-bold">Surat Pengantar</div>
                                        <small class="text-muted">Klik untuk melihat</small>
                                    </a>
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-2">
                                    <div class="doc-icon text-success">
                                        <i class="fas fa-file-excel"></i>
                                    </div>
                                </div>
                                <div class="col-10">
                                    <a href="{{ asset('storage/' . $peserta->transkrip_nilai) }}" class="doc-link" target="_blank">
                                        <div class="fw-bold">Transkrip Nilai</div>
                                        <small class="text-muted">Klik untuk melihat</small>
                                    </a>
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-2">
                                    <div class="doc-icon text-info">
                                        <i class="fas fa-file-word"></i>
                                    </div>
                                </div>
                                <div class="col-10">
                                    <a href="{{ asset('storage/' . $peserta->cv) }}" class="doc-link" target="_blank">
                                        <div class="fw-bold">Curriculum Vitae</div>
                                        <small class="text-muted">Klik untuk melihat</small>
                                    </a>
                                </div>
                            </div>
                            
                            @if($peserta->surat_balasan)
                            <div class="row mb-3">
                                <div class="col-2">
                                    <div class="doc-icon text-danger">
                                        <i class="fas fa-file-pdf"></i>
                                    </div>
                                </div>
                                <div class="col-10">
                                    <a href="{{ asset('storage/' . $peserta->surat_balasan) }}" class="doc-link" target="_blank">
                                        <div class="fw-bold">Surat Balasan</div>
                                        <small class="text-muted">Klik untuk melihat</small>
                                    </a>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="row">
        <!-- Attendance Stats -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Statistik Kehadiran</h5>
                </div>
                <div class="card-body">
                    <!-- Progress -->
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span>Persentase Kehadiran</span>
                            <span class="fw-bold">{{ $persentaseKehadiran }}%</span>
                        </div>
                        <div class="progress">
                            <div 
                                class="progress-bar bg-success" 
                                role="progressbar" 
                                style="width: {{ $persentaseKehadiran }}%" 
                                aria-valuenow="{{ $persentaseKehadiran }}" 
                                aria-valuemin="0" 
                                aria-valuemax="100">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Attendance Stats -->
                    <div class="row">
                        <div class="col-md-4">
                            <div class="attendance-stat bg-success">
                                <i class="fas fa-check-circle mb-2"></i>
                                <h4>{{ $hadir }}</h4>
                                <div>Hadir</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="attendance-stat bg-info">
                                <i class="fas fa-procedures mb-2"></i>
                                <h4>{{ $sakit }}</h4>
                                <div>Sakit</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="attendance-stat bg-warning">
                                <i class="fas fa-clock mb-2"></i>
                                <h4>{{ $izin }}</h4>
                                <div>Izin</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- View button -->
                    <div class="mt-3 text-center">
                        <a href="{{ route('pimpinan.absensi.index', ['user_id' => $peserta->id]) }}" class="btn btn-primary">
                            <i class="fas fa-calendar-check"></i> Lihat Riwayat Kehadiran
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Report Stats -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Laporan Terbaru</h5>
                </div>
                <div class="card-body">
                    @if(count($laporanTerbaru) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Jenis</th>
                                        <th>Judul</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($laporanTerbaru as $laporan)
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($laporan->created_at)->format('d-m-Y') }}</td>
                                            <td>{{ $laporan->jenis_laporan }}</td>
                                            <td>{{ $laporan->judul }}</td>
                                            <td>
                                                @if($laporan->status == 'menunggu')
                                                    <span class="badge bg-warning">Menunggu</span>
                                                @elseif($laporan->status == 'diterima')
                                                    <span class="badge bg-success">Diterima</span>
                                                @elseif($laporan->status == 'ditolak')
                                                    <span class="badge bg-danger">Ditolak</span>
                                                @else
                                                    <span class="badge bg-secondary">{{ $laporan->status }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ asset('storage/' . $laporan->file_path) }}" target="_blank" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-download"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                            <p>Belum ada laporan yang dikumpulkan.</p>
                        </div>
                    @endif
                    
                    <!-- View button -->
                    <div class="mt-3 text-center">
                        <a href="{{ route('pimpinan.laporan.index', ['user_id' => $peserta->id]) }}" class="btn btn-primary">
                            <i class="fas fa-file-alt"></i> Lihat Semua Laporan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('additional_scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.0/dist/chart.min.js"></script>
<script>
    // Future implementation for charts if needed
</script>
@endsection