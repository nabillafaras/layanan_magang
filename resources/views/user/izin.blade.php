@extends('layouts.header_user')
@section('title', 'Form Izin - Kementerian Sosial RI')

@section('additional_css')
<style>
    /* Izin Page Specific Styles */
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
    
    /* Pulse Animation for Button */
    @keyframes pulse-button {
        0% { box-shadow: 0 0 0 0 rgba(139, 0, 0, 0.7); }
        70% { box-shadow: 0 0 0 10px rgba(139, 0, 0, 0); }
        100% { box-shadow: 0 0 0 0 rgba(139, 0, 0, 0); }
    }
    
    .btn-pulse {
        animation: pulse-button 2s infinite;
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
        <p class="text-muted">Pengajuan izin tidak masuk kerja</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm animate__animated animate__fadeInUp">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 text-dark">
                        <i class="fas fa-clipboard-list me-2" style="color: #8b0000;"></i>Form Pengajuan Izin
                    </h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-info fade-in" role="alert">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Perhatian:</strong> Pengajuan izin harus dilakukan minimal 1 hari sebelum hari kerja.
                    </div>
                    
                    @if(session('error'))
                    <div class="alert alert-danger animate__animated animate__shakeX">
                        <i class="fas fa-exclamation-triangle me-2"></i> {{ session('error') }}
                    </div>
                    @endif
                    
                    @if($canSubmitIzin)
                    <form id="izinForm" action="{{ route('izin.submit') }}" method="POST" enctype="multipart/form-data" class="slide-in-up">
                        @csrf
                        <div class="mb-3">
                            <label for="tanggal" class="form-label">Tanggal Izin <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="tanggal" name="tanggal" required min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                            <small class="text-muted">Pilih tanggal minimal 1 hari dari sekarang</small>
                        </div>
                        
                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan Izin <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="keterangan" name="keterangan" rows="3" required placeholder="Jelaskan alasan izin Anda secara detail"></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label for="bukti" class="form-label">Bukti Pendukung <span class="text-danger">*</span></label>
                            <input type="file" class="form-control" id="bukti" name="bukti" required accept="image/*,.pdf">
                            <small class="text-muted">Format file yang diperbolehkan: JPG, PNG, PDF (Maks. 2MB)</small>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" id="submitBtn" class="btn btn-danger btn-pulse">
                                <i class="fas fa-paper-plane me-2"></i> Kirim Pengajuan Izin
                            </button>
                        </div>
                    </form>
                    @else
                    <div class="alert alert-warning animate__animated animate__fadeIn" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Perhatian:</strong> Anda tidak dapat mengajukan izin karena sudah terdapat absensi/izin yang aktif pada tanggal tersebut.
                    </div>
                    @endif
                </div>
            </div>
            
            <!-- Riwayat Izin -->
            <div class="card shadow-sm mt-4 animate__animated animate__fadeInUp" style="animation-delay: 0.2s">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 text-dark">
                        <i class="fas fa-history me-2" style="color: #8b0000;"></i>Riwayat Pengajuan Izin
                    </h5>
                </div>
                <div class="card-body">
                    @if(count($riwayatIzin) > 0)
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
                                @foreach($riwayatIzin as $index => $izin)
                                <tr class="animate__animated animate__fadeIn" style="animation-delay: {{ $index * 0.1 }}s">
                                    <td>{{ date('d M Y', strtotime($izin->date)) }}</td>
                                    <td>{{ $izin->ket_izin }}</td>
                                    <td>
                                        @if($izin->status == 'izin')
                                        <span class="badge bg-info">Izin</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($izin->bukti_izin)
                                        <a href="{{ asset('storage/' . $izin->bukti_izin) }}" target="_blank" class="btn btn-sm btn-outline-secondary">
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
                        <p class="mt-3 text-muted">Belum ada riwayat pengajuan izin</p>
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
    
    const form = document.getElementById('izinForm');
    
    if (form) {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const submitBtn = document.getElementById('submitBtn');
            submitBtn.innerHTML = '<i class="fas fa-spin fa-spinner me-2"></i> Memproses...';
            submitBtn.disabled = true;
            submitBtn.classList.remove('btn-pulse');
            
            const formData = new FormData(this);
            
            try {
                const response = await fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    credentials: 'same-origin'
                });
                
                const data = await response.json();
                
                if (data.success) {
                    // Tampilkan notifikasi sukses yang menarik
                    Swal.fire({
                        icon: 'success',
                        title: 'Izin Berhasil!',
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
                        title: 'Izin Gagal',
                        text: data.message,
                        confirmButtonColor: '#8b0000',
                        showClass: {
                            popup: 'animate__animated animate__fadeInDown'
                        },
                        hideClass: {
                            popup: 'animate__animated animate__fadeOutUp'
                        }
                    });
                    
                    submitBtn.innerHTML = '<i class="fas fa-paper-plane me-2"></i> Kirim Pengajuan Izin';
                    submitBtn.disabled = false;
                    submitBtn.classList.add('btn-pulse');
                }
            } catch (error) {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi Kesalahan',
                    text: 'Terjadi kesalahan saat mengirim data izin',
                    confirmButtonColor: '#8b0000',
                    showClass: {
                        popup: 'animate__animated animate__fadeInDown'
                    },
                    hideClass: {
                        popup: 'animate__animated animate__fadeOutUp'
                    }
                });
                
                submitBtn.innerHTML = '<i class="fas fa-paper-plane me-2"></i> Kirim Pengajuan Izin';
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
});
</script>
<!-- Animate.css untuk animasi -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
@endsection