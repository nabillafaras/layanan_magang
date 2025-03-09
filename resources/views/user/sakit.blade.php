@extends('layouts.header_user')

@section('title', 'Absen Sakit - Kementerian Sosial RI')

@section('content')
<!-- Page Content -->
<div class="main-content">
    <div class="container-fluid p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="section-title">Sistem Absensi</h2>
        </div>
<div class="container-fluid p-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0" style="color: #8b0000;">
                        <i class="fas fa-notes-medical me-2"></i>Form Absensi Sakit
                    </h5>
                </div>
                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    
                    <form id="sakitForm" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="ket_sakit" class="form-label">Keterangan Sakit <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="ket_sakit" name="ket_sakit" rows="3" required></textarea>
                            <div class="form-text">Silakan masukkan keterangan sakit Anda secara detail.</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="bukti_sakit" class="form-label">Bukti Sakit <span class="text-danger">*</span></label>
                            <input class="form-control" type="file" id="bukti_sakit" name="bukti_sakit" required>
                            <div class="form-text">Upload surat dokter atau bukti lainnya (format: JPG, PNG, PDF, max: 2MB)</div>
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="submit" id="submitBtn" class="btn btn-danger">
                                <i class="fas fa-paper-plane me-2"></i> Kirim
                            </button>
                        </div>
                    </form>
                </div>
                <!-- Riwayat Izin -->
            <div class="card shadow-sm mt-4">
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
                                @foreach($riwayatSakit as $sakit)
                                <tr>
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
                    <div class="text-center py-3">
                        <i class="fas fa-folder-open text-muted" style="font-size: 3rem;"></i>
                        <p class="mt-3 text-muted">Belum ada riwayat sakit</p>
                    </div>
                    @endif
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
    const sakitForm = document.getElementById('sakitForm');
    const submitBtn = document.getElementById('submitBtn');
    
    sakitForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Mengirim...';
        submitBtn.disabled = true;
        
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
                    confirmButtonColor: '#8b0000'
                }).then(() => {
                    location.reload();
                });
            } else {
                // Tampilkan notifikasi error yang menarik
                Swal.fire({
                    icon: 'error',
                    title: 'Izin sakit Gagal',
                    text: data.message,
                    confirmButtonColor: '#8b0000'
                });
                submitBtn.innerHTML = '<i class="fas fa-paper-plane me-2"></i> Kirim';
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
            submitBtn.innerHTML = '<i class="fas fa-paper-plane me-2"></i> Kirim';
            submitBtn.disabled = false;
        }
    });
});
</script>
@endsection