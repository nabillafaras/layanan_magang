@extends('layouts.header')

@section('title', 'Cek Status Pendaftaran - Kementerian Sosial RI')

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
    
    .form-control {
        padding: 0.8rem 1.2rem;
        border-radius: 10px;
        border: 1px solid rgba(0,0,0,0.1);
        font-size: 1rem;
        transition: all 0.3s ease;
        background-color: #f8f9fa;
    }
    
    .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.25rem rgba(139, 0, 0, 0.25);
        background-color: #ffffff;
    }
    
    .form-label {
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 0.5rem;
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
    
    .alert {
        border-radius: 15px;
        padding: 1.25rem;
        margin-bottom: 1.5rem;
        border-left: 5px solid;
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
    
    .alert-danger {
        background-color: rgba(248, 215, 218, 0.8);
        border-color: var(--primary-color);
        color: #721c24;
    }
    
    /* Animasi input focus */
    .form-floating {
        position: relative;
    }
    
    .input-animation {
        position: relative;
        overflow: hidden;
    }
    
    .input-animation::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 0;
        height: 2px;
        background-color: var(--primary-color);
        transition: width 0.4s ease;
    }
    
    .input-animation:focus-within::after {
        width: 100%;
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
                        <h4 class="mb-0"><i class="fas fa-search"></i> Informasi Status Magang</h4>
                    </div>
                    <div class="card-body">
                        @if(session('error'))
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                            </div>
                        @endif
                        
                        <div data-aos="fade-up" data-aos-delay="100">
                        <ul class="list-disc pl-5 space-y-3">
                            <li class="mb-2"><strong>Cek Status Pendaftaran</strong>: Cek Status pendaftaran Anda untuk melihat apakah pendaftaran magang Anda masih dalam Proses/Diterima/Ditolak.</li>
                            <li class="mb-2"><strong>Ambil Dokumen Penyelesaian</strong>: Setelah menyelesaikan program magang, Anda dapat mengunduh:
                            <ul class="list-circle pl-5 mt-1">
                                <li>Surat Keterangan Penyelesaian Magang</li>
                                <li>Sertifikat Magang</li>
                            </ul>
                            </li>
                            <li class="mb-2"><strong>Cara Penggunaan</strong>: Cukup masukkan nomor pendaftaran Anda pada kolom yang tersedia dan klik tombol "Cek Status".</li>
                        </ul>
                        </div>
                        <form action="{{ route('status.check') }}" method="POST" id="checkStatusForm">
                            @csrf
                            <div class="form-group mb-4" data-aos="fade-up" data-aos-delay="200">
                                <label for="nomor_pendaftaran" class="form-label">Nomor Pendaftaran</label>
                                <div class="input-animation">
                                    <input type="text" class="form-control @error('nomor_pendaftaran') is-invalid @enderror" 
                                         id="nomor_pendaftaran" name="nomor_pendaftaran" placeholder="Contoh: REG-2025-00123" required>
                                </div>
                                @error('nomor_pendaftaran')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="d-grid" data-aos="fade-up" data-aos-delay="300">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i> Cek Status
                                </button>
                            </div>
                        </form>
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
</script>
@endsection