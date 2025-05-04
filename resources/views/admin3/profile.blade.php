@extends('layouts.header_admin3')

@section('title', 'Profil admin')

@section('additional_css')
<style>
/* Profile Page Specific Styles - Selaras dengan user.blade.php */
:root {
    --primary-color: #8b0000;
    --primary-light: #c13030;
    --transition-speed: 0.3s ease;
}

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
    background: linear-gradient(90deg, var(--primary-color), var(--primary-light));
    border-radius: 2px;
}

.dashboard-card {
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    transition: all var(--transition-speed);
    margin-bottom: 25px;
    overflow: hidden;
    border: none;
}

.dashboard-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 30px rgba(0,0,0,0.1);
}

.card-header {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-bottom: 1px solid #e0e0e0;
    padding: 18px 25px;
}

.card-header h3 {
    margin: 0;
    font-weight: 600;
    color: #333;
    display: flex;
    align-items: center;
}

.card-header h3 i {
    margin-right: 10px;
    color: var(--primary-color);
}

.section-title {
    position: relative;
    padding-bottom: 12px;
    margin-bottom: 25px;
    font-weight: 600;
    color: var(--primary-color);
}

.section-title::after {
    content: '';
    position: absolute;
    left: 0;
    bottom: 0;
    height: 3px;
    width: 60px;
    background: linear-gradient(90deg, var(--primary-color), var(--primary-light));
    border-radius: 2px;
}

.form-label {
    font-weight: 500;
    color: #555;
}

.form-control {
    border-radius: 8px;
    padding: 10px 15px;
    border: 1px solid #ddd;
    transition: all var(--transition-speed);
}

.form-control:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.25rem rgba(139, 0, 0, 0.15);
}

.btn-primary {
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
    border: none;
    border-radius: 8px;
    padding: 12px 25px;
    font-weight: 500;
    transition: all var(--transition-speed);
}

.btn-primary:hover {
    background: linear-gradient(135deg, var(--primary-light) 0%, var(--primary-color) 100%);
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(139, 0, 0, 0.2);
}

.btn-warning {
    background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);
    border: none;
    border-radius: 8px;
    padding: 12px 25px;
    font-weight: 500;
    transition: all var(--transition-speed);
}

.btn-warning:hover {
    background: linear-gradient(135deg, #fd7e14 0%, #ffc107 100%);
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(255, 193, 7, 0.2);
}

.profile-image-container {
    position: relative;
    width: 150px;
    height: 150px;
    margin: 0 auto 20px;
}

.profile-image {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    object-fit: cover;
    border: 5px solid white;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    transition: all var(--transition-speed);
}

.profile-image:hover {
    transform: scale(1.05);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.profile-info-item {
    margin-bottom: 15px;
    padding-bottom: 15px;
    border-bottom: 1px solid #eee;
}

.profile-info-item:last-child {
    border-bottom: none;
}

.alert {
    border-radius: 10px;
    border: none;
    box-shadow: 0 3px 10px rgba(0,0,0,0.05);
}

/* Animation Classes */
.fade-in {
    animation: fadeIn 0.5s ease-in-out;
}

.slide-in-left {
    animation: slideInLeft 0.5s ease-in-out;
}

.slide-in-right {
    animation: slideInRight 0.5s ease-in-out;
}

.bounce-in {
    animation: bounceIn 0.6s ease-in-out;
}

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

@keyframes bounceIn {
    0% { transform: scale(0.8); opacity: 0; }
    50% { transform: scale(1.05); opacity: 0.8; }
    100% { transform: scale(1); opacity: 1; }
}

/* Pulse Animation for Buttons */
@keyframes pulse-button {
    0% {
        box-shadow: 0 0 0 0 rgba(139, 0, 0, 0.7);
    }
    70% {
        box-shadow: 0 0 0 10px rgba(139, 0, 0, 0);
    }
    100% {
        box-shadow: 0 0 0 0 rgba(139, 0, 0, 0);
    }
}

.btn-pulse {
    animation: pulse-button 2s infinite;
}

/* Profile image animation */
@keyframes profile-pulse {
    0% { box-shadow: 0 0 0 0 rgba(139, 0, 0, 0.4); }
    70% { box-shadow: 0 0 0 15px rgba(139, 0, 0, 0); }
    100% { box-shadow: 0 0 0 0 rgba(139, 0, 0, 0); }
}

.profile-pulse {
    animation: profile-pulse 2s infinite;
}
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="dashboard-header animate__animated animate__fadeIn">
        <h2 class="mb-4">Profil Admin</h2>
        <p class="text-muted">Kelola informasi profil dan akun admin</p>
    </div>
    
    <!-- Alert Success -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show animate__animated animate__fadeIn" role="alert">
        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    <!-- Alert Error -->
    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show animate__animated animate__fadeIn" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    <div class="row">
        <!-- Informasi Profil -->
        <div class="col-md-6">
            <div class="dashboard-card animate__animated animate__fadeInLeft">
                <div class="card-header bg-primary">
                    <h3 class="card-title text"><i class="fas fa-user-circle"></i> Informasi Profil</h3>
                </div>
                <div class="card-body p-4">
                    
                    <form action="{{ route('admin3.profile.update') }}" method="POST" id="profileForm">
                        @csrf
                        @method('PUT')
                        
                        <div class="profile-info-item">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control @error('username') is-invalid @enderror" 
                                id="username" name="username" value="{{ old('username', $admin->username) }}">
                            @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="profile-info-item">
                            <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror" 
                                id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap', $admin->nama_lengkap) }}">
                            @error('nama_lengkap')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="profile-info-item">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                id="email" name="email" value="{{ old('email', $admin->email) }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="profile-info-item">
                                    <label for="created_at" class="form-label">Tanggal Dibuat</label>
                                    <input type="text" class="form-control" id="created_at" value="{{ $admin->created_at->format('d M Y H:i') }}" readonly>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="profile-info-item">
                                    <label for="updated_at" class="form-label">Terakhir Diupdate</label>
                                    <input type="text" class="form-control" id="updated_at" value="{{ $admin->updated_at->format('d M Y H:i') }}" readonly>
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-primary" id="updateProfileBtn">
                                <i class="fas fa-save me-2"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Ubah Password -->
        <div class="col-md-6">
            <div class="dashboard-card animate__animated animate__fadeInRight">
                <div class="card-header bg-warning">
                    <h3 class="card-title text"><i class="fas fa-key"></i> Ubah Password</h3>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin3.profile.update-password') }}" method="POST" id="changePasswordForm">
                        @csrf
                        @method('PUT')
                        
                        <div class="profile-info-item">
                            <label for="current_password" class="form-label">Password Saat Ini</label>
                            <input type="password" class="form-control @error('current_password') is-invalid @enderror" 
                                id="current_password" name="current_password">
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="profile-info-item">
                            <label for="password" class="form-label">Password Baru</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                id="password" name="password">
                            <div class="form-text">Password minimal 8 karakter</div>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="profile-info-item">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                            <input type="password" class="form-control" 
                                id="password_confirmation" name="password_confirmation">
                        </div>
                        
                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-warning text-white" id="changePasswordBtn">
                                <i class="fas fa-key me-2"></i> Ubah Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('additional_scripts')
<!-- SweetAlert2 untuk notifikasi yang lebih menarik -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Animate.css untuk animasi -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Animasi elemen saat halaman dimuat
        setTimeout(function() {
            const cards = document.querySelectorAll('.dashboard-card');
            cards.forEach(function(card, index) {
                setTimeout(function() {
                    card.classList.add('bounce-in');
                }, index * 100);
            });
        }, 300);
        
        // Handle profile form submission
        const profileForm = document.getElementById('profileForm');
        if (profileForm) {
            profileForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const submitBtn = document.getElementById('updateProfileBtn');
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Menyimpan...';
                }
                
                this.submit();
            });
        }
        
        // Handle password change form submission
        const changePasswordForm = document.getElementById('changePasswordForm');
        if (changePasswordForm) {
            changePasswordForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const password = document.getElementById('password');
                const passwordConfirmation = document.getElementById('password_confirmation');
                
                if (!password || !passwordConfirmation) {
                    return;
                }
                
                if (password.value !== passwordConfirmation.value) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Password Tidak Cocok',
                        text: 'Password baru dan konfirmasi password harus sama',
                        confirmButtonColor: '#8b0000'
                    });
                    return;
                }
                
                if (password.value.length < 8) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Password Terlalu Pendek',
                        text: 'Password minimal 8 karakter',
                        confirmButtonColor: '#8b0000'
                    });
                    return;
                }
                
                const submitBtn = document.getElementById('changePasswordBtn');
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Menyimpan...';
                }
                
                this.submit();
            });
        }
        
        // Handle errors from server - menggunakan try-catch untuk menangani error
        // Alternatif: tambahkan elemen hidden dengan data notifikasi
// di view Anda, lalu baca nilai tersebut dengan JavaScript
const errorData = document.getElementById('error-data');
if (errorData && errorData.value) {
    Swal.fire({
        icon: 'error',
        title: 'Terjadi Kesalahan',
        text: errorData.value,
        confirmButtonColor: '#8b0000'
    });
}
    });
</script>
@endsection