<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rangkuman Pendaftaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
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
        background-image: linear-gradient(rgba(139, 0, 0, 0.85), rgba(139, 0, 0, 0.85)), url('{{ asset('images/bg1.png') }}');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        margin: 0;
        padding: 20px;
    }

    .card {
        border-radius: 15px;
        overflow: hidden;
        border: none;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3) !important;
    }

    .card-header {
        background-color: var(--primary-color);
        color: var(--text-light);
        text-align: center;
        padding: 25px 20px;
        border-bottom: 4px solid var(--secondary-color);
    }

    .registration-number {
        background-color: var(--secondary-color);
        color: var(--primary-color);
        font-weight: bold;
        padding: 8px 15px;
        border-radius: 30px;
        display: inline-block;
        margin-top: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .list-group {
        margin-top: 20px;
    }

    .list-group-item {
        display: flex;
        align-items: center;
        padding: 12px 20px;
        border-left: none;
        border-right: none;
        transition: var(--transition);
    }

    .list-group-item:hover {
        background-color: rgba(255, 215, 0, 0.1);
    }

    .list-group-item:first-child {
        border-top: none;
    }

    .label {
        min-width: 160px;
        font-weight: bold;
        text-align: left;
        position: relative;
        color: var(--primary-color);
    }

    .label::after {
        content: ":";
        position: absolute;
        right: 0;
    }

    .value {
        margin-left: 15px;
        flex: 1;
    }

    .icon {
        color: var(--primary-color);
        margin-right: 10px;
        width: 20px;
        text-align: center;
    }

    .btn-back {
        background-color: var(--secondary-color);
        color: var(--primary-color);
        font-weight: bold;
        padding: 12px;
        border-radius: 30px;
        transition: var(--transition);
        border: none;
        margin-top: 25px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .btn-back:hover {
        background-color: var(--primary-color);
        color: var(--secondary-color);
        transform: translateY(-3px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
    }

    .card-body {
        padding: 30px;
    }

    .title-icon {
        font-size: 2rem;
        color: var(--text-light);
        margin-bottom: 10px;
    }
</style>
<body>
@include('layouts.transisi')
    <div class="container">
        <div class="card shadow">
            <div class="card-header">
                <div class="title-icon">
                </div>
                <h2><strong>Rangkuman Pendaftaran</strong></h2>
                <div class="registration-number">
                <h2 class="text-center"><strong>Nomor Pendaftaran:</strong> {{ $pendaftaran->nomor_pendaftaran }}</h2>
                </div>
                <p class="text-light mt-3 mb-0">Berikut adalah informasi yang telah Anda daftarkan:</p>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    <li class="list-group-item d-flex">
                        <div class="icon"><i class="fas fa-key"></i></div>
                        <strong class="label">Password</strong> 
                        <span class="value">{{ session('temp_password') }}</span>
                    </li>
                    <li class="list-group-item d-flex">
                        <div class="icon"><i class="fas fa-user"></i></div>
                        <strong class="label">Nama Lengkap</strong> 
                        <span class="value">{{ $pendaftaran->nama_lengkap }}</span>
                    </li>
                    <li class="list-group-item d-flex">
                        <div class="icon"><i class="fas fa-envelope"></i></div>
                        <strong class="label">Email</strong> 
                        <span class="value">{{ $pendaftaran->email }}</span>
                    </li>
                    <li class="list-group-item d-flex">
                        <div class="icon"><i class="fas fa-university"></i></div>
                        <strong class="label">Asal Universitas</strong> 
                        <span class="value">{{ $pendaftaran->asal_universitas }}</span>
                    </li>
                    <li class="list-group-item d-flex">
                        <div class="icon"><i class="fas fa-book"></i></div>
                        <strong class="label">Jurusan</strong> 
                        <span class="value">{{ $pendaftaran->jurusan }}</span>
                    </li>
                    <li class="list-group-item d-flex">
                        <div class="icon"><i class="fas fa-graduation-cap"></i></div>
                        <strong class="label">Prodi</strong> 
                        <span class="value">{{ $pendaftaran->prodi }}</span>
                    </li>
                    <li class="list-group-item d-flex">
                        <div class="icon"><i class="fas fa-calendar-alt"></i></div>
                        <strong class="label">Semester</strong> 
                        <span class="value">{{ $pendaftaran->semester }}</span>
                    </li>
                    <li class="list-group-item d-flex">
                        <div class="icon"><i class="fas fa-building"></i></div>
                        <strong class="label">Direktorat</strong> 
                        <span class="value">{{ $pendaftaran->direktorat }}</span>
                    </li>
                    <li class="list-group-item d-flex">
                        <div class="icon"><i class="fas fa-briefcase"></i></div>
                        <strong class="label">Unit Kerja</strong> 
                        <span class="value">{{ $pendaftaran->unit_kerja }}</span>
                    </li>
                </ul>

                <a href="{{ route('home') }}" class="btn btn-back w-100">
                    <i class="fas fa-home me-2"></i> Kembali ke Dashboard
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>