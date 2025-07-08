@extends('layouts.header_admin3')

@section('title', 'Detail Laporan - Kementerian Sosial RI')
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

    
</style>
@section('content')
<div class="container-fluid px-4">
    <div class="dashboard-header fade-in">
        <h2 class="mt-4">Detail Laporan</h2>
    </div>
    <ol class="breadcrumb mb-4">
        @if(session('previous_direktorat'))
            <li class="breadcrumb-item"><a href="{{ route('admin.direktorat', ['id' => session('previous_direktorat')]) }}">Direktorat {{ session('previous_direktorat') }}</a></li>
        @endif
        <li class="breadcrumb-item active">Detail Laporan</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-file-alt me-1"></i>
            Informasi Laporan
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-3 fw-bold">Nama Peserta</div>
                <div class="col-md-9">{{ $laporan->pendaftaran->nama_lengkap }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3 fw-bold">Asal Instansi</div>
                <div class="col-md-9">{{ $laporan->pendaftaran->asal_universitas }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3 fw-bold">Direktorat</div>
                <div class="col-md-9">{{ $laporan->pendaftaran->direktorat }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3 fw-bold">Jenis Laporan</div>
                <div class="col-md-9">{{ $laporan->jenis_laporan }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3 fw-bold">Judul</div>
                <div class="col-md-9">{{ $laporan->judul }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3 fw-bold">Periode</div>
                <div class="col-md-9">{{ \Carbon\Carbon::parse($laporan->periode_bulan)->format('F Y') }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3 fw-bold">Tanggal Upload</div>
                <div class="col-md-9">{{ \Carbon\Carbon::parse($laporan->created_at)->format('d F Y, H:i') }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3 fw-bold">Status</div>
                <div class="col-md-9">
                    <span class="badge bg-{{ $laporan->status == 'Menunggu' ? 'warning' : ($laporan->status == 'Acc' ? 'success' : 'danger') }}">
                        {{ ucfirst($laporan->status) }}
                    </span>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3 fw-bold">Feedback</div>
                <div class="col-md-9">{{ $laporan->feedback ?: 'Belum ada feedback' }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3 fw-bold">File Laporan</div>
                <div class="col-md-9">
                    <a href="{{ asset('storage/app/public/'.$laporan->file_path) }}" class="btn btn-primary" target="_blank">
                        <i class="fas fa-file-download me-1"></i> Unduh Laporan
                    </a>
                </div>
            </div>
           @if($laporan->jenis_laporan == 'akhir' && $laporan->status == 'Acc')
            @if($laporan->sk_selesai)
            <div class="row mb-3">
                <div class="col-md-3 fw-bold">SK Selesai</div>
                <div class="col-md-9">
                    <a href="{{ url('storage/app/public/' . str_replace('storage/', '', $laporan->sk_selesai)) }}" class="btn btn-success" target="_blank">
                        <i class="fas fa-file-download me-1"></i> Unduh SK Selesai
                    </a>
                </div>
            </div>
            @endif
                
                @if($laporan->sertifikat)
                <div class="row mb-3">
                    <div class="col-md-3 fw-bold">Sertifikat</div>
                    <div class="col-md-9">
                        <a href="{{ url('storage/app/public/' . str_replace('storage/', '', $laporan->sertifikat)) }}" class="btn btn-success" target="_blank">
                            <i class="fas fa-file-download me-1"></i> Unduh Sertifikat
                        </a>
                    </div>
                </div>
                @endif
                @if($laporan->nilai_magang)
                <div class="row mb-3">
                    <div class="col-md-3 fw-bold">Nilai Magang</div>
                    <div class="col-md-9">
                        <a href="{{ url('storage/app/public/' . str_replace('storage/', '', $laporan->nilai_magang)) }}" class="btn btn-success" target="_blank">
                            <i class="fas fa-file-download me-1"></i> Unduh Nilai Magang
                        </a>
                    </div>
                </div>
                @endif
            @endif
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-tasks me-1"></i>
            Update Status Laporan
        </div>
        <div class="card-body">
            <form action="{{ route('admin3.update-status', ['id' => $laporan->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="status" class="form-label">Status Laporan</label>
                    <select class="form-select" id="status" name="status" required>
                        <option value="Menunggu" {{ $laporan->status == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                        <option value="Acc" {{ $laporan->status == 'Acc' ? 'selected' : '' }}>Acc</option>
                        <option value="Ditolak" {{ $laporan->status == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>
                
                <div id="fileUploadContainer" style="{{ ($laporan->jenis_laporan != 'akhir' || $laporan->status == 'Acc') ? 'display:none;' : '' }}">
                    <div class="mb-3">
                        <label for="sk_selesai" class="form-label">Upload SK Selesai</label>
                        <input type="file" class="form-control" id="sk_selesai" name="sk_selesai" accept=".pdf,.jpg,.jpeg,.png">
                        <small class="text-muted">Upload SK Selesai bila ini adalah laporan akhir dan status diubah menjadi Acc</small>
                    </div>
                    
                    <div class="mb-3">
                        <label for="sertifikat" class="form-label">Upload Sertifikat</label>
                        <input type="file" class="form-control" id="sertifikat" name="sertifikat" accept=".pdf,.jpg,.jpeg,.png">
                        <small class="text-muted">Upload sertifikat bila ini adalah laporan akhir dan status diubah menjadi Acc</small>
                    </div>
                    <div class="mb-3">
                        <label for="nilai_magang" class="form-label">Upload Nilai Magang</label>
                        <input type="file" class="form-control" id="nilai_magang" name="nilai_magang" accept=".pdf,.jpg,.jpeg,.png">
                        <small class="text-muted">Upload Nilai Magang bila ini adalah laporan akhir dan status diubah menjadi Acc</small>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary">Update Status</button>
            </form>
        </div>
    </div>

    @if($laporan->feedback === null || $laporan->feedback === '')
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-comment me-1"></i>
            Berikan Feedback
        </div>
        <div class="card-body">
            <form action="{{ route('admin3.submit-feedback', ['id' => $laporan->id]) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="feedback" class="form-label">Feedback untuk Laporan</label>
                    <textarea class="form-control" id="feedback" name="feedback" rows="5" required></textarea>
                </div>
                <button type="submit" class="btn btn-success">Submit Feedback</button>
            </form>
        </div>
    </div>
    @endif

    <div class="mt-4 mb-5">
        <a href="{{ url()->previous() }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const statusSelect = document.getElementById('status');
    const fileUploadContainer = document.getElementById('fileUploadContainer');
    const jenisLaporan = "{{ $laporan->jenis_laporan }}";
    
    statusSelect.addEventListener('change', function() {
        if (jenisLaporan === 'akhir' && this.value === 'Acc') {
            fileUploadContainer.style.display = 'block';
        } else {
            fileUploadContainer.style.display = 'none';
        }
    });
    
    // Menampilkan form upload pada halaman load
    if (jenisLaporan === 'akhir' && statusSelect.value === 'Acc' && "{{ $laporan->status }}" !== 'Acc') {
        fileUploadContainer.style.display = 'block';
    }
});
</script>
@endsection