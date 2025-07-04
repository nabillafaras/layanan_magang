@extends('layouts.header_user')

@section('title', 'Absen Sakit - Kementerian Sosial RI')

@section('additional_css')
<style>
    /* Sakit Page Specific Styles */
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
    
    .card {
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        transition: all var(--transition-speed);
        border: none;
        overflow: hidden;
        margin-bottom: 25px;
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1);
    }
    
    .card-header {
        background: white;
        border-bottom: 1px solid rgba(0,0,0,0.05);
        padding: 20px;
    }
    
    .card-header h5 {
        margin: 0;
        font-weight: 600;
        display: flex;
        align-items: center;
    }
    
    .card-header i {
        margin-right: 10px;
    }
    
    .form-label {
        font-weight: 500;
        color: #444;
    }
    
    .btn-danger {
        background: linear-gradient(135deg, var(--primary-color) 0%, #6a0000 100%);
        border: none;
        box-shadow: 0 4px 10px rgba(139, 0, 0, 0.2);
        transition: all 0.3s;
        font-weight: 500;
        padding: 10px 20px;
    }
    
    .btn-danger:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(139, 0, 0, 0.3);
    }
    
    .table {
        border-radius: 10px;
        overflow: hidden;
    }
    
    .table th {
        background-color: #f8f9fa;
        font-weight: 600;
        color: #444;
    }
    
    .table tr {
        transition: all 0.3s;
    }
    
    .table tr:hover {
        background-color: rgba(139, 0, 0, 0.02);
    }
    
    .badge {
        padding: 6px 12px;
        font-weight: 500;
        border-radius: 30px;
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
    
    .slide-in-up {
        animation: slideInUp 0.5s ease-in-out;
    }
    
    .bounce-in {
        animation: bounceIn 0.6s ease-in-out;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    @keyframes slideInUp {
        from { transform: translateY(50px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
    
    @keyframes bounceIn {
        0% { transform: scale(0.8); opacity: 0; }
        50% { transform: scale(1.05); opacity: 0.8; }
        100% { transform: scale(1); opacity: 1; }
    }
    
    /* Heartbeat Animation for Icons */
    @keyframes heartbeat {
        0% { transform: scale(1); }
        14% { transform: scale(1.1); }
        28% { transform: scale(1); }
        42% { transform: scale(1.1); }
        70% { transform: scale(1); }
    }
    
    .icon-heartbeat:hover {
        animation: heartbeat 1.5s ease-in-out;
    }
    
    /* Empty state styling */
    .empty-state {
        text-align: center;
        padding: 30px 0;
    }
    
    .empty-state i {
        font-size: 4rem;
        color: #ddd;
        margin-bottom: 15px;
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0% { transform: scale(0.95); opacity: 0.7; }
        50% { transform: scale(1); opacity: 1; }
        100% { transform: scale(0.95); opacity: 0.7; }
    }
</style>
@endsection

@section('content')
<!-- Page Content -->
<div class="container-fluid py-4">
    <div class="dashboard-header animate__animated animate__fadeIn">
        <h2 class="section-title mb-4">Sistem Absensi</h2>
        <p class="text-muted">Pengajuan izin sakit</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm animate__animated animate__fadeInUp">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0" style="color: #8b0000;">
                        <i class="fas fa-notes-medical me-2 icon-heartbeat"></i>Form Absensi Sakit
                    </h5>
                </div>
                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show animate__animated animate__shakeX" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    
                    <form id="sakitForm" enctype="multipart/form-data" class="slide-in-up">
                        @csrf
                        <div class="mb-3">
                            <label for="ket_sakit" class="form-label">Keterangan Sakit <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="ket_sakit" name="ket_sakit" rows="3" required placeholder="Jelaskan kondisi sakit Anda secara detail"></textarea>
                            <div class="form-text">Silakan masukkan keterangan sakit Anda secara detail.</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="bukti_sakit" class="form-label">Bukti Sakit <span class="text-danger">*</span></label>
                            <input class="form-control" type="file" id="bukti_sakit" name="bukti_sakit" required>
                            <div class="form-text">Upload surat dokter atau bukti lainnya (format: JPG, PNG, PDF, max: 2MB)</div>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" id="submitBtn" class="btn btn-danger btn-pulse">
                                <i class="fas fa-paper-plane me-2"></i> Kirim
                            </button>
                        </div>
                    </form>
                </div>
            </div>
                
            <!-- Riwayat Sakit -->
            <div class="card shadow-sm mt-4 animate__animated animate__fadeInUp" style="animation-delay: 0.2s">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 text-dark">
                        <i class="fas fa-history me-2" style="color: #8b0000;"></i>Riwayat Izin Sakit
                    </h5>
                </div>
                <div class="card-body">
                    @if(count($riwayatSakit) > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Keterangan</th>
                                    <th>Status</th>
                                    <th>Bukti</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($riwayatSakit as $index => $sakit)
                                <tr class="animate__animated animate__fadeIn" style="animation-delay: {{ $index * 0.1 }}s">
                                    <td>{{ date('d M Y', strtotime($sakit->date)) }}</td>
                                    <td>{{ $sakit->ket_sakit }}</td>
                                    <td>
                                        @if($sakit->status == 'sakit')
                                        <span class="badge bg-info">Sakit</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($sakit->bukti_sakit)
                                        <a href="{{ asset('storage/' . $sakit->bukti_sakit) }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                                            <i class="fas fa-file-alt"></i> Lihat
                                        </a>
                                        @else
                                        <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="empty-state">
                        <i class="fas fa-folder-open"></i>
                        <p class="mt-3 text-muted">Belum ada riwayat sakit</p>
                    </div>
                    @endif
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
    const animateElements = function() {
        const elements = document.querySelectorAll('.card');
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
    
    const sakitForm = document.getElementById('sakitForm');
    const submitBtn = document.getElementById('submitBtn');
    
    sakitForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Mengirim...';
        submitBtn.disabled = true;
        submitBtn.classList.remove('animate__pulse', 'animate__infinite');
        
        try {
            const formData = new FormData(sakitForm);
            const response = await fetch('{{ route("sakit.store") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            });
            
            const data = await response.json();
            
            if (data.success) {
                // Tampilkan notifikasi sukses yang menarik
                Swal.fire({
                    icon: 'success',
                    title: 'Izin sakit Berhasil!',
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
                    title: 'Izin sakit Gagal',
                    text: data.message,
                    confirmButtonColor: '#8b0000',
                    showClass: {
                        popup: 'animate__animated animate__fadeInDown'
                    },
                    hideClass: {
                        popup: 'animate__animated animate__fadeOutUp'
                    }
                });
                submitBtn.innerHTML = '<i class="fas fa-paper-plane me-2"></i> Kirim';
                submitBtn.disabled = false;
                submitBtn.classList.add('animate__pulse', 'animate__infinite');
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
            submitBtn.innerHTML = '<i class="fas fa-paper-plane me-2"></i> Kirim';
            submitBtn.disabled = false;
            submitBtn.classList.add('animate__pulse', 'animate__infinite');
        }
    });
    
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
    
    // Efek hover pada icon
    const icons = document.querySelectorAll('.icon-heartbeat');
    icons.forEach(icon => {
        icon.addEventListener('mouseenter', function() {
            this.style.color = '#c13030';
        });
        
        icon.addEventListener('mouseleave', function() {
            this.style.color = '';
        });
    });
});
</script>
<!-- Animate.css untuk animasi -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
@endsection