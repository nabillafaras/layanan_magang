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
  --secondary-color: #ffd700;
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
  font-family: "Calibri", sans-serif;
  overflow-x: hidden;
  color: var(--text-dark);
  background-image: linear-gradient(135deg, rgba(139, 0, 0, 0.9), rgba(80, 0, 0, 0.95)), url("images/bg1.png");
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
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: url("images/pattern.png");
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
  overflow: hidden; /* Changed from hidden to visible */
  animation: fadeIn 0.8s ease-out;
  z-index: 1; /* Added base z-index */
}

.card::before {
  content: "";
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
  content: "";
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

.form-control,
.form-select {
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

.form-control:focus,
.form-select:focus {
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

/* Removed hover transform to prevent layout shifts */
.input-group:hover {
  /* transform: translateX(5px); - Removed this */
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
  content: "";
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
  background: linear-gradient(45deg, var(--secondary-color), #ffe55c);
  color: var(--primary-color);
  box-shadow: 0 4px 15px rgba(255, 215, 0, 0.4);
}

.btn-primary:hover {
  background: linear-gradient(45deg, #ffe55c, var(--secondary-color));
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
  animation: shake 0.5s cubic-bezier(0.36, 0.07, 0.19, 0.97) both;
}

@keyframes shake {
  10%,
  90% {
    transform: translateX(-1px);
  }
  20%,
  80% {
    transform: translateX(2px);
  }
  30%,
  50%,
  70% {
    transform: translateX(-4px);
  }
  40%,
  60% {
    transform: translateX(4px);
  }
}

.file-upload-wrapper {
  position: relative;
  margin-bottom: 1.8rem;
  transition: all 0.3s ease;
}

/* Removed hover transform to prevent layout shifts */
.file-upload-wrapper:hover {
  /* transform: translateX(5px); - Removed this */
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
  content: "";
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
  0% {
    background-position: 0% 50%;
  }
  50% {
    background-position: 100% 50%;
  }
  100% {
    background-position: 0% 50%;
  }
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

/* FIXED CITY DROPDOWN STYLES */
.city-dropdown-container {
  position: relative;
  width: 100%;
  margin-bottom: 30px; /* Increased margin to prevent overlap */
  z-index: 100; /* Added z-index for proper stacking */
}

.city-search-container {
  position: relative;
  width: 100%;
}

.city-search-input {
  width: 100%;
  padding: 12px 40px 12px 45px;
  border: 2px solid #e0e0e0;
  border-radius: 8px;
  font-size: 14px;
  background-color: #fff;
  transition: all 0.3s ease;
  cursor: pointer;
  box-sizing: border-box;
}

.city-search-input:focus {
  outline: none;
  border-color: var(--primary-color);
  box-shadow: 0 0 0 3px rgba(139, 0, 0, 0.1);
}

.city-search-input.is-invalid {
  border-color: #dc3545;
  box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.1);
}

.dropdown-arrow {
  position: absolute;
  right: 15px;
  top: 50%;
  transform: translateY(-50%);
  color: #666;
  font-size: 12px;
  transition: transform 0.3s ease;
  cursor: pointer;
  pointer-events: none;
}

.city-dropdown {
  position: absolute;
  top: calc(100% + 5px); /* Increased gap from input */
  left: 0;
  right: 0;
  background: white;
  border: 2px solid var(--primary-color);
  border-radius: 12px;
  box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
  z-index: 10000; /* Very high z-index */
  max-height: 280px;
  overflow: hidden;
  display: none;
  width: 100%;
  box-sizing: border-box;
  backdrop-filter: blur(10px);
}

.city-dropdown.show {
  display: block;
  animation: fadeIn 0.3s ease;
}

.city-search-box {
  padding: 12px;
  border-bottom: 2px solid #f0f0f0;
  background: #f8f9fa;
  position: sticky;
  top: 0;
  z-index: 10001;
}

.city-search-box .city-search-input {
  padding: 10px 15px;
  border: 1px solid #ddd;
  border-radius: 6px;
  font-size: 13px;
  cursor: text;
  width: 100%;
  box-sizing: border-box;
}

.cities-list {
  max-height: 220px;
  overflow-y: auto;
  background: white;
}

.city-option {
  padding: 15px 18px;
  cursor: pointer;
  border-bottom: 1px solid #f5f5f5;
  transition: all 0.2s ease;
  display: block;
  width: 100%;
  box-sizing: border-box;
  /* Removed z-index changes that caused issues */
}

.city-option:hover {
  background-color: rgba(139, 0, 0, 0.05);
  border-left: 4px solid var(--primary-color);
  padding-left: 14px; /* Adjust padding to account for border */
}

.city-option:last-child {
  border-bottom: none;
}

.city-option.other-option {
  background-color: #f8f9fa;
  border-top: 2px solid #e0e0e0;
  font-style: italic;
  font-weight: 600;
  color: var(--primary-color);
}

.city-option.other-option:hover {
  background-color: rgba(139, 0, 0, 0.1);
}

.city-name {
  font-weight: 600;
  color: #333;
  margin-bottom: 3px;
  line-height: 1.4;
}

.city-province {
  font-size: 12px;
  color: #666;
  line-height: 1.3;
}

.manual-input-container {
  margin-top: 15px;
  display: none;
}

.manual-input {
  width: 100%;
  padding: 12px 15px;
  border: 2px solid #e0e0e0;
  border-radius: 8px;
  font-size: 14px;
  background-color: #fff;
  transition: all 0.3s ease;
  box-sizing: border-box;
}

.manual-input:focus {
  outline: none;
  border-color: var(--primary-color);
  box-shadow: 0 0 0 3px rgba(139, 0, 0, 0.1);
}

.loading-cities {
  padding: 25px;
  text-align: center;
  color: #666;
  font-weight: 500;
}

.loading-cities i {
  margin-right: 10px;
  animation: rotate 1s linear infinite;
}

/* Improved scrollbar styling */
.city-dropdown::-webkit-scrollbar,
.cities-list::-webkit-scrollbar {
  width: 8px;
}

.city-dropdown::-webkit-scrollbar-track,
.cities-list::-webkit-scrollbar-track {
  background: #f1f1f1;
  border-radius: 4px;
}

.city-dropdown::-webkit-scrollbar-thumb,
.cities-list::-webkit-scrollbar-thumb {
  background: var(--primary-color);
  border-radius: 4px;
  opacity: 0.7;
}

.city-dropdown::-webkit-scrollbar-thumb:hover,
.cities-list::-webkit-scrollbar-thumb:hover {
  background: var(--primary-hover);
  opacity: 1;
}

/* Ensure proper containment */
.city-dropdown-container * {
  box-sizing: border-box;
}

/* Loading animation */
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
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}

/* Responsive design improvements */
@media (max-width: 576px) {
  .card {
    padding: 1.8rem;
    overflow: visible; /* Ensure dropdown is visible on mobile */
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

  .form-control,
  .form-select {
    padding: 0.8rem 1rem 0.8rem 2.5rem;
  }

  .city-dropdown-container {
    margin-bottom: 35px;
  }

  .city-dropdown {
    max-height: 250px;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
  }

  .cities-list {
    max-height: 180px;
  }

  .city-option {
    padding: 12px 15px;
  }

  .city-name {
    font-size: 14px;
  }

  .city-province {
    font-size: 11px;
  }
}

/* Extra small screens */
@media (max-width: 480px) {
  .city-dropdown {
    /* Keep normal positioning instead of fixed */
    position: absolute;
    max-height: 200px;
  }

  .city-dropdown-container {
    margin-bottom: 40px;
  }

  .cities-list {
    max-height: 150px;
  }
}

/* Prevent body scroll when dropdown is open on mobile */
@media (max-width: 768px) {
  body.dropdown-open {
    overflow: hidden;
  }
}


/* Tambahan untuk mengatasi masalah overlap pada mobile */
@media (max-width: 480px) {
    .city-dropdown {
        position: fixed;
        top: auto;
        left: 10px;
        right: 10px;
        width: auto;
        max-height: 60vh;
    }
    
    .city-dropdown-container {
        margin-bottom: 25px;
    }
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
                    
                    <div class="city-dropdown-container">
                        <div class="city-search-container">
                            <input type="text" 
                                class="form-control city-search-input" 
                                id="ttl_display" 
                                placeholder="Pilih atau cari kota tempat lahir..." 
                                readonly>
                            <i class="fas fa-chevron-down dropdown-arrow"></i>
                            <div class="city-dropdown" id="cityDropdown">
                                <div class="loading-cities" id="loadingCities">
                                    <i class="fas fa-spinner fa-spin"></i> Memuat data kota...
                                </div>
                            </div>
                        </div>
                        
                        <div class="manual-input-container" id="manualInputContainer">
                            <input type="text" 
                                class="manual-input" 
                                id="ttl_manual" 
                                placeholder="Masukkan tempat lahir lainnya...">
                        </div>
                    </div>
                    
                    <!-- Input tersembunyi untuk form submission -->
                    <input type="hidden" id="ttl" name="ttl" required>
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

            <!-- Step 2: Akademik (Diperbaiki) -->
            <div id="step-2" class="form-step">
                <!-- Pilihan Kategori Pendidikan -->
                <div class="input-group">
                    <label for="kategori_pendidikan" class="form-label">Kategori Pendidikan</label>
                    <i class="fas fa-graduation-cap input-icon"></i>
                    <select class="form-select" id="kategori_pendidikan" name="kategori_pendidikan" required>
                        <option value="">Pilih kategori pendidikan</option>
                        <option value="mahasiswa">Mahasiswa (Perguruan Tinggi)</option>
                        <option value="siswa">Siswa (SMA/SMK/Sederajat)</option>
                    </select>
                    <div class="form-feedback">Kategori pendidikan wajib dipilih</div>
                </div>

                <!-- Form untuk Mahasiswa (default/existing form) -->
                <div id="form-mahasiswa" class="kategori-form" style="display: none;">
                    <div class="input-group">
                        <label for="asal_universitas" class="form-label">Asal Institusi Pendidikan (Perguruan Tinggi)</label>
                        <i class="fas fa-university input-icon"></i>
                        <input type="text" class="form-control" id="asal_universitas" name="asal_universitas" placeholder="Masukkan nama perguruan tinggi" data-required-for="mahasiswa">
                        <div class="form-feedback">Asal Perguruan Tinggi wajib diisi</div>
                    </div>
                    
                    <div class="input-group">
                        <label for="jurusan" class="form-label">Fakultas/Jurusan</label>
                        <i class="fas fa-book input-icon"></i>
                        <input type="text" class="form-control" id="jurusan" name="jurusan" placeholder="Masukkan fakultas/jurusan" data-required-for="mahasiswa">
                        <div class="form-feedback">Fakultas/Jurusan wajib diisi</div>
                    </div>
                    
                    <div class="input-group">
                        <label for="prodi" class="form-label">Program Studi</label>
                        <i class="fas fa-graduation-cap input-icon"></i>
                        <input type="text" class="form-control" id="prodi" name="prodi" placeholder="Masukkan program studi" data-required-for="mahasiswa">
                        <div class="form-feedback">Program studi wajib diisi</div>
                    </div>
                    
                    <div class="input-group">
                        <label for="semester" class="form-label">Semester</label>
                        <i class="fas fa-user-graduate input-icon"></i>
                        <input type="number" class="form-control" id="semester" name="semester" placeholder="Masukkan semester saat ini" data-required-for="mahasiswa" min="1" title="Semester minimal 1">
                        <div class="form-feedback">Semester wajib diisi (minimal 1)</div>
                    </div>
                    
                    <div class="input-group">
                        <label for="ipk" class="form-label">IPK (Indeks Prestasi Kumulatif)</label>
                        <i class="fas fa-award input-icon"></i>
                        <input type="number" step="0.01" class="form-control" id="ipk" name="ipk" placeholder="Contoh: 3.50" data-required-for="mahasiswa" min="0" max="4">
                        <div class="form-feedback">IPK wajib diisi (0.00 - 4.00)</div>
                    </div>
                    
                    <div class="file-upload-wrapper">
                        <label for="transkrip_nilai" class="form-label">Unggah Transkrip Nilai</label>
                        <div class="custom-file-upload fixed-height-upload">
                            <i class="fas fa-file-pdf upload-icon"></i>
                            <p class="mb-0" id="transkrip-label">Klik atau seret file PDF/JPG/PNG</p>
                            <input type="file" class="form-control" id="transkrip_nilai" name="transkrip_nilai" accept=".pdf,.jpg,.png" data-required-for="mahasiswa">
                        </div>
                        <div class="form-feedback">Transkrip Nilai wajib diunggah</div>
                    </div>
                    
                    <div class="file-upload-wrapper">
                        <label for="surat_pengantar" class="form-label">Unggah Surat Pengantar Perguruan Tinggi</label>
                        <div class="custom-file-upload fixed-height-upload">
                            <i class="fas fa-file-alt upload-icon"></i>
                            <p class="mb-0" id="surat-label">Klik atau seret file PDF/JPG/PNG</p>
                            <input type="file" class="form-control" id="surat_pengantar" name="surat_pengantar" accept=".pdf,.jpg,.png" data-required-for="mahasiswa">
                        </div>
                        <div class="form-feedback">Surat pengantar wajib diunggah</div>
                    </div>
                </div>

                <!-- Form untuk Siswa (form baru) -->
                <div id="form-siswa" class="kategori-form" style="display: none;">
                    <div class="input-group">
                        <label for="asal_sekolah" class="form-label">Asal Institusi Pendidikan (Sekolah)</label>
                        <i class="fas fa-school input-icon"></i>
                        <input type="text" class="form-control" id="asal_sekolah" name="asal_sekolah" placeholder="Masukkan nama sekolah (SMA/SMK/Sederajat)" data-required-for="siswa">
                        <div class="form-feedback">Asal Sekolah wajib diisi</div>
                    </div>
                    
                    <div class="input-group">
                        <label for="jurusan_sekolah" class="form-label">Jurusan</label>
                        <i class="fas fa-book input-icon"></i>
                        <input type="text" class="form-control" id="jurusan_sekolah" name="jurusan_sekolah" placeholder="Masukkan jurusan (IPA/IPS/Teknik/dll)" data-required-for="siswa">
                        <div class="form-feedback">Jurusan wajib diisi</div>
                    </div>
                    
                    <div class="input-group">
                        <label for="program_keahlian" class="form-label">Program/Keahlian yang Diambil</label>
                        <i class="fas fa-tools input-icon"></i>
                        <input type="text" class="form-control" id="program_keahlian" name="program_keahlian" placeholder="Masukkan program/keahlian yang diambil" data-required-for="siswa">
                        <div class="form-feedback">Program/Keahlian wajib diisi</div>
                    </div>
                    
                    <div class="input-group">
                        <label for="kelas" class="form-label">Kelas</label>
                        <i class="fas fa-chalkboard input-icon"></i>
                        <select class="form-select" id="kelas" name="kelas" data-required-for="siswa">
                            <option value="">Pilih kelas</option>
                            <option value="10">Kelas 10</option>
                            <option value="11">Kelas 11</option>
                            <option value="12">Kelas 12</option>
                        </select>
                        <div class="form-feedback">Kelas wajib dipilih</div>
                    </div>
                    
                    <div class="input-group">
                        <label for="nilai_rata_rata" class="form-label">Nilai Rata-Rata</label>
                        <i class="fas fa-award input-icon"></i>
                        <input type="number" step="0.1" class="form-control" id="nilai_rata_rata" name="nilai_rata_rata" placeholder="Contoh: 85.5" data-required-for="siswa" min="0" max="100">
                        <div class="form-feedback">Nilai rata-rata wajib diisi (0 - 100)</div>
                    </div>
                    
                    <div class="file-upload-wrapper">
                        <label for="raport" class="form-label">Unggah Raport</label>
                        <div class="custom-file-upload fixed-height-upload">
                            <i class="fas fa-file-pdf upload-icon"></i>
                            <p class="mb-0" id="raport-label">Klik atau seret file PDF/JPG/PNG</p>
                            <input type="file" class="form-control" id="raport" name="raport" accept=".pdf,.jpg,.png" data-required-for="siswa">
                        </div>
                        <div class="form-feedback">Raport wajib diunggah</div>
                    </div>
                    
                    <div class="file-upload-wrapper">
                        <label for="surat_pengantar_sekolah" class="form-label">Unggah Surat Pengantar Sekolah</label>
                        <div class="custom-file-upload fixed-height-upload">
                            <i class="fas fa-file-alt upload-icon"></i>
                            <p class="mb-0" id="surat-sekolah-label">Klik atau seret file PDF/JPG/PNG</p>
                            <input type="file" class="form-control" id="surat_pengantar_sekolah" name="surat_pengantar_sekolah" accept=".pdf,.jpg,.png" data-required-for="siswa">
                        </div>
                        <div class="form-feedback">Surat pengantar sekolah wajib diunggah</div>
                    </div>
                    
                    <!-- Hidden inputs untuk mapping data siswa ke database -->
                    <input type="hidden" id="hidden_asal_universitas" name="asal_universitas_hidden">
                    <input type="hidden" id="hidden_jurusan" name="jurusan_hidden">
                    <input type="hidden" id="hidden_prodi" name="prodi_hidden">
                    <input type="hidden" id="hidden_semester" name="semester_hidden">
                    <input type="hidden" id="hidden_ipk" name="ipk_hidden">
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
        // Fungsi untuk dropdown kota - menambahkan ke kode JavaScript yang sudah ada
// Jangan hapus kode JavaScript yang sudah ada sebelumnya

// Data kota Indonesia yang akan diambil dari API
let citiesData = [];
let isLoadingCities = false;

// Data kota Indonesia statis sebagai fallback
const fallbackCitiesData = [
    { name: "Jakarta Pusat", province: "DKI Jakarta" },
    { name: "Jakarta Utara", province: "DKI Jakarta" },
    { name: "Jakarta Barat", province: "DKI Jakarta" },
    { name: "Jakarta Selatan", province: "DKI Jakarta" },
    { name: "Jakarta Timur", province: "DKI Jakarta" },
    { name: "Kepulauan Seribu", province: "DKI Jakarta" },
    { name: "Bandung", province: "Jawa Barat" },
    { name: "Bekasi", province: "Jawa Barat" },
    { name: "Bogor", province: "Jawa Barat" },
    { name: "Cirebon", province: "Jawa Barat" },
    { name: "Depok", province: "Jawa Barat" },
    { name: "Sukabumi", province: "Jawa Barat" },
    { name: "Tasikmalaya", province: "Jawa Barat" },
    { name: "Banjar", province: "Jawa Barat" },
    { name: "Surabaya", province: "Jawa Timur" },
    { name: "Malang", province: "Jawa Timur" },
    { name: "Kediri", province: "Jawa Timur" },
    { name: "Madiun", province: "Jawa Timur" },
    { name: "Mojokerto", province: "Jawa Timur" },
    { name: "Pasuruan", province: "Jawa Timur" },
    { name: "Probolinggo", province: "Jawa Timur" },
    { name: "Blitar", province: "Jawa Timur" },
    { name: "Semarang", province: "Jawa Tengah" },
    { name: "Solo", province: "Jawa Tengah" },
    { name: "Salatiga", province: "Jawa Tengah" },
    { name: "Pekalongan", province: "Jawa Tengah" },
    { name: "Tegal", province: "Jawa Tengah" },
    { name: "Magelang", province: "Jawa Tengah" },
    { name: "Yogyakarta", province: "DI Yogyakarta" },
    { name: "Serang", province: "Banten" },
    { name: "Tangerang", province: "Banten" },
    { name: "Tangerang Selatan", province: "Banten" },
    { name: "Cilegon", province: "Banten" },
    { name: "Medan", province: "Sumatera Utara" },
    { name: "Binjai", province: "Sumatera Utara" },
    { name: "Pematangsiantar", province: "Sumatera Utara" },
    { name: "Tebing Tinggi", province: "Sumatera Utara" },
    { name: "Padang", province: "Sumatera Barat" },
    { name: "Bukittinggi", province: "Sumatera Barat" },
    { name: "Padang Panjang", province: "Sumatera Barat" },
    { name: "Pariaman", province: "Sumatera Barat" },
    { name: "Payakumbuh", province: "Sumatera Barat" },
    { name: "Sawahlunto", province: "Sumatera Barat" },
    { name: "Solok", province: "Sumatera Barat" },
    { name: "Pekanbaru", province: "Riau" },
    { name: "Dumai", province: "Riau" },
    { name: "Jambi", province: "Jambi" },
    { name: "Sungai Penuh", province: "Jambi" },
    { name: "Palembang", province: "Sumatera Selatan" },
    { name: "Prabumulih", province: "Sumatera Selatan" },
    { name: "Pagar Alam", province: "Sumatera Selatan" },
    { name: "Lubuklinggau", province: "Sumatera Selatan" },
    { name: "Bengkulu", province: "Bengkulu" },
    { name: "Bandar Lampung", province: "Lampung" },
    { name: "Metro", province: "Lampung" },
    { name: "Pangkal Pinang", province: "Kepulauan Bangka Belitung" },
    { name: "Batam", province: "Kepulauan Riau" },
    { name: "Tanjung Pinang", province: "Kepulauan Riau" },
    { name: "Banda Aceh", province: "Aceh" },
    { name: "Langsa", province: "Aceh" },
    { name: "Lhokseumawe", province: "Aceh" },
    { name: "Sabang", province: "Aceh" },
    { name: "Subulussalam", province: "Aceh" },
    { name: "Denpasar", province: "Bali" },
    { name: "Mataram", province: "Nusa Tenggara Barat" },
    { name: "Bima", province: "Nusa Tenggara Barat" },
    { name: "Kupang", province: "Nusa Tenggara Timur" },
    { name: "Pontianak", province: "Kalimantan Barat" },
    { name: "Singkawang", province: "Kalimantan Barat" },
    { name: "Palangka Raya", province: "Kalimantan Tengah" },
    { name: "Banjarmasin", province: "Kalimantan Selatan" },
    { name: "Banjarbaru", province: "Kalimantan Selatan" },
    { name: "Samarinda", province: "Kalimantan Timur" },
    { name: "Balikpapan", province: "Kalimantan Timur" },
    { name: "Bontang", province: "Kalimantan Timur" },
    { name: "Tarakan", province: "Kalimantan Utara" },
    { name: "Manado", province: "Sulawesi Utara" },
    { name: "Bitung", province: "Sulawesi Utara" },
    { name: "Tomohon", province: "Sulawesi Utara" },
    { name: "Kotamobagu", province: "Sulawesi Utara" },
    { name: "Palu", province: "Sulawesi Tengah" },
    { name: "Makassar", province: "Sulawesi Selatan" },
    { name: "Palopo", province: "Sulawesi Selatan" },
    { name: "Parepare", province: "Sulawesi Selatan" },
    { name: "Kendari", province: "Sulawesi Tenggara" },
    { name: "Bau-Bau", province: "Sulawesi Tenggara" },
    { name: "Gorontalo", province: "Gorontalo" },
    { name: "Mamuju", province: "Sulawesi Barat" },
    { name: "Ambon", province: "Maluku" },
    { name: "Tual", province: "Maluku" },
    { name: "Ternate", province: "Maluku Utara" },
    { name: "Tidore Kepulauan", province: "Maluku Utara" },
    { name: "Jayapura", province: "Papua" },
    { name: "Sorong", province: "Papua Barat" },
    { name: "Manokwari", province: "Papua Barat" }
];

// Fungsi untuk memuat data kota dari API dengan fallback
async function loadCitiesData() {
    if (isLoadingCities) return;
    
    isLoadingCities = true;
    const loadingElement = document.getElementById('loadingCities');
    
    try {
        // Tampilkan loading
        loadingElement.style.display = 'block';
        loadingElement.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memuat data kota...';
        
        // Coba metode pertama: API emsifa dengan timeout
        try {
            const controller = new AbortController();
            const timeoutId = setTimeout(() => controller.abort(), 5000); // 5 detik timeout
            
            const response = await fetch('https://emsifa.github.io/api-wilayah-indonesia/api/regencies.json', {
                signal: controller.signal
            });
            
            clearTimeout(timeoutId);
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const regencies = await response.json();
            
            // Proses data dari API
            const allCities = regencies.map(regency => {
                let cleanName = regency.name
                    .replace(/^KABUPATEN\s+/, '')
                    .replace(/^KOTA\s+/, '')
                    .toLowerCase()
                    .split(' ')
                    .map(word => word.charAt(0).toUpperCase() + word.slice(1))
                    .join(' ');
                
                return {
                    id: regency.id,
                    name: cleanName,
                    province: regency.province_id || "Unknown",
                    fullName: regency.name
                };
            });
            
            citiesData = allCities.sort((a, b) => a.name.localeCompare(b.name));
            
        } catch (apiError) {
            console.warn('Primary API failed, using fallback data:', apiError);
            
            // Fallback ke data statis
            citiesData = fallbackCitiesData.sort((a, b) => a.name.localeCompare(b.name));
        }
        
        // Sembunyikan loading
        loadingElement.style.display = 'none';
        
        // Tampilkan dropdown dengan data kota
        renderCityDropdown();
        
    } catch (error) {
        console.error('Error loading cities data:', error);
        
        // Jika semua gagal, gunakan data fallback
        citiesData = fallbackCitiesData.sort((a, b) => a.name.localeCompare(b.name));
        loadingElement.style.display = 'none';
        renderCityDropdown();
    } finally {
        isLoadingCities = false;
    }
}

// Fungsi untuk merender dropdown kota
function renderCityDropdown() {
    const dropdownElement = document.getElementById('cityDropdown');
    
    if (!dropdownElement) {
        console.warn('Dropdown element not found');
        return;
    }
    
    // Bersihkan dropdown
    dropdownElement.innerHTML = '';
    
    // Tambahkan opsi pencarian
    const searchContainer = document.createElement('div');
    searchContainer.className = 'city-search-box';
    searchContainer.innerHTML = `
        <input type="text" 
               class="city-search-input" 
               placeholder="Cari kota..." 
               id="citySearchInput">
    `;
    dropdownElement.appendChild(searchContainer);
    
    // Container untuk daftar kota
    const citiesContainer = document.createElement('div');
    citiesContainer.className = 'cities-list';
    citiesContainer.id = 'citiesList';
    
    // Tampilkan kota (batasi untuk performa)
    const citiesToShow = citiesData.slice(0, 50);
    
    citiesToShow.forEach(city => {
        const cityOption = document.createElement('div');
        cityOption.className = 'city-option';
        cityOption.innerHTML = `
            <div class="city-name">${city.name}</div>
            <div class="city-province">${city.province}</div>
        `;
        cityOption.addEventListener('click', () => selectCity(city));
        citiesContainer.appendChild(cityOption);
    });
    
    // Tambahkan opsi "Lainnya"
    const otherOption = document.createElement('div');
    otherOption.className = 'city-option other-option';
    otherOption.innerHTML = `
        <div class="city-name">Lainnya</div>
        <div class="city-province">Masukkan tempat lahir lainnya</div>
    `;
    otherOption.addEventListener('click', () => selectOther());
    citiesContainer.appendChild(otherOption);
    
    dropdownElement.appendChild(citiesContainer);
    
    // Event listener untuk pencarian
    const searchInput = document.getElementById('citySearchInput');
    if (searchInput) {
        searchInput.addEventListener('input', (e) => {
            filterCities(e.target.value);
        });
    }
}

// Fungsi untuk memfilter kota berdasarkan pencarian
function filterCities(searchTerm) {
    const citiesContainer = document.getElementById('citiesList');
    const filteredCities = citiesData.filter(city => 
        city.name.toLowerCase().includes(searchTerm.toLowerCase()) ||
        city.province.toLowerCase().includes(searchTerm.toLowerCase())
    );
    
    // Bersihkan container
    citiesContainer.innerHTML = '';
    
    // Tampilkan hasil pencarian (maksimal 50 untuk performa)
    const citiesToShow = filteredCities.slice(0, 50);
    
    citiesToShow.forEach(city => {
        const cityOption = document.createElement('div');
        cityOption.className = 'city-option';
        cityOption.innerHTML = `
            <div class="city-name">${city.name}</div>
            <div class="city-province">${city.province}</div>
        `;
        cityOption.addEventListener('click', () => selectCity(city));
        citiesContainer.appendChild(cityOption);
    });
    
    // Tambahkan opsi "Lainnya"
    const otherOption = document.createElement('div');
    otherOption.className = 'city-option other-option';
    otherOption.innerHTML = `
        <div class="city-name">Lainnya</div>
        <div class="city-province">Masukkan tempat lahir lainnya</div>
    `;
    otherOption.addEventListener('click', () => selectOther());
    citiesContainer.appendChild(otherOption);
}

// Fungsi untuk memilih kota
function selectCity(city) {
    const displayInput = document.getElementById('ttl_display');
    const hiddenInput = document.getElementById('ttl');
    const manualContainer = document.getElementById('manualInputContainer');
    const dropdown = document.getElementById('cityDropdown');
    
    // Set nilai
    displayInput.value = city.name;
    hiddenInput.value = city.name;
    
    // Sembunyikan input manual dan dropdown
    manualContainer.style.display = 'none';
    dropdown.style.display = 'none';
    
    // Hapus class invalid jika ada
    displayInput.classList.remove('is-invalid');
    hiddenInput.classList.remove('is-invalid');
}

// Fungsi untuk memilih "Lainnya"
function selectOther() {
    const displayInput = document.getElementById('ttl_display');
    const manualContainer = document.getElementById('manualInputContainer');
    const manualInput = document.getElementById('ttl_manual');
    const dropdown = document.getElementById('cityDropdown');
    
    // Set display input
    displayInput.value = 'Lainnya';
    
    // Tampilkan input manual
    manualContainer.style.display = 'block';
    dropdown.style.display = 'none';
    
    // Focus ke input manual
    manualInput.focus();
}

// Event listener untuk dropdown kota
document.addEventListener('DOMContentLoaded', function() {
    const displayInput = document.getElementById('ttl_display');
    const dropdown = document.getElementById('cityDropdown');
    const manualInput = document.getElementById('ttl_manual');
    const hiddenInput = document.getElementById('ttl');
    const dropdownArrow = document.querySelector('.dropdown-arrow');
    
    // Cek apakah elemen ada sebelum menambahkan event listener
    if (!displayInput || !dropdown || !dropdownArrow) {
        console.warn('Dropdown elements not found');
        return;
    }
    
    // Event listener untuk klik pada input display
    displayInput.addEventListener('click', function() {
        if (citiesData.length === 0) {
            // Langsung gunakan data fallback jika tidak ada data
            citiesData = fallbackCitiesData.sort((a, b) => a.name.localeCompare(b.name));
            renderCityDropdown();
        }
        
        // Toggle dropdown
        if (dropdown.style.display === 'block') {
            dropdown.style.display = 'none';
            dropdownArrow.style.transform = 'rotate(0deg)';
        } else {
            dropdown.style.display = 'block';
            dropdownArrow.style.transform = 'rotate(180deg)';
        }
    });
    
    // Event listener untuk input manual
    if (manualInput) {
        manualInput.addEventListener('input', function() {
            hiddenInput.value = this.value;
            
            // Hapus class invalid jika ada
            if (this.value.trim() !== '') {
                displayInput.classList.remove('is-invalid');
                hiddenInput.classList.remove('is-invalid');
            }
        });
    }
    
    // Event listener untuk klik di luar dropdown
    document.addEventListener('click', function(event) {
        if (!event.target.closest('.city-dropdown-container')) {
            dropdown.style.display = 'none';
            dropdownArrow.style.transform = 'rotate(0deg)';
        }
    });
    
    // Event listener untuk tombol panah dropdown
    dropdownArrow.addEventListener('click', function(event) {
        event.stopPropagation();
        displayInput.click();
    });
    
    // Preload data kota saat halaman dimuat
    setTimeout(() => {
        if (citiesData.length === 0) {
            loadCitiesData();
        }
    }, 1000);
});

// Fungsi untuk validasi tempat lahir (untuk integrasi dengan validasi form yang sudah ada)
function validateTempatlahir() {
    const hiddenInput = document.getElementById('ttl');
    const displayInput = document.getElementById('ttl_display');
    const manualInput = document.getElementById('ttl_manual');
    
    if (!hiddenInput.value || hiddenInput.value.trim() === '') {
        displayInput.classList.add('is-invalid');
        hiddenInput.classList.add('is-invalid');
        return false;
    }
    
    displayInput.classList.remove('is-invalid');
    hiddenInput.classList.remove('is-invalid');
    return true;
}

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
document.addEventListener('DOMContentLoaded', function() {
    // Setup direktorat change listener
    const direktoratSelect = document.getElementById('direktorat');
    if (direktoratSelect) {
        direktoratSelect.addEventListener('change', function() {
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
    }
    
    // Initialize kategori pendidikan handler
    initializeKategoriPendidikan();
});

// ====== KATEGORI PENDIDIKAN HANDLERS ======

// Fungsi untuk menangani pergantian kategori pendidikan
function initializeKategoriPendidikan() {
    const kategoriSelect = document.getElementById('kategori_pendidikan');
    if (!kategoriSelect) return;
    
    kategoriSelect.addEventListener('change', function() {
        const selectedKategori = this.value;
        const formMahasiswa = document.getElementById('form-mahasiswa');
        const formSiswa = document.getElementById('form-siswa');
        
        // Hapus class is-invalid dari kategori pendidikan
        this.classList.remove('is-invalid');
        
        // Sembunyikan semua form terlebih dahulu dengan animasi
        if (formMahasiswa) {
            formMahasiswa.style.opacity = '0';
            setTimeout(() => {
                formMahasiswa.style.display = 'none';
            }, 300);
        }
        
        if (formSiswa) {
            formSiswa.style.opacity = '0';
            setTimeout(() => {
                formSiswa.style.display = 'none';
            }, 300);
        }
        
        // Reset semua input dan hapus class is-invalid
        resetFormInputsStep2();
        
        // Tampilkan form yang sesuai dengan animasi
        setTimeout(() => {
            if (selectedKategori === 'mahasiswa' && formMahasiswa) {
                formMahasiswa.style.display = 'block';
                formMahasiswa.style.opacity = '0';
                setTimeout(() => {
                    formMahasiswa.style.opacity = '1';
                    formMahasiswa.style.transition = 'opacity 0.5s ease';
                }, 50);
            } else if (selectedKategori === 'siswa' && formSiswa) {
                formSiswa.style.display = 'block';
                formSiswa.style.opacity = '0';
                setTimeout(() => {
                    formSiswa.style.opacity = '1';
                    formSiswa.style.transition = 'opacity 0.5s ease';
                }, 50);
            }
        }, 350);
    });
}

// Fungsi untuk reset semua input dalam form step 2
function resetFormInputsStep2() {
    const allInputs = document.querySelectorAll('#step-2 input, #step-2 select');
    allInputs.forEach(input => {
        if (input.id !== 'kategori_pendidikan') {
            if (input.type === 'file') {
                input.value = '';
                // Reset label file upload
                const labelElement = input.parentNode.querySelector('p');
                if (labelElement) {
                    labelElement.textContent = 'Klik atau seret file PDF/JPG/PNG';
                }
            } else {
                input.value = '';
            }
            input.classList.remove('is-invalid');
        }
    });
}

// Fungsi untuk copy data siswa ke field database saat submit
function copyDataSiswaToDatabase() {
    const kategoriPendidikan = document.getElementById('kategori_pendidikan')?.value;
    
    console.log('Kategori pendidikan:', kategoriPendidikan); // Debug log
    
    if (kategoriPendidikan === 'siswa') {
        // Copy data siswa ke field database yang sesuai
        const mappings = {
            'asal_sekolah': 'asal_universitas',
            'jurusan_sekolah': 'jurusan', 
            'program_keahlian': 'prodi',
            'kelas': 'semester',
            'nilai_rata_rata': 'ipk'
        };
        
        // Copy nilai input text/select
        Object.keys(mappings).forEach(sourceId => {
            const sourceElement = document.getElementById(sourceId);
            const targetElement = document.getElementById(mappings[sourceId]);
            
            if (sourceElement && targetElement && sourceElement.value) {
                targetElement.value = sourceElement.value;
                console.log(`Copied ${sourceId} (${sourceElement.value}) to ${mappings[sourceId]}`); // Debug log
            }
        });
        
        // Copy file uploads dengan cara yang lebih reliable
        copyFileFromSiswaToMahasiswa('raport', 'transkrip_nilai');
        copyFileFromSiswaToMahasiswa('surat_pengantar_sekolah', 'surat_pengantar');
    }
}

// Fungsi helper untuk copy file
function copyFileFromSiswaToMahasiswa(sourceId, targetId) {
    const sourceElement = document.getElementById(sourceId);
    const targetElement = document.getElementById(targetId);
    
    if (sourceElement && targetElement && sourceElement.files.length > 0) {
        try {
            // Method 1: Menggunakan DataTransfer
            const dt = new DataTransfer();
            dt.items.add(sourceElement.files[0]);
            targetElement.files = dt.files;
            console.log(`File copied from ${sourceId} to ${targetId}`); // Debug log
        } catch (error) {
            console.log('DataTransfer not supported, using alternative method');
            // Method 2: Alternative - Set custom attribute untuk dihandle di server
            targetElement.setAttribute('data-source-file', sourceId);
            targetElement.setAttribute('data-file-name', sourceElement.files[0].name);
        }
    }
}


// ====== VALIDASI KHUSUS STEP 2 ======

// Fungsi validasi khusus untuk step 2
function validateStep2() {
    const kategoriPendidikan = document.getElementById('kategori_pendidikan')?.value;
    
    console.log('Validating step 2, kategori:', kategoriPendidikan); // Debug log
    
    if (!kategoriPendidikan) {
        const kategoriSelect = document.getElementById('kategori_pendidikan');
        kategoriSelect.classList.add('is-invalid');
        kategoriSelect.focus();
        console.log('Kategori pendidikan not selected'); // Debug log
        return false;
    }
    
    document.getElementById('kategori_pendidikan').classList.remove('is-invalid');
    
    // Validasi berdasarkan kategori yang dipilih
    const requiredInputs = document.querySelectorAll(`[data-required-for="${kategoriPendidikan}"]`);
    let isValid = true;
    let firstInvalid = null;

    console.log(`Found ${requiredInputs.length} required inputs for ${kategoriPendidikan}`); // Debug log

    requiredInputs.forEach(input => {
        let inputValid = true;
        
        if (input.type === 'file') {
            // Untuk file input, cek apakah ada file yang dipilih
            inputValid = input.files && input.files.length > 0;
        } else {
            // Untuk input lainnya, cek validitas dan nilai
            inputValid = input.checkValidity() && input.value.trim() !== '';
        }
        
        console.log(`Input ${input.id}: valid = ${inputValid}, value = ${input.value}`); // Debug log
        
        if (!inputValid) {
            isValid = false;
            input.classList.add('is-invalid');
            
            if (!firstInvalid) {
                firstInvalid = input;
            }
        } else {
            input.classList.remove('is-invalid');
        }
    });

    // Fokus ke input pertama yang tidak valid
    if (firstInvalid) {
        setTimeout(() => {
            firstInvalid.focus();
            firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }, 100);
    }

    console.log('Step 2 validation result:', isValid); // Debug log
    return isValid;
}

// ====== SETUP FILE UPLOAD EVENT LISTENERS ======

// Event listener untuk file upload siswa
function setupFileUploadEventListeners() {
    // Event listener untuk raport
    const raportInput = document.getElementById('raport');
    if (raportInput) {
        raportInput.addEventListener('change', function() {
            const fileName = this.files[0]?.name || "Klik atau seret file PDF/JPG/PNG";
            const label = document.getElementById('raport-label');
            
            if (label) {
                label.style.opacity = '0';
                setTimeout(() => {
                    label.textContent = fileName;
                    label.style.opacity = '1';
                }, 300);
            }
            
            this.classList.remove('is-invalid');
        });
    }

    // Event listener untuk surat pengantar sekolah
    const suratSekolahInput = document.getElementById('surat_pengantar_sekolah');
    if (suratSekolahInput) {
        suratSekolahInput.addEventListener('change', function() {
            const fileName = this.files[0]?.name || "Klik atau seret file PDF/JPG/PNG";
            const label = document.getElementById('surat-sekolah-label');
            
            if (label) {
                label.style.opacity = '0';
                setTimeout(() => {
                    label.textContent = fileName;
                    label.style.opacity = '1';
                }, 300);
            }
            
            this.classList.remove('is-invalid');
        });
    }
}

// ====== MAIN FORM FUNCTIONS (UPDATED) ======

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

// Fungsi untuk validasi setiap langkah dengan animasi (UPDATED)
function validateStep(step) {
    if (step === 2) {
        // Validasi khusus untuk step 2 dengan kategori pendidikan
        return validateStep2();
    }
    
    // Validasi untuk step lainnya (step 1 dan 3)
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

    // Validasi khusus untuk tempat lahir pada step 1
    if (step === 1) {
        const isTempatLahirValid = validateTempatlahir();
        if (!isTempatLahirValid) {
            isValid = false;
            if (!firstInvalid) {
                firstInvalid = document.getElementById('ttl_display');
            }
        }
    }

    // Fokus ke input pertama yang tidak valid dengan animasi scroll
    if (firstInvalid) {
        setTimeout(() => {
            firstInvalid.focus();
            firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }, 100);
    }

    return isValid;
}

// ====== EVENT LISTENERS SETUP ======

// Event listeners untuk navigasi langkah-langkah form dengan animasi (UPDATED)
document.addEventListener('DOMContentLoaded', function() {
    // Step 1 to Step 2
    const nextToStep2 = document.getElementById('next-to-step-2');
    if (nextToStep2) {
        nextToStep2.addEventListener('click', function () {
            if (validateStep(1)) {
                showStep(1, 2);
            }
        });
    }

    // Step 2 back to Step 1
    const backToStep1 = document.getElementById('back-to-step-1');
    if (backToStep1) {
        backToStep1.addEventListener('click', function () {
            showStep(2, 1);
        });
    }

    // Step 2 to Step 3 (UPDATED untuk kategori pendidikan)
    const nextToStep3 = document.getElementById('next-to-step-3');
    if (nextToStep3) {
        nextToStep3.addEventListener('click', function () {
            if (validateStep2()) {
                // Copy data siswa ke field database sebelum pindah ke step 3
                copyDataSiswaToDatabase();
                showStep(2, 3);
            }
        });
    }

    // Step 3 back to Step 2
    const backToStep2 = document.getElementById('back-to-step-2');
    if (backToStep2) {
        backToStep2.addEventListener('click', function () {
            showStep(3, 2);
        });
    }
    
    // Setup file upload event listeners
    setupFileUploadEventListeners();
});

// Event listener untuk pengiriman form dengan animasi loading
document.addEventListener('DOMContentLoaded', function() {
    const submitFinal = document.getElementById('submit-final');
    if (submitFinal) {
        submitFinal.addEventListener('click', function (e) {
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
    }
});

// Event listeners untuk menampilkan nama file yang diunggah dengan animasi
document.addEventListener('DOMContentLoaded', function() {
    // Transkrip nilai
    const transkripInput = document.getElementById('transkrip_nilai');
    if (transkripInput) {
        transkripInput.addEventListener('change', function() {
            const fileName = this.files[0]?.name || "Klik atau seret file PDF/JPG/PNG";
            const label = document.getElementById('transkrip-label');
            
            if (label) {
                label.style.opacity = '0';
                setTimeout(() => {
                    label.textContent = fileName;
                    label.style.opacity = '1';
                }, 300);
            }
            
            this.classList.remove('is-invalid');
        });
    }
    
    // Surat pengantar
    const suratInput = document.getElementById('surat_pengantar');
    if (suratInput) {
        suratInput.addEventListener('change', function() {
            const fileName = this.files[0]?.name || "Klik atau seret file PDF/JPG/PNG";
            const label = document.getElementById('surat-label');
            
            if (label) {
                label.style.opacity = '0';
                setTimeout(() => {
                    label.textContent = fileName;
                    label.style.opacity = '1';
                }, 300);
            }
            
            this.classList.remove('is-invalid');
        });
    }
    
    // CV
    const cvInput = document.getElementById('cv');
    if (cvInput) {
        cvInput.addEventListener('change', function() {
            const fileName = this.files[0]?.name || "Klik atau seret file PDF/JPG/PNG";
            const label = document.getElementById('cv-label');
            
            if (label) {
                label.style.opacity = '0';
                setTimeout(() => {
                    label.textContent = fileName;
                    label.style.opacity = '1';
                }, 300);
            }
            
            this.classList.remove('is-invalid');
        });
    }

    // Foto profile
    const fotoInput = document.getElementById('foto_profile');
    if (fotoInput) {
        fotoInput.addEventListener('change', function() {
            const fileName = this.files[0]?.name || "Klik atau seret file JPG/PNG";
            const label = document.getElementById('foto-label');
            
            if (label) {
                label.style.opacity = '0';
                setTimeout(() => {
                    label.textContent = fileName;
                    label.style.opacity = '1';
                }, 300);
            }
            
            this.classList.remove('is-invalid');
        });
    }
});

// Hapus pesan kesalahan saat input berubah dengan animasi
document.addEventListener('DOMContentLoaded', function() {
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
});

// Animasi untuk card saat halaman dimuat
window.addEventListener('load', function() {
    const card = document.querySelector('.card');
    if (card) {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
            card.style.transition = 'opacity 0.8s ease, transform 0.8s ease';
        }, 300);
    }
});
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

// Fungsi untuk validasi setiap langkah dengan animasi (UPDATED)
function validateStep(step) {
    if (step === 2) {
        // Validasi khusus untuk step 2 dengan kategori pendidikan
        return validateStep2();
    }
    
    // Validasi untuk step lainnya (step 1 dan 3)
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

    // Validasi khusus untuk tempat lahir pada step 1
    if (step === 1) {
        const isTempatLahirValid = validateTempatlahir();
        if (!isTempatLahirValid) {
            isValid = false;
            if (!firstInvalid) {
                firstInvalid = document.getElementById('ttl_display');
            }
        }
    }

    // Fokus ke input pertama yang tidak valid dengan animasi scroll
    if (firstInvalid) {
        setTimeout(() => {
            firstInvalid.focus();
            firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }, 100);
    }

    return isValid;
}

// ====== EVENT LISTENERS SETUP ======

// Event listeners untuk navigasi langkah-langkah form dengan animasi (UPDATED)
document.addEventListener('DOMContentLoaded', function() {
    // Step 1 to Step 2
    const nextToStep2 = document.getElementById('next-to-step-2');
    if (nextToStep2) {
        nextToStep2.addEventListener('click', function () {
            if (validateStep(1)) {
                showStep(1, 2);
            }
        });
    }

    // Step 2 back to Step 1
    const backToStep1 = document.getElementById('back-to-step-1');
    if (backToStep1) {
        backToStep1.addEventListener('click', function () {
            showStep(2, 1);
        });
    }

    // Step 2 to Step 3 (UPDATED untuk kategori pendidikan)
    document.addEventListener('DOMContentLoaded', function() {
    const nextToStep3 = document.getElementById('next-to-step-3');
    if (nextToStep3) {
        // Hapus event listener lama
        nextToStep3.replaceWith(nextToStep3.cloneNode(true));
        const newNextToStep3 = document.getElementById('next-to-step-3');
        
        newNextToStep3.addEventListener('click', function () {
            console.log('Next to step 3 clicked'); // Debug log
            
            if (validateStep2()) {
                console.log('Validation passed'); // Debug log
                
                // Copy data siswa ke field database sebelum pindah ke step 3
                copyDataSiswaToDatabase();
                
                // Log form data sebelum submit
                const kategori = document.getElementById('kategori_pendidikan').value;
                console.log('Final kategori before step 3:', kategori);
                
                showStep(2, 3);
            } else {
                console.log('Validation failed'); // Debug log
            }
        });
    }
});
    // Step 3 back to Step 2
    const backToStep2 = document.getElementById('back-to-step-2');
    if (backToStep2) {
        backToStep2.addEventListener('click', function () {
            showStep(3, 2);
        });
    }
    
    // Setup file upload event listeners
    setupFileUploadEventListeners();
});

// Event listener untuk pengiriman form dengan animasi loading
document.addEventListener('DOMContentLoaded', function() {
    const submitFinal = document.getElementById('submit-final');
    if (submitFinal) {
        submitFinal.addEventListener('click', function (e) {
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
    }
});

// Event listeners untuk menampilkan nama file yang diunggah dengan animasi
document.addEventListener('DOMContentLoaded', function() {
    // Transkrip nilai
    const transkripInput = document.getElementById('transkrip_nilai');
    if (transkripInput) {
        transkripInput.addEventListener('change', function() {
            const fileName = this.files[0]?.name || "Klik atau seret file PDF/JPG/PNG";
            const label = document.getElementById('transkrip-label');
            
            if (label) {
                label.style.opacity = '0';
                setTimeout(() => {
                    label.textContent = fileName;
                    label.style.opacity = '1';
                }, 300);
            }
            
            this.classList.remove('is-invalid');
        });
    }
    
    // Surat pengantar
    const suratInput = document.getElementById('surat_pengantar');
    if (suratInput) {
        suratInput.addEventListener('change', function() {
            const fileName = this.files[0]?.name || "Klik atau seret file PDF/JPG/PNG";
            const label = document.getElementById('surat-label');
            
            if (label) {
                label.style.opacity = '0';
                setTimeout(() => {
                    label.textContent = fileName;
                    label.style.opacity = '1';
                }, 300);
            }
            
            this.classList.remove('is-invalid');
        });
    }
    
    // CV
    const cvInput = document.getElementById('cv');
    if (cvInput) {
        cvInput.addEventListener('change', function() {
            const fileName = this.files[0]?.name || "Klik atau seret file PDF/JPG/PNG";
            const label = document.getElementById('cv-label');
            
            if (label) {
                label.style.opacity = '0';
                setTimeout(() => {
                    label.textContent = fileName;
                    label.style.opacity = '1';
                }, 300);
            }
            
            this.classList.remove('is-invalid');
        });
    }

    // Foto profile
    const fotoInput = document.getElementById('foto_profile');
    if (fotoInput) {
        fotoInput.addEventListener('change', function() {
            const fileName = this.files[0]?.name || "Klik atau seret file JPG/PNG";
            const label = document.getElementById('foto-label');
            
            if (label) {
                label.style.opacity = '0';
                setTimeout(() => {
                    label.textContent = fileName;
                    label.style.opacity = '1';
                }, 300);
            }
            
            this.classList.remove('is-invalid');
        });
    }
});

// Hapus pesan kesalahan saat input berubah dengan animasi
document.addEventListener('DOMContentLoaded', function() {
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
});

// Animasi untuk card saat halaman dimuat
window.addEventListener('load', function() {
    const card = document.querySelector('.card');
    if (card) {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
            card.style.transition = 'opacity 0.8s ease, transform 0.8s ease';
        }, 300);
    }
});
</script>
</body>
</html>