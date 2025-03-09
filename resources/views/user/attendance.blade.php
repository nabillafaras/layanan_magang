@extends('layouts.header_user')

@section('title', 'Absensi - Kementerian Sosial RI')

@section('additional_css')
<style>
    .map-container {
        width: 100%;
        height: 300px;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 12px;
        margin-bottom: 20px;
    }
    .location-info {
        background-color: #f8f9fa;
        padding: 15px;
        border-radius: 12px;
        margin-top: 10px;
        border: 1px solid #dee2e6;
        font-size: 14px;
    }
    .attendance-card {
        border-radius: 15px;
        border: none;
        overflow: hidden;
        box-shadow: 0 4px 25px rgba(0,0,0,0.1);
        margin-bottom: 30px;
        transition: all 0.3s ease;
    }
    .attendance-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    }
    .card-header {
        background-color: #fff;
        border-bottom: 1px solid #f0f0f0;
        padding: 20px;
    }
    .card-header h5 {
        margin: 0;
        font-weight: 600;
        color: #333;
    }
    .time-display {
        background-color: #8b0000;
        color: white;
        padding: 20px;
        border-radius: 12px;
        margin-bottom: 30px;
        text-align: center;
        box-shadow: 0 4px 15px rgba(139, 0, 0, 0.2);
    }
    .time-display h1 {
        font-size: 3rem;
        font-weight: 700;
        margin: 0;
        letter-spacing: 2px;
    }
    .time-display p {
        font-size: 1.1rem;
        margin-top: 5px;
        letter-spacing: 1px;
    }
    .action-btn {
        font-weight: 600;
        padding: 12px 25px;
        border-radius: 50px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }
    .action-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 15px rgba(0,0,0,0.15);
    }
    .check-in-btn {
        background-color: #8b0000;
        border-color: #8b0000;
    }
    .check-in-btn:hover {
        background-color: #700000;
        border-color: #700000;
    }
    .check-out-btn {
        background-color: #1a8754;
        border-color: #1a8754;
    }
    .check-out-btn:hover {
        background-color: #146c43;
        border-color: #146c43;
    }
    .location-btn {
        background-color: #f8f9fa;
        color: #333;
        border: 1px solid #dee2e6;
        padding: 12px 20px;
        border-radius: 50px;
        transition: all 0.3s ease;
        font-weight: 500;
    }
    .location-btn:hover {
        background-color: #e9ecef;
    }
    .camera-box {
        border: 2px dashed #dee2e6;
        border-radius: 15px;
        padding: 30px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .camera-box:hover {
        border-color: #8b0000;
        background-color: #fff9f9;
    }
    .camera-icon {
        font-size: 40px;
        color: #8b0000;
        margin-bottom: 15px;
    }
    .history-table {
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    }
    .history-table th {
        background-color: #f8f9fa;
        border-top: none;
        padding: 15px;
        font-weight: 600;
    }
    .history-table td {
        padding: 15px;
        vertical-align: middle;
    }
    .status-badge {
        padding: 8px 15px;
        border-radius: 50px;
        font-weight: 500;
        font-size: 12px;
    }
    .attendance-section {
        padding: 30px;
        background-color: #fff;
        border-radius: 15px;
        box-shadow: 0 4px 25px rgba(0,0,0,0.05);
    }
    .section-title {
        color: #8b0000;
        font-weight: 700;
        margin-bottom: 20px;
        border-left: 5px solid #8b0000;
        padding-left: 15px;
    }
    .form-card {
        background-color: #fff;
        border-radius: 15px;
        border: 1px solid #f0f0f0;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    .form-card:hover {
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
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
    }
    .photo-preview-container {
        text-align: center;
        margin-top: 20px;
    }
</style>
@endsection

@section('content')
<!-- Page Content -->
<div class="main-content">
    <div class="container-fluid p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="section-title">Sistem Absensi</h2>
        </div>

        <!-- Absensi Content -->
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="attendance-card">
                    <div class="card-header d-flex align-items-center">
                        <i class="fas fa-clock me-2" style="color: #8b0000;"></i>
                        <h5>Absensi Masuk Peserta</h5>
                    </div>
                    <div class="card-body p-4">
                        <!-- Time Display -->
                        <div class="time-display mb-4">
                            <h1 class="current-time">{{ now()->format('H:i:s') }}</h1>
                            <p class="current-date">{{ now()->isoFormat('dddd, D MMMM Y') }}</p>
                        </div>

                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-triangle me-2"></i> {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <!-- Check-in Form -->
                        @if(!isset($hasCheckedIn) || !$hasCheckedIn)
                        <div class="form-card mb-4">
                            <div class="form-header bg-primary">
                                <i class="fas fa-sign-in-alt me-2"></i> Absen Masuk
                            </div>
                            <div class="form-body">
                                <form action="{{ route('attendance.check-in') }}" method="POST" enctype="multipart/form-data" id="absensiForm">
                                    @csrf
                                    <div class="mb-4">
                                        <label class="form-label fw-bold">Lokasi</label>
                                        <button type="button" class="location-btn w-100 mb-3" onclick="getLocation('check-in')">
                                            <i class="fas fa-map-marker-alt me-2" style="color: #8b0000;"></i> Dapatkan Lokasi Saat Ini
                                        </button>
                                        <div id="map-container-in" class="map-container">
                                            <iframe id="map-iframe-in" width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                                        </div>
                                        <div class="location-info" id="location-info-in">
                                            <i class="fas fa-info-circle me-2" style="color: #8b0000;"></i>
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
                                        <button type="submit" class="action-btn check-in-btn" id="submitBtn" disabled>
                                            <i class="fas fa-check-circle me-2"></i> Absen Masuk
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        @endif

                        <!-- Check-out Form - Hanya muncul jika sudah check-in -->
                        @if(isset($hasCheckedIn) && $hasCheckedIn && (!isset($hasCheckedOut) || !$hasCheckedOut))
                        <div class="form-card mb-4">
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
                                        <button type="submit" class="action-btn check-out-btn" id="submitBtnOut" disabled>
                                            <i class="fas fa-check-circle me-2"></i> Absen Pulang
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        @endif

                        <!-- Attendance History -->
                        <div class="mt-5">
                            <h5>Riwayat Absensi</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Masuk</th>
                                            <th>Pulang</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody id="attendanceHistory">
                                        @foreach($attendanceHistory ?? [] as $record)
                                        <tr>
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
</div>
@endsection

@section('additional_scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Efek animasi pada load halaman
        const attendanceCard = document.querySelector('.attendance-card');
        if (attendanceCard) {
            attendanceCard.style.opacity = '0';
            attendanceCard.style.transform = 'translateY(20px)';
            setTimeout(() => {
                attendanceCard.style.transition = 'all 0.5s ease';
                attendanceCard.style.opacity = '1';
                attendanceCard.style.transform = 'translateY(0)';
            }, 100);
        }
        
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
                        preview.style.opacity = '0';
                        setTimeout(() => {
                            preview.style.transition = 'opacity 0.5s ease';
                            preview.style.opacity = '1';
                        }, 100);
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
                        preview.style.opacity = '0';
                        setTimeout(() => {
                            preview.style.transition = 'opacity 0.5s ease';
                            preview.style.opacity = '1';
                        }, 100);
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
                            confirmButtonColor: '#8b0000'
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        // Tampilkan notifikasi error yang menarik
                        Swal.fire({
                            icon: 'error',
                            title: 'Absensi Gagal',
                            text: data.message,
                            confirmButtonColor: '#8b0000'
                        });
                        
                        submitBtn.innerHTML = '<i class="fas fa-check-circle me-2"></i> Absen Masuk';
                        submitBtn.disabled = false;
                    }
                } catch (error) {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan',
                        text: 'Terjadi kesalahan saat mengirim data absensi',
                        confirmButtonColor: '#8b0000'
                    });
                    
                    submitBtn.innerHTML = '<i class="fas fa-check-circle me-2"></i> Absen Masuk';
                    submitBtn.disabled = false;
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
                            confirmButtonColor: '#1a8754'
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        // Tampilkan notifikasi error yang menarik
                        Swal.fire({
                            icon: 'error',
                            title: 'Absensi Gagal',
                            text: data.message,
                            confirmButtonColor: '#1a8754'
                        });
                        
                        submitBtn.innerHTML = '<i class="fas fa-check-circle me-2"></i> Absen Pulang';
                        submitBtn.disabled = false;
                    }
                } catch (error) {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan',
                        text: 'Terjadi kesalahan saat mengirim data absensi',
                        confirmButtonColor: '#1a8754'
                    });
                    
                    submitBtn.innerHTML = '<i class="fas fa-check-circle me-2"></i> Absen Pulang';
                    submitBtn.disabled = false;
                }
            });
        }
    });

    // Fungsi untuk mendapatkan lokasi dan menampilkannya di iframe Google Maps
    function getLocation(type) {
        if (navigator.geolocation) {
            // Tampilkan indikator loading dengan animasi
            const infoElement = document.getElementById(`location-info-${type === 'check-in' ? 'in' : 'out'}`);
            infoElement.innerHTML = '<div class="text-center"><i class="fas fa-spinner fa-spin"></i> Mendapatkan lokasi...</div>';
            
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
                        <div class="text-success">
                            <i class="fas fa-check-circle me-2"></i><strong>Lokasi terdeteksi:</strong>
                        </div>
                        <div class="mt-2">
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
                        <div class="text-success">
                            <i class="fas fa-check-circle me-2"></i><strong>Lokasi terdeteksi:</strong>
                        </div>
                        <div class="mt-2">
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
                    confirmButtonColor: '#8b0000'
                });
                
                document.getElementById(`location-info-${type === 'check-in' ? 'in' : 'out'}`).innerHTML = 
                    `<div class="text-danger"><i class="fas fa-exclamation-triangle me-2"></i> ${pesanError}</div>`;
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
                confirmButtonColor: '#8b0000'
            });
        }
    }
</script>
<!-- SweetAlert2 untuk notifikasi yang lebih menarik -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Animate.css untuk animasi -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
@endsection