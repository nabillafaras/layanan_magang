@extends('layouts.header_user')

@section('title', 'Absensi - Kementerian Sosial RI')

@section('additional_css')
<style>
    /* Attendance Page Specific Styles */
    :root {
        --primary-color: #8b0000;
        --primary-light: #c13030;
        --transition-speed: 0.3s ease;
    }
    
    .section-title {
        position: relative;
        font-weight: 700;
        color: var(--primary-color);
        padding-bottom: 10px;
        margin-bottom: 25px;
    }
    
    .section-title::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: 0;
        height: 4px;
        width: 60px;
        background: linear-gradient(90deg, var(--primary-color), var(--primary-light));
        border-radius: 2px;
    }
    
    .dashboard-header {
        margin-bottom: 30px;
    }
    
    .attendance-card {
        border-radius: 15px;
        border: none;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        margin-bottom: 30px;
        transition: all var(--transition-speed);
    }
    
    .attendance-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.12);
    }
    
    .card-header {
        background-color: #fff;
        border-bottom: 1px solid rgba(0,0,0,0.05);
        padding: 20px;
    }
    
    .card-header h5 {
        margin: 0;
        font-weight: 600;
        color: #333;
        display: flex;
        align-items: center;
    }
    
    .card-header i {
        margin-right: 10px;
    }
    
    .time-display {
        background: linear-gradient(135deg, var(--primary-color) 0%, #6a0000 100%);
        color: white;
        padding: 25px;
        border-radius: 15px;
        margin-bottom: 30px;
        text-align: center;
        box-shadow: 0 8px 25px rgba(139, 0, 0, 0.25);
        position: relative;
        overflow: hidden;
    }
    
    .time-display::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 70%);
        opacity: 0.5;
        animation: shine 3s linear infinite;
    }
    
    @keyframes shine {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    
    .time-display h1 {
        font-size: 3.5rem;
        font-weight: 700;
        margin: 0;
        letter-spacing: 2px;
        text-shadow: 0 2px 5px rgba(0,0,0,0.2);
    }
    
    .time-display p {
        font-size: 1.1rem;
        margin-top: 5px;
        letter-spacing: 1px;
        opacity: 0.9;
    }
    
    .action-btn {
        font-weight: 600;
        padding: 12px 25px;
        border-radius: 50px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        transition: all var(--transition-speed);
        position: relative;
        overflow: hidden;
        z-index: 1;
    }
    
    .action-btn::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 0;
        background: rgba(0,0,0,0.1);
        transition: all 0.3s;
        z-index: -1;
    }
    
    .action-btn:hover::after {
        height: 100%;
    }
    
    .action-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }
    
    .check-in-btn {
        background: linear-gradient(135deg, var(--primary-color) 0%, #6a0000 100%);
        border: none;
    }
    
    .check-out-btn {
        background: linear-gradient(135deg, #1a8754 0%, #146c43 100%);
        border: none;
    }
    
    .location-btn {
        background-color: #f8f9fa;
        color: #333;
        border: 1px solid #dee2e6;
        padding: 12px 20px;
        border-radius: 50px;
        transition: all var(--transition-speed);
        font-weight: 500;
    }
    
    .location-btn:hover {
        background-color: #e9ecef;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }
    
    .camera-box {
        border: 2px dashed #dee2e6;
        border-radius: 15px;
        padding: 30px;
        text-align: center;
        cursor: pointer;
        transition: all var(--transition-speed);
        background-color: #f8f9fa;
    }
    
    .camera-box:hover {
        border-color: var(--primary-color);
        background-color: #fff9f9;
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.05);
    }
    
    .camera-icon {
        font-size: 40px;
        color: var(--primary-color);
        margin-bottom: 15px;
        transition: all var(--transition-speed);
    }
    
    .camera-box:hover .camera-icon {
        transform: scale(1.1);
        color: var(--primary-light);
    }
    
    .map-container {
        width: 100%;
        height: 300px;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        margin-bottom: 20px;
        transition: all var(--transition-speed);
        border: 1px solid #eee;
    }
    
    .map-container:hover {
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        transform: translateY(-3px);
    }
    
    .location-info {
        background-color: #f8f9fa;
        padding: 15px;
        border-radius: 12px;
        margin-top: 10px;
        border: 1px solid #dee2e6;
        font-size: 14px;
        transition: all var(--transition-speed);
    }
    
    .location-info:hover {
        background-color: #fff;
        border-color: var(--primary-color);
    }
    
    .form-card {
        background-color: #fff;
        border-radius: 15px;
        border: none;
        overflow: hidden;
        transition: all var(--transition-speed);
        margin-bottom: 25px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }
    
    .form-card:hover {
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        transform: translateY(-5px);
    }
    
    .form-header {
        padding: 20px;
        color: #fff;
        font-weight: 600;
    }
    
    .form-body {
        padding: 25px;
    }
    
    .preview-image {
        max-height: 300px;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        transition: all var(--transition-speed);
    }
    
    .preview-image:hover {
        transform: scale(1.02);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }
    
    .photo-preview-container {
        text-align: center;
        margin-top: 20px;
    }
    
    /* Table styles */
    .table {
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    }
    
    .table th {
        background-color: #f8f9fa;
        font-weight: 600;
        color: #444;
        padding: 15px;
        border-top: none;
    }
    
    .table td {
        padding: 15px;
        vertical-align: middle;
    }
    
    .table tr {
        transition: all var(--transition-speed);
    }
    
    .table tr:hover {
        background-color: rgba(139, 0, 0, 0.02);
    }
    
    .badge {
        padding: 8px 15px;
        border-radius: 50px;
        font-weight: 500;
        font-size: 12px;
    }
    
    /* Animation Classes */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    @keyframes slideInUp {
        from { opacity: 0; transform: translateY(50px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    @keyframes bounceIn {
        0% { transform: scale(0.8); opacity: 0; }
        50% { transform: scale(1.05); opacity: 0.8; }
        100% { transform: scale(1); opacity: 1; }
    }
    
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.03); }
        100% { transform: scale(1); }
    }
    
    @keyframes pulse-button {
        0% { box-shadow: 0 0 0 0 rgba(139, 0, 0, 0.7); }
        70% { box-shadow: 0 0 0 10px rgba(139, 0, 0, 0); }
        100% { box-shadow: 0 0 0 0 rgba(139, 0, 0, 0); }
    }
    
    .btn-pulse {
        animation: pulse-button 2s infinite;
    }
    
    .pulse-clock {
        animation: pulse 2s infinite;
    }
    
    .alert {
        border-radius: 10px;
        border: none;
        box-shadow: 0 3px 10px rgba(0,0,0,0.05);
    }
</style>
@endsection

@section('content')
<!-- Page Content -->
<div class="container-fluid py-4">
    <div class="dashboard-header animate__animated animate__fadeIn">
        <h2 class="section-title mb-4">Sistem Absensi</h2>
        <p class="text-muted">Absensi masuk dan pulang peserta magang</p>
    </div>

    <!-- Absensi Content -->
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="attendance-card animate__animated animate__fadeInUp">
                <div class="card-header d-flex align-items-center">
                    <i class="fas fa-clock me-2" style="color: var(--primary-color);"></i>
                    <h5>Absensi Peserta</h5>
                </div>
                <div class="card-body p-4">
                    <!-- Time Display -->
                    <div class="time-display mb-4 animate__animated animate__fadeIn">
                        <h1 class="current-time pulse-clock">{{ now()->format('H:i:s') }}</h1>
                        <p class="current-date">{{ now()->isoFormat('dddd, D MMMM Y') }}</p>
                    </div>

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show animate__animated animate__shakeX" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Check-in Form -->
@if(!isset($hasCheckedIn) || !$hasCheckedIn)
<div class="form-card mb-4 animate__animated animate__fadeInUp">
    <div class="form-header bg-primary">
        <i class="fas fa-sign-in-alt me-2"></i> Absen Masuk
    </div>
    <div class="form-body">
        <form action="{{ route('attendance.check-in') }}" method="POST" enctype="multipart/form-data" id="absensiForm">
            @csrf
            <div class="mb-4">
                <label class="form-label fw-bold">Lokasi</label>
                <button type="button" class="location-btn w-100 mb-3" onclick="getLocation('check-in')">
                    <i class="fas fa-map-marker-alt me-2" style="color: var(--primary-color);"></i> Dapatkan Lokasi Saat Ini
                </button>
                <div id="map-container-in" class="map-container">
                    <iframe id="map-iframe-in" width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
                <div class="location-info" id="location-info-in">
                    <i class="fas fa-info-circle me-2" style="color: var(--primary-color);"></i>
                    <small>Koordinat akan muncul di sini setelah lokasi terdeteksi</small>
                </div>
                <input type="hidden" name="location" id="location">
                <input type="hidden" name="latitude" id="latitude">
                <input type="hidden" name="longitude" id="longitude">
                <input type="hidden" name="real_time" id="real_time">
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold">Foto</label>
                <div class="camera-box" id="cameraTriggerIn">
                    <i class="fas fa-camera camera-icon"></i>
                    <p class="mb-0">Buka Kamera Absensi</p>
                </div>
                <!-- Hidden file input - hanya untuk menyimpan foto yang diambil dari kamera -->
                <input type="file" id="photo" name="photo" accept="image/*" class="d-none">
                
                <!-- Container untuk kamera yang akan dibuka -->
                <div id="cameraContainerIn" class="camera-container mt-3 d-none">
                    <video id="cameraVideoIn" class="camera-preview img-fluid border rounded" autoplay playsinline></video>
                    <canvas id="canvasIn" class="d-none"></canvas>
                    <div class="camera-controls mt-2 text-center">
                        <button type="button" id="capturePhotoIn" class="btn btn-danger">
                            <i class="fas fa-camera me-2"></i> Ambil Foto
                        </button>
                    </div>
                </div>
                
                <!-- Preview foto yang diambil -->
                <div class="photo-preview-container mt-3">
                    <img id="photoPreviewIn" class="img-fluid preview-image d-none" alt="Preview Foto">
                    <div id="photoControlsIn" class="mt-2 text-center d-none">
                        <button type="button" id="retakePhotoIn" class="btn btn-outline-secondary">
                            <i class="fas fa-redo me-2"></i> Ambil Ulang
                        </button>
                    </div>
                </div>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="action-btn check-in-btn btn-pulse" id="submitBtn" disabled>
                    <i class="fas fa-check-circle me-2"></i> Absen Masuk
                </button>
            </div>
        </form>
    </div>
</div>
@endif

<!-- Check-out Form - Hanya muncul jika sudah check-in -->
@if(isset($hasCheckedIn) && $hasCheckedIn && (!isset($hasCheckedOut) || !$hasCheckedOut))
<div class="form-card mb-4 animate__animated animate__fadeInUp" style="animation-delay: 0.2s">
    <div class="form-header bg-success">
        <i class="fas fa-sign-out-alt me-2"></i> Absen Pulang
    </div>
    <div class="form-body">
        <form action="{{ route('attendance.check-out') }}" method="POST" enctype="multipart/form-data" id="checkoutForm">
            @csrf
            <div class="mb-4">
                <label class="form-label fw-bold">Lokasi</label>
                <button type="button" class="location-btn w-100 mb-3" onclick="getLocation('check-out')">
                    <i class="fas fa-map-marker-alt me-2" style="color: #1a8754;"></i> Dapatkan Lokasi Saat Ini
                </button>
                <div id="map-container-out" class="map-container">
                    <iframe id="map-iframe-out" width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
                <div class="location-info" id="location-info-out">
                    <i class="fas fa-info-circle me-2" style="color: #1a8754;"></i>
                    <small>Koordinat akan muncul di sini setelah lokasi terdeteksi</small>
                </div>
                <input type="hidden" name="location" id="location_out">
                <input type="hidden" name="latitude" id="latitude_out">
                <input type="hidden" name="longitude" id="longitude_out">
                <input type="hidden" name="real_time" id="real_time_out">
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold">Foto</label>
                <div class="camera-box" id="cameraTriggerOut">
                    <i class="fas fa-camera camera-icon" style="color: #1a8754;"></i>
                    <p class="mb-0">Buka Kamera Absensi</p>
                </div>
                <!-- Hidden file input - hanya untuk menyimpan foto yang diambil dari kamera -->
                <input type="file" id="photo_out" name="photo" accept="image/*" class="d-none">
                
                <!-- Container untuk kamera yang akan dibuka -->
                <div id="cameraContainerOut" class="camera-container mt-3 d-none">
                    <video id="cameraVideoOut" class="camera-preview img-fluid border rounded" autoplay playsinline></video>
                    <canvas id="canvasOut" class="d-none"></canvas>
                    <div class="camera-controls mt-2 text-center">
                        <button type="button" id="capturePhotoOut" class="btn btn-success">
                            <i class="fas fa-camera me-2"></i> Ambil Foto
                        </button>
                    </div>
                </div>
                
                <!-- Preview foto yang diambil -->
                <div class="photo-preview-container mt-3">
                    <img id="photoPreviewOut" class="img-fluid preview-image d-none" alt="Preview Foto">
                    <div id="photoControlsOut" class="mt-2 text-center d-none">
                        <button type="button" id="retakePhotoOut" class="btn btn-outline-secondary">
                            <i class="fas fa-redo me-2"></i> Ambil Ulang
                        </button>
                    </div>
                </div>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="action-btn check-out-btn btn-pulse" id="submitBtnOut" disabled>
                    <i class="fas fa-check-circle me-2"></i> Absen Pulang
                </button>
            </div>
        </form>
    </div>
</div>
@endif

<!-- Attendance History -->
<div class="mt-5 animate__animated animate__fadeInUp" style="animation-delay: 0.3s">
    <h5 class="mb-4"><i class="fas fa-history me-2" style="color: var(--primary-color);"></i>Riwayat Absensi</h5>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Masuk</th>
                    <th>Pulang</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody id="attendanceHistory">
                @foreach($attendanceHistory ?? [] as $index => $record)
                <tr class="animate__animated animate__fadeIn" style="animation-delay: {{ $index * 0.1 }}s">
                    <td>{{ \Carbon\Carbon::parse($record->date)->format('d/m/Y') }}</td>
                    <td>{{ $record->check_in_time }}</td>
                    <td>{{ $record->check_out_time ?? '-' }}</td>
                    <td>
                        <span class="badge {{ $record->status === 'hadir' ? 'bg-success' : ($record->status === 'terlambat' ? 'bg-danger' : 'bg-danger') }}">
                            {{ $record->status }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('additional_scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        
        // Efek animasi pada load halaman
        const animateElements = function() {
            const elements = document.querySelectorAll('.attendance-card, .form-card');
            elements.forEach(function(element, index) {
                element.style.opacity = '0';
                element.style.transform = 'translateY(20px)';
                setTimeout(function() {
                    element.style.transition = 'all 0.5s ease';
                    element.style.opacity = '1';
                    element.style.transform = 'translateY(0)';
                }, index * 200);
            });
        };
        
        // Jalankan animasi
        animateElements();
        
        // Update time every second with animation
        const timeDisplay = document.querySelector('.current-time');
        if (timeDisplay) {
            setInterval(function() {
                const now = new Date();
                // Tambahkan animasi pulse saat waktu berubah
                timeDisplay.classList.add('animate__animated', 'animate__pulse');
                timeDisplay.textContent = now.toLocaleTimeString('id-ID');
                setTimeout(() => {
                    timeDisplay.classList.remove('animate__animated', 'animate__pulse');
                }, 1000);
            }, 1000);
        }

        // Variabel global untuk menyimpan stream
        let videoStreamIn = null;
        let videoStreamOut = null;
        
        // ===== KAMERA CHECK-IN =====
        const cameraTriggerIn = document.getElementById('cameraTriggerIn');
        const cameraContainerIn = document.getElementById('cameraContainerIn');
        const cameraVideoIn = document.getElementById('cameraVideoIn');
        const capturePhotoIn = document.getElementById('capturePhotoIn');
        const canvasIn = document.getElementById('canvasIn');
        const photoPreviewIn = document.getElementById('photoPreviewIn');
        const photoControlsIn = document.getElementById('photoControlsIn');
        const retakePhotoIn = document.getElementById('retakePhotoIn');
        const photoInput = document.getElementById('photo');
        const submitBtn = document.getElementById('submitBtn');
        
        // Event listener untuk tombol "Buka Kamera"
        if (cameraTriggerIn) {
            cameraTriggerIn.addEventListener('click', function() {
                startCamera('in');
            });
        }
        
        // Event listener untuk capture foto check-in
        if (capturePhotoIn) {
            capturePhotoIn.addEventListener('click', function() {
                capturePhoto('in');
            });
        }
        
        // Event listener untuk ambil ulang foto check-in
        if (retakePhotoIn) {
            retakePhotoIn.addEventListener('click', function() {
                startCamera('in');
            });
        }
        
        // ===== KAMERA CHECK-OUT =====
        const cameraTriggerOut = document.getElementById('cameraTriggerOut');
        const cameraContainerOut = document.getElementById('cameraContainerOut');
        const cameraVideoOut = document.getElementById('cameraVideoOut');
        const capturePhotoOut = document.getElementById('capturePhotoOut');
        const canvasOut = document.getElementById('canvasOut');
        const photoPreviewOut = document.getElementById('photoPreviewOut');
        const photoControlsOut = document.getElementById('photoControlsOut');
        const retakePhotoOut = document.getElementById('retakePhotoOut');
        const photoOutInput = document.getElementById('photo_out');
        const submitBtnOut = document.getElementById('submitBtnOut');
        
        // Event listener untuk tombol "Buka Kamera" check-out
        if (cameraTriggerOut) {
            cameraTriggerOut.addEventListener('click', function() {
                startCamera('out');
            });
        }
        
        // Event listener untuk capture foto check-out
        if (capturePhotoOut) {
            capturePhotoOut.addEventListener('click', function() {
                capturePhoto('out');
            });
        }
        
        // Event listener untuk ambil ulang foto check-out
        if (retakePhotoOut) {
            retakePhotoOut.addEventListener('click', function() {
                startCamera('out');
            });
        }
        
        // Fungsi untuk memulai kamera berdasarkan tipe (in/out)
        function startCamera(type) {
            const videoElement = type === 'in' ? cameraVideoIn : cameraVideoOut;
            const cameraContainer = type === 'in' ? cameraContainerIn : cameraContainerOut;
            const photoPreview = type === 'in' ? photoPreviewIn : photoPreviewOut;
            const photoControls = type === 'in' ? photoControlsIn : photoControlsOut;
            
            // Tampilkan container kamera dan sembunyikan preview foto
            cameraContainer.classList.remove('d-none');
            photoPreview.classList.add('d-none');
            photoControls.classList.add('d-none');
            
            // Matikan stream sebelumnya jika ada
            if (type === 'in' && videoStreamIn) {
                videoStreamIn.getTracks().forEach(track => track.stop());
                videoStreamIn = null;
            } else if (type === 'out' && videoStreamOut) {
                videoStreamOut.getTracks().forEach(track => track.stop());
                videoStreamOut = null;
            }
            
            // Tambahkan loading
            videoElement.classList.add('d-none');
            const loadingId = `loadingCamera${type.charAt(0).toUpperCase() + type.slice(1)}`;
            let loadingElement = document.getElementById(loadingId);
            
            if (!loadingElement) {
                loadingElement = document.createElement('div');
                loadingElement.id = loadingId;
                loadingElement.classList.add('text-center', 'p-4', 'animate__animated', 'animate__pulse', 'animate__infinite');
                loadingElement.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Mengaktifkan kamera...';
                cameraContainer.insertBefore(loadingElement, videoElement);
            } else {
                loadingElement.classList.remove('d-none');
            }
            
            // Konfigurasi untuk mengakses kamera
            const constraints = {
                video: {
                    facingMode: 'user',  // Gunakan kamera depan, 'environment' untuk kamera belakang
                    width: { ideal: 640 },
                    height: { ideal: 480 }
                },
                audio: false
            };
            
            // Akses kamera
            navigator.mediaDevices.getUserMedia(constraints)
                .then(function(stream) {
                    // Simpan stream ke variabel global
                    if (type === 'in') {
                        videoStreamIn = stream;
                    } else {
                        videoStreamOut = stream;
                    }
                    
                    // Sembunyikan loading
                    loadingElement.classList.add('d-none');
                    
                    // Tampilkan video stream
                    videoElement.classList.remove('d-none');
                    videoElement.srcObject = stream;
                    videoElement.play();
                    
                    // Tambahkan animasi
                    videoElement.classList.add('animate__animated', 'animate__fadeIn');
                })
                .catch(function(error) {
                    console.error('Error mengakses kamera:', error);
                    
                    // Sembunyikan loading dan container kamera
                    loadingElement.classList.add('d-none');
                    cameraContainer.classList.add('d-none');
                    
                    // Tampilkan pesan error
                    Swal.fire({
                        icon: 'error',
                        title: 'Tidak Dapat Mengakses Kamera',
                        text: 'Pastikan Anda telah memberikan izin untuk mengakses kamera. Error: ' + error.message,
                        confirmButtonColor: type === 'in' ? '#8b0000' : '#1a8754',
                        showClass: {
                            popup: 'animate__animated animate__fadeInDown'
                        },
                        hideClass: {
                            popup: 'animate__animated animate__fadeOutUp'
                        }
                    });
                });
        }
        
        // Fungsi untuk mengambil foto dari stream kamera
        function capturePhoto(type) {
            const videoElement = type === 'in' ? cameraVideoIn : cameraVideoOut;
            const canvasElement = type === 'in' ? canvasIn : canvasOut;
            const cameraContainer = type === 'in' ? cameraContainerIn : cameraContainerOut;
            const photoPreview = type === 'in' ? photoPreviewIn : photoPreviewOut;
            const photoControls = type === 'in' ? photoControlsIn : photoControlsOut;
            const fileInput = type === 'in' ? photoInput : photoOutInput;
            const submitButton = type === 'in' ? submitBtn : submitBtnOut;
            
            // Ambil dimensi video
            const width = videoElement.videoWidth;
            const height = videoElement.videoHeight;
            
            // Set ukuran canvas
            canvasElement.width = width;
            canvasElement.height = height;
            
            // Gambar frame dari video ke canvas
            const context = canvasElement.getContext('2d');
            context.drawImage(videoElement, 0, 0, width, height);
            
            // Konversi canvas ke data URL dengan kualitas baik
            const dataURL = canvasElement.toDataURL('image/jpeg', 0.8);
            
            // Tampilkan preview foto
            photoPreview.src = dataURL;
            photoPreview.classList.remove('d-none');
            photoPreview.classList.add('animate__animated', 'animate__fadeIn');
            photoControls.classList.remove('d-none');
            
            // Sembunyikan container kamera
            cameraContainer.classList.add('d-none');
            
            // Hentikan stream kamera
            if (type === 'in' && videoStreamIn) {
                videoStreamIn.getTracks().forEach(track => track.stop());
                videoStreamIn = null;
            } else if (type === 'out' && videoStreamOut) {
                videoStreamOut.getTracks().forEach(track => track.stop());
                videoStreamOut = null;
            }
            
            // Konversi data URL ke File object untuk upload
            const byteString = atob(dataURL.split(',')[1]);
            const mimeType = dataURL.split(',')[0].split(':')[1].split(';')[0];
            
            const ab = new ArrayBuffer(byteString.length);
            const ia = new Uint8Array(ab);
            for (let i = 0; i < byteString.length; i++) {
                ia[i] = byteString.charCodeAt(i);
            }
            
            const blob = new Blob([ab], { type: mimeType });
            const fileName = `photo_${type}_${new Date().getTime()}.jpg`;
            const photoFile = new File([blob], fileName, { type: mimeType });
            
            // Masukkan File ke input file untuk form submission
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(photoFile);
            fileInput.files = dataTransfer.files;
            
            console.log(`Foto ${type} berhasil diambil dan disimpan ke input file`);
            
            // Aktifkan tombol submit jika lokasi sudah terdeteksi
            const locationField = document.getElementById(type === 'in' ? 'location' : 'location_out');
            if (locationField && locationField.value) {
                console.log(`Lokasi sudah ada: ${locationField.value}, mengaktifkan tombol submit`);
                submitButton.disabled = false;
                submitButton.classList.add('btn-pulse');
            } else {
                console.log('Lokasi belum terdeteksi, tombol submit masih disabled');
            }
        }
        
        // Fungsi untuk mengaktifkan tombol submit
        function checkFormCompletion(type) {
            const photoField = type === 'in' ? photoInput : photoOutInput;
            const locationField = document.getElementById(type === 'in' ? 'location' : 'location_out');
            const submitButton = type === 'in' ? submitBtn : submitBtnOut;
            
            console.log(`Checking form completion for ${type}:`, {
                photoAvailable: photoField && photoField.files.length > 0,
                locationAvailable: locationField && locationField.value
            });
            
            if (photoField && photoField.files.length > 0 && locationField && locationField.value) {
                submitButton.disabled = false;
                submitButton.classList.add('btn-pulse');
                console.log(`Form ${type} lengkap, tombol submit diaktifkan`);
            } else {
                submitButton.disabled = true;
                submitButton.classList.remove('btn-pulse');
                console.log(`Form ${type} belum lengkap, tombol submit masih disabled`);
            }
        }
        
        // ===== FORM SUBMISSION =====
        
        // Handle form check-in submission
        const checkInForm = document.getElementById('absensiForm');
        if (checkInForm) {
            checkInForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                
                // Set waktu real saat ini
                document.getElementById('real_time').value = new Date().toISOString();
                
                // Validasi form
                if (!photoInput.files || photoInput.files.length === 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Foto Belum Diambil',
                        text: 'Silakan ambil foto absensi terlebih dahulu',
                        confirmButtonColor: '#8b0000'
                    });
                    return;
                }
                
                // Tampilkan loading pada tombol
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Memproses...';
                submitBtn.disabled = true;
                submitBtn.classList.remove('btn-pulse');
                
                // Submit form dengan AJAX
                const formData = new FormData(checkInForm);
                
                try {
                    const response = await fetch('/attendance/check-in', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    });
                    
                    const data = await response.json();
                    
                    if (data.success) {
                        // Tampilkan notifikasi sukses
                        Swal.fire({
                            icon: 'success',
                            title: 'Absensi Berhasil!',
                            text: data.message,
                            confirmButtonColor: '#8b0000',
                            showClass: {
                                popup: 'animate__animated animate__fadeInDown'
                            },
                            hideClass: {
                                popup: 'animate__animated animate__fadeOutUp'
                            }
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        // Tampilkan notifikasi error
                        Swal.fire({
                            icon: 'error',
                            title: 'Absensi Gagal',
                            text: data.message,
                            confirmButtonColor: '#8b0000'
                        });
                        
                        // Reset tombol submit
                        submitBtn.innerHTML = '<i class="fas fa-check-circle me-2"></i> Absen Masuk';
                        submitBtn.disabled = false;
                        submitBtn.classList.add('btn-pulse');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    
                    // Tampilkan notifikasi error
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan',
                        text: 'Terjadi kesalahan saat mengirim data absensi',
                        confirmButtonColor: '#8b0000'
                    });
                    
                    // Reset tombol submit
                    submitBtn.innerHTML = '<i class="fas fa-check-circle me-2"></i> Absen Masuk';
                    submitBtn.disabled = false;
                    submitBtn.classList.add('btn-pulse');
                }
            });
        }
        
        // Handle form check-out submission
        const checkOutForm = document.getElementById('checkoutForm');
        if (checkOutForm) {
            checkOutForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                
                // Set waktu real saat ini
                document.getElementById('real_time_out').value = new Date().toISOString();
                
                // Validasi form
                if (!photoOutInput.files || photoOutInput.files.length === 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Foto Belum Diambil',
                        text: 'Silakan ambil foto absensi terlebih dahulu',
                        confirmButtonColor: '#1a8754'
                    });
                    return;
                }
                
                // Tampilkan loading pada tombol
                submitBtnOut.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Memproses...';
                submitBtnOut.disabled = true;
                submitBtnOut.classList.remove('btn-pulse');
                
                // Submit form dengan AJAX
                const formData = new FormData(checkOutForm);
                
                try {
                    const response = await fetch('/attendance/check-out', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    });
                    
                    const data = await response.json();
                    
                    if (data.success) {
                        // Tampilkan notifikasi sukses
                        Swal.fire({
                            icon: 'success',
                            title: 'Absensi Pulang Berhasil!',
                            text: data.message,
                            confirmButtonColor: '#1a8754',
                            showClass: {
                                popup: 'animate__animated animate__fadeInDown'
                            },
                            hideClass: {
                                popup: 'animate__animated animate__fadeOutUp'
                            }
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        // Tampilkan notifikasi error
                        Swal.fire({
                            icon: 'error',
                            title: 'Absensi Gagal',
                            text: data.message,
                            confirmButtonColor: '#1a8754'
                        });
                        
                        // Reset tombol submit
                        submitBtnOut.innerHTML = '<i class="fas fa-check-circle me-2"></i> Absen Pulang';
                        submitBtnOut.disabled = false;
                        submitBtnOut.classList.add('btn-pulse');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    
                    // Tampilkan notifikasi error
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan',
                        text: 'Terjadi kesalahan saat mengirim data absensi',
                        confirmButtonColor: '#1a8754'
                    });
                    
                    // Reset tombol submit
                    submitBtnOut.innerHTML = '<i class="fas fa-check-circle me-2"></i> Absen Pulang';
                    submitBtnOut.disabled = false;
                    submitBtnOut.classList.add('btn-pulse');
                }
            });
        }
    });

    // Fungsi untuk mendapatkan lokasi dan menampilkannya di iframe Google Maps
    function getLocation(type) {
    if (navigator.geolocation) {
        // Tampilkan indikator loading dengan animasi
        const infoElement = document.getElementById(`location-info-${type === 'check-in' ? 'in' : 'out'}`);
        infoElement.innerHTML = '<div class="text-center animate__animated animate__pulse animate__infinite"><i class="fas fa-spinner fa-spin me-2"></i> Mendapatkan lokasi presisi tinggi...</div>';
        
        // Opsi geolokasi dengan akurasi tinggi dan timeout lebih lama
        const geoOptions = {
            enableHighAccuracy: true,  // Paksa menggunakan GPS
            maximumAge: 0,             // Jangan gunakan cache
            timeout: 30000             // 30 detik - beri waktu lebih untuk GPS lock
        };
        
        // Tambahkan penanganan error yang lebih baik
        const errorHandler = function(error) {
            console.error("Geolocation error:", error);
            let pesanError = 'Error mendapatkan lokasi: ';
            
            switch(error.code) {
                case error.PERMISSION_DENIED:
                    pesanError += 'Izin akses lokasi ditolak. Mohon izinkan akses lokasi di browser Anda.';
                    break;
                case error.POSITION_UNAVAILABLE:
                    pesanError += 'Informasi lokasi tidak tersedia. Pastikan GPS dan layanan lokasi aktif.';
                    break;
                case error.TIMEOUT:
                    pesanError += 'Waktu permintaan lokasi habis. Coba lagi atau pastikan berada di area dengan sinyal GPS yang baik.';
                    break;
                case error.UNKNOWN_ERROR:
                    pesanError += 'Terjadi kesalahan yang tidak diketahui saat mengakses lokasi.';
                    break;
            }
            
            // Tampilkan error dengan alert yang lebih menarik
            Swal.fire({
                icon: 'error',
                title: 'Lokasi Tidak Akurat',
                text: pesanError,
                confirmButtonColor: '#8b0000',
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                }
            });
            
            document.getElementById(`location-info-${type === 'check-in' ? 'in' : 'out'}`).innerHTML = 
                `<div class="text-danger animate__animated animate__fadeIn"><i class="fas fa-exclamation-triangle me-2"></i> ${pesanError}</div>`;
        };
        
        // Fungsi untuk memproses lokasi yang diterima
        const successHandler = function(position) {
            const lat = position.coords.latitude;
            const lng = position.coords.longitude;
            const accuracy = position.coords.accuracy; // dalam meter
            
            console.log("Lokasi diterima:", lat, lng, "Akurasi:", accuracy);
            
            // Periksa akurasi lokasi
            if (accuracy > 100) { // Jika akurasi lebih dari 100 meter
                infoElement.innerHTML = `
                    <div class="text-warning animate__animated animate__fadeIn">
                        <i class="fas fa-exclamation-circle me-2"></i><strong>Perhatian: Lokasi kurang akurat (±${Math.round(accuracy)}m)</strong>
                        <button class="btn btn-sm btn-outline-warning ms-2" onclick="getLocation('${type}')">
                            <i class="fas fa-sync-alt me-1"></i> Coba Lagi
                        </button>
                    </div>`;
                
                // Tunjukkan peringatan
                Swal.fire({
                    icon: 'warning',
                    title: 'Lokasi Kurang Akurat',
                    text: `Akurasi lokasi saat ini adalah ±${Math.round(accuracy)}m. Ini mungkin menyebabkan lokasi tidak dikenali sebagai area kantor. Pastikan GPS aktif dan lakukan di area terbuka.`,
                    confirmButtonText: 'Gunakan Lokasi Ini',
                    showCancelButton: true,
                    cancelButtonText: 'Coba Lagi',
                    confirmButtonColor: '#8b0000',
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Lanjut menggunakan lokasi meskipun kurang akurat
                        processLocation(lat, lng, accuracy, type);
                    } else {
                        // Mencoba ulang mendapatkan lokasi
                        getLocation(type);
                    }
                });
            } else {
                // Lokasi cukup akurat, langsung proses
                processLocation(lat, lng, accuracy, type);
            }
        };
        
        // Fungsi untuk memproses lokasi yang sudah didapatkan
        function processLocation(lat, lng, accuracy, type) {
            // Update field tersembunyi
            if (type === 'check-in') {
                document.getElementById('latitude').value = lat;
                document.getElementById('longitude').value = lng;
                document.getElementById('location').value = `${lat}, ${lng}`;
                
                // Update iframe dengan URL Google Maps
                const mapIframe = document.getElementById('map-iframe-in');
                mapIframe.src = `https://www.google.com/maps?q=${lat},${lng}&hl=id&z=16&output=embed`;
                
                // Update info lokasi dengan animasi dan info akurasi
                document.getElementById('location-info-in').innerHTML = `
                    <div class="text-success animate__animated animate__fadeIn">
                        <i class="fas fa-check-circle me-2"></i><strong>Lokasi terdeteksi:</strong>
                    </div>
                    <div class="mt-2 animate__animated animate__fadeIn" style="animation-delay: 0.2s">
                        <i class="fas fa-map-pin me-2" style="color: #8b0000;"></i> Latitude: ${lat.toFixed(6)}<br>
                        <i class="fas fa-map-pin me-2" style="color: #8b0000;"></i> Longitude: ${lng.toFixed(6)}<br>
                        <i class="fas fa-bullseye me-2" style="color: #8b0000;"></i> Akurasi: ±${Math.round(accuracy)}m
                    </div>
                `;
                
                // Cek apakah foto sudah diambil dan aktifkan tombol submit jika sudah
                const photoInput = document.getElementById('photo');
                if (photoInput && photoInput.files.length > 0) {
                    const submitBtn = document.getElementById('submitBtn');
                    submitBtn.disabled = false;
                    submitBtn.classList.add('btn-pulse');
                    console.log("Foto check-in dan lokasi sudah ada, tombol submit diaktifkan");
                }
            } else {
                document.getElementById('latitude_out').value = lat;
                document.getElementById('longitude_out').value = lng;
                document.getElementById('location_out').value = `${lat}, ${lng}`;
                
                // Update iframe dengan URL Google Maps
                const mapIframe = document.getElementById('map-iframe-out');
                mapIframe.src = `https://www.google.com/maps?q=${lat},${lng}&hl=id&z=16&output=embed`;
                
                // Update info lokasi dengan animasi dan info akurasi
                document.getElementById('location-info-out').innerHTML = `
                    <div class="text-success animate__animated animate__fadeIn">
                        <i class="fas fa-check-circle me-2"></i><strong>Lokasi terdeteksi:</strong>
                    </div>
                    <div class="mt-2 animate__animated animate__fadeIn" style="animation-delay: 0.2s">
                        <i class="fas fa-map-pin me-2" style="color: #1a8754;"></i> Latitude: ${lat.toFixed(6)}<br>
                        <i class="fas fa-map-pin me-2" style="color: #1a8754;"></i> Longitude: ${lng.toFixed(6)}<br>
                        <i class="fas fa-bullseye me-2" style="color: #1a8754;"></i> Akurasi: ±${Math.round(accuracy)}m
                    </div>
                `;
                
                // Cek apakah foto sudah diambil dan aktifkan tombol submit jika sudah
                const photoOutInput = document.getElementById('photo_out');
                if (photoOutInput && photoOutInput.files.length > 0) {
                    const submitBtnOut = document.getElementById('submitBtnOut');
                    submitBtnOut.disabled = false;
                    submitBtnOut.classList.add('btn-pulse');
                    console.log("Foto check-out dan lokasi sudah ada, tombol submit diaktifkan");
                }
            }
        }
        
        // Mulai mendapatkan lokasi
        navigator.geolocation.getCurrentPosition(successHandler, errorHandler, geoOptions);
    } else {
        // Browser tidak mendukung geolokasi
        Swal.fire({
            icon: 'error',
            title: 'Browser Tidak Mendukung',
            text: 'Geolocation tidak didukung oleh browser ini.',
            confirmButtonColor: '#8b0000',
            showClass: {
                popup: 'animate__animated animate__fadeInDown'
            },
            hideClass: {
                popup: 'animate__animated animate__fadeOutUp'
            }
        });
    }
}
</script>
<!-- SweetAlert2 untuk notifikasi yang lebih menarik -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Animate.css untuk animasi -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
@endsection