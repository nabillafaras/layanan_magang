@extends('layouts.header_user')
@section('title', 'Form Izin - Kementerian Sosial RI')
@section('content')
<!-- Page Content -->
<div class="main-content">
    <div class="container-fluid p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="section-title">Sistem Absensi</h2>
        </div>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 text-dark">
                        <i class="fas fa-clipboard-list me-2" style="color: #8b0000;"></i>Form Pengajuan Izin
                    </h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-info" role="alert">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Perhatian:</strong> Pengajuan izin harus dilakukan minimal 1 hari sebelum hari kerja.
                    </div>
                    
                    @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                    @endif
                    
                    @if($canSubmitIzin)
                    <form id="izinForm" action="{{ route('izin.submit') }}" method="POST" enctype="multipart/form-data">
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
                            <button type="submit" id="submitBtn" class="btn btn-danger" style="background-color: #8b0000;">
                                <i class="fas fa-paper-plane me-2"></i> Kirim Pengajuan Izin
                            </button>
                        </div>
                    </form>
                    @else
                    <div class="alert alert-warning" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Perhatian:</strong> Anda tidak dapat mengajukan izin karena sudah terdapat absensi/izin yang aktif pada tanggal tersebut.
                    </div>
                    @endif
                </div>
            </div>
            
            <!-- Riwayat Izin -->
            <div class="card shadow-sm mt-4">
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
                                @foreach($riwayatIzin as $izin)
                                <tr>
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
                    <div class="text-center py-3">
                        <i class="fas fa-folder-open text-muted" style="font-size: 3rem;"></i>
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
    const form = document.getElementById('izinForm');
    
    if (form) {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const submitBtn = document.getElementById('submitBtn');
            submitBtn.innerHTML = '<i class="fas fa-spin fa-spinner me-2"></i> Memproses...';
            submitBtn.disabled = true;
            
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
                        confirmButtonColor: '#8b0000'
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    // Tampilkan notifikasi error yang menarik
                    Swal.fire({
                        icon: 'error',
                        title: 'Izin Gagal',
                        text: data.message,
                        confirmButtonColor: '#8b0000'
                    });
                    
                    submitBtn.innerHTML = '<i class="fas fa-paper-plane me-2"></i> Kirim Pengajuan Izin';
                    submitBtn.disabled = false;
                }
            } catch (error) {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi Kesalahan',
                    text: 'Terjadi kesalahan saat mengirim data izin',
                    confirmButtonColor: '#8b0000'
                });
                
                submitBtn.innerHTML = '<i class="fas fa-paper-plane me-2"></i> Kirim Pengajuan Izin';
                submitBtn.disabled = false;
            }
        });
    }
});
</script>
@endsection