@extends('layouts.header_admin')
@section('title', 'Manajemen Peserta - Kementerian Sosial RI')
@section('additional_css')
<style>
    /* Dashboard Specific Styles */
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
        background: linear-gradient(90deg, var(--primary-color), #c13030);
        border-radius: 2px;
    }

    .breadcrumb {
        background-color: transparent;
        padding: 0;
        margin-bottom: 20px;
    }
    
    .breadcrumb-item a {
        color: var(--primary-color);
        text-decoration: none;
        transition: all 0.3s;
    }
    
    .breadcrumb-item a:hover {
        color: #c13030;
        text-decoration: underline;
    }
    
    .breadcrumb-item.active {
        color: #6c757d;
    }
    
    .breadcrumb-item + .breadcrumb-item::before {
        content: ">";
        color: #6c757d;
    }
    
    .dashboard-card {
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        transition: all 0.3s;
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
    
    .table {
        width: 100%;
        margin-bottom: 0;
    }
    
    .table th {
        background-color: #f8f9fa;
        color: #333;
        font-weight: 600;
        padding: 15px;
        border-bottom: 2px solid #e0e0e0;
        white-space: nowrap;
    }
    
    .table td {
        padding: 15px;
        vertical-align: middle;
        border-bottom: 1px solid #e0e0e0;
        transition: all 0.3s;
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
    
    .bg-warning {
        background-color: #ffc107 !important;
        color: #212529;
    }
    
    .bg-success {
        background-color: #28a745 !important;
        color: white;
    }
    
    .bg-danger {
        background-color: #dc3545 !important;
        color: white;
    }
    
    .btn {
        font-weight: 600;
        padding: 0.6rem 1.2rem;
        border-radius: 50px;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: none;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        position: relative;
        overflow: hidden;
        z-index: 1;
    }
    
    .btn-sm {
        padding: 0.4rem 0.8rem;
        font-size: 0.875rem;
    }
    
    .btn::after {
        content: '';
        position: absolute;
        width: 0;
        height: 100%;
        top: 0;
        left: 0;
        transition: width 0.3s ease;
        z-index: -1;
        border-radius: 50px;
    }
    
    .btn:hover::after {
        width: 100%;
    }
    
    .btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }
    
    .btn-primary {
        background: linear-gradient(135deg, var(--primary-color), #5a0000);
        color: white;
    }
    
    .btn-primary::after {
        background-color: rgba(255, 255, 255, 0.2);
    }
    
    .btn-outline-primary {
        color: var(--primary-color);
        border: 1px solid var(--primary-color);
        background: transparent;
    }
    
    .btn-outline-primary:hover {
        color: white;
        background: var(--primary-color);
    }
    
    .modal-content {
        border-radius: 15px;
        border: none;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }
    
    .modal-header {
        background: linear-gradient(135deg, var(--primary-color) 0%, #6a0000 100%);
        color: white;
        border-bottom: none;
        padding: 1.2rem 1.5rem;
    }
    
    .modal-title {
        font-weight: 600;
    }
    
    .modal-body {
        padding: 1.5rem;
    }
    
    .modal-footer {
        border-top: 1px solid #e0e0e0;
        padding: 1.2rem 1.5rem;
    }
    
    .form-control {
        border-radius: 8px;
        padding: 0.75rem 1rem;
        border: 1px solid #ced4da;
        transition: all 0.3s;
    }
    
    .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.25rem rgba(139, 0, 0, 0.25);
    }
    
    .form-select {
        border-radius: 8px;
        padding: 0.75rem 1rem;
        border: 1px solid #ced4da;
        transition: all 0.3s;
    }
    
    .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.25rem rgba(139, 0, 0, 0.25);
    }
    
    .document-link {
        margin-top: 10px;
    }
    
    .alert {
        border-radius: 10px;
        padding: 1rem;
        margin-bottom: 1rem;
        border-left: 4px solid;
    }
    
    .alert-success {
        background-color: rgba(212, 237, 218, 0.5);
        border-color: #28a745;
        color: #155724;
    }
    
    .alert-danger {
        background-color: rgba(248, 215, 218, 0.5);
        border-color: #dc3545;
        color: #721c24;
    }
    
    /* Animation Classes */
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
    
    @keyframes slideInUp {
        from { transform: translateY(50px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
    
    @keyframes bounceIn {
        0% { transform: scale(0.8); opacity: 0; }
        50% { transform: scale(1.05); opacity: 0.8; }
        100% { transform: scale(1); opacity: 1; }
    }
    
    .fade-in {
        animation: fadeIn 0.5s ease-in-out;
    }
    
    .slide-in-left {
        animation: slideInLeft 0.5s ease-in-out;
    }
    
    .slide-in-right {
        animation: slideInRight 0.5s ease-in-out;
    }
    
    .slide-in-up {
        animation: slideInUp 0.5s ease-in-out;
    }
    
    .bounce-in {
        animation: bounceIn 0.6s ease-in-out;
    }
    
    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .table-responsive {
            border-radius: 15px;
        }
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-4">
    <div class="dashboard-header fade-in">
        <h2 class="mt-4">Manajemen Peserta Magang</h2>
        <ol class="breadcrumb mb-4 slide-in-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Peserta Pendaftar</li>
        </ol>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="dashboard-card bounce-in">
                <div class="card-header">
                    <h5><i class="fas fa-users"></i> Manajemen Peserta Magang</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="pesertaTable" class="table table-hover">
                            <thead>
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
                                <tr class="fade-in" style="animation-delay: {{ $loop->index * 0.05 }}s">
                                    <td>{{ $peserta->nomor_pendaftaran }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm me-2" style="width: 32px; height: 32px; border-radius: 50%; background-color: #f0f0f0; display: flex; align-items: center; justify-content: center;">
                                                <i class="fas fa-user text-primary"></i>
                                            </div>
                                            <span>{{ $peserta->nama_lengkap }}</span>
                                        </div>
                                    </td>
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
                                            <i class="fas fa-edit me-1"></i> Edit
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
    </div>
</div>

<!-- Detail Modal -->
@foreach($pendaftaran as $peserta)
<!-- Update Status Modal -->
<div class="modal fade" id="updateModal{{ $peserta->id }}" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">
                    <i class="fas fa-user-edit me-2"></i> Update Status: {{ $peserta->nama_lengkap }}
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.peserta.update', $peserta->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row mb-4">
                        <div class="col-md-6 slide-in-left">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body">
                                    <h6 class="card-title mb-3 text-primary">Informasi Peserta</h6>
                                    <p class="mb-2"><strong><i class="fas fa-id-card me-2"></i>No. Pendaftaran:</strong> {{ $peserta->nomor_pendaftaran }}</p>
                                    <p class="mb-2"><strong><i class="fas fa-user me-2"></i>Nama Lengkap:</strong> {{ $peserta->nama_lengkap }}</p>
                                    <p class="mb-2"><strong><i class="fas fa-building me-2"></i>Direktorat:</strong> {{ $peserta->direktorat }}</p>
                                    <p class="mb-2"><strong><i class="fas fa-envelope me-2"></i>Email:</strong> {{ $peserta->email }}</p>
                                    <p class="mb-2"><strong><i class="fas fa-phone me-2"></i>No. Telepon:</strong> {{ $peserta->no_hp }}</p>
                                    <p class="mb-2"><strong><i class="fas fa-university me-2"></i>Institusi:</strong> {{ $peserta->asal_universitas }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 slide-in-right">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body">
                                    <h6 class="card-title mb-3 text-primary">Informasi Tambahan</h6>
                                    <p class="mb-2"><strong><i class="fas fa-graduation-cap me-2"></i>Program Studi:</strong> {{ $peserta->prodi }}</p>
                                    <p class="mb-2"><strong><i class="fas fa-check-circle me-2"></i>Status:</strong> 
                                        @if($peserta->status == 'Diproses')
                                            <span class="badge bg-warning">Diproses</span>
                                        @elseif($peserta->status == 'Diterima')
                                            <span class="badge bg-success">Diterima</span>
                                        @else
                                            <span class="badge bg-danger">Ditolak</span>
                                        @endif
                                    </p>
                                    <p class="mb-2"><strong><i class="fas fa-calendar-alt me-2"></i>Tanggal Daftar:</strong> {{ $peserta->created_at->format('d-m-Y') }}</p>

                                    <p class="mb-2"><strong><i class="fas fa-calendar-day me-2"></i>Periode Magang:</strong> 
                                        @if($peserta->tanggal_mulai && $peserta->tanggal_selesai)
                                            {{ \Carbon\Carbon::parse($peserta->tanggal_mulai)->format('d-m-Y') }} 
                                            s/d 
                                            {{ \Carbon\Carbon::parse($peserta->tanggal_selesai)->format('d-m-Y') }}
                                        @else
                                            <span class="text-muted">Belum diatur</span>
                                        @endif
                                    </p>

                                    <div class="document-links mt-3">
                                        <h6 class="text-primary mb-2"><i class="fas fa-file-alt me-2"></i>Dokumen</h6>
                                        <div class="d-flex flex-wrap gap-2">
                                            <a href="{{ asset('storage/'.$peserta->cv) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-file-pdf me-1"></i> CV
                                            </a>
                                            <a href="{{ asset('storage/'.$peserta->surat_pengantar) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-file-pdf me-1"></i> Surat Pengantar
                                            </a>
                                            <a href="{{ asset('storage/'.$peserta->transkrip_nilai) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-file-pdf me-1"></i> Transkrip Nilai
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Show rejection notes if status is 'Ditolak' -->
                    @if($peserta->status == 'Ditolak' && $peserta->catatan)
                    <div class="alert alert-danger mt-3 slide-in-up">
                        <h6 class="alert-heading"><i class="fas fa-info-circle me-2"></i>Catatan Penolakan:</h6>
                        <p class="mb-0">{{ $peserta->catatan }}</p>
                    </div>
                    @endif

                    <!-- Show acceptance letter if status is 'Diterima' -->
                    @if($peserta->status == 'Diterima' && $peserta->surat_balasan)
                    <div class="alert alert-success mt-3 slide-in-up">
                        <h6 class="alert-heading"><i class="fas fa-check-circle me-2"></i>Surat Balasan:</h6>
                        <p class="mb-0">
                            <a href="{{ asset('storage/'.$peserta->surat_balasan) }}" target="_blank" class="btn btn-sm btn-success">
                                <i class="fas fa-file-pdf me-1"></i> Lihat Surat Balasan
                            </a>
                        </p>
                    </div>
                    @endif

                    <div class="card border-0 shadow-sm mt-3 bounce-in">
                        <div class="card-body">
                            <h6 class="card-title mb-3 text-primary"><i class="fas fa-edit me-2"></i>Update Status</h6>
                            
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
                                <textarea class="form-control" id="catatan{{ $peserta->id }}" name="catatan" rows="3" placeholder="Berikan alasan penolakan">{{ $peserta->catatan }}</textarea>
                            </div>

                            <!-- Acceptance Letter Section -->
                            <div id="suratDiv{{ $peserta->id }}" class="mb-3" style="display:none;">
                                <label for="surat_balasan{{ $peserta->id }}" class="form-label">Surat Balasan (PDF)</label>
                                <input type="file" class="form-control" id="surat_balasan{{ $peserta->id }}" name="surat_balasan" accept=".pdf">
                                @if($peserta->surat_balasan)
                                <div class="form-text mt-2">File saat ini: {{ basename($peserta->surat_balasan) }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Batal
                    </button>
                    @if($peserta->status == 'Diproses')
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Simpan Perubahan
                        </button>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

@endsection

@section('additional_scripts')
<script>
// Fungsi untuk toggle fields berdasarkan status yang dipilih
function toggleFields(id) {
    var statusSelect = document.getElementById('status' + id);
    var catatanDiv = document.getElementById('catatanDiv' + id);
    var suratDiv = document.getElementById('suratDiv' + id);
    
    if (statusSelect.value === 'Ditolak') {
        catatanDiv.style.display = 'block';
        suratDiv.style.display = 'none';
        // Tambahkan animasi
        catatanDiv.classList.add('slide-in-up');
    } else if (statusSelect.value === 'Diterima') {
        catatanDiv.style.display = 'none';
        suratDiv.style.display = 'block';
        // Tambahkan animasi
        suratDiv.classList.add('slide-in-up');
    } else {
        catatanDiv.style.display = 'none';
        suratDiv.style.display = 'none';
    }
}

// Inisialisasi saat dokumen dimuat
document.addEventListener('DOMContentLoaded', function() {
    // Inisialisasi DataTable dengan animasi
    if (typeof $.fn.DataTable !== 'undefined') {
        $('#pesertaTable').DataTable({
            "language": {
                "lengthMenu": "Tampilkan _MENU_ data per halaman",
                "zeroRecords": "Tidak ada data yang ditemukan",
                "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
                "infoEmpty": "Tidak ada data yang tersedia",
                "infoFiltered": "(difilter dari _MAX_ total data)",
                "search": "Cari:",
                "paginate": {
                    "first": "Pertama",
                    "last": "Terakhir",
                    "next": "Selanjutnya",
                    "previous": "Sebelumnya"
                }
            },
            "pageLength": 10,
            "responsive": true
        });
    }
    
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
    
    // Tambahkan animasi hover untuk baris tabel
    const tableRows = document.querySelectorAll('#pesertaTable tbody tr');
    tableRows.forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.transform = 'translateX(5px)';
            this.style.transition = 'transform 0.3s ease';
        });
        
        row.addEventListener('mouseleave', function() {
            this.style.transform = 'translateX(0)';
        });
    });
});
</script>
@endsection