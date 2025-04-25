<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Pendaftaran Magang Kemensos RI</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
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
        
        @keyframes pulse {
            0% {
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(255, 215, 0, 0.7);
            }
            70% {
                transform: scale(1.05);
                box-shadow: 0 0 0 10px rgba(255, 215, 0, 0);
            }
            100% {
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(255, 215, 0, 0);
            }
        }
        
        @keyframes float {
            0% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-10px);
            }
            100% {
                transform: translateY(0px);
            }
        }
        
        @keyframes slideInLeft {
            from {
                transform: translateX(-50px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        @keyframes slideInRight {
            from {
                transform: translateX(50px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        @keyframes rotate {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(360deg);
            }
        }
        
        body {
            font-family:  'Calibri', sans-serif;
            overflow-x: hidden;
            color: var(--text-dark);
            background-image: linear-gradient(135deg, rgba(139, 0, 0, 0.9), rgba(80, 0, 0, 0.95)), url('images/bg1.png');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
            position: relative;
        }
        
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('images/pattern.png');
            opacity: 0.05;
            pointer-events: none;
        }
        
        .card {
            width: 100%;
            max-width: 600px;
            border-radius: 24px;
            padding: 2.8rem;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            background-color: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(15px);
            border: none;
            transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275), box-shadow 0.4s ease;
            margin: 20px auto;
            position: relative;
            overflow: hidden;
            animation: fadeIn 0.8s ease-out;
        }
        
        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 6px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
        }
        
        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.35);
        }
        
        .row {
            display: flex;
            justify-content: space-between;
        }
        
        .col-6 {
            width: 48%;
        }
        
        h3 {
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 0.5rem;
            font-size: 2.2rem;
            text-align: center;
            position: relative;
            display: inline-block;
            width: 100%;
        }
        
        h3::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
            border-radius: 3px;
        }
        
        .subtitle {
            color: #666;
            margin-bottom: 2.5rem;
            font-size: 1.1rem;
            text-align: center;
            animation: fadeIn 1s ease-out 0.3s both;
        }
        
        .progress-container {
            margin-bottom: 2.8rem;
            position: relative;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 10px;
        }
        
        .step {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            z-index: 2;
            transition: all 0.4s ease;
        }
        
        .circle {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #e9ecef;
            color: var(--text-dark);
            font-weight: bold;
            position: relative;
            z-index: 2;
            transition: all 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            border: 2px solid transparent;
            font-size: 1.2rem;
        }
        
        .circle.bg-primary {
            background-color: var(--secondary-color);
            color: var(--primary-color);
            border: 2px solid var(--primary-color);
            box-shadow: 0 0 0 5px rgba(255, 215, 0, 0.3);
            animation: pulse 2s infinite;
        }
        
        .step-label {
            margin-top: 12px;
            font-weight: 600;
            color: #666;
            transition: all 0.4s ease;
            opacity: 0.7;
        }
        
        .step.active .step-label {
            color: var(--primary-color);
            opacity: 1;
            transform: scale(1.1);
        }
        
        .line {
            height: 4px;
            background-color: #e9ecef;
            flex-grow: 1;
            position: relative;
            z-index: 1;
            transition: all 0.6s ease;
            margin: 0 5px;
        }
        
        .line.bg-primary {
            background: linear-gradient(90deg, var(--secondary-color), var(--primary-color));
            box-shadow: 0 0 10px rgba(255, 215, 0, 0.5);
        }
        
        .form-step {
            display: none;
            animation: fadeIn 0.6s ease;
        }
        
        .form-step.active {
            display: block;
        }
        
        .form-label {
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 0.6rem;
            display: block;
            transition: all 0.3s ease;
            transform-origin: left;
        }
        
        .input-group:focus-within .form-label {
            transform: scale(1.05);
            color: var(--primary-hover);
        }
        
        .form-control, .form-select {
            padding: 0.9rem 1rem 0.9rem 2.8rem;
            border-radius: 12px;
            border: 1px solid #ddd;
            background-color: #f8f9fa;
            transition: all 0.3s ease;
            margin-bottom: 5px;
            width: 100%;
            box-sizing: border-box;
            font-size: 1rem;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(139, 0, 0, 0.2);
            background-color: white;
            outline: none;
            transform: translateY(-2px);
        }
        
        .input-group {
            margin-bottom: 1.8rem;
            position: relative;
            transition: all 0.3s ease;
        }
        
        .input-group:hover {
            transform: translateX(5px);
        }
        
        .input-icon {
            position: absolute;
            top: 42px;
            left: 15px;
            color: var(--primary-color);
            z-index: 10;
            transition: all 0.3s ease;
        }
        
        .input-group:focus-within .input-icon {
            transform: scale(1.2);
            color: var(--primary-hover);
        }
        
        .btn {
            padding: 0.9rem 1.5rem;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            letter-spacing: 0.5px;
            text-transform: uppercase;
            font-size: 0.95rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            width: 100%;
            border: none;
            position: relative;
            overflow: hidden;
        }
        
        .btn::after {
            content: '';
            position: absolute;
            width: 0;
            height: 100%;
            top: 0;
            left: 0;
            background-color: rgba(255, 255, 255, 0.2);
            transition: width 0.3s ease;
        }
        
        .btn:hover::after {
            width: 100%;
        }
        
        .btn-primary {
            background: linear-gradient(45deg, var(--secondary-color), #FFE55C);
            color: var(--primary-color);
            box-shadow: 0 4px 15px rgba(255, 215, 0, 0.4);
        }
        
        .btn-primary:hover {
            background: linear-gradient(45deg, #FFE55C, var(--secondary-color));
            color: var(--primary-color);
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(255, 215, 0, 0.5);
        }
        
        .btn-secondary {
            background: linear-gradient(45deg, var(--primary-color), #c10000);
            color: var(--secondary-color);
            box-shadow: 0 4px 15px rgba(139, 0, 0, 0.4);
            margin-bottom: 12px;
        }
        
        .btn-secondary:hover {
            background: linear-gradient(45deg, #c10000, var(--primary-color));
            color: var(--secondary-color);
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(139, 0, 0, 0.5);
        }
        
        .btn-success {
            background: linear-gradient(45deg, #28a745, #20c997);
            color: white;
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.4);
        }
        
        .btn-success:hover {
            background: linear-gradient(45deg, #20c997, #28a745);
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(40, 167, 69, 0.5);
        }
        
        .is-invalid {
            border-color: #dc3545 !important;
            box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25) !important;
            animation: shake 0.5s cubic-bezier(.36,.07,.19,.97) both;
        }
        
        @keyframes shake {
            10%, 90% { transform: translateX(-1px); }
            20%, 80% { transform: translateX(2px); }
            30%, 50%, 70% { transform: translateX(-4px); }
            40%, 60% { transform: translateX(4px); }
        }
        
        .file-upload-wrapper {
            position: relative;
            margin-bottom: 1.8rem;
            transition: all 0.3s ease;
        }
        
        .file-upload-wrapper:hover {
            transform: translateX(5px);
        }
        
        .custom-file-upload {
            border: 2px dashed var(--primary-color);
            border-radius: 12px;
            padding: 1.8rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            background-color: rgba(139, 0, 0, 0.05);
            position: relative;
            overflow: hidden;
        }
        
        .custom-file-upload:hover {
            background-color: rgba(139, 0, 0, 0.1);
            transform: scale(1.02);
        }
        
        .custom-file-upload::before {
            content: '';
            position: absolute;
            top: -10px;
            left: -10px;
            right: -10px;
            bottom: -10px;
            background: linear-gradient(45deg, rgba(139, 0, 0, 0.1), rgba(255, 215, 0, 0.1), rgba(139, 0, 0, 0.1));
            background-size: 200% 200%;
            animation: gradientBG 3s ease infinite;
            z-index: -1;
            border-radius: 12px;
        }
        
        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        .upload-icon {
            font-size: 2.2rem;
            color: var(--primary-color);
            margin-bottom: 0.8rem;
            animation: float 3s ease-in-out infinite;
        }
        
        .file-upload-wrapper input[type="file"] {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }
        
        .form-feedback {
            font-size: 0.85rem;
            color: #dc3545;
            display: none;
            margin-top: 0.25rem;
            animation: fadeIn 0.3s ease;
            padding-left: 10px;
        }
        
        .is-invalid ~ .form-feedback {
            display: block;
        }
        
        .fixed-height-upload {
            min-height: 140px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .btn-icon i {
            margin-right: 10px;
            transition: all 0.3s ease;
        }
        
        .btn:hover .btn-icon i {
            transform: translateX(3px);
        }
        
        .d-grid {
            display: grid;
        }
        
        .gap-2 {
            gap: 0.8rem;
        }
        
        .mt-4 {
            margin-top: 2rem;
        }
        
        /* Animasi tambahan */
        .btn-primary i {
            animation: slideInRight 0.5s ease;
        }
        
        .btn-secondary i {
            animation: slideInLeft 0.5s ease;
        }
        
        .btn-success i {
            animation: rotate 2s linear infinite;
            animation-play-state: paused;
        }
        
        .btn-success:hover i {
            animation-play-state: running;
        }
        
        /* Responsif untuk layar kecil */
        @media (max-width: 576px) {
            .card {
                padding: 1.8rem;
            }
            
            .progress-container {
                margin-bottom: 1.8rem;
            }
            
            .circle {
                width: 50px;
                height: 50px;
                font-size: 1rem;
            }
            
            .step-label {
                font-size: 0.8rem;
            }
            
            h3 {
                font-size: 1.8rem;
            }
            
            .subtitle {
                font-size: 1rem;
            }
            
            .form-control, .form-select {
                padding: 0.8rem 1rem 0.8rem 2.5rem;
            }
        }
        
        /* Animasi loading */
        .loading {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            z-index: 9999;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }
        
        .loading-spinner {
            width: 60px;
            height: 60px;
            border: 5px solid var(--secondary-color);
            border-top: 5px solid var(--primary-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        
        .loading-text {
            color: white;
            margin-top: 20px;
            font-size: 1.2rem;
            font-weight: 600;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
@include('layouts.transisi')
    <div class="card">
        <h3>Pendaftaran Magang</h3>
        <p class="subtitle">Ayo daftarkan diri Anda menjadi peserta magang di Kemensos RI</p>
        
        <div class="progress-container">
            <div class="step active">
                <div class="circle bg-primary">1</div>
                <div class="step-label">Data Diri</div>
            </div>
            <div class="line" id="line-1"></div>
            <div class="step">
                <div class="circle">2</div>
                <div class="step-label">Akademik</div>
            </div>
            <div class="line" id="line-2"></div>
            <div class="step">
                <div class="circle">3</div>
                <div class="step-label">Penempatan</div>
            </div>
        </div>
        
        <!-- Form -->
        <form id="registrations" action="{{ route('pendaftaran.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="step" id="step" value="1">

            <!-- Step 1: Data Diri -->
            <div id="step-1" class="form-step active">
                <div class="input-group">
                    <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                    <i class="fas fa-user input-icon"></i>
                    <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" placeholder="Masukkan nama lengkap" required>
                    <div class="form-feedback">Nama lengkap wajib diisi</div>
                </div>
                
                <div class="input-group">
                    <label for="ttl" class="form-label">Tempat Lahir</label>
                    <i class="fas fa-map-marker-alt input-icon"></i>
                    <input type="text" class="form-control" id="ttl" name="ttl" placeholder="Contoh: Jakarta" required>
                    <div class="form-feedback">Tempat lahir wajib diisi</div>
                </div>


                <div class="input-group">
                    <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                    <i class="fas fa-calendar-alt input-icon"></i>
                    <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" required>
                    <div class="form-feedback">Tanggal lahir wajib diisi</div>
                </div>
                
                <div class="input-group">
                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                    <i class="fas fa-venus-mars input-icon"></i>
                    <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                        <option value="">Pilih jenis kelamin</option>
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                    <div class="form-feedback">Jenis kelamin wajib dipilih</div>
                </div>
                
                <div class="input-group">
                    <label for="no_hp" class="form-label">No Handphone</label>
                    <i class="fas fa-phone input-icon"></i>
                    <input type="text" class="form-control" id="no_hp" name="no_hp" placeholder="Contoh: 081234567890" required pattern="\d{10,15}" title="Masukkan nomor handphone yang valid (10-15 digit)">
                    <div class="form-feedback">Nomor handphone wajib diisi (10-15 digit)</div>
                </div>
                
                <div class="input-group">
                    <label for="email" class="form-label">Email</label>
                    <i class="fas fa-envelope input-icon"></i>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Contoh: nama@email.com" required>
                    <div class="form-feedback">Email wajib diisi dengan format yang benar</div>
                </div>
                
                <button type="button" class="btn btn-primary mt-4 btn-icon" id="next-to-step-2">
                    <i class="fas fa-arrow-right"></i> Selanjutnya
                </button>
            </div>

            <!-- Step 2: Akademik -->
            <div id="step-2" class="form-step">
                <div class="input-group">
                    <label for="asal_universitas" class="form-label">Asal Institusi Pendidikan</label>
                    <i class="fas fa-university input-icon"></i>
                    <input type="text" class="form-control" id="asal_universitas" name="asal_universitas" placeholder="Masukkan nama asal institusi pendidikan" required>
                    <div class="form-feedback">Asal Institusi Pendidikan</div>
                </div>
                
                <div class="input-group">
                    <label for="jurusan" class="form-label">Jurusan/Bidang Keilmuan</label>
                    <i class="fas fa-book input-icon"></i>
                    <input type="text" class="form-control" id="jurusan" name="jurusan" placeholder="Masukkan jurusan/bidang keilmuan" required>
                    <div class="form-feedback">Jurusan/Bidang Keilmuan wajib diisi</div>
                </div>
                
                <div class="input-group">
                    <label for="prodi" class="form-label">Program/Keahlian yang Diambil</label>
                    <i class="fas fa-graduation-cap input-icon"></i>
                    <input type="text" class="form-control" id="prodi" name="prodi" placeholder="Masukkan program/keahlian yang diambil" required>
                    <div class="form-feedback">Program/Keahlian yang diambil wajib diisi</div>
                </div>
                
                <div class="input-group">
                    <label for="semester" class="form-label">Semester</label>
                    <i class="fas fa-user-graduate input-icon"></i>
                    <input type="number" class="form-control" id="semester" name="semester" placeholder="Masukkan semester saat ini" required min="1" title="Semester minimal 1">
                    <div class="form-feedback">Semester wajib diisi (minimal 1)</div>
                </div>
                
                <div class="input-group">
                    <label for="ipk" class="form-label">IPK/Nilai Rata-Rata</label>
                    <i class="fas fa-award input-icon"></i>
                    <input type="number" step="0.01" class="form-control" id="ipk" name="ipk" placeholder="Contoh: 3.50/88.7" required min="0" max="100">
                    <div class="form-feedback">IPK/Nilai Rata-Rata wajib diisi</div>
                </div>
                
                <div class="file-upload-wrapper">
                    <label for="transkrip_nilai" class="form-label">Unggah Transkrip Nilai/Rata-Rata Raport</label>
                    <div class="custom-file-upload fixed-height-upload">
                        <i class="fas fa-file-pdf upload-icon"></i>
                        <p class="mb-0" id="transkrip-label">Klik atau seret file PDF/JPG/PNG</p>
                        <input type="file" class="form-control" id="transkrip_nilai" name="transkrip_nilai" accept=".pdf,.jpg,.png" required>
                    </div>
                    <div class="form-feedback">Transkrip Nilai/Rata-Rata Raport wajib diunggah</div>
                </div>
                
                <div class="file-upload-wrapper">
                    <label for="surat_pengantar" class="form-label">Unggah Surat Pengantar Institusi Pendidikan</label>
                    <div class="custom-file-upload fixed-height-upload">
                        <i class="fas fa-file-alt upload-icon"></i>
                        <p class="mb-0" id="surat-label">Klik atau seret file PDF/JPG/PNG</p>
                        <input type="file" class="form-control" id="surat_pengantar" name="surat_pengantar" accept=".pdf,.jpg,.png" required>
                    </div>
                    <div class="form-feedback">Surat pengantar wajib diunggah</div>
                </div>
                
                <div class="d-grid gap-2 mt-4">
                    <button type="button" class="btn btn-secondary btn-icon" id="back-to-step-1">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </button>
                    <button type="button" class="btn btn-primary btn-icon" id="next-to-step-3">
                        <i class="fas fa-arrow-right"></i> Selanjutnya
                    </button>
                </div>
            </div>

            <!-- Step 3: Penempatan -->
            <div id="step-3" class="form-step">
                <div class="mb-3">
                    <label class="form-label d-block">Periode Magang</label>
                    <div class="row g-0">
                        <div class="col-6">
                            <label for="tanggal_mulai" class="form-label small text-muted">Tanggal Mulai</label>
                            <input type="date" class="form-control rounded-0 rounded-start" id="tanggal_mulai" name="tanggal_mulai" required>
                        </div>
                        <div class="col-6">
                            <label for="tanggal_selesai" class="form-label small text-muted">Tanggal Selesai</label>
                            <input type="date" class="form-control rounded-0 rounded-end border-start-0" id="tanggal_selesai" name="tanggal_selesai" required>
                        </div>
                    </div>
                    <div class="form-feedback">Periode magang wajib diisi</div>
                </div>

                <div class="input-group">
                    <label for="direktorat" class="form-label">Direktorat</label>
                    <i class="fas fa-building input-icon"></i>
                    <select class="form-select" id="direktorat" name="direktorat" required>
                        <option value="">Pilih direktorat</option>
                        <option value="Sekretariat Jenderal">Sekretariat Jenderal</option>
                        <option value="Direktorat Jenderal Perlindungan dan Jaminan Sosial">Direktorat Jenderal Perlindungan dan Jaminan Sosial</option>
                        <option value="Direktorat Jenderal Rehabilitasi Sosial">Direktorat Jenderal Rehabilitasi Sosial</option>
                        <option value="Direktorat Jenderal Pemberdayaan Sosial">Direktorat Jenderal Pemberdayaan Sosial</option>
                        <option value="Inspektorat Jenderal">Inspektorat Jenderal</option>
                    </select>
                    <div class="form-feedback">Direktorat wajib dipilih</div>
                </div>
                
                <div class="input-group">
                    <label for="unit_kerja" class="form-label">Unit Kerja</label>
                    <i class="fas fa-briefcase input-icon"></i>
                    <select class="form-select" id="unit_kerja" name="unit_kerja" required>
                        <option value="">Pilih unit kerja</option>
                    </select>
                    <div class="form-feedback">Unit kerja wajib dipilih</div>
                </div>
                
                <div class="file-upload-wrapper">
                    <label for="cv" class="form-label">Unggah CV</label>
                    <div class="custom-file-upload fixed-height-upload">
                        <i class="fas fa-file-contract upload-icon"></i>
                        <p class="mb-0" id="cv-label">Klik atau seret file PDF/JPG/PNG</p>
                        <input type="file" class="form-control" id="cv" name="cv" accept=".pdf,.jpg,.png" required>
                    </div>
                    <div class="form-feedback">CV wajib diunggah</div>
                </div>

                <div class="file-upload-wrapper">
                    <label for="foto_profile" class="form-label">Unggah Photo</label>
                    <div class="custom-file-upload fixed-height-upload">
                        <i class="fas fa-file-contract upload-icon"></i>
                        <p class="mb-0" id="foto-label">Klik atau seret file JPG/PNG</p>
                        <input type="file" class="form-control" id="foto_profile" name="foto_profile" accept=".pdf,.jpg,.png" required>
                    </div>
                    <div class="form-feedback">Photo wajib formal</div>
                </div>
                
                <div class="d-grid gap-2 mt-4">
                    <button type="button" class="btn btn-secondary btn-icon" id="back-to-step-2">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </button>
                    <button type="button" class="btn btn-success btn-icon" id="submit-final">
                        <i class="fas fa-paper-plane"></i> Kirim Pendaftaran
                    </button>
                </div>
            </div>

    <!-- Loading Overlay -->
    <div class="loading" id="loading-overlay">
        <div class="loading-spinner"></div>
        <div class="loading-text">Sedang memproses pendaftaran...</div>
    </div>

    <script>
// Definisikan data unit kerja untuk setiap direktorat
const unitKerjaOptions = {
    "Sekretariat Jenderal": [
        "Biro Perencanaan",
        "Biro Keuangan",
        "Biro Organisasi dan Sumber Daya Manusia",
        "Biro Hukum",
        "Biro Umum",
        "Biro Hubungan Masyarakat",
        "Pusat Pendidikan, Pelatihan, dan Pengembangan Profesi Kesejahteraan Sosial",
        "Pusat Data dan Informasi Kesejahteraan Sosial"
    ],
    "Direktorat Jenderal Perlindungan dan Jaminan Sosial": [
        "Sekretariat Direktorat Jenderal",
        "Direktorat Jaminan Sosial",
        "Direktorat Perlindungan Sosial Non Kebencanaan",
        "Direktorat Perlindungan Sosial Korban Bencana"
    ],
    "Direktorat Jenderal Rehabilitasi Sosial": [
        "Sekretariat Direktorat Jenderal",
        "Direktorat Rehabilitasi Sosial Anak",
        "Direktorat Rehabilitasi Sosial Penyandang Disabilitas",
        "Direktorat Rehabilitasi Sosial Tuna Sosial dan Korban Perdagangan Orang",
        "Direktorat Rehabilitasi Sosial Korban Penyalahgunaan Napza, Psikotropika, Zat Adiktif Lainnya, dan ODHA (HIV)",
        "Direktorat Rehabilitasi Sosial Lanjut Usia"
    ],
    "Direktorat Jenderal Pemberdayaan Sosial": [
        "Sekretariat Direktorat Jenderal",
        "Direktorat Pemberdayaan Sosial Komunitas Adat Terpencil",
        "Direktorat Pemberdayaan Sosial Keluarga Miskin dan Rentan",
        "Direktorat Pemberdayaan Sosial Masyarakat",
        "Direktorat Pemberdayaan Potensi dan Sumber Daya Sosial"
    ],
    "Inspektorat Jenderal": [
        "Sekretariat Inspektorat Jenderal",
        "Inspektorat Bidang Investigasi",
        "Inspektorat Bidang Perlindungan dan Jaminan Sosial",
        "Inspektorat Bidang Rehabilitasi Sosial",
        "Inspektorat Bidang Pemberdayaan Sosial",
        "Inspektorat Bidang Penunjang"
    ]
};

// Tambahkan event listener untuk perubahan pada direktorat
document.getElementById('direktorat').addEventListener('change', function() {
    const selectedDirektorat = this.value;
    const unitKerjaSelect = document.getElementById('unit_kerja');
    
    // Reset pilihan unit kerja
    unitKerjaSelect.innerHTML = '<option value="">Pilih unit kerja</option>';
    
    // Jika direktorat dipilih, tambahkan opsi unit kerja yang sesuai
    if (selectedDirektorat && unitKerjaOptions[selectedDirektorat]) {
        // Tambahkan animasi fade out
        unitKerjaSelect.style.opacity = '0';
        
        setTimeout(() => {
            // Tambahkan opsi-opsi unit kerja
            unitKerjaOptions[selectedDirektorat].forEach(unit => {
                const option = document.createElement('option');
                option.value = unit;
                option.textContent = unit;
                unitKerjaSelect.appendChild(option);
            });
            
            // Tambahkan animasi fade in
            unitKerjaSelect.style.opacity = '1';
            unitKerjaSelect.style.transition = 'opacity 0.3s ease';
        }, 300);
    }
});


        // Fungsi untuk mengubah status progres dengan animasi
        function updateProgress(currentStep, nextStep) {
            // Ambil semua lingkaran step
            const circles = document.querySelectorAll('.circle');
            const steps = document.querySelectorAll('.step');
            
            // Animasi untuk menghapus class dari lingkaran sebelumnya
            setTimeout(() => {
                circles[currentStep-1].classList.remove('bg-primary');
                steps[currentStep-1].classList.remove('active');
            }, 200);
            
            // Animasi untuk menambahkan class ke lingkaran berikutnya
            setTimeout(() => {
                circles[nextStep-1].classList.add('bg-primary');
                steps[nextStep-1].classList.add('active');
            }, 400);
            
            // Perbarui warna garis antara lingkaran dengan animasi
            const lines = document.querySelectorAll('.line');
            
            if (nextStep > currentStep) {
                // Jika bergerak maju, warnai garis sebelumnya dengan animasi
                if (currentStep <= lines.length) {
                    setTimeout(() => {
                        lines[currentStep-1].classList.add('bg-primary');
                    }, 300);
                }
            } else {
                // Jika bergerak mundur, hapus warna garis dengan animasi
                if (currentStep-1 < lines.length) {
                    setTimeout(() => {
                        lines[currentStep-1].classList.remove('bg-primary');
                    }, 300);
                }
            }
        }

        // Fungsi untuk menampilkan langkah form dengan animasi
        function showStep(currentStep, nextStep) {
            // Sembunyikan langkah saat ini dengan animasi fade out
            const currentStepEl = document.getElementById(`step-${currentStep}`);
            currentStepEl.style.animation = 'fadeIn 0.3s ease reverse';
            
            setTimeout(() => {
                currentStepEl.classList.remove('active');
                
                // Tampilkan langkah berikutnya dengan animasi fade in
                const nextStepEl = document.getElementById(`step-${nextStep}`);
                nextStepEl.classList.add('active');
                nextStepEl.style.animation = 'fadeIn 0.5s ease';
                
                updateProgress(currentStep, nextStep);
                document.getElementById('step').value = nextStep;
            }, 300);
        }

        // Fungsi untuk validasi setiap langkah dengan animasi
        function validateStep(step) {
            const inputs = document.querySelectorAll(`#step-${step} input[required], #step-${step} select[required]`);
            let isValid = true;
            let firstInvalid = null;

            inputs.forEach(input => {
                if (!input.checkValidity()) {
                    isValid = false;
                    input.classList.add('is-invalid');
                    
                    // Simpan referensi ke input pertama yang tidak valid
                    if (!firstInvalid) {
                        firstInvalid = input;
                    }
                } else {
                    input.classList.remove('is-invalid');
                }
            });

            // Fokus ke input pertama yang tidak valid dengan animasi scroll
            if (firstInvalid) {
                setTimeout(() => {
                    firstInvalid.focus();
                    firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }, 100);
            }

            return isValid;
        }

        // Event listeners untuk navigasi langkah-langkah form dengan animasi
        document.getElementById('next-to-step-2').addEventListener('click', function () {
            if (validateStep(1)) {
                showStep(1, 2);
            }
        });

        document.getElementById('back-to-step-1').addEventListener('click', function () {
            showStep(2, 1);
        });

        document.getElementById('next-to-step-3').addEventListener('click', function () {
            if (validateStep(2)) {
                showStep(2, 3);
            }
        });

        document.getElementById('back-to-step-2').addEventListener('click', function () {
            showStep(3, 2);
        });
        
        // Event listener untuk pengiriman form dengan animasi loading
        document.getElementById('submit-final').addEventListener('click', function (e) {
            e.preventDefault();
            if (validateStep(3)) {
                // Tampilkan animasi loading
                document.getElementById('loading-overlay').style.display = 'flex';
                
                let form = document.getElementById('registrations');
                let formData = new FormData(form);
                formData.append('step', '3');

                // Simulasi delay untuk menampilkan animasi loading (opsional)
                setTimeout(() => {
                    fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                            'Accept': 'application/json'
                        },
                        credentials: 'same-origin'
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Sembunyikan animasi loading
                        document.getElementById('loading-overlay').style.display = 'none';
                        
                        if (data.success && data.redirect) {
                            // Animasi sukses sebelum redirect
                            const card = document.querySelector('.card');
                            card.style.animation = 'fadeIn 0.5s ease reverse';
                            
                            setTimeout(() => {
                                window.location.href = data.redirect;
                            }, 500);
                        } else {
                            alert('Terjadi kesalahan saat menyimpan data');
                        }
                    })
                    .catch(error => {
                        // Sembunyikan animasi loading
                        document.getElementById('loading-overlay').style.display = 'none';
                        
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat mengirim data');
                    });
                }, 1000); // Delay 1 detik untuk efek visual
            }
        });
        
        // Event listeners untuk menampilkan nama file yang diunggah dengan animasi
        document.getElementById('transkrip_nilai').addEventListener('change', function() {
            const fileName = this.files[0]?.name || "Klik atau seret file PDF/JPG/PNG";
            const label = document.getElementById('transkrip-label');
            
            // Animasi perubahan teks
            label.style.opacity = '0';
            setTimeout(() => {
                label.textContent = fileName;
                label.style.opacity = '1';
            }, 300);
            
            this.classList.remove('is-invalid');
        });
        
        document.getElementById('surat_pengantar').addEventListener('change', function() {
            const fileName = this.files[0]?.name || "Klik atau seret file PDF/JPG/PNG";
            const label = document.getElementById('surat-label');
            
            // Animasi perubahan teks
            label.style.opacity = '0';
            setTimeout(() => {
                label.textContent = fileName;
                label.style.opacity = '1';
            }, 300);
            
            this.classList.remove('is-invalid');
        });
        
        document.getElementById('cv').addEventListener('change', function() {
            const fileName = this.files[0]?.name || "Klik atau seret file PDF/JPG/PNG";
            const label = document.getElementById('cv-label');
            
            // Animasi perubahan teks
            label.style.opacity = '0';
            setTimeout(() => {
                label.textContent = fileName;
                label.style.opacity = '1';
            }, 300);
            
            this.classList.remove('is-invalid');
        });

        document.getElementById('foto_profile').addEventListener('change', function() {
            const fileName = this.files[0]?.name || "Klik atau seret file PDF/JPG/PNG";
            const label = document.getElementById('foto-label');
            
            // Animasi perubahan teks
            label.style.opacity = '0';
            setTimeout(() => {
                label.textContent = fileName;
                label.style.opacity = '1';
            }, 300);
            
            this.classList.remove('is-invalid');
        });
        
        // Hapus pesan kesalahan saat input berubah dengan animasi
        document.querySelectorAll('input, select').forEach(input => {
            input.addEventListener('input', function() {
                if (this.checkValidity()) {
                    // Animasi menghapus class is-invalid
                    this.classList.remove('is-invalid');
                }
            });
            
            // Tambahkan efek hover pada input
            input.addEventListener('mouseover', function() {
                if (!this.classList.contains('is-invalid')) {
                    this.style.transform = 'translateY(-2px)';
                    this.style.boxShadow = '0 5px 15px rgba(0,0,0,0.1)';
                }
            });
            
            input.addEventListener('mouseout', function() {
                if (!this.classList.contains('is-invalid') && !this.matches(':focus')) {
                    this.style.transform = '';
                    this.style.boxShadow = '';
                }
            });
        });
        
        // Animasi untuk card saat halaman dimuat
        window.addEventListener('load', function() {
            const card = document.querySelector('.card');
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
                card.style.transition = 'opacity 0.8s ease, transform 0.8s ease';
            }, 300);
        });
    </script>
</body>
</html>