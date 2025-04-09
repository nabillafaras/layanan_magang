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
                                    <div class="camera-box" onclick="document.getElementById('photo').click()">
                                        <i class="fas fa-camera camera-icon"></i>
                                        <p class="mb-0">Ambil Foto Absensi</p>
                                    </div>
                                    <input type="file" id="photo" name="photo" accept="image/*" capture="user" class="d-none" required>
                                    <div class="photo-preview-container">
                                        <img id="photoPreview" class="img-fluid preview-image d-none" alt="Preview">
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
                                    <div class="camera-box" onclick="document.getElementById('photo_out').click()">
                                        <i class="fas fa-camera camera-icon" style="color: #1a8754;"></i>
                                        <p class="mb-0">Ambil Foto Absensi</p>
                                    </div>
                                    <input type="file" id="photo_out" name="photo" accept="image/*" capture="user" class="d-none" required>
                                    <div class="photo-preview-container">
                                        <img id="photoPreviewOut" class="img-fluid preview-image d-none" alt="Preview">
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
                                            <span class="badge {{ $record->status === 'hadir' ? 'bg-success' : ($record->status === 'terlambat' ? 'bg-warning' : 'bg-danger') }}">
                                                {{ $record->status }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    
                </div>
            </div>
        </div>
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
        setInterval(function() {
            const now = new Date();
            // Tambahkan animasi pulse saat waktu berubah
            timeDisplay.classList.add('animate__animated', 'animate__pulse');
            timeDisplay.textContent = now.toLocaleTimeString('id-ID');
            setTimeout(() => {
                timeDisplay.classList.remove('animate__animated', 'animate__pulse');
            }, 1000);
        }, 1000);

        // Photo preview for check-in with animation
        const photoInput = document.getElementById('photo');
        if (photoInput) {
            photoInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const preview = document.getElementById('photoPreview');
                        preview.src = e.target.result;
                        preview.classList.remove('d-none');
                        preview.classList.add('animate__animated', 'animate__fadeIn');
                    }
                    reader.readAsDataURL(file);
                }
            });
        }

        // Photo preview for check-out with animation
        const photoOutInput = document.getElementById('photo_out');
        if (photoOutInput) {
            photoOutInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const preview = document.getElementById('photoPreviewOut');
                        preview.src = e.target.result;
                        preview.classList.remove('d-none');
                        preview.classList.add('animate__animated', 'animate__fadeIn');
                    }
                    reader.readAsDataURL(file);
                }
            });
        }

        // Tambahkan function helper untuk AJAX dengan CSRF token
        function fetchWithCSRF(url, options = {}) {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            return fetch(url, {
                ...options,
                headers: {
                    ...options.headers,
                    'X-CSRF-TOKEN': csrfToken,
                }
            });
        }

        // Gunakan untuk form checkIn dengan animasi loading
        const checkInForm = document.getElementById('absensiForm');
        if (checkInForm) {
            checkInForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                
                // Tambahkan waktu sebenarnya ke form
                document.getElementById('real_time').value = new Date().toISOString();
                
                // Tampilkan loading pada tombol
                const submitBtn = document.getElementById('submitBtn');
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Memproses...';
                submitBtn.disabled = true;
                submitBtn.classList.remove('btn-pulse');
                
                const formData = new FormData(checkInForm);
                
                try {
                    const response = await fetchWithCSRF('/attendance/check-in', {
                        method: 'POST',
                        body: formData
                    });
                    
                    const data = await response.json();
                    console.log('Response:', data);
                    
                    if (data.success) {
                        // Tampilkan notifikasi sukses yang menarik
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
                        // Tampilkan notifikasi error yang menarik
                        Swal.fire({
                            icon: 'error',
                            title: 'Absensi Gagal',
                            text: data.message,
                            confirmButtonColor: '#8b0000',
                            showClass: {
                                popup: 'animate__animated animate__fadeInDown'
                            },
                            hideClass: {
                                popup: 'animate__animated animate__fadeOutUp'
                            }
                        });
                        
                        submitBtn.innerHTML = '<i class="fas fa-check-circle me-2"></i> Absen Masuk';
                        submitBtn.disabled = false;
                        submitBtn.classList.add('btn-pulse');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan',
                        text: 'Terjadi kesalahan saat mengirim data absensi',
                        confirmButtonColor: '#8b0000',
                        showClass: {
                            popup: 'animate__animated animate__fadeInDown'
                        },
                        hideClass: {
                            popup: 'animate__animated animate__fadeOutUp'
                        }
                    });
                    
                    submitBtn.innerHTML = '<i class="fas fa-check-circle me-2"></i> Absen Masuk';
                    submitBtn.disabled = false;
                    submitBtn.classList.add('btn-pulse');
                }
            });
        }

        // Gunakan juga untuk form checkOut dengan animasi loading
        const checkOutForm = document.getElementById('checkoutForm');
        if (checkOutForm) {
            checkOutForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                
                // Tambahkan waktu sebenarnya ke form
                document.getElementById('real_time_out').value = new Date().toISOString();
                
                // Tampilkan loading pada tombol
                const submitBtn = document.getElementById('submitBtnOut');
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Memproses...';
                submitBtn.disabled = true;
                submitBtn.classList.remove('btn-pulse');
                
                const formData = new FormData(checkOutForm);
                
                try {
                    const response = await fetchWithCSRF('/attendance/check-out', {
                        method: 'POST',
                        body: formData
                    });
                    
                    const data = await response.json();
                    console.log('Response:', data);
                    
                    if (data.success) {
                        // Tampilkan notifikasi sukses yang menarik
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
                        // Tampilkan notifikasi error yang menarik
                        Swal.fire({
                            icon: 'error',
                            title: 'Absensi Gagal',
                            text: data.message,
                            confirmButtonColor: '#1a8754',
                            showClass: {
                                popup: 'animate__animated animate__fadeInDown'
                            },
                            hideClass: {
                                popup: 'animate__animated animate__fadeOutUp'
                            }
                        });
                        
                        submitBtn.innerHTML = '<i class="fas fa-check-circle me-2"></i> Absen Pulang';
                        submitBtn.disabled = false;
                        submitBtn.classList.add('btn-pulse');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan',
                        text: 'Terjadi kesalahan saat mengirim data absensi',
                        confirmButtonColor: '#1a8754',
                        showClass: {
                            popup: 'animate__animated animate__fadeInDown'
                        },
                        hideClass: {
                            popup: 'animate__animated animate__fadeOutUp'
                        }
                    });
                    
                    submitBtn.innerHTML = '<i class="fas fa-check-circle me-2"></i> Absen Pulang';
                    submitBtn.disabled = false;
                    submitBtn.classList.add('btn-pulse');
                }
            });
        }
        
        // Efek hover pada baris tabel
        const tableRows = document.querySelectorAll('tbody tr');
        tableRows.forEach(row => {
            row.addEventListener('mouseenter', function() {
                this.style.transition = 'all 0.3s ease';
                this.style.backgroundColor = 'rgba(139, 0, 0, 0.03)';
            });
            
            row.addEventListener('mouseleave', function() {
                this.style.backgroundColor = '';
            });
        });
        
        // Animasi untuk elemen tabel saat scroll
        const animateOnScroll = function() {
            const rows = document.querySelectorAll('#attendanceHistory tr');
            rows.forEach(row => {
                const rowTop = row.getBoundingClientRect().top;
                const rowBottom = row.getBoundingClientRect().bottom;
                const isVisible = (rowTop >= 0) && (rowBottom <= window.innerHeight);
                
                if (isVisible) {
                    row.classList.add('animate__animated', 'animate__fadeIn');
                }
            });
        };
        
        // Jalankan animasi saat scroll
        window.addEventListener('scroll', animateOnScroll);
        animateOnScroll(); // Jalankan sekali saat halaman dimuat
    });

    // Fungsi untuk mendapatkan lokasi dan menampilkannya di iframe Google Maps
    function getLocation(type) {
        if (navigator.geolocation) {
            // Tampilkan indikator loading dengan animasi
            const infoElement = document.getElementById(`location-info-${type === 'check-in' ? 'in' : 'out'}`);
            infoElement.innerHTML = '<div class="text-center animate__animated animate__pulse animate__infinite"><i class="fas fa-spinner fa-spin me-2"></i> Mendapatkan lokasi...</div>';
            
            navigator.geolocation.getCurrentPosition(function(position) {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;
                
                // Update field tersembunyi
                if (type === 'check-in') {
                    document.getElementById('latitude').value = lat;
                    document.getElementById('longitude').value = lng;
                    document.getElementById('location').value = `${lat}, ${lng}`;
                    
                    // Update iframe dengan URL Google Maps
                    const mapIframe = document.getElementById('map-iframe-in');
                    mapIframe.src = `https://www.google.com/maps?q=${lat},${lng}&hl=id&z=16&output=embed`;
                    
                    // Update info lokasi dengan animasi
                    document.getElementById('location-info-in').innerHTML = `
                        <div class="text-success animate__animated animate__fadeIn">
                            <i class="fas fa-check-circle me-2"></i><strong>Lokasi terdeteksi:</strong>
                        </div>
                        <div class="mt-2 animate__animated animate__fadeIn" style="animation-delay: 0.2s">
                            <i class="fas fa-map-pin me-2" style="color: #8b0000;"></i> Latitude: ${lat.toFixed(6)}<br>
                            <i class="fas fa-map-pin me-2" style="color: #8b0000;"></i> Longitude: ${lng.toFixed(6)}
                        </div>
                    `;
                    
                    // Aktifkan tombol submit dengan animasi
                    const submitBtn = document.getElementById('submitBtn');
                    submitBtn.disabled = false;
                    submitBtn.classList.add('animate__animated', 'animate__pulse');
                    
                } else {
                    document.getElementById('latitude_out').value = lat;
                    document.getElementById('longitude_out').value = lng;
                    document.getElementById('location_out').value = `${lat}, ${lng}`;
                    
                    // Update iframe dengan URL Google Maps
                    const mapIframe = document.getElementById('map-iframe-out');
                    mapIframe.src = `https://www.google.com/maps?q=${lat},${lng}&hl=id&z=16&output=embed`;
                    
                    // Update info lokasi dengan animasi
                    document.getElementById('location-info-out').innerHTML = `
                        <div class="text-success animate__animated animate__fadeIn">
                            <i class="fas fa-check-circle me-2"></i><strong>Lokasi terdeteksi:</strong>
                        </div>
                        <div class="mt-2 animate__animated animate__fadeIn" style="animation-delay: 0.2s">
                            <i class="fas fa-map-pin me-2" style="color: #1a8754;"></i> Latitude: ${lat.toFixed(6)}<br>
                            <i class="fas fa-map-pin me-2" style="color: #1a8754;"></i> Longitude: ${lng.toFixed(6)}
                        </div>
                    `;
                    
                    // Aktifkan tombol submit dengan animasi
                    const submitBtn = document.getElementById('submitBtnOut');
                    submitBtn.disabled = false;
                    submitBtn.classList.add('animate__animated', 'animate__pulse');
                }
                
            }, function(error) {
                let pesanError = 'Error mendapatkan lokasi: ';
                
                switch(error.code) {
                    case error.PERMISSION_DENIED:
                        pesanError += 'Izin akses lokasi ditolak.';
                        break;
                    case error.POSITION_UNAVAILABLE:
                        pesanError += 'Informasi lokasi tidak tersedia.';
                        break;
                    case error.TIMEOUT:
                        pesanError += 'Waktu permintaan lokasi habis.';
                        break;
                    case error.UNKNOWN_ERROR:
                        pesanError += 'Terjadi kesalahan yang tidak diketahui.';
                        break;
                }
                
                // Tampilkan error dengan alert yang lebih menarik
                Swal.fire({
                    icon: 'error',
                    title: 'Lokasi Tidak Ditemukan',
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
            }, {
                maximumAge: 0,      // Tidak menggunakan cache
                timeout: 10000,     // 10 detik
                enableHighAccuracy: true
            });
        } else {
            // Tampilkan error dengan alert yang lebih menarik
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