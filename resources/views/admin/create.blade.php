@extends('layouts.header_admin')

@section('title', 'Tambah Admin - Kementerian Sosial RI')

@section('additional_css')
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
    
    .admin-card {
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        transition: all 0.3s;
        border: none;
        overflow: hidden;
    }
    
    .admin-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1);
    }
    
    .admin-card .card-header {
        background: linear-gradient(135deg, var(--primary-color) 0%, #6a0000 100%);
        color: white;
        font-weight: 600;
        padding: 1.2rem 1.5rem;
        border-bottom: none;
        position: relative;
        overflow: hidden;
    }
    
    .admin-card .card-header::before {
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
    
    .admin-card .card-body {
        padding: 2rem;
        background-color: #ffffff;
    }
    
    .form-group {
        margin-bottom: 1.5rem;
    }
    
    .form-control {
        border-radius: 8px;
        padding: 0.75rem 1rem;
        border: 1px solid #ced4da;
        transition: all 0.3s;
    }
    
    .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.25rem rgba(139, 0, 0, 0.25);
    }
    
    .form-label {
        font-weight: 500;
        margin-bottom: 0.5rem;
        color: #495057;
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
        color: white;
    }
    
    .btn-primary::after {
        background-color: rgba(255, 255, 255, 0.2);
    }
    
    .btn-secondary {
        background: linear-gradient(135deg, #6c757d, #5a6268);
        color: white;
    }
    
    .btn-secondary::after {
        background-color: rgba(255, 255, 255, 0.2);
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
    
    .alert-danger {
        background-color: rgba(248, 215, 218, 0.8);
        border-color: var(--primary-color);
        color: #721c24;
    }
    
    /* Animation Classes */
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    @keyframes slideInLeft {
        from { transform: translateX(-50px); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    
    @keyframes slideInRight {
        from { transform: translateX(50px); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    
    @keyframes slideInUp {
        from { transform: translateY(50px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
    
    @keyframes bounceIn {
        0% { transform: scale(0.8); opacity: 0; }
        50% { transform: scale(1.05); opacity: 0.8; }
        100% { transform: scale(1); opacity: 1; }
    }
    
    .fade-in {
        animation: fadeIn 0.5s ease-in-out;
    }
    
    .slide-in-left {
        animation: slideInLeft 0.5s ease-in-out;
    }
    
    .slide-in-right {
        animation: slideInRight 0.5s ease-in-out;
    }
    
    .slide-in-up {
        animation: slideInUp 0.5s ease-in-out;
    }
    
    .bounce-in {
        animation: bounceIn 0.6s ease-in-out;
    }
    
    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .admin-card .card-body {
            padding: 1.5rem;
        }
        
        .col-form-label {
            text-align: left !important;
        }
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-4">
    <div class="dashboard-header fade-in">
        <h2 class="mt-4">Manajemen Admin</h2>
        <ol class="breadcrumb mb-4 slide-in-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Create</li>
        </ol>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="admin-card bounce-in">
                <div class="card-header">
                    <i class="fas fa-user-plus me-2"></i> Tambah Admin Baru
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success slide-in-up">
                            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger slide-in-up">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.store') }}" class="slide-in-up" style="animation-delay: 0.2s">
                        @csrf

                        <div class="form-group row mb-4">
                            <label for="nama_lengkap" class="col-md-4 col-form-label text-md-right">Nama Lengkap</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-user"></i></span>
                                    <input id="nama_lengkap" type="text" class="form-control @error('nama_lengkap') is-invalid @enderror" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required autocomplete="nama_lengkap" autofocus placeholder="Masukkan nama lengkap">
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label for="username" class="col-md-4 col-form-label text-md-right">Username</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-at"></i></span>
                                    <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" placeholder="Masukkan username">
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label for="role" class="col-md-4 col-form-label text-md-right">Pilih Direktorat</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-building"></i></span>
                                    <select id="role" name="role" class="form-control @error('role') is-invalid @enderror" required>
                                        <option value="" disabled selected>-- Pilih Direktorat --</option>
                                        <option value="admin">Semua Direktorat</option>
                                        <option value="admin1">Sekretariat Jenderal</option>
                                        <option value="admin2">Direktorat Jenderal Perlindungan dan Jaminan Sosial</option>
                                        <option value="admin3">Direktorat Jenderal Rehabilitasi Sosial</option>
                                        <option value="admin4">Direktorat Jenderal Pemberdayaan Sosial</option>
                                        <option value="admin5">Inspektorat Jenderal</option>
                                    </select>
                                </div>
                                @error('role')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label for="email" class="col-md-4 col-form-label text-md-right">Email</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-envelope"></i></span>
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Masukkan email">
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-lock"></i></span>
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Masukkan password">
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Konfirmasi Password</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-lock"></i></span>
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Konfirmasi password">
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4 d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i> Daftar
                                </button>
                                
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection