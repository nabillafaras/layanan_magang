@extends('layouts.header_user')

@section('title', 'Laporan Bulanan - Kementerian Sosial RI')

@section('additional_css')
<style>
/* Laporan Bulanan Specific Styles - Selaras dengan user.blade.php */
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

.btn-info, .btn-danger, .btn-secondary {
    border-radius: 8px;
    padding: 8px 15px;
    font-weight: 500;
    transition: all var(--transition-speed);
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.table {
    border-collapse: separate;
    border-spacing: 0;
    width: 100%;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 0 15px rgba(0,0,0,0.05);
}

.table th {
    background-color: #f8f9fa;
    color: #333;
    font-weight: 600;
    padding: 15px;
    border-bottom: 2px solid #e0e0e0;
}

.table td {
    padding: 15px;
    vertical-align: middle;
    border-bottom: 1px solid #e0e0e0;
    transition: all var(--transition-speed);
}

.table tr:hover td {
    background-color: rgba(139, 0, 0, 0.02);
}

.table tr:last-child td {
    border-bottom: none;
}

.badge {
    padding: 8px 12px;
    font-weight: 500;
    border-radius: 30px;
    font-size: 0.85rem;
}

.accordion-button:not(.collapsed) {
    background-color: rgba(139, 0, 0, 0.05);
    color: var(--primary-color);
    box-shadow: none;
}

.accordion-button:focus {
    box-shadow: 0 0 0 0.25rem rgba(139, 0, 0, 0.1);
    border-color: rgba(139, 0, 0, 0.1);
}

.accordion-item {
    border-radius: 10px;
    overflow: hidden;
    border: 1px solid rgba(0,0,0,0.1);
    margin-bottom: 15px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    transition: all var(--transition-speed);
}

.accordion-item:hover {
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    transform: translateY(-2px);
}

.alert {
    border-radius: 10px;
    border: none;
    box-shadow: 0 3px 10px rgba(0,0,0,0.05);
}

.modal-content {
    border-radius: 15px;
    border: none;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.modal-header {
    border-bottom: 1px solid rgba(0,0,0,0.05);
    background-color: #f8f9fa;
}

.modal-footer {
    border-top: 1px solid rgba(0,0,0,0.05);
    background-color: #f8f9fa;
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

/* File upload animation */
@keyframes file-upload {
    0% { transform: translateY(0); }
    50% { transform: translateY(-5px); }
    100% { transform: translateY(0); }
}

.file-upload-animation {
    animation: file-upload 1s ease infinite;
}

/* Empty state animation */
@keyframes float {
    0% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
    100% { transform: translateY(0); }
}

.float-animation {
    animation: float 3s ease-in-out infinite;
}
</style>
@endsection

@section('content')
<div class="container-fluid p-4">
    <div class="dashboard-header animate__animated animate__fadeIn">
        <h2 class="mb-4">Laporan Bulanan</h2>
        <p class="text-muted">Silahkan upload laporan bulanan Anda di sini. Laporan harus diupload setiap akhir bulan sesuai periode magang Anda.</p>
    </div>

    <div class="dashboard-card animate__animated animate__fadeInUp" style="animation-delay: 0.1s">
        <div class="card-header">
            <h5><i class="fas fa-file-alt"></i> Laporan Bulanan</h5>
        </div>
        <div class="card-body p-4">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show animate__animated animate__fadeIn" role="alert">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show animate__animated animate__shakeX" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i> Terdapat kesalahan pada form pengisian
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="accordion animate__animated animate__fadeIn" id="accordionUpload" style="animation-delay: 0.2s">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingUpload">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseUpload" aria-expanded="false" aria-controls="collapseUpload">
                                    <i class="fas fa-upload me-2"></i>Upload Laporan Bulanan Baru
                                </button>
                            </h2>
                            <div id="collapseUpload" class="accordion-collapse collapse" aria-labelledby="headingUpload" data-bs-parent="#accordionUpload">
                                <div class="accordion-body">
                                    <form action="{{ route('laporan.bulanan.upload') }}" method="POST" enctype="multipart/form-data" id="uploadForm">
                                        @csrf
                                        
                                        <div class="mb-3 animate__animated animate__fadeIn" style="animation-delay: 0.3s">
                                            <label for="periode_bulan" class="form-label">Periode Bulan <span class="text-danger">*</span></label>
                                            <select class="form-select" name="periode_bulan" id="periode_bulan" required>
                                                <option value="">-- Pilih Periode --</option>
                                                @foreach($bulanSejakDiterima as $bulan)
                                                    <option value="{{ $bulan['bulan'] }}" {{ $bulan['sudah_upload'] ? 'disabled' : '' }}>
                                                        {{ $bulan['nama_bulan'] }}
                                                        @if($bulan['sudah_upload'])
                                                            (Sudah diupload)
                                                        @endif
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        
                                        <div class="mb-3 animate__animated animate__fadeIn" style="animation-delay: 0.4s">
                                            <label for="judul" class="form-label">Judul Laporan <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="judul" name="judul" required>
                                        </div>
                                        
                                        <div class="mb-3 animate__animated animate__fadeIn" style="animation-delay: 0.5s">
                                            <label for="file_laporan" class="form-label">File Laporan <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input type="file" class="form-control" id="file_laporan" name="file_laporan" accept=".pdf,.doc,.docx" required>
                                                <span class="input-group-text file-icon"><i class="fas fa-file-upload"></i></span>
                                            </div>
                                            <div class="form-text"><i class="fas fa-info-circle me-1"></i> Format file: PDF, DOC, atau DOCX. Maksimal ukuran: 10MB</div>
                                        </div>
                                        
                                        <div class="mb-3 animate__animated animate__fadeIn" style="animation-delay: 0.6s">
                                            <label for="keterangan" class="form-label">Keterangan (opsional)</label>
                                            <textarea class="form-control" id="keterangan" name="keterangan" rows="3"></textarea>
                                        </div>
                                        
                                        <div class="d-grid gap-2 animate__animated animate__fadeIn" style="animation-delay: 0.7s">
                                            <button type="submit" class="btn btn-primary btn-pulse" id="submitBtn">
                                                <i class="fas fa-upload me-2"></i>Upload Laporan
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- riwayat laporan bulanan -->
<div class="mt-4 animate__animated animate__fadeInUp" style="animation-delay: 0.3s">
    <h5 class="section-title"><i class="fas fa-history me-2"></i>Riwayat Laporan Bulanan</h5>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="15%">Periode</th>
                    <th width="15%">Judul</th>
                    <th width="15%">Tanggal Upload</th>
                    <th width="10%">Status</th>
                    <th width="15%">Feedback</th>
                    <th width="15%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($laporan as $index => $item)
                    <tr class="animate__animated animate__fadeIn" style="animation-delay: {{ 0.4 + $index * 0.1 }}s">
                        <td>{{ $index + 1 }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->periode_bulan)->translatedFormat('F Y') }}</td>
                        <td>{{ $item->judul }}</td>
                        <td>{{ $item->created_at->translatedFormat('d M Y') }}</td>
                        <td>
                            @if($item->status == 'Menunggu')
                                <span class="badge bg-warning">
                                    <i class="fas fa-clock me-1"></i> Menunggu
                                </span>
                            @elseif($item->status == 'Acc')
                                <span class="badge bg-success">
                                    <i class="fas fa-check-circle me-1"></i> Acc
                                </span>
                            @elseif($item->status == 'Ditolak')
                                <span class="badge bg-danger">
                                    <i class="fas fa-times-circle me-1"></i> Ditolak
                                </span>
                            @endif
                        </td>
                        <td>
                            @if($item->feedback)
                                <span class="text-truncate d-inline-block" style="max-width: 150px;" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $item->feedback }}">
                                    {{ $item->feedback }}
                                </span>
                            @else
                                <span class="text-muted fst-italic">Belum ada feedback</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('laporan.bulanan.download', $item->id) }}" class="btn btn-sm btn-info mb-1">
                                <i class="fas fa-download"></i> Download
                            </a>
                            
                            @if($item->status == 'Menunggu')
                                <form action="{{ route('laporan.bulanan.delete', $item->id) }}" method="POST" class="d-inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger mb-1">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            @endif
                            
                            
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <div class="empty-state animate__animated animate__fadeIn">
                                <i class="fas fa-folder-open text-muted float-animation" style="font-size: 4rem;"></i>
                                <p class="mt-3 text-muted">Belum ada laporan bulanan yang diupload</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
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

        // Cek apakah ada pesan sukses, jika ada buka form upload
        @if(session('success') && !$errors->any())
            // Tampilkan notifikasi sukses yang menarik
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                confirmButtonColor: '#8b0000',
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                }
            });
        @elseif($errors->any())
            // Buka form jika ada error
            new bootstrap.Collapse(document.getElementById('collapseUpload'), {
                show: true
            });
            
            // Tampilkan notifikasi error yang menarik
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: 'Terdapat kesalahan pada form pengisian',
                confirmButtonColor: '#8b0000',
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                }
            });
        @endif
        
        // Animasi untuk file input saat berubah
        const fileInput = document.getElementById('file_laporan');
        const fileIcon = document.querySelector('.file-icon');
        
        if (fileInput) {
            fileInput.addEventListener('change', function() {
                if (this.files.length > 0) {
                    this.classList.add('animate__animated', 'animate__flash');
                    fileIcon.classList.add('file-upload-animation');
                    fileIcon.style.color = '#8b0000';
                    
                    setTimeout(() => {
                        this.classList.remove('animate__animated', 'animate__flash');
                    }, 1000);
                }
            });
        }
        
        // Event listener untuk form submit dengan animasi loading
        const uploadForm = document.getElementById('uploadForm');
        if (uploadForm) {
            uploadForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const submitBtn = document.getElementById('submitBtn');
                submitBtn.disabled = true;
                submitBtn.classList.remove('btn-pulse');
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Mengunggah...';
                
                this.submit();
            });
        }
        
        // Event listener untuk form delete dengan SweetAlert
        const deleteForms = document.querySelectorAll('.delete-form');
        deleteForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                Swal.fire({
                    title: 'Konfirmasi Hapus',
                    text: 'Apakah Anda yakin ingin menghapus laporan ini?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#8b0000',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    showClass: {
                        popup: 'animate__animated animate__fadeInDown'
                    },
                    hideClass: {
                        popup: 'animate__animated animate__fadeOutUp'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Tambahkan animasi loading pada tombol
                        const deleteBtn = this.querySelector('button[type="submit"]');
                        deleteBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                        deleteBtn.disabled = true;
                        
                        this.submit();
                    }
                });
            });
        });
        
        // Animasi untuk accordion saat dibuka
        const accordionButton = document.querySelector('.accordion-button');
        if (accordionButton) {
            accordionButton.addEventListener('click', function() {
                if (this.classList.contains('collapsed')) {
                    setTimeout(() => {
                        const formElements = document.querySelectorAll('#collapseUpload .animate__animated');
                        formElements.forEach((el, index) => {
                            setTimeout(() => {
                                el.style.opacity = '0';
                                el.style.transform = 'translateY(20px)';
                                setTimeout(() => {
                                    el.style.transition = 'all 0.5s ease';
                                    el.style.opacity = '1';
                                    el.style.transform = 'translateY(0)';
                                }, 50);
                            }, index * 100);
                        });
                    }, 300);
                }
            });
        }
    });
</script>
<!-- SweetAlert2 untuk notifikasi yang lebih menarik -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Animate.css untuk animasi -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
@endsection