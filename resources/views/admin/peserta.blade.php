@extends('layouts.header_admin')
@section('title', 'Dashboard Admin - Kementerian Sosial RI')
@section('additional_css')
<style>
        body {
            font-family: 'Calibri', sans-serif;
        }
        .card {
            box-shadow: 0 0 1px rgba(0,0,0,0.125), 0 1px 3px rgba(0,0,0,0.2);
        }
</style>
@endsection

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Manajemen Peserta Magang</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Peserta Pendaftar</li>
    </ol>

        

<div class="container py-4">
    <div class="card">
        <div class="card-header bg-light">
            <h5 class="mb-0">Manajemen Peserta Magang</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="pesertaTable" class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>No. Pendaftaran</th>
                            <th>Nama Lengkap</th>
                            <th>Direktorat</th>
                            <th>Email</th>
                            <th>Institusi</th>
                            <th>Tanggal Daftar</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pendaftaran as $peserta)
                        <tr>
                            <td>{{ $peserta->nomor_pendaftaran }}</td>
                            <td>{{ $peserta->nama_lengkap }}</td>
                            <td>{{ $peserta->direktorat }}</td>
                            <td>{{ $peserta->email }}</td>
                            <td>{{ $peserta->asal_universitas }}</td>
                            <td>{{ $peserta->created_at->format('d-m-Y') }}</td>
                            <td>
                                <span class="badge {{ $peserta->status == 'Diproses' ? 'bg-warning' : ($peserta->status == 'Diterima' ? 'bg-success' : 'bg-danger') }}">
                                    {{ $peserta->status }}
                                </span>
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#updateModal{{ $peserta->id }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Detail Modal -->
@foreach($pendaftaran as $peserta)
<!-- Update Status Modal -->
<div class="modal fade" id="updateModal{{ $peserta->id }}" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">Update Status: {{ $peserta->nama_lengkap }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.peserta.update', $peserta->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p><strong>No. Pendaftaran:</strong> {{ $peserta->nomor_pendaftaran }}</p>
                            <p><strong>Nama Lengkap:</strong> {{ $peserta->nama_lengkap }}</p>
                            <p><strong>Direktorat:</strong> {{ $peserta->direktorat }}</p>
                            <p><strong>Email:</strong> {{ $peserta->email }}</p>
                            <p><strong>No. Telepon:</strong> {{ $peserta->no_hp }}</p>
                            <p><strong>Institusi:</strong> {{ $peserta->asal_universitas }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Program Studi:</strong> {{ $peserta->prodi }}</p>
                            <p><strong>Status:</strong> 
                                @if($peserta->status == 'Diproses')
                                    <span class="badge bg-warning">Diproses</span>
                                @elseif($peserta->status == 'Diterima')
                                    <span class="badge bg-success">Diterima</span>
                                @else
                                    <span class="badge bg-danger">Ditolak</span>
                                @endif
                            </p>
                            <p><strong>Tanggal Daftar:</strong> {{ $peserta->created_at->format('d-m-Y') }}</p>
                            <div class="document-link">
                                <a href="{{ asset('storage/'.$peserta->cv) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-file-pdf me-1"></i> CV </a>
                            </div>
                            <div class="document-link">
                                <a href="{{ asset('storage/'.$peserta->surat_pengantar) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-file-pdf me-1"></i> Surat Pengantar </a>
                            </div>
                            <div class="document-link">
                                <a href="{{ asset('storage/'.$peserta->transkrip_nilai) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-file-pdf me-1"></i> Transkrip Nilai </a>
                            </div>
                        </div>
                    </div>

                    <!-- Show rejection notes if status is 'Ditolak' -->
                    @if($peserta->status == 'Ditolak' && $peserta->catatan)
                    <div class="alert alert-danger mt-3">
                        <p><strong>Catatan Penolakan:</strong></p>
                        <p>{{ $peserta->catatan }}</p>
                    </div>
                    @endif

                    <!-- Show acceptance letter if status is 'Diterima' -->
                    @if($peserta->status == 'Diterima' && $peserta->surat_balasan)
                    <div class="alert alert-success mt-3">
                        <p><strong>Surat Balasan:</strong></p>
                        <p><a href="{{ asset('storage/'.$peserta->surat_balasan) }}" target="_blank" class="btn btn-sm btn-success">
                            <i class="fas fa-file-pdf me-1"></i> Lihat Surat Balasan
                        </a></p>
                    </div>
                    @endif

                    <!-- Status Section (Non-editable after determination) -->
                    @if($peserta->status != 'Diproses')
                    <div class="mb-3">
                        <label for="status{{ $peserta->id }}" class="form-label">Status</label>
                        <input type="text" class="form-control" id="status{{ $peserta->id }}" value="{{ $peserta->status }}" readonly>
                    </div>
                    @else
                    <div class="mb-3">
                        <label for="status{{ $peserta->id }}" class="form-label">Status</label>
                        <select class="form-select" id="status{{ $peserta->id }}" name="status" onchange="toggleFields({{ $peserta->id }})" required>
                            <option value="Diproses" {{ $peserta->status == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                            <option value="Diterima" {{ $peserta->status == 'Diterima' ? 'selected' : '' }}>Diterima</option>
                            <option value="Ditolak" {{ $peserta->status == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>
                    @endif

                    <!-- Rejection Note Section -->
                    <div id="catatanDiv{{ $peserta->id }}" class="mb-3" style="display:none;">
                        <label for="catatan{{ $peserta->id }}" class="form-label">Catatan Penolakan</label>
                        <textarea class="form-control" id="catatan{{ $peserta->id }}" name="catatan" rows="3">{{ $peserta->catatan }}</textarea>
                    </div>

                    <!-- Acceptance Letter Section -->
                    <div id="suratDiv{{ $peserta->id }}" class="mb-3" style="display:none;">
                        <label for="surat_balasan{{ $peserta->id }}" class="form-label">Surat Balasan (PDF)</label>
                        <input type="file" class="form-control" id="surat_balasan{{ $peserta->id }}" name="surat_balasan" accept=".pdf">
                        @if($peserta->surat_balasan)
                        <div class="form-text">File saat ini: {{ basename($peserta->surat_balasan) }}</div>
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    @if($peserta->status == 'Diproses')
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<script>
// Fungsi untuk toggle fields berdasarkan status yang dipilih (menggunakan JavaScript murni)
function toggleFields(id) {
    var statusSelect = document.getElementById('status' + id);
    var catatanDiv = document.getElementById('catatanDiv' + id);
    var suratDiv = document.getElementById('suratDiv' + id);
    
    if (statusSelect.value === 'Ditolak') {
        catatanDiv.style.display = 'block';
        suratDiv.style.display = 'none';
    } else if (statusSelect.value === 'Diterima') {
        catatanDiv.style.display = 'none';
        suratDiv.style.display = 'block';
    } else {
        catatanDiv.style.display = 'none';
        suratDiv.style.display = 'none';
    }
}

// Inisialisasi saat dokumen dimuat
document.addEventListener('DOMContentLoaded', function() {
    // Inisialisasi semua modal saat dibuka
    var modals = document.querySelectorAll('.modal');
    modals.forEach(function(modal) {
        modal.addEventListener('shown.bs.modal', function() {
            // Ambil ID peserta dari ID modal
            var modalId = modal.id;
            var pesertaId = modalId.replace('updateModal', '');
            
            // Cek apakah ada select status di modal ini
            var statusSelect = document.getElementById('status' + pesertaId);
            if (statusSelect) {
                // Trigger fungsi toggle untuk set tampilan awal
                toggleFields(pesertaId);
            }
        });
    });
});
</script>

@endsection