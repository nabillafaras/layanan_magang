@extends('layouts.header_admin2')
@section('title', 'Manajemen Pengumuman - Kementerian Sosial RI')
@section('additional_css')
<link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
<!-- Add Summernote CSS -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
<style>
    /* Styling yang selaras dengan admin2.blade.php */
    .dashboard-header {
        margin-bottom: 30px;
        position: relative;
    }
    
    .dashboard-header h4 {
        font-weight: 700;
        color: var(--primary-color);
        position: relative;
        display: inline-block;
        padding-bottom: 10px;
    }
    
    .dashboard-header h4::after {
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
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .card-header h4 {
        margin: 0;
        font-weight: 600;
        color: #333;
        display: flex;
        align-items: center;
    }
    
    .card-header h4 i {
        margin-right: 10px;
        color: var(--primary-color);
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary-color), #c13030);
        border: none;
        box-shadow: 0 4px 10px rgba(193, 48, 48, 0.2);
        transition: all 0.3s;
    }
    
    .btn-primary:hover {
        background: linear-gradient(135deg, #c13030, var(--primary-color));
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(193, 48, 48, 0.3);
    }

    .btn-group .btn {
        margin-right: 5px;
        border-radius: 8px;
        padding: 6px 12px;
        transition: all 0.3s;
    }

    .btn-group .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    .btn-info {
        background-color: #17a2b8;
        border-color: #17a2b8;
    }

    .btn-danger {
        background-color: #dc3545;
        border-color: #dc3545;
    }

    .table {
        border-collapse: separate;
        border-spacing: 0;
        width: 100%;
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
    
    .bg-success {
        background-color: #28a745 !important;
        color: white !important;
    }
    
    .bg-warning {
        background-color: #ffc107 !important;
        color: #212529 !important;
    }

    .modal-content {
        border-radius: 15px;
        border: none;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        overflow: hidden;
    }
    
    .modal-header {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-bottom: 1px solid #e0e0e0;
        padding: 15px 25px;
    }
    
    .modal-title {
        font-weight: 600;
        color: #333;
    }
    
    .modal-body {
        padding: 25px;
    }
    
    .modal-footer {
        background-color: #f8f9fa;
        border-top: 1px solid #e0e0e0;
        padding: 15px 25px;
    }

    .form-control {
        border-radius: 8px;
        padding: 12px 15px;
        border: 1px solid #e0e0e0;
        transition: all 0.3s;
    }
    
    .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(139, 0, 0, 0.15);
    }

    .form-group label {
        font-weight: 600;
        color: #333;
        margin-bottom: 8px;
    }

    .content-detail {
        min-height: 100px;
        max-height: 300px;
        overflow-y: auto;
        padding: 15px;
        background-color: #f8f9fa;
        border-radius: 8px;
        border: 1px solid #e0e0e0;
    }

    .pagination {
        justify-content: center;
        margin-top: 25px;
    }
    
    .page-item.active .page-link {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }
    
    .page-link {
        color: var(--primary-color);
        border-radius: 5px;
        margin: 0 3px;
    }
    
    .page-link:hover {
        color: #c13030;
        background-color: #f8f9fa;
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

    /* Progress bar animation */
    @keyframes progressAnimation {
        0% { width: 0%; }
        100% { width: 100%; }
    }

    .progress {
        height: 5px;
        margin-top: 10px;
        border-radius: 3px;
        overflow: hidden;
    }

    .progress-bar {
        background: linear-gradient(90deg, var(--primary-color), #c13030);
        animation: progressAnimation 1.5s ease-in-out;
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .table-responsive {
            overflow-x: auto;
        }
        .btn-group .btn {
            padding: 0.2rem 0.4rem;
        }
        .modal-dialog.modal-lg {
            max-width: 95%;
            margin: 10px auto;
        }
    }
</style>
@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="dashboard-header fade-in">
                <h4 class="mt-4">Manajemen Pengumuman</h4>
                <ol class="breadcrumb mb-4 slide-in-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin2.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Manajemen Pengumuman Direktorat Jenderal Perlindungan dan Jaminan Sosial</li>
                </ol>
            </div>
            
            <div class="card bounce-in">
                <div class="card-header">
                    <h4><i class="fa fa-bullhorn"></i> Daftar Pengumuman Direktorat Jenderal Perlindungan dan Jaminan Sosial</h4>
                    <div class="card-tools">
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createPengumumanModal">
                            <i class="fa fa-plus"></i> Tambah Pengumuman
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show slide-in-up">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show slide-in-up">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="progress mb-4">
                        <div class="progress-bar"></div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Judul</th>
                                    <th>Kategori</th>
                                    <th width="10%">Status</th>
                                    <th>Tanggal Dibuat</th>
                                    <th width="15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pengumuman as $key => $item)
                                    <tr class="fade-in" style="animation-delay: {{ $key * 0.05 }}s">
                                        <td>{{ $pengumuman->firstItem() + $key }}</td>
                                        <td>{{ $item->title }}</td>
                                        <td>
                                            <span class="badge bg-success">Direktorat Jenderal Perlindungan dan Jaminan Sosial</span>
                                        </td>
                                        <td>
                                            @if($item->status == 'published')
                                                <span class="badge bg-success">Publikasi</span>
                                            @else
                                                <span class="badge bg-warning">Draft</span>
                                            @endif
                                        </td>
                                        <td>
                                            <i class="far fa-calendar-alt me-2 text-primary"></i>
                                            {{ $item->created_at->format('d M Y H:i') }}
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#showPengumumanModal{{ $item->id }}">
                                                    <i class="fa fa-eye"></i>
                                                </button>
                                                
                                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editPengumumanModal{{ $item->id }}">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                               
                                                <form action="{{ route('admin2.pengumuman2.update.status', $item->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-{{ $item->status == 'published' ? 'secondary' : 'success' }} btn-sm" title="{{ $item->status == 'published' ? 'Ubah ke Draft' : 'Publikasikan' }}">
                                                        <i class="fa fa-{{ $item->status == 'published' ? 'times' : 'check' }}"></i>
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin2.pengumuman2.destroy', $item->id) }}" method="POST" class="d-inline delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Tidak ada data pengumuman Direktorat Jenderal Perlindungan dan Jaminan Sosial</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $pengumuman->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Create Pengumuman -->
<div class="modal fade" id="createPengumumanModal" tabindex="-1" aria-labelledby="createPengumumanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content bounce-in">
            <div class="modal-header">
                <h5 class="modal-title" id="createPengumumanModalLabel"><i class="fa fa-plus-circle me-2"></i>Tambah Pengumuman Baru - Direktorat Jenderal Perlindungan dan Jaminan Sosial</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin2.pengumuman2.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <!-- Menampilkan kategori yang dipilih sebagai informasi saja -->
                    <div class="form-group mb-3">
                        <label>Kategori Pengumuman</label>
                        <input type="text" class="form-control" value="Direktorat Jenderal Perlindungan dan Jaminan Sosial" readonly disabled>
                        <small class="form-text text-muted">Pengumuman ini akan ditampilkan khusus untuk Direktorat Jenderal Perlindungan dan Jaminan Sosial</small>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="title">Judul Pengumuman <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="isi">Isi Pengumuman <span class="text-danger">*</span></label>
                        <textarea class="form-control summernote" id="isi" name="isi" rows="5" required></textarea>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="content">Content (JPG, PNG, MP4, MOV)</label>
                        <input type="file" class="form-control" id="content" name="content">
                        <small class="form-text text-muted">Ukuran maksimal 10MB</small>
                    </div>

                    <div class="form-group mb-3">
                        <label for="attachment">Lampiran (PDF, JPG, PNG, DOC, DOCX, XLS, XLSX)</label>
                        <input type="file" class="form-control" id="attachment" name="attachment">
                        <small class="form-text text-muted">Ukuran maksimal 10MB</small>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="status">Status <span class="text-danger">*</span></label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="draft">Draft</option>
                            <option value="published">Publikasikan</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Show dan Edit Pengumuman untuk setiap item -->
@foreach($pengumuman as $item)
    <!-- Modal Show Pengumuman -->
    <div class="modal fade" id="showPengumumanModal{{ $item->id }}" tabindex="-1" aria-labelledby="showPengumumanModalLabel{{ $item->id }}" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content slide-in-up">
                <div class="modal-header">
                    <h5 class="modal-title" id="showPengumumanModalLabel{{ $item->id }}"><i class="fa fa-eye me-2"></i>Detail Pengumuman</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-header">
                            <h5>{{ $item->title }}</h5>
                            <small class="text-muted">
                                <i class="far fa-calendar-alt me-1"></i> Dibuat pada: {{ $item->created_at->format('d M Y H:i') }} | 
                                Status: 
                                @if($item->status == 'published')
                                    <span class="badge bg-success">Publikasi</span>
                                @else
                                    <span class="badge bg-warning">Draft</span>
                                @endif
                            </small>
                        </div>
                        <div class="card-body">
                            <div class="progress mb-4">
                                <div class="progress-bar"></div>
                            </div>
                            
                            <h6 class="fw-bold"><i class="fas fa-align-left me-2 text-primary"></i>Ringkasan:</h6>
                            <p>{{ $item->isi }}</p>
                            
                            @if($item->content)
                                <h6 class="fw-bold mt-4"><i class="fas fa-file-alt me-2 text-primary"></i>Content:</h6>
                                <div class="content-section p-3 bg-light rounded">
                                    <a href="{{ Storage::url($item->content) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="fa fa-file"></i> Lihat Content
                                    </a>
                                </div>
                            @endif
                            
                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <h6 class="fw-bold"><i class="fas fa-tag me-2 text-primary"></i>Kategori:</h6>
                                    <p>
                                        <span class="badge bg-success">Direktorat Jenderal Perlindungan dan Jaminan Sosial</span>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="fw-bold"><i class="fas fa-user me-2 text-primary"></i>Dibuat oleh:</h6>
                                    <p>{{ $item->admin->name ?? 'admin2' }}</p>
                                </div>
                            </div>
                            
                            @if($item->attachment)
                                <h6 class="fw-bold mt-4"><i class="fas fa-paperclip me-2 text-primary"></i>Lampiran:</h6>
                                <div class="attachment-section p-3 bg-light rounded">
                                    <a href="{{ Storage::url($item->attachment) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="fa fa-file"></i> Lihat Lampiran
                                    </a>
                                </div>
                            @endif
                            
                            @if($item->status == 'published' && $item->published_at)
                                <div class="published-info mt-4 p-2 bg-light rounded">
                                    <small class="text-muted"><i class="fas fa-globe me-1"></i> Dipublikasikan pada: {{ \Carbon\Carbon::parse($item->published_at)->format('d M Y H:i') }}</small>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#editPengumumanModal{{ $item->id }}">Edit</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Pengumuman -->
    <div class="modal fade" id="editPengumumanModal{{ $item->id }}" tabindex="-1" aria-labelledby="editPengumumanModalLabel{{ $item->id }}" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content slide-in-up">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPengumumanModalLabel{{ $item->id }}"><i class="fa fa-edit me-2"></i>Edit Pengumuman - Direktorat Jenderal Perlindungan dan Jaminan Sosial</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin2.pengumuman2.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="progress mb-4">
                            <div class="progress-bar"></div>
                        </div>
                        
                        <!-- Menampilkan kategori yang dipilih sebagai informasi saja -->
                        <div class="form-group mb-3">
                            <label>Kategori Pengumuman</label>
                            <input type="text" class="form-control" value="Direktorat Jenderal Perlindungan dan Jaminan Sosial" readonly disabled>
                            <small class="form-text text-muted">Pengumuman ini akan ditampilkan khusus untuk Direktorat Jenderal Perlindungan dan Jaminan Sosial</small>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="title{{ $item->id }}">Judul Pengumuman <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="title{{ $item->id }}" name="title" value="{{ $item->title }}" required>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="isi{{ $item->id }}">Isi Pengumuman <span class="text-danger">*</span></label>
                            <textarea class="form-control summernote" id="isi{{ $item->id }}" name="isi" rows="5" required>{{ $item->isi }}</textarea>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="content{{ $item->id }}">Content (JPG, PNG, MP4, MOV)</label>
                            <input type="file" class="form-control" id="content{{ $item->id }}" name="content">
                            @if($item->content)
                                <div class="mt-2">
                                    <small class="form-text text-muted">File saat ini: {{ basename($item->content) }}</small>
                                    <div class="mt-1">
                                        <a href="{{ Storage::url($item->content) }}" target="_blank" class="btn btn-sm btn-outline-info">
                                            <i class="fa fa-file"></i> Lihat File
                                        </a>
                                    </div>
                                </div>
                            @endif
                            <small class="form-text text-muted">Biarkan kosong jika tidak ingin mengubah file. Ukuran maksimal 10MB</small>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="attachment{{ $item->id }}">Lampiran (PDF, JPG, PNG, DOC, DOCX, XLS, XLSX)</label>
                            <input type="file" class="form-control" id="attachment{{ $item->id }}" name="attachment">
                            @if($item->attachment)
                                <div class="mt-2">
                                    <small class="form-text text-muted">File saat ini: {{ basename($item->attachment) }}</small>
                                    <div class="mt-1">
                                        <a href="{{ Storage::url($item->attachment) }}" target="_blank" class="btn btn-sm btn-outline-info">
                                            <i class="fa fa-file"></i> Lihat File
                                        </a>
                                    </div>
                                </div>
                            @endif
                            <small class="form-text text-muted">Biarkan kosong jika tidak ingin mengubah file. Ukuran maksimal 10MB</small>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="status{{ $item->id }}">Status <span class="text-danger">*</span></label>
                            <select class="form-control" id="status{{ $item->id }}" name="status" required>
                                <option value="draft" {{ $item->status == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="published" {{ $item->status == 'published' ? 'selected' : '' }}>Publikasikan</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach

@endsection

@section('scripts')
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap 5 JS Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Summernote JS -->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>

<script>
    $(document).ready(function() {
        // Inisialisasi Summernote untuk semua textarea dengan class summernote
        $('.summernote').each(function() {
            $(this).summernote({
                height: 300,
                placeholder: 'Tulis konten detail pengumuman di sini...',
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ],
                callbacks: {
                    onImageUpload: function(files) {
                        // Menangani upload gambar jika diperlukan
                        alert('Upload gambar tidak diaktifkan, gunakan URL gambar');
                    }
                }
            });
        });

        // Konfirmasi hapus data
        $('.delete-form').on('submit', function(e) {
            e.preventDefault();
            var form = this;
            
            if (confirm('Apakah Anda yakin ingin menghapus pengumuman ini?')) {
                form.submit();
            }
        });
        
        // Aktivasi popover dan tooltip jika diperlukan
        $('[data-bs-toggle="popover"]').popover();
        $('[data-bs-toggle="tooltip"]').tooltip();
        
        // Animasi untuk baris tabel
        function animateRows() {
            $('tbody tr').each(function(index) {
                $(this).css('animation-delay', (index * 0.05) + 's');
                $(this).addClass('fade-in');
            });
        }
        
        // Panggil fungsi animasi
        animateRows();
        
        // Animasi untuk progress bar
        $('.progress-bar').css('width', '100%');
    });
</script>
@endsection