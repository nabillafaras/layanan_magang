@extends('layouts.header_user')

@section('title', 'Laporan Bulanan - Kementerian Sosial RI')

@section('content')
<div class="container-fluid p-4">
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white">
            <h5 class="card-title m-0"><i class="fas fa-file-alt me-2"></i>Laporan Bulanan</h5>
        </div>
        <div class="card-body">
            <p class="text-muted">
                Silahkan upload laporan bulanan Anda di sini. Laporan harus diupload setiap akhir bulan sesuai periode magang Anda.
            </p>
            
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="accordion" id="accordionUpload">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingUpload">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseUpload" aria-expanded="false" aria-controls="collapseUpload">
                                    <i class="fas fa-upload me-2"></i>Upload Laporan Bulanan Baru
                                </button>
                            </h2>
                            <div id="collapseUpload" class="accordion-collapse collapse" aria-labelledby="headingUpload" data-bs-parent="#accordionUpload">
                                <div class="accordion-body">
                                    <form action="{{ route('laporan.bulanan.upload') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        
                                        <div class="mb-3">
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
                                        
                                        <div class="mb-3">
                                            <label for="judul" class="form-label">Judul Laporan <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="judul" name="judul" required>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="file_laporan" class="form-label">File Laporan <span class="text-danger">*</span></label>
                                            <input type="file" class="form-control" id="file_laporan" name="file_laporan" accept=".pdf,.doc,.docx" required>
                                            <div class="form-text">Format file: PDF, DOC, atau DOCX. Maksimal ukuran: 10MB</div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="keterangan" class="form-label">Keterangan (opsional)</label>
                                            <textarea class="form-control" id="keterangan" name="keterangan" rows="3"></textarea>
                                        </div>
                                        
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-upload me-2"></i>Upload Laporan
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">No</th>
                            <th width="15%">Periode</th>
                            <th width="30%">Judul</th>
                            <th width="15%">Tanggal Upload</th>
                            <th width="15%">Status</th>
                            <th width="20%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($laporan as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->periode_bulan)->translatedFormat('F Y') }}</td>
                                <td>{{ $item->judul }}</td>
                                <td>{{ $item->created_at->translatedFormat('d M Y') }}</td>
                                <td>
                                    @if($item->status == 'menunggu')
                                        <span class="badge bg-warning">Menunggu</span>
                                    @elseif($item->status == 'diterima')
                                        <span class="badge bg-success">Diterima</span>
                                    @elseif($item->status == 'ditolak')
                                        <span class="badge bg-danger">Ditolak</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('laporan.bulanan.download', $item->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-download"></i> Download
                                    </a>
                                    
                                    @if($item->status == 'menunggu')
                                        <form action="{{ route('laporan.bulanan.delete', $item->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus laporan ini?')">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                    @endif
                                    
                                    @if($item->feedback)
                                        <button type="button" class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#feedbackModal{{ $item->id }}">
                                            <i class="fas fa-comment"></i> Feedback
                                        </button>
                                        
                                        <!-- Modal Feedback -->
                                        <div class="modal fade" id="feedbackModal{{ $item->id }}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Feedback Laporan</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>{{ $item->feedback }}</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-3">Belum ada laporan bulanan yang diupload</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('additional_scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Cek apakah ada pesan sukses, jika ada buka form upload
        @if(session('success') && !$errors->any())
            // Tampilkan notifikasi sukses yang menarik
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                confirmButtonColor: '#8b0000'
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
                confirmButtonColor: '#8b0000'
            });
        @endif
        
        // Event listener untuk form submit
        const formUpload = document.querySelector('form[action="{{ route('laporan.bulanan.upload') }}"]');
        if (formUpload) {
            formUpload.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const submitBtn = this.querySelector('button[type="submit"]');
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Mengunggah...';
                
                this.submit();
            });
        }
        
        // Event listener untuk form delete
        const deleteButtons = document.querySelectorAll('form[action^="{{ route('laporan.bulanan.delete', '') }}"]');
        deleteButtons.forEach(form => {
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
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                });
            });
        });
    });
</script>
@endsection