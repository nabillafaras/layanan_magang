@extends('layouts.header')

@section('title', 'Hasil Cek Status - Kementerian Sosial RI')

@section('additional_css')
<style>
    :root {
        --primary-color: #8b0000;
        --primary-hover: #a00000;
        --secondary-color: #FFD700;
        --text-light: #ffffff;
        --text-dark: #333333;
        --bg-light: #f8f9fa;
        --transition: all 0.3s ease;
    }
    
    body {
        font-family: 'Calibri', sans-serif;
        overflow-x: hidden;
        color: var(--text-dark);
    }
    
    /* Page Transition Animation */
    .fade-enter-active {
        animation: fadeIn 0.5s ease-in;
    }
    
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    /* Hero Section */
    .hero {
        position: relative;
        min-height: 100vh;
        background-image: url('images/bg1.png');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        display: flex;
        align-items: center;
        padding: 100px 10%;
    }
    
    .hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(139, 0, 0, 0.9) 0%, rgba(139, 0, 0, 0.7) 100%);
        z-index: 0;
    }
    
    .hero-content {
        position: relative;
        z-index: 2;
        max-width: 600px;
        animation: slideInLeft 1s ease-out;
    }

    .card {
        border: none;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }
    
    .card-header {
        background-color: var(--primary-color) !important;
        color: var(--text-light);
        border-bottom: none;
        padding: 1.2rem 1.5rem;
    }
    
    .card-body {
        padding: 2rem;
    }
    
    .table-bordered {
        border-color: #dee2e6;
    }
    
    .table-bordered td, .table-bordered th {
        border-color: #dee2e6;
        padding: 0.75rem 1rem;
    }
    
    .badge {
        font-size: 85%;
        font-weight: 600;
        padding: 0.5em 0.8em;
        border-radius: 5px;
    }
    
    .badge.bg-warning {
        background-color: var(--secondary-color) !important;
        color: var(--text-dark);
    }
    
    .badge.bg-success {
        background-color: #28a745 !important;
    }
    
    .badge.bg-danger {
        background-color: var(--primary-color) !important;
    }
    
    .alert {
        border-radius: 8px;
        padding: 1.25rem;
        margin-bottom: 1.5rem;
        border-left: 5px solid;
    }
    
    .alert-success {
        background-color: #d4edda;
        border-color: #28a745;
        color: #155724;
    }
    
    .alert-warning {
        background-color: #fff3cd;
        border-color: var(--secondary-color);
        color: #856404;
    }
    
    .alert-danger {
        background-color: #f8d7da;
        border-color: var(--primary-color);
        color: #721c24;
    }
    
    .alert-heading {
        font-weight: 600;
        margin-bottom: 1rem;
    }
    
    .btn {
        padding: 0.6rem 1.5rem;
        border-radius: 5px;
        font-weight: 600;
        transition: var(--transition);
    }
    
    .btn-primary {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
        color: var(--text-light);
    }
    
    .btn-primary:hover, .btn-primary:focus {
        background-color: var(--primary-hover);
        border-color: var(--primary-hover);
    }
    
    .btn-secondary {
        background-color: #6c757d;
        border-color: #6c757d;
    }
    
    .btn-secondary:hover {
        background-color: #5a6268;
        border-color: #545b62;
    }
    
    .btn-success {
        background-color: #28a745;
        border-color: #28a745;
    }
    
    .btn-success:hover {
        background-color: #218838;
        border-color: #1e7e34;
    }
    
    .btn-sm {
        padding: 0.4rem 1rem;
        font-size: 0.875rem;
    }
    
    .fas {
        margin-right: 0.5rem;
    }
    </style>
@endsection

@section('content')
@include('layouts.transisi')
<div class="hero">
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Status Pendaftaran</h4>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h5>Informasi Pendaftaran</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <td style="width: 40%"><strong>Nomor Pendaftaran</strong></td>
                                    <td>{{ $pendaftaran->nomor_pendaftaran }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Nama Lengkap</strong></td>
                                    <td>{{ $pendaftaran->nama_lengkap }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Institusi</strong></td>
                                    <td>{{ $pendaftaran->asal_universitas }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Program Studi</strong></td>
                                    <td>{{ $pendaftaran->prodi }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Status</strong></td>
                                    <td>
                                        <span class="badge {{ $pendaftaran->status == 'Diproses' ? 'bg-warning' : 
                                            ($pendaftaran->status == 'Diterima' ? 'bg-success' : 'bg-danger') }}">
                                            {{ $pendaftaran->status }}
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    @if($pendaftaran->status == 'Diproses')
                        <div class="alert alert-warning">
                            <i class="fas fa-info-circle me-2"></i> Pendaftaran Anda sedang dalam proses. Mohon menunggu konfirmasi selanjutnya.
                        </div>
                    @elseif($pendaftaran->status == 'Ditolak')
                        <div class="alert alert-danger">
                            <h6 class="alert-heading">Pendaftaran Anda Ditolak</h6>
                            <p class="mb-0"><strong>Catatan:</strong></p>
                            <p>{{ $pendaftaran->catatan ?? 'Tidak ada catatan yang diberikan.' }}</p>
                        </div>
                    @elseif($pendaftaran->status == 'Diterima')
                        <div class="alert alert-success">
                            <h6 class="alert-heading">Selamat! Pendaftaran Anda Diterima</h6>
                            <p>Silakan login menggunakan kredensial berikut:</p>
                            <div class="row mb-2">
                                <div class="col-md-4"><strong>Nomor Pendaftaran:</strong></div>
                                <div class="col-md-8">{{ $pendaftaran->nomor_pendaftaran }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4"><strong>Kode Akses:</strong></div>
                                <div class="col-md-8">{{ session('temp_password') }}</div>
                            </div>
                            @if($pendaftaran->surat_balasan)
                                <a href="{{ asset('storage/'.$pendaftaran->surat_balasan) }}" target="_blank" class="btn btn-sm btn-success">
                                    <i class="fas fa-file-pdf me-1"></i> Unduh Surat Balasan
                                </a>
                            @endif
                        </div>
                    @endif

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('status.form') }}" class="btn btn-secondary">Kembali</a>
                        <a href="{{ route('home') }}" class="btn btn-primary">Halaman Utama</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>
@endsection