@extends('layouts.header')

@section('title', 'Hasil Cek Status - Kementerian Sosial RI')

@section('additional_css')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
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
        background-color: #ffffff;
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
    
    .card {
        position: relative;
        z-index: 2;
        border: none;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 15px 50px rgba(0, 0, 0, 0.3);
        background: #ffffff;
        transform: translateY(0);
        transition: transform 0.5s ease, box-shadow 0.5s ease;
    }
    
    .card:hover {
        transform: translateY(-10px);
        box-shadow: 0 25px 60px rgba(0, 0, 0, 0.4);
    }
    
    .card-header {
        background: linear-gradient(135deg, var(--primary-color), #5a0000) !important;
        color: var(--text-light);
        border-bottom: 5px solid var(--secondary-color);
        padding: 1.5rem;
        position: relative;
        overflow: hidden;
    }
    
    .card-header::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 70%);
        transform: rotate(30deg);
        pointer-events: none;
    }
    
    .card-header h4 {
        font-weight: 700;
        margin-bottom: 0;
        display: flex;
        align-items: center;
    }
    
    .card-header h4 i {
        margin-right: 10px;
        font-size: 1.5rem;
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.1);
        }
        100% {
            transform: scale(1);
        }
    }
    
    .card-body {
        position: relative;
        z-index: 2;
        padding: 2.5rem;
        background-color: #ffffff;
    }
    
    .table-bordered {
        border-color: #dee2e6;
    }
    
    .table-bordered td, .table-bordered th {
        border-color: #dee2e6;
        padding: 1rem;
        transition: all 0.3s ease;
    }
    
    .table-bordered tr {
        position: relative;
        overflow: hidden;
    }
    
    .table-bordered tr::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        width: 0;
        background: linear-gradient(90deg, rgba(255, 215, 0, 0.1), rgba(255, 215, 0, 0));
        transition: width 0.4s ease;
        z-index: -1;
    }
    
    .table-bordered tr:hover::before {
        width: 100%;
    }
    
    .table-bordered tr:hover {
        transform: translateX(5px);
    }
    
    .badge {
        font-size: 85%;
        font-weight: 600;
        padding: 0.6em 1em;
        border-radius: 30px;
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }
    
    .badge:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 12px rgba(0, 0, 0, 0.15);
    }
    
    .badge.bg-warning {
        background: linear-gradient(135deg, var(--secondary-color), #ffc107) !important;
        color: var(--text-dark);
    }
    
    .badge.bg-success {
        background: linear-gradient(135deg, #28a745, #218838) !important;
    }
    
    .badge.bg-danger {
        background: linear-gradient(135deg, var(--primary-color), #5a0000) !important;
    }
    
    .alert {
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        border-left: 5px solid;
        position: relative;
        overflow: hidden;
        animation: fadeInUp 0.5s ease-out;
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .alert::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0));
        pointer-events: none;
    }
    
    .alert-success {
        background-color: rgba(212, 237, 218, 0.8);
        border-color: #28a745;
        color: #155724;
    }
    
    .alert-warning {
        background-color: rgba(255, 243, 205, 0.8);
        border-color: var(--secondary-color);
        color: #856404;
    }
    
    .alert-danger {
        background-color: rgba(248, 215, 218, 0.8);
        border-color: var(--primary-color);
        color: #721c24;
    }
    
    .alert-heading {
        font-weight: 700;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
    }
    
    .alert-heading i {
        margin-right: 10px;
        font-size: 1.2rem;
    }
    
    .btn {
        font-weight: 600;
        padding: 0.8rem 1.5rem;
        border-radius: 50px;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: none;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
        position: relative;
        overflow: hidden;
        z-index: 1;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    
    .btn::after {
        content: '';
        position: absolute;
        width: 0;
        height: 100%;
        top: 0;
        left: 0;
        transition: width 0.3s ease;
        z-index: -1;
        border-radius: 50px;
    }
    
    .btn:hover::after {
        width: 100%;
    }
    
    .btn:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.25);
    }
    
    .btn i {
        margin-right: 10px;
        transition: transform 0.3s ease;
    }
    
    .btn:hover i {
        transform: translateY(-3px);
    }
    
    .btn-primary {
        background: linear-gradient(135deg, var(--primary-color), #5a0000);
        color: var(--text-light);
    }
    
    .btn-primary::after {
        background-color: rgba(255, 255, 255, 0.2);
    }
    
    .btn-secondary {
        background: linear-gradient(135deg, #6c757d, #5a6268);
        color: var(--text-light);
    }
    
    .btn-secondary::after {
        background-color: rgba(255, 255, 255, 0.2);
    }
    
    .btn-success {
        background: linear-gradient(135deg, #28a745, #218838);
        color: var(--text-light);
    }
    
    .btn-success::after {
        background-color: rgba(255, 255, 255, 0.2);
    }
    
    .btn-sm {
        padding: 0.5rem 1.2rem;
        font-size: 0.875rem;
    }
    
    /* Animasi untuk table rows */
    .table-appear {
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 0.5s ease, transform 0.5s ease;
    }
    
    .table-appear.active {
        opacity: 1;
        transform: translateY(0);
    }
    
    /* Responsif */
    @media (max-width: 768px) {
        .hero {
            padding: 80px 5%;
        }
        
        .card-body {
            padding: 1.5rem;
        }
    }
</style>
@endsection

@section('content')
@include('layouts.transisi')

<div class="hero">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm" data-aos="fade-up">
                    <div class="card-header">
                        <h4 class="mb-0"><i class="fas fa-clipboard-check"></i> Status Pendaftaran</h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-4" data-aos="fade-up" data-aos-delay="100">
                            <h5 class="fw-bold mb-3">Informasi Pendaftaran</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tr class="table-appear">
                                        <td style="width: 40%"><strong>Nomor Pendaftaran</strong></td>
                                        <td>{{ $pendaftaran->nomor_pendaftaran }}</td>
                                    </tr>
                                    <tr class="table-appear">
                                        <td><strong>Nama Lengkap</strong></td>
                                        <td>{{ $pendaftaran->nama_lengkap }}</td>
                                    </tr>
                                    <tr class="table-appear">
                                        <td><strong>Institusi</strong></td>
                                        <td>{{ $pendaftaran->asal_universitas }}</td>
                                    </tr>
                                    <tr class="table-appear">
                                        <td><strong>Program Studi</strong></td>
                                        <td>{{ $pendaftaran->prodi }}</td>
                                    </tr>
                                    <tr class="table-appear">
                                        <td><strong>Status</strong></td>
                                        <td>
                                            <span class="badge 
                                                {{ $pendaftaran->status == 'Diproses' ? 'bg-warning' : 
                                                    ($pendaftaran->status == 'Ditolak' ? 'bg-danger' : 
                                                    ($pendaftaran->status == 'Diterima' ? 'bg-success' : 
                                                    ($pendaftaran->status == 'Selesai' ? 'bg-info' : 'bg-secondary'))) }}">
                                                {{ $pendaftaran->status }}
                                            </span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        @if($pendaftaran->status == 'Diproses')
                            <div class="alert alert-warning" data-aos="fade-up" data-aos-delay="200">
                                <h6 class="alert-heading"><i class="fas fa-info-circle"></i> Pendaftaran Sedang Diproses</h6>
                                <p class="mb-0">Pendaftaran Anda sedang dalam proses. Mohon menunggu konfirmasi selanjutnya.</p>
                            </div>
                        @elseif($pendaftaran->status == 'Ditolak')
                            <div class="alert alert-danger" data-aos="fade-up" data-aos-delay="200">
                                <h6 class="alert-heading"><i class="fas fa-times-circle"></i> Pendaftaran Anda Ditolak</h6>
                                <p class="mb-0"><strong>Catatan:</strong></p>
                                <p>{{ $pendaftaran->catatan ?? 'Tidak ada catatan yang diberikan.' }}</p>
                            
                            @if($pendaftaran->surat_ditolak)
                                    <a href="{{ asset('storage/'.$pendaftaran->surat_ditolak) }}" target="_blank" class="btn btn-sm btn-danger">
                                        <i class="fas fa-file-pdf"></i> Unduh Surat Balasan Ditolak
                                    </a>
                                @endif
                                </div>
                        @elseif($pendaftaran->status == 'Diterima')
                            <div class="alert alert-success" data-aos="fade-up" data-aos-delay="200">
                                <h6 class="alert-heading"><i class="fas fa-check-circle"></i> Selamat! Pendaftaran Anda Diterima</h6>
                                <p>Silakan login menggunakan kredensial berikut:</p>
                                <div class="row mb-2">
                                    <div class="col-md-4"><strong>Nomor Pendaftaran:</strong></div>
                                    <div class="col-md-8">{{ $pendaftaran->nomor_pendaftaran }}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4"><strong>Password:</strong></div>
                                    <div class="col-md-8">{{ $pendaftaran->decrypted_password ?? $pendaftaran->password }}</div>
                                </div>
                                @if($pendaftaran->surat_balasan)
                                    <a href="{{ asset('storage/'.$pendaftaran->surat_balasan) }}" target="_blank" class="btn btn-sm btn-success">
                                        <i class="fas fa-file-pdf"></i> Unduh Surat Balasan Diterima
                                    </a>
                                @endif
                            </div>
                            @elseif($pendaftaran->status == 'Selesai')
                            <div class="alert alert-info" data-aos="fade-up" data-aos-delay="200">
                                <h6 class="alert-heading"><i class="fas fa-check-double"></i> Selamat! Anda Telah Menyelesaikan Program</h6>
                                <p>Berikut adalah dokumen penyelesaian program magang/PKL Anda:</p>
                                
                                @if(isset($pendaftaran->dokumen_selesai))
                                    <div class="row mt-3">
                                        <div class="col-md-6 mb-2">
                                            @if($pendaftaran->dokumen_selesai->sk_selesai)
                                                <a href="{{ url('storage/' . str_replace('storage/', '', $pendaftaran->dokumen_selesai->sk_selesai)) }}" 
                                                target="_blank" class="btn btn-sm btn-primary w-100">
                                                    <i class="fas fa-file-pdf"></i> Unduh SK Selesai
                                                </a>
                                            @else
                                                <button disabled class="btn btn-sm btn-secondary w-100">
                                                    <i class="fas fa-file-pdf"></i> SK Selesai Belum Tersedia
                                                </button>
                                            @endif
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            @if($pendaftaran->dokumen_selesai->sertifikat)
                                                <a href="{{ url('storage/' . str_replace('storage/', '', $pendaftaran->dokumen_selesai->sertifikat)) }}" 
                                                target="_blank" class="btn btn-sm btn-success w-100">
                                                    <i class="fas fa-certificate"></i> Unduh Sertifikat
                                                </a>
                                            @else
                                                <button disabled class="btn btn-sm btn-secondary w-100">
                                                    <i class="fas fa-certificate"></i> Sertifikat Belum Tersedia
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                @else
                                    <div class="alert alert-warning mt-2 mb-0">
                                        <small><i class="fas fa-info-circle"></i> Dokumen penyelesaian program belum tersedia.</small>
                                    </div>
                                @endif
                            </div>
                        @endif

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end" data-aos="fade-up" data-aos-delay="300">
                            <a href="{{ route('status.form') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <a href="{{ route('home') }}" class="btn btn-primary">
                                <i class="fas fa-home"></i> Halaman Utama
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    // Inisialisasi AOS Animation
    AOS.init({
        duration: 800,
        once: true
    });
    
    // Animasi untuk table rows
    document.addEventListener('DOMContentLoaded', function() {
        const tableRows = document.querySelectorAll('.table-appear');
        tableRows.forEach((row, index) => {
            setTimeout(() => {
                row.classList.add('active');
            }, 100 * (index + 1));
        });
    });
</script>
@endsection