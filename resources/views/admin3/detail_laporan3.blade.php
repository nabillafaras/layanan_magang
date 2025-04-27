@extends('layouts.header_admin3')

@section('title', 'Detail Laporan - Kementerian Sosial RI')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="mt-4">Detail Laporan</h1>
    </div>
    <ol class="breadcrumb mb-4">
        @if(session('previous_direktorat'))
            <li class="breadcrumb-item"><a href="{{ route('admin3.direktorat', ['id' => session('previous_direktorat')]) }}">Direktorat {{ session('previous_direktorat') }}</a></li>
        @endif
        <li class="breadcrumb-item active">Detail Laporan Direktorat Jenderal Rehabilitas Sosial</li>
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
                    <a href="{{ asset($laporan->file_path) }}" class="btn btn-primary" target="_blank">
                        <i class="fas fa-file-download me-1"></i> Download Laporan
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-tasks me-1"></i>
            Update Status Laporan
        </div>
        <div class="card-body">
            <form action="{{ route('admin3.update-status', ['id' => $laporan->id]) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="status" class="form-label">Status Laporan</label>
                    <select class="form-select" id="status" name="status" required>
                        <option value="Menunggu" {{ $laporan->status == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                        <option value="Acc" {{ $laporan->status == 'Acc' ? 'selected' : '' }}>Acc</option>
                        <option value="Ditolak" {{ $laporan->status == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
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
@endsection