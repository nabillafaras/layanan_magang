@extends('layouts.header_user')

@section('title', 'Profil Saya - Kementerian Sosial RI')

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

.card-header h5 {
    margin: 0;
    font-weight: 600;
    color: #333;
    display: flex;
    align-items: center;
}

.card-header h5 i {
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

.btn-outline-primary {
    color: var(--primary-color);
    border-color: var(--primary-color);
    border-radius: 8px;
    padding: 12px 25px;
    font-weight: 500;
    transition: all var(--transition-speed);
}

.btn-outline-primary:hover {
    background-color: var(--primary-color);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(139, 0, 0, 0.1);
}

.nav-tabs {
    border-bottom: 1px solid #dee2e6;
    margin-bottom: 20px;
}

.nav-tabs .nav-link {
    border: none;
    border-bottom: 3px solid transparent;
    border-radius: 0;
    padding: 10px 20px;
    font-weight: 500;
    color: #555;
    transition: all var(--transition-speed);
}

.nav-tabs .nav-link:hover {
    border-color: rgba(139, 0, 0, 0.3);
    color: var(--primary-color);
}

.nav-tabs .nav-link.active {
    color: var(--primary-color);
    background-color: transparent;
    border-color: var(--primary-color);
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

.profile-image-edit {
    position: absolute;
    bottom: 0;
    right: 0;
    background: var(--primary-color);
    color: white;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    box-shadow: 0 3px 10px rgba(0,0,0,0.2);
    transition: all var(--transition-speed);
}

.profile-image-edit:hover {
    transform: scale(1.1);
    background: var(--primary-light);
}

.profile-info-item {
    margin-bottom: 15px;
    padding-bottom: 15px;
    border-bottom: 1px solid #eee;
}

.profile-info-item:last-child {
    border-bottom: none;
}

.profile-info-label {
    font-weight: 600;
    color: #555;
    margin-bottom: 5px;
}

.profile-info-value {
    color: #333;
}

.badge-status {
    padding: 8px 15px;
    border-radius: 30px;
    font-weight: 500;
    font-size: 0.85rem;
}

.badge-active {
    background-color: #28a745;
}

.badge-pending {
    background-color: #ffc107;
    color: #212529;
}

.badge-rejected {
    background-color: #dc3545;
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
<div class="container-fluid p-4">
    <div class="dashboard-header animate__animated animate__fadeIn">
        <h2 class="mb-4">Profil Saya</h2>
        <p class="text-muted">Kelola informasi profil dan akun Anda</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show animate__animated animate__fadeIn" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <!-- Profile Summary Card -->
        <div class="col-lg-4 mb-4">
            <div class="dashboard-card animate__animated animate__fadeInLeft">
                <div class="card-header">
                    <h5><i class="fas fa-user-circle"></i> Informasi Profil</h5>
                </div>
                <div class="card-body p-4 text-center">
                <div class="profile-image-container mb-4">
                    @if(isset($user->foto_profile))
                        <img src="{{ asset('storage/' . $user->foto_profile) }}" alt="Profile" class="profile-image profile-pulse">
                    @else
                        <img src="{{ asset('assets/images/default-profile.png') }}" alt="Profile" class="profile-image">
                    @endif
                    </div>
                    
                    <h4 class="mb-1">{{ $user->nama_lengkap }}</h4>
                    <p class="text-muted mb-3">{{ $user->nomor_pendaftaran }}</p>
                    
                    <div class="mb-3">
                        @if($user->status == 'Diterima')
                            <span class="badge bg-success badge-status">
                                <i class="fas fa-check-circle me-1"></i> Diterima
                            </span>
                        @elseif($user->status == 'Diproses')
                            <span class="badge bg-warning badge-status">
                                <i class="fas fa-clock me-1"></i> Proses
                            </span>
                        @elseif($user->status == 'Ditolak')
                            <span class="badge bg-danger badge-status">
                                <i class="fas fa-times-circle me-1"></i> Ditolak
                            </span>
                        @endif
                    </div>
                    
                    <div class="d-grid gap-2 mt-4">
                        <button class="btn btn-outline-primary" type="button" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                            <i class="fas fa-key me-2"></i> Ubah Password
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Internship Period Card -->
            <div class="dashboard-card animate__animated animate__fadeInLeft" style="animation-delay: 0.1s">
                <div class="card-header">
                    <h5><i class="fas fa-calendar-alt"></i> Periode Magang</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="mb-3">
                                <p class="text-muted mb-1">Tanggal Mulai</p>
                                <h5>{{ $tanggalMulai ?? '-' }}</h5>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <p class="text-muted mb-1">Tanggal Selesai</p>
                                <h5>{{ $tanggalSelesai ?? '-' }}</h5>
                            </div>
                        </div>
                    </div>
                    
                    @if($user->tanggal_mulai && $user->tanggal_selesai)
                    @php
                        $now = \Carbon\Carbon::now();
                        $start = \Carbon\Carbon::parse($user->tanggal_mulai);
                        $end = \Carbon\Carbon::parse($user->tanggal_selesai);

                        // Hitung total hari
                        $totalDays = $start->diffInDays($end);

                        // Hitung hari yang tersisa
                        $daysLeft = $now->diffInDays($end, false);

                        // Hitung progres sebagai persentase
                        $progress = $totalDays > 0 ? 100 - (($daysLeft / $totalDays) * 100) : 0;
                        $progress = max(0, min(100, $progress)); // Pastikan progres tidak lebih dari 100% atau kurang dari 0%
                    @endphp
                        
                        <div class="mt-3">
                            <p class="d-flex justify-content-between mb-1">
                                <span>Progress Magang</span>
                                <span>{{ round($progress) }}%</span>
                            </p>
                            <div class="progress" style="height: 10px;">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $progress }}%;" aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            
                            <p class="text-center mt-3">
                                @if($daysLeft > 0)
                                    <span class="badge bg-info">{{ $sisaHari }} hari tersisa</span>
                                @elseif($daysLeft == 0)
                                    <span class="badge bg-warning">Hari terakhir</span>
                                @else
                                    <span class="badge bg-secondary">Magang selesai</span>
                                @endif
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Profile Details Card -->
        <div class="col-lg-8">
            <div class="dashboard-card animate__animated animate__fadeInRight">
                <div class="card-header">
                    <h5><i class="fas fa-id-card"></i> Detail Profil</h5>
                </div>
                <div class="card-body p-4">
                    <ul class="nav nav-tabs" id="profileTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="personal-tab" data-bs-toggle="tab" data-bs-target="#personal" type="button" role="tab" aria-controls="personal" aria-selected="true">
                                <i class="fas fa-user me-2"></i>Data Pribadi
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="academic-tab" data-bs-toggle="tab" data-bs-target="#academic" type="button" role="tab" aria-controls="academic" aria-selected="false">
                                <i class="fas fa-graduation-cap me-2"></i>Data Akademik
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="internship-tab" data-bs-toggle="tab" data-bs-target="#internship" type="button" role="tab" aria-controls="internship" aria-selected="false">
                                <i class="fas fa-building me-2"></i>Data Magang
                            </button>
                        </li>
                    </ul>
                    
                    <div class="tab-content" id="profileTabsContent">
                        <!-- Personal Information Tab -->
                        <div class="tab-pane fade show active animate__animated animate__fadeIn" id="personal" role="tabpanel" aria-labelledby="personal-tab">
                            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" id="profileForm">
                                @csrf
                                @method('PUT')
                                <input type="file" id="profile-image-upload" name="foto_profile" class="d-none" accept="image/*">
                                
                                <div class="row mt-4">
                                    <div class="col-md-6 mb-3">
                                        <div class="profile-info-item">
                                            <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                                            <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="{{ $user->nama_lengkap }}" required>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <div class="profile-info-item">
                                            <label for="ttl" class="form-label">Tempat, Tanggal Lahir</label>
                                            <input type="text" class="form-control" id="ttl" value="{{ $user->ttl }}" readonly>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <div class="profile-info-item">
                                            <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                            <input type="text" class="form-control" id="jenis_kelamin" value="{{ $user->jenis_kelamin }}" readonly>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <div class="profile-info-item">
                                            <label for="no_hp" class="form-label">Nomor HP</label>
                                            <input type="text" class="form-control" id="no_hp" name="no_hp" value="{{ $user->no_hp }}" required>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <div class="profile-info-item">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <div class="profile-info-item">
                                            <label for="nomor_pendaftaran" class="form-label">Nomor Pendaftaran</label>
                                            <input type="text" class="form-control" id="nomor_pendaftaran" value="{{ $user->nomor_pendaftaran }}" readonly>
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
                        
                        <!-- Academic Information Tab -->
                        <div class="tab-pane fade animate__animated animate__fadeIn" id="academic" role="tabpanel" aria-labelledby="academic-tab">
                            <div class="row mt-4">
                                <div class="col-md-6 mb-3">
                                    <div class="profile-info-item">
                                        <div class="profile-info-label">Asal Institusi Pendidikan</div>
                                        <div class="profile-info-value">{{ $user->asal_universitas }}</div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <div class="profile-info-item">
                                        <div class="profile-info-label">Jurusan/Bidang Keilmuan</div>
                                        <div class="profile-info-value">{{ $user->jurusan }}</div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <div class="profile-info-item">
                                        <div class="profile-info-label">Program/Keahlian yang Diambil</div>
                                        <div class="profile-info-value">{{ $user->prodi }}</div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <div class="profile-info-item">
                                        <div class="profile-info-label">Semester</div>
                                        <div class="profile-info-value">{{ $user->semester }}</div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <div class="profile-info-item">
                                        <div class="profile-info-label">IPK/Nilai Rata-Rata</div>
                                        <div class="profile-info-value">{{ $user->ipk }}</div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mt-3">
                                <div class="col-md-6 mb-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <h6 class="card-title"><i class="fas fa-file-alt me-2"></i>Transkrip Nilai/Rata-Rata Raport</h6>
                                            @if($user->transkrip_nilai)
                                                <a href="{{ asset('storage/'.$user->transkrip_nilai) }}" target="_blank" class="btn btn-sm btn-outline-primary mt-2">
                                                    <i class="fas fa-eye me-1"></i> Lihat Dokumen
                                                </a>
                                            @else
                                                <p class="text-muted">Tidak ada dokumen</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <h6 class="card-title"><i class="fas fa-file-alt me-2"></i>Surat Pengantar Institusi Pendidikan</h6>
                                            @if($user->surat_pengantar)
                                                <a href="{{ asset('storage/'.$user->surat_pengantar) }}" target="_blank" class="btn btn-sm btn-outline-primary mt-2">
                                                    <i class="fas fa-eye me-1"></i> Lihat Dokumen
                                                </a>
                                            @else
                                                <p class="text-muted">Tidak ada dokumen</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <h6 class="card-title"><i class="fas fa-file-alt me-2"></i>CV</h6>
                                            @if($user->cv)
                                                <a href="{{ asset('storage/'.$user->cv) }}" target="_blank" class="btn btn-sm btn-outline-primary mt-2">
                                                    <i class="fas fa-eye me-1"></i> Lihat Dokumen
                                                </a>
                                            @else
                                                <p class="text-muted">Tidak ada dokumen</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Internship Information Tab -->
                        <div class="tab-pane fade animate__animated animate__fadeIn" id="internship" role="tabpanel" aria-labelledby="internship-tab">
                            <div class="row mt-4">
                                <div class="col-md-6 mb-3">
                                    <div class="profile-info-item">
                                        <div class="profile-info-label">Direktorat</div>
                                        <div class="profile-info-value">{{ $user->direktorat }}</div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <div class="profile-info-item">
                                        <div class="profile-info-label">Unit Kerja</div>
                                        <div class="profile-info-value">{{ $user->unit_kerja }}</div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <div class="profile-info-item">
                                        <div class="profile-info-label">Tanggal Mulai</div>
                                        <div class="profile-info-value">{{ $tanggalMulai ?? '-' }}</div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <div class="profile-info-item">
                                        <div class="profile-info-label">Tanggal Selesai</div>
                                        <div class="profile-info-value">{{ $tanggalSelesai ?? '-' }}</div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <div class="profile-info-item">
                                        <div class="profile-info-label">Status</div>
                                        <div class="profile-info-value">
                                            @if($user->status == 'Diterima')
                                                <span class="badge bg-success">Diterima</span>
                                            @elseif($user->status == 'Diproses')
                                                <span class="badge bg-warning text-dark">Diproses</span>
                                            @elseif($user->status == 'Ditolak')
                                                <span class="badge bg-danger">Ditolak</span>
                                            @else
                                                <span class="badge bg-secondary">{{ $user->status }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            @if($user->catatan)
                                <div class="alert alert-info mt-3">
                                    <h6><i class="fas fa-info-circle me-2"></i>Catatan:</h6>
                                    <p class="mb-0">{{ $user->catatan }}</p>
                                </div>
                            @endif
                            
                            @if($user->surat_balasan)
                                <div class="card mt-3">
                                    <div class="card-body">
                                        <h6 class="card-title"><i class="fas fa-file-alt me-2"></i>Surat Balasan</h6>
                                        <a href="{{ asset('storage/'.$user->surat_balasan) }}" target="_blank" class="btn btn-sm btn-outline-primary mt-2">
                                            <i class="fas fa-download me-1"></i> Unduh Surat Balasan
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <form action="{{ route('logout') }}" method="POST">
    @csrf
        <div class="d-grid gap-2 mt-4">
            <button type="submit" class="btn btn-danger text-white" id="changePasswordBtn">
                <i class="fas fa-key me-2"></i> Logout
            </button>
        </div>
    </form>
</div>

<!-- Change Password Modal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changePasswordModalLabel"><i class="fas fa-key me-2"></i>Ubah Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('update.password') }}" method="POST" id="changePasswordForm">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Password Saat Ini</label>
                        <input type="password" class="form-control" id="current_password" name="current_password" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password Baru</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                        <div class="form-text">Password minimal 8 karakter</div>
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="changePasswordBtn">
                        <i class="fas fa-save me-2"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('additional_scripts')
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

        // Handle profile image upload
        const profileImageUpload = document.getElementById('profile-image-upload');
        const profileImageEdit = document.querySelector('.profile-image-edit');
        
        if (profileImageEdit) {
            profileImageEdit.addEventListener('click', function() {
                profileImageUpload.click();
            });
        }
        
        if (profileImageUpload) {
            profileImageUpload.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const profileImage = document.querySelector('.profile-image');
                        profileImage.src = e.target.result;
                        profileImage.classList.add('animate__animated', 'animate__pulse');
                        
                        setTimeout(() => {
                            profileImage.classList.remove('animate__animated', 'animate__pulse');
                        }, 1000);
                        
                        // Auto submit the form when image is selected
                        document.getElementById('profileForm').submit();
                    }
                    reader.readAsDataURL(this.files[0]);
                }
            });
        }
        
        // Handle profile form submission
        const profileForm = document.getElementById('profileForm');
        if (profileForm) {
            profileForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const submitBtn = document.getElementById('updateProfileBtn');
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Menyimpan...';
                
                this.submit();
            });
        }
        
        // Handle password change form submission
        const changePasswordForm = document.getElementById('changePasswordForm');
        if (changePasswordForm) {
            changePasswordForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const password = document.getElementById('password').value;
                const passwordConfirmation = document.getElementById('password_confirmation').value;
                
                if (password !== passwordConfirmation) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Password Tidak Cocok',
                        text: 'Password baru dan konfirmasi password harus sama',
                        confirmButtonColor: '#8b0000'
                    });
                    return;
                }
                
                if (password.length < 8) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Password Terlalu Pendek',
                        text: 'Password minimal 8 karakter',
                        confirmButtonColor: '#8b0000'
                    });
                    return;
                }
                
                const submitBtn = document.getElementById('changePasswordBtn');
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Menyimpan...';
                
                this.submit();
            });
        }
        
        // Animasi tab saat diklik
        const tabButtons = document.querySelectorAll('.nav-link');
        tabButtons.forEach(button => {
            button.addEventListener('click', function() {
                const tabContent = document.querySelector(this.dataset.bsTarget);
                if (tabContent) {
                    tabContent.classList.add('animate__animated', 'animate__fadeIn');
                    setTimeout(() => {
                        tabContent.classList.remove('animate__animated', 'animate__fadeIn');
                    }, 500);
                }
            });
        });
        
        // Handle errors from server
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
<!-- SweetAlert2 untuk notifikasi yang lebih menarik -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Animate.css untuk animasi -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
@endsection