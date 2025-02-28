<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>User Dashboard- Kementerian Sosial RI</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- ... rest of head content ... -->
</head>
<style>
    body {
        font-family: 'Calibri', sans-serif;
        background-color: #f8f9fa;
    }
    
    .sidebar {
        background-color: #8b0000;
        min-height: 100vh;
        color: white;
    }
    
    .sidebar .nav-link {
        color: white;
        padding: 10px 20px;
        margin: 5px 0;
        border-radius: 5px;
    }
    
    .sidebar .nav-link:hover {
        background-color: rgba(255,255,255,0.1);
    }
    
    .sidebar .nav-link.active {
        background-color: rgba(255,255,255,0.2);
    }
    
    .main-content {
        padding: 20px;
    }
    
    .navbar {
        background-color: white;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .user-profile {
        padding: 20px;
        text-align: center;
        border-bottom: 1px solid rgba(255,255,255,0.1);
        margin-bottom: 20px;
    }
    
    .user-profile img {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        margin-bottom: 10px;
    }

    .dashboard-card {
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        transition: transform 0.2s;
    }
    
    .dashboard-card:hover {
        transform: translateY(-5px);
    }
    
    .stat-card {
        background: white;
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 20px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .stat-card h3 {
        color: #8b0000;
        margin-bottom: 5px;
    }
    
    .stat-card p {
        color: #666;
        margin-bottom: 0;
    }
</style>


<body>
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 px-0 sidebar">
            <div class="text-center py-4">
                <img src="{{ asset('images/ic_kemensos_1.png') }}" alt="Logo" height="60">
                <div class="user-profile">
                    <h6 class="mb-0">{{ auth()->user()->nama_lengkap }}</h6>
                    <small>{{ auth()->user()->nomor_pendaftaran }}</small>
                </div>
            </div>
            
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('user') ? 'active' : '' }}" href="{{ route('user') }}">
                        <i class="fas fa-home me-2"></i>Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#absensiCollapse" data-bs-toggle="collapse">
                        <i class="fas fa-id-badge me-2"></i>Absensi
                        
                    </a>
                    <div class="collapse" id="absensiCollapse">
                        <ul class="nav flex-column ms-3">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('attendance') }}">Masuk</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Izin</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Sakit</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#laporanCollapse" data-bs-toggle="collapse">
                        <i class="fas fa-file-alt me-2"></i>Laporan
                    </a>
                    <div class="collapse" id="laporanCollapse">
                        <ul class="nav flex-column ms-3">
                            <li class="nav-item">
                                <a class="nav-link" href="#">Laporan Bulanan</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Laporan Akhir</a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="col-md-9 col-lg-10 px-0">
            <!-- Top Navbar -->
            <nav class="navbar navbar-expand-lg">
                <div class="container-fluid">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    
                    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                    {{ auth()->user()->nama_lengkap }}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <form action="{{ route('logout') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="dropdown-item">Logout</button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <!-- Absensi Content -->
            <div class="container py-4">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header d-flex align-items-center">
                                <i class="fas fa-clock me-2"></i>
                                <h5 class="mb-0">Absensi {{ request()->segment(2) === 'masuk' ? 'Masuk' : 'Pulang' }}</h5>
                            </div>
                            <div class="card-body">
                                <!-- Time Display -->
                                <div class="text-center mb-4">
    <h2 class="current-time">{{ now()->format('H:i:s') }}</h2>
    <p class="current-date">{{ now()->isoFormat('dddd, D MMMM Y') }}</p>
</div>

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<!-- Check-in Form -->
@if(!isset($hasCheckedIn) || !$hasCheckedIn)
<form action="{{ route('attendance.check-in') }}" method="POST" enctype="multipart/form-data" id="absensiForm">
    @csrf
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <i class="fas fa-sign-in-alt me-2"></i> Absen Masuk
        </div>
        <div class="card-body">
            <div class="mb-3">
                <label class="form-label">Lokasi</label>
                <div class="input-group">
                    <input type="text" class="form-control" name="location" id="location" required>
                    <button type="button" class="btn btn-outline-secondary" onclick="getLocation()">
                        <i class="fas fa-map-marker-alt"></i> Get Location
                    </button>
                </div>
                <input type="hidden" name="latitude" id="latitude">
                <input type="hidden" name="longitude" id="longitude">
            </div>

            <div class="mb-3">
                <label class="form-label">Foto</label>
                <div class="d-flex flex-column align-items-center">
                    <div class="border rounded p-3 text-center mb-3" style="cursor: pointer" onclick="document.getElementById('photo').click()">
                        <i class="fas fa-camera fa-2x mb-2"></i>
                        <p class="mb-0">Ambil Foto</p>
                    </div>
                    <input type="file" id="photo" name="photo" accept="image/*" capture="user" class="d-none" required>
                    <img id="photoPreview" class="img-fluid rounded d-none" alt="Preview">
                </div>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary" id="submitBtn">
                    Absen Masuk
                </button>
            </div>
        </div>
    </div>
</form>
@endif

<!-- Check-out Form - Hanya muncul jika sudah check-in -->
@if(isset($hasCheckedIn) && $hasCheckedIn && (!isset($hasCheckedOut) || !$hasCheckedOut))
<form action="{{ route('attendance.check-out') }}" method="POST" enctype="multipart/form-data" id="checkoutForm">
    @csrf
    <div class="card mb-4">
        <div class="card-header bg-success text-white">
            <i class="fas fa-sign-out-alt me-2"></i> Absen Pulang
        </div>
        <div class="card-body">
            <div class="mb-3">
                <label class="form-label">Lokasi</label>
                <div class="input-group">
                    <input type="text" class="form-control" name="location" id="location_out" required>
                    <button type="button" class="btn btn-outline-secondary" onclick="getLocationOut()">
                        <i class="fas fa-map-marker-alt"></i> Get Location
                    </button>
                </div>
                <input type="hidden" name="latitude" id="latitude_out">
                <input type="hidden" name="longitude" id="longitude_out">
            </div>

            <div class="mb-3">
                <label class="form-label">Foto</label>
                <div class="d-flex flex-column align-items-center">
                    <div class="border rounded p-3 text-center mb-3" style="cursor: pointer" onclick="document.getElementById('photo_out').click()">
                        <i class="fas fa-camera fa-2x mb-2"></i>
                        <p class="mb-0">Ambil Foto</p>
                    </div>
                    <input type="file" id="photo_out" name="photo" accept="image/*" capture="user" class="d-none" required>
                    <img id="photoPreviewOut" class="img-fluid rounded d-none" alt="Preview">
                </div>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-success" id="submitBtnOut">
                    Absen Pulang
                </button>
            </div>
        </div>
    </div>
</form>
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
    </div>
</div>



<script>
document.addEventListener('DOMContentLoaded', function() {
    // Update time every second
    setInterval(function() {
        const now = new Date();
        document.querySelector('.current-time').textContent = now.toLocaleTimeString('id-ID');
    }, 1000);

    // Photo preview for check-in
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
                }
                reader.readAsDataURL(file);
            }
        });
    }

    // Photo preview for check-out
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

    // Gunakan untuk form checkIn
    const checkInForm = document.getElementById('absensiForm');
    if (checkInForm) {
        checkInForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(checkInForm);
            
            try {
                const response = await fetchWithCSRF('/attendance/check-in', {
                    method: 'POST',
                    body: formData
                });
                
                const data = await response.json();
                console.log('Response:', data); // Untuk debugging
                
                if (data.success) {
                    alert(data.message);
                    location.reload();
                } else {
                    alert(data.message);
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat mengirim data absensi');
            }
        });
    }

    // Gunakan juga untuk form checkOut
    const checkOutForm = document.getElementById('checkoutForm');
    if (checkOutForm) {
        checkOutForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(checkOutForm);
            
            try {
                const response = await fetchWithCSRF('/attendance/check-out', {
                    method: 'POST',
                    body: formData
                });
                
                const data = await response.json();
                console.log('Response:', data); // Untuk debugging
                
                if (data.success) {
                    alert(data.message);
                    location.reload();
                } else {
                    alert(data.message);
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat mengirim data absensi');
            }
        });
    }
});

// Geolocation for check-in
function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            document.getElementById('latitude').value = position.coords.latitude;
            document.getElementById('longitude').value = position.coords.longitude;
            document.getElementById('location').value = `${position.coords.latitude}, ${position.coords.longitude}`;
        }, function(error) {
            alert('Error mendapatkan lokasi: ' + error.message);
        });
    } else {
        alert('Geolocation tidak didukung oleh browser ini.');
    }
}

// Geolocation for check-out
function getLocationOut() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            document.getElementById('latitude_out').value = position.coords.latitude;
            document.getElementById('longitude_out').value = position.coords.longitude;
            document.getElementById('location_out').value = `${position.coords.latitude}, ${position.coords.longitude}`;
        }, function(error) {
            alert('Error mendapatkan lokasi: ' + error.message);
        });
    } else {
        alert('Geolocation tidak didukung oleh browser ini.');
    }
}
</script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>