@extends('layouts.header')

@section('title', 'Cek Status Pendaftaran - Kementerian Sosial RI')

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
        position: relative;
        z-index: 2;
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
        position: relative;
        z-index: 2;
        padding: 2rem;
    }
    
    .btn-primary {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
        color: var(--text-light);
        transition: var(--transition);
    }
    
    .btn-primary:hover, .btn-primary:focus {
        background-color: var(--primary-hover);
        border-color: var(--primary-hover);
    }
    
    .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.25rem rgba(139, 0, 0, 0.25);
    }
    
    .form-label {
        font-weight: 600;
        color: var(--text-dark);
    }
    
    /* Badges untuk hasil status */
    .badge.bg-warning {
        background-color: #FFD700 !important;
        color: var(--text-dark);
    }
    
    .badge.bg-success {
        background-color: #28a745 !important;
    }
    
    .badge.bg-danger {
        background-color: var(--primary-color) !important;
    }
    
    /* Alert styling */
    .alert {
        border-radius: 8px;
        padding: 1.25rem;
        margin-bottom: 1.5rem;
    }
    
    .alert-success {
        background-color: #d4edda;
        border-color: #c3e6cb;
        color: #155724;
    }
    
    .alert-warning {
        background-color: #fff3cd;
        border-color: #ffeeba;
        color: #856404;
    }
    
    .alert-danger {
        background-color: #f8d7da;
        border-color: #f5c6cb;
        color: #721c24;
    }
    
    .btn {
        padding: 0.6rem 1.5rem;
        border-radius: 5px;
        font-weight: 600;
        transition: var(--transition);
    }
    
    .btn-secondary {
        background-color: #6c757d;
        border-color: #6c757d;
    }
    
    .btn-secondary:hover {
        background-color: #5a6268;
        border-color: #545b62;
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
                        <h4 class="mb-0">Cek Status Pendaftaran</h4>
                    </div>
                    <div class="card-body">
                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        
                        <p class="mb-4">Masukkan nomor pendaftaran Anda untuk memeriksa status pendaftaran magang.</p>
                        
                        <form action="{{ route('status.check') }}" method="POST">
                            @csrf
                            <div class="form-group mb-4">
                                <label for="nomor_pendaftaran" class="form-label">Nomor Pendaftaran</label>
                                <input type="text" class="form-control @error('nomor_pendaftaran') is-invalid @enderror" 
                                     id="nomor_pendaftaran" name="nomor_pendaftaran" placeholder="Contoh: REG-2025-00123" required>
                                @error('nomor_pendaftaran')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Cek Status</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection