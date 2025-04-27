@extends('layouts.header_admin5')
@section('title', 'Manajemen Peserta - Kementerian Sosial RI')
@section('additional_css')
<link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
<style>
    /* Dashboard Specific Styles */
    body {
        font-family: 'Calibri', sans-serif;
    }
    
    .dashboard-header {
        margin-bottom: 30px;
        position: relative;
    }
    
    .dashboard-header h1 {
        font-weight: 700;
        color: var(--primary-color);
        position: relative;
        display: inline-block;
        padding-bottom: 10px;
    }
    
    .dashboard-header h1::after {
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
    
    /* Card Styling */
    .card {
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        transition: all 0.3s;
        margin-bottom: 25px;
        overflow: hidden;
        border: none;
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1);
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
    
    .filter-card {
        background-color: #f8f9fa;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        margin-bottom: 25px;
    }
    
    .filter-card .card-body {
        padding: 20px 25px;
    }
    
    .filter-card label {
        font-weight: 600;
        color: #555;
        margin-bottom: 8px;
    }
    
    .filter-card .form-control,
    .filter-card .form-select {
        border-radius: 8px;
        border: 1px solid #e0e0e0;
        padding: 10px 15px;
        transition: all 0.3s;
    }
    
    .filter-card .form-control:focus,
    .filter-card .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.25rem rgba(139, 0, 0, 0.25);
    }
    
    /* Table Styling */
    .table-responsive {
        border-radius: 10px;
        overflow: hidden;
    }
    
    .table {
        border-collapse: separate;
        border-spacing: 0;
        width: 100%;
        margin-bottom: 0;
    }
    
    .table th {
        background-color: #f8f9fa;
        color: #333;
        font-weight: 600;
        padding: 15px;
        border-bottom: 2px solid #e0e0e0;
        text-transform: uppercase;
        font-size: 0.85rem;
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
    
    /* Badge Styling */
    .badge {
        padding: 8px 12px;
        font-weight: 500;
        border-radius: 30px;
        font-size: 0.85rem;
    }
    
    .bg-success {
        background-color: #28a745 !important;
        color: white;
    }
    
    .bg-warning {
        background-color: #ffc107 !important;
        color: #212529;
    }
    
    .bg-danger {
        background-color: #dc3545 !important;
        color: white;
    }
    
    .bg-info {
        background-color: #17a2b8 !important;
        color: white;
    }
    
    /* Button Styling */
    .btn {
        font-weight: 600;
        padding: 0.6rem 1.2rem;
        border-radius: 8px;
        transition: all 0.3s;
        border: none;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
    }
    
    .btn-sm {
        padding: 0.4rem 0.8rem;
        font-size: 0.875rem;
    }
    
    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }
    
    .btn-primary {
        background: linear-gradient(135deg, var(--primary-color), #5a0000);
        color: white;
    }
    
    .btn-success {
        background-color: #28a745;
        color: white;
        border-radius: 8px;
        padding: 8px 16px;
        font-weight: 600;
        transition: all 0.3s;
        border: none;
    }
    
    .btn-success:hover {
        background-color: #218838;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(40, 167, 69, 0.2);
    }
    
    .btn-filter {
        background-color: #8b0000;
        color: white;
        border-radius: 8px;
        padding: 10px 20px;
        font-weight: 600;
        transition: all 0.3s;
        border: none;
    }
    
    .btn-filter:hover {
        background-color: #6d0000;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(139, 0, 0, 0.2);
    }
    
    .btn-outline-primary {
        color: #007bff;
        border-color: #007bff;
        border-radius: 8px;
        transition: all 0.3s;
    }
    
    .btn-outline-primary:hover {
        background-color: #007bff;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 123, 255, 0.2);
    }
    
    /* Modal Styling */
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
    
    /* Form Styling */
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
    
    /* Document Link Styling */
    .document-link {
        margin-bottom: 10px;
    }
    
    .document-link a {
        display: flex;
        align-items: center;
        transition: all 0.3s;
    }
    
    .document-link a:hover {
        transform: translateY(-2px);
    }
    
    /* Alert Styling */
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
    
    /* Empty State Styling */
    .empty-state {
        padding: 40px 0;
        text-align: center;
    }
    
    .empty-state i {
        font-size: 4rem;
        color: #e0e0e0;
        margin-bottom: 20px;
    }
    
    .empty-state p {
        font-size: 1.1rem;
        color: #6c757d;
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
    
    /* Pagination Styling */
    .pagination {
        display: flex;
        justify-content: center;
        margin-top: 20px;
    }
    
    .pagination .page-item .page-link {
        border-radius: 8px;
        margin: 0 5px;
        color: #333;
        border: 1px solid #e0e0e0;
        transition: all 0.3s;
    }
    
    .pagination .page-item.active .page-link {
        background-color: #8b0000;
        border-color: #8b0000;
        color: white;
    }
    
    .pagination .page-item .page-link:hover {
        background-color: #f8f9fa;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }
    
    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .card-header {
            padding: 15px;
        }
        
        .card-body {
            padding: 15px;
        }
        
        .table th, .table td {
            padding: 10px;
        }
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-4">
    <div class="dashboard-header fade-in">
        <h1 class="mt-4">Manajemen Peserta Magang</h1>
        <ol class="breadcrumb mb-4 slide-in-right">
            <li class="breadcrumb-item"><a href="{{ route('admin5.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Peserta Pendaftar Inspektorat Jenderal</li>
        </ol>
    </div>

    <!-- Filters -->
    <div class="card filter-card mb-4 slide-in-up" style="animation-delay: 0.1s">
        <div class="card-header">
            <h5><i class="fas fa-filter"></i> Filter Data</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin5.peserta5') }}" method="GET">
                <div class="row">
                    <div class="col-md-3 mb-2">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="">Semua Status</option>
                            <option value="Diterima" {{ request('status') == 'Diterima' ? 'selected' : '' }}>Diterima</option>
                            <option value="Diproses" {{ request('status') == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                            <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-2">
                        <label for="unit_kerja" class="form-label">Unit Kerja</label>
                        <select class="form-select" id="unit_kerja" name="unit_kerja">
                            <option value="">Semua Unit Kerja</option>
                            @foreach($unit_kerja ?? [] as $d)
                                <option value="{{ $d }}" {{ request('unit_kerja') == $d ? 'selected' : '' }}>{{ $d }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 mb-2">
                        <label for="search" class="form-label">Pencarian</label>
                        <input type="text" class="form-control" id="search" name="search" value="{{ request('search') }}" placeholder="Cari nama, nomor pendaftaran, universitas...">
                    </div>
                    <div class="col-md-2 mb-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-filter w-100">
                            <i class="fas fa-search me-1"></i> Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Peserta Data -->
    <div class="card bounce-in" style="animation-delay: 0.2s">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5><i class="fas fa-users"></i> Manajemen Peserta Magang</h5>
                <div class="col-md-2 mb-2 d-flex align-items-end">
                    <a href="{{ route('admin5.export-datapeserta5') }}?bulan={{ request('bulan', date('Y-m')) }}&direktorat={{ request('direktorat', '') }}" class="btn btn-success w-100">
                        <i class="fas fa-file-excel me-1"></i> Export Excel
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
    <div class="table-responsive">
        <table class="table table-hover" id="datatables-peserta">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="15%">No. Pendaftaran</th>
                    <th width="10%">Nama Lengkap</th>
                    <th width="15%">Unit Kerja</th>
                    <th width="15%">Institusi Pendidikan</th>
                    <th width="15%">Tanggal Daftar</th>
                    <th width="10%">Status</th>
                    <th width="10%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pendaftaran as $key => $p)
                <tr class="fade-in" style="animation-delay: {{ $key * 0.05 }}s">
                <td>{{ $key + 1 }}</td>
                    <td>{{ $p->nomor_pendaftaran }}</td>
                    <td>
                        <div class="d-flex align-items-center">
                        <div class="avatar-sm me-2" style="width: 32px; height: 32px; border-radius: 50%; background-color: #f0f0f0; display: flex; align-items: center; justify-content: center;">
                            @if(isset($p->foto_profile))
                                <img src="{{ asset('storage/' . $p->foto_profile) }}" alt="Profile" class="profile-image profile-pulse" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                            @else
                                <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; font-weight: bold; color: #666;">
                                    {{ strtoupper(substr($p->nama_lengkap, 0, 1)) }}
                                </div>
                            @endif
                        </div>
                            <div>
                                {{ $p->nama_lengkap }}<br>
                                <small class="text-muted">{{ $p->email }}</small>
                            </div>
                        </div>
                    </td>
                    <td>
                        <strong>{{ $p->unit_kerja }}</strong><br>
                       
                    </td>
                    <td>
                        <strong>{{ $p->asal_universitas }}</strong><br>
                        <small class="text-muted">{{ $p->prodi }}</small>
                    </td>
                    <td>
                        <i class="far fa-calendar-alt me-1 text-muted"></i>
                        {{ $p->created_at->format('d-m-Y') }}
                    </td>
                    <td>
                        <span class="badge {{ $p->status == 'Diproses' ? 'bg-warning' : ($p->status == 'Diterima' ? 'bg-success' : 'bg-danger') }}">
                            {{ $p->status }}
                        </span>
                    </td>
                    <td>
                        <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#updateModal{{ $p->id }}">
                            <i class="fas fa-eye"></i> Detail
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-5">
                        <div class="empty-state">
                            <i class="fas fa-search fa-3x text-muted mb-3"></i>
                            <p>Tidak ada data peserta ditemukan.</p>
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

<!-- Detail Modal -->
@foreach($pendaftaran as $p)
<!-- Update Status Modal -->
<div class="modal fade" id="updateModal{{ $p->id }}" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">
                    <i class="fas fa-user-edit me-2"></i> Update Status: {{ $p->nama_lengkap }}
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin5.peserta5.update', $p->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row mb-4">
                        <div class="col-md-6 slide-in-left">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body">
                                    <h6 class="card-title mb-3 text-primary">Informasi Peserta</h6>
                                    <div class="avatar-sm me-2" style="width: 100px; height: 100px; background-color: #f0f0f0; display: flex; align-items: center; justify-content: center;">
                                        @if(isset($p->foto_profile))
                                            <img src="{{ asset('storage/' . $p->foto_profile) }}" alt="Profile" class="profile-image profile-pulse" style="width: 100%; height: 100%; object-fit: cover; border-radius: 0;">
                                        @else
                                            <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; font-weight: bold; color: #666;">
                                                {{ strtoupper(substr($p->nama_lengkap, 0, 1)) }}
                                            </div>
                                        @endif
                                    </div>

                                    <p class="mb-2"><strong><i class="fas fa-id-card me-2"></i>No. Pendaftaran:</strong> {{ $p->nomor_pendaftaran }}</p>
                                    <p class="mb-2"><strong><i class="fas fa-user me-2"></i>Nama Lengkap:</strong> {{ $p->nama_lengkap }}</p>
                                    <p class="mb-2"><strong><i class="fas fa-birthday-cake me-2"></i>Tempat, Tanggal Lahir:</strong> {{ $p->ttl }}, {{ \Carbon\Carbon::parse($p->tanggal_lahir)->format('d-m-Y') }}</p>
                                    <p class="mb-2"><strong><i class="fas fa-building me-2"></i>Direktorat:</strong> {{ $p->direktorat }}</p>
                                    <p class="mb-2"><strong><i class="fas fa-building me-2"></i>Unit Kerja:</strong> {{ $p->unit_kerja }}</p>
                                    <p class="mb-2"><strong><i class="fas fa-envelope me-2"></i>Email:</strong> {{ $p->email }}</p>
                                    <p class="mb-2"><strong><i class="fas fa-phone me-2"></i>No. Telepon:</strong> {{ $p->no_hp }}</p>
                                    <p class="mb-2"><strong><i class="fas fa-university me-2"></i>Institusi Pendidikan:</strong> {{ $p->asal_universitas }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 slide-in-right">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body">
                                    <h6 class="card-title mb-3 text-primary">Informasi Tambahan</h6>
                                    <p class="mb-2"><strong><i class="fas fa-graduation-cap me-2"></i>Jurusan/Bidang Keilmuan:</strong> {{ $p->jurusan }}</p>
                                    <p class="mb-2"><strong><i class="fas fa-graduation-cap me-2"></i>Program/Keahlian yang Diambil:</strong> {{ $p->prodi }}</p>
                                    <p class="mb-2"><strong><i class="fas fa-check-circle me-2"></i>Status:</strong> 
                                        @if($p->status == 'Diproses')
                                            <span class="badge bg-warning">Diproses</span>
                                        @elseif($p->status == 'Diterima')
                                            <span class="badge bg-success">Diterima</span>
                                        @else
                                            <span class="badge bg-danger">Ditolak</span>
                                        @endif
                                    </p>
                                    <p class="mb-2"><strong><i class="fas fa-calendar-alt me-2"></i>Tanggal Daftar:</strong> {{ $p->created_at->format('d-m-Y') }}</p>

                                    <p class="mb-2"><strong><i class="fas fa-calendar-day me-2"></i>Periode Magang:</strong> 
                                        @if($p->tanggal_mulai && $p->tanggal_selesai)
                                            {{ \Carbon\Carbon::parse($p->tanggal_mulai)->format('d-m-Y') }} 
                                            s/d 
                                            {{ \Carbon\Carbon::parse($p->tanggal_selesai)->format('d-m-Y') }}
                                        @else
                                            <span class="text-muted">Belum diatur</span>
                                        @endif
                                    </p>

                                    <div class="document-links mt-3">
                                        <h6 class="text-primary mb-2"><i class="fas fa-file-alt me-2"></i>Dokumen</h6>
                                        <div class="d-flex flex-wrap gap-2">
                                            <a href="{{ asset('storage/'.$p->cv) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-file-pdf me-1"></i> CV
                                            </a>
                                            <a href="{{ asset('storage/'.$p->surat_pengantar) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-file-pdf me-1"></i> Surat Pengantar Institusi Pendidikan
                                            </a>
                                            <a href="{{ asset('storage/'.$p->transkrip_nilai) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-file-pdf me-1"></i> Transkrip Nilai/Rata-Rata Raport
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Show rejection notes if status is 'Ditolak' -->
                    @if($p->status == 'Ditolak' && $p->catatan)
                    <div class="alert alert-danger mt-3 slide-in-up">
                        <h6 class="alert-heading"><i class="fas fa-info-circle me-2"></i>Catatan Penolakan:</h6>
                        <p class="mb-0">{{ $p->catatan }}</p>
                    </div>
                    @endif

                    <!-- Show acceptance letter if status is 'Diterima' -->
                    @if($p->status == 'Diterima' && $p->surat_balasan)
                    <div class="alert alert-success mt-3 slide-in-up">
                        <h6 class="alert-heading"><i class="fas fa-check-circle me-2"></i>Surat Balasan:</h6>
                        <p class="mb-0">
                            <a href="{{ asset('storage/'.$p->surat_balasan) }}" target="_blank" class="btn btn-sm btn-success">
                                <i class="fas fa-file-pdf me-1"></i> Lihat Surat Balasan
                            </a>
                        </p>
                    </div>
                    @endif

                    <div class="card border-0 shadow-sm mt-3 bounce-in">
                        <div class="card-body">
                            <h6 class="card-title mb-3 text-primary"><i class="fas fa-edit me-2"></i>Update Status</h6>
                            
                            <!-- Status Section (Non-editable after determination) -->
                            @if($p->status != 'Diproses')
                            <div class="mb-3">
                                <label for="status{{ $p->id }}" class="form-label">Status</label>
                                <input type="text" class="form-control" id="status{{ $p->id }}" value="{{ $p->status }}" readonly>
                            </div>
                            @else
                            <div class="mb-3">
                                <label for="status{{ $p->id }}" class="form-label">Status</label>
                                <select class="form-select" id="status{{ $p->id }}" name="status" onchange="toggleFields({{ $p->id }})" required>
                                    <option value="Diproses" {{ $p->status == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                                    <option value="Diterima" {{ $p->status == 'Diterima' ? 'selected' : '' }}>Diterima</option>
                                    <option value="Ditolak" {{ $p->status == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                                </select>
                            </div>
                            @endif

                            <!-- Rejection Note Section -->
                            <div id="catatanDiv{{ $p->id }}" class="mb-3" style="display:none;">
                                <label for="catatan{{ $p->id }}" class="form-label">Catatan Penolakan</label>
                                <textarea class="form-control" id="catatan{{ $p->id }}" name="catatan" rows="3" placeholder="Berikan alasan penolakan">{{ $p->catatan }}</textarea>
                            </div>

                            <!-- Acceptance Letter Section -->
                            <div id="suratDiv{{ $p->id }}" class="mb-3" style="display:none;">
                                <label for="surat_balasan{{ $p->id }}" class="form-label">Surat Balasan (PDF)</label>
                                <input type="file" class="form-control" id="surat_balasan{{ $p->id }}" name="surat_balasan" accept=".pdf">
                                @if($p->surat_balasan)
                                <div class="form-text mt-2">File saat ini: {{ basename($p->surat_balasan) }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Batal
                    </button>
                    @if($p->status == 'Diproses')
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

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">


<script>

$(document).ready(function() {
        // Inisialisasi DataTable dengan animasi
        $('#datatables-peserta').DataTable({
            "scrollX": true,
            "searching": false,
            "language": {
                "lengthMenu": "Tampilkan _MENU_ data per halaman",
                "zeroRecords": "Tidak ada data yang ditemukan",
                "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
                "infoEmpty": "Tidak ada data yang tersedia",
                "infoFiltered": "(difilter dari _MAX_ total data)",
                
                "paginate": {
                    "first": "Pertama",
                    "last": "Terakhir",
                    "next": "Selanjutnya",
                    "previous": "Sebelumnya"
                }
            },
            "pageLength": 10,
            "responsive": true,
            "drawCallback": function() {
                $('.datatables-peserta_paginate .paginate_button').addClass('fade-in');
            }
        });
    });
    // Fungsi untuk toggle fields berdasarkan status yang dipilih
    function toggleFields(id) {
        var statusSelect = document.getElementById('status' + id);
        var catatanDiv = document.getElementById('catatanDiv' + id);
        var suratDiv = document.getElementById('suratDiv' + id);
        var periodeDiv = document.getElementById('periodeDiv' + id);
        
        if (statusSelect.value === 'Ditolak') {
            catatanDiv.style.display = 'block';
            suratDiv.style.display = 'none';
            periodeDiv.style.display = 'none';
            // Tambahkan animasi
            catatanDiv.classList.add('slide-in-up');
        } else if (statusSelect.value === 'Diterima') {
            catatanDiv.style.display = 'none';
            suratDiv.style.display = 'block';
            periodeDiv.style.display = 'block';
            // Tambahkan animasi
            suratDiv.classList.add('slide-in-up');
            periodeDiv.classList.add('slide-in-up');
        } else {
            catatanDiv.style.display = 'none';
            suratDiv.style.display = 'none';
            periodeDiv.style.display = 'none';
        }
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
        
        // Animate elements on page load
        const animateElements = () => {
            const elements = document.querySelectorAll('.fade-in, .slide-in-left, .slide-in-right, .slide-in-up, .bounce-in');
            elements.forEach(element => {
                element.style.opacity = '1';
            });
        };
        
        setTimeout(animateElements, 100);
    

    // Export to Excel with animation
    function exportToExcel() {
        // Add animation to export button
        const exportBtn = document.querySelector('.btn-success');
        exportBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Exporting...';
        
        setTimeout(() => {
            const table = document.getElementById('pesertaTable');
            const wb = XLSX.utils.table_to_book(table, {sheet: "Peserta Magang"});
            XLSX.writeFile(wb, 'data-peserta-magang.xlsx');
            
            // Reset button text
            exportBtn.innerHTML = '<i class="fas fa-file-excel me-1"></i> Export Excel';
            
            // Show success message
            const alertDiv = document.createElement('div');
            alertDiv.className = 'alert alert-success alert-dismissible fade show position-fixed top-0 end-0 m-3';
            alertDiv.setAttribute('role', 'alert');
            alertDiv.innerHTML = `
                <i class="fas fa-check-circle me-2"></i> Data berhasil diekspor ke Excel
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            `;
            document.body.appendChild(alertDiv);
            
            // Remove alert after 3 seconds
            setTimeout(() => {
                alertDiv.remove();
            }, 3000);
        }, 800);
    }
</script>
@endsection