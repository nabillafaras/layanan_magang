@extends('layouts.header_pimpinan')

@section('title', 'Data Peserta Magang - Kementerian Sosial RI')

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

    /* Button Styling */
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
    
    .btn-info {
        background-color: #17a2b8;
        color: white;
        border-radius: 8px;
        padding: 6px 12px;
        font-weight: 600;
        transition: all 0.3s;
        border: none;
    }
    
    .btn-info:hover {
        background-color: #138496;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(23, 162, 184, 0.2);
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
    
    /* Modal Styling */
    .modal-content {
        border-radius: 15px;
        border: none;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }
    
    .modal-header {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-bottom: 1px solid #e0e0e0;
        padding: 15px 25px;
    }
    
    .modal-header .modal-title {
        font-weight: 600;
        color: #333;
    }
    
    .modal-body {
        padding: 25px;
    }
    
    .modal-footer {
        border-top: 1px solid #e0e0e0;
        padding: 15px 25px;
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
            <li class="breadcrumb-item"><a href="{{ route('pimpinan.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Data Peserta Magang</li>
        </ol>
    </div>

    <!-- Filters -->
    <div class="card filter-card mb-4 slide-in-up" style="animation-delay: 0.1s">
        <div class="card-header">
            <h5><i class="fas fa-filter"></i> Filter Data</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('pimpinan.peserta.index') }}" method="GET">
                <div class="row">
                    <div class="col-md-3 mb-2">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="">Semua Status</option>
                            <option value="Diterima" {{ $status == 'Diterima' ? 'selected' : '' }}>Diterima</option>
                            <option value="Diproses" {{ $status == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                            <option value="Ditolak" {{ $status == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-2">
                        <label for="direktorat" class="form-label">Direktorat</label>
                        <select class="form-select" id="direktorat" name="direktorat">
                            <option value="">Semua Direktorat</option>
                            @foreach($direktorat as $d)
                                <option value="{{ $d }}" {{ request('direktorat') == $d ? 'selected' : '' }}>{{ $d }}</option>
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
                <h5><i class="fas fa-users"></i> Daftar Peserta Magang</h5>
                <div>
                    <button class="btn btn-success" onclick="exportToExcel()">
                        <i class="fas fa-file-excel me-1"></i> Export Excel
                    </button>
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
                            <th width="15%">Direktorat</th>
                            <th width="15%">Institusi Pendidikan</th>
                            <th width="15%">Tanggal Daftar</th>
                            <th width="10%">Status</th>
                            <th width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($peserta as $key => $p)
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
                                <strong>{{ $p->direktorat }}</strong><br>
                                <small class="text-muted">{{ $p->unit_kerja }}</small>
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
                                <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#detailModal{{ $p->id }}">
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

<!-- Detail Modals -->
@foreach($peserta as $p)
<div class="modal fade" id="detailModal{{ $p->id }}" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">
                    <i class="fas fa-user-graduate me-2"></i>
                    Detail Peserta: {{ $p->nama_lengkap }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm mb-3">
                            <div class="card-body">
                                <h6 class="card-title mb-3 border-bottom pb-2">
                                    <i class="fas fa-id-card me-2 text-primary"></i>
                                    Informasi Peserta
                                </h6>
                                <p><strong>No. Pendaftaran:</strong> {{ $p->nomor_pendaftaran }}</p>
                                <p><strong>Nama Lengkap:</strong> {{ $p->nama_lengkap }}</p>
                                <p><strong>Email:</strong> {{ $p->email }}</p>
                                <p><strong>No. Telepon:</strong> {{ $p->no_hp }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm mb-3">
                            <div class="card-body">
                                <h6 class="card-title mb-3 border-bottom pb-2">
                                    <i class="fas fa-university me-2 text-primary"></i>
                                    Informasi Tambahan
                                </h6>
                                <p><strong>Institusi Pendidikan:</strong> {{ $p->asal_universitas }}</p>
                                <p><strong>Jurusan/Bidang Keilmuan:</strong> {{ $p->jurusan }}</p>
                                <p><strong>Program/Keahlian yang Diambil:</strong> {{ $p->prodi }}</p>
                                <p><strong>Direktorat:</strong> {{ $p->direktorat }}</p>
                                <p><strong>Unit Kerja:</strong> {{ $p->unit_kerja }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm mb-3">
                            <div class="card-body">
                                <h6 class="card-title mb-3 border-bottom pb-2">
                                    <i class="fas fa-file-alt me-2 text-primary"></i>
                                    Dokumen
                                </h6>
                                <div class="document-link">
                                    <a href="{{ asset('storage/'.$p->cv) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-file-pdf me-1"></i> Lihat CV
                                    </a>
                                </div>
                                <div class="document-link">
                                    <a href="{{ asset('storage/'.$p->surat_pengantar) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-file-pdf me-1"></i> Lihat Surat Pengantar
                                    </a>
                                </div>
                                <div class="document-link">
                                    <a href="{{ asset('storage/'.$p->transkrip_nilai) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-file-pdf me-1"></i> Lihat Transkrip Nilai
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm mb-3">
                            <div class="card-body">
                                <h6 class="card-title mb-3 border-bottom pb-2">
                                    <i class="fas fa-info-circle me-2 text-primary"></i>
                                    Status Peserta
                                </h6>
                                <p><strong>Tanggal Daftar:</strong> {{ $p->created_at->format('d-m-Y') }}</p>
                                <p class="mb-2"><strong></i>Periode Magang:</strong> 
                                        @if($p->tanggal_mulai && $p->tanggal_selesai)
                                            {{ \Carbon\Carbon::parse($p->tanggal_mulai)->format('d-m-Y') }} 
                                            s/d 
                                            {{ \Carbon\Carbon::parse($p->tanggal_selesai)->format('d-m-Y') }}
                                        @else
                                            <span class="text-muted">Belum diatur</span>
                                        @endif
                                    </p>
                                <p>
                                    <strong>Status:</strong> 
                                    <span class="badge {{ $p->status == 'Diproses' ? 'bg-warning' : ($p->status == 'Diterima' ? 'bg-success' : 'bg-danger') }}">
                                        {{ $p->status }}
                                    </span>
                                </p>
                                
                                <!-- Show rejection notes if status is 'Ditolak' -->
                                @if($p->status == 'Ditolak' && $p->catatan)
                                <div class="alert alert-danger mt-3">
                                    <p><strong>Catatan Penolakan:</strong></p>
                                    <p>{{ $p->catatan }}</p>
                                </div>
                                @endif

                                <!-- Show acceptance letter if status is 'Diterima' -->
                                @if($p->status == 'Diterima' && $p->surat_balasan)
                                <div class="alert alert-success mt-3">
                                    <p><strong>Surat Balasan:</strong></p>
                                    <p>
                                        <a href="{{ asset('storage/'.$p->surat_balasan) }}" target="_blank" class="btn btn-sm btn-success">
                                            <i class="fas fa-file-pdf me-1"></i> Lihat Surat Balasan
                                        </a>
                                    </p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
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
    // Export to Excel with animation
    function exportToExcel() {
        // Add animation to export button
        const exportBtn = document.querySelector('.btn-success');
        exportBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Exporting...';
        
        setTimeout(() => {
            const table = document.getElementById('datatables-peserta');
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