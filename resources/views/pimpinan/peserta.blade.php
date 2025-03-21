@extends('layouts.header_pimpinan')

@section('title', 'Data Peserta Magang - Kementerian Sosial RI')

@section('additional_css')
<link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
<style>
    body {
        font-family: 'Calibri', sans-serif;
    }
    .card {
        box-shadow: 0 0 1px rgba(0,0,0,0.125), 0 1px 3px rgba(0,0,0,0.2);
        margin-bottom: 1rem;
    }
    .filter-card {
        background-color: #f8f9fa;
    }
    .badge-status {
        font-size: 0.8rem;
        padding: 0.4rem 0.6rem;
    }
    .card-title {
        margin-bottom: 0;
    }
    .btn-filter {
        background-color: #8b0000;
        color: white;
    }
    .btn-filter:hover {
        background-color: #6d0000;
        color: white;
    }
    .document-link {
        margin-bottom: 5px;
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Manajemen Peserta Magang</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('pimpinan.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Data Peserta Magang</li>
    </ol>

    <!-- Filters -->
    <div class="card filter-card mb-4">
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
    <div class="card">
        <div class="card-header bg-light">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Daftar Peserta Magang</h5>
                <div>
                    <button class="btn btn-sm btn-success" onclick="exportToExcel()">
                        <i class="fas fa-file-excel me-1"></i> Export Excel
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="datatables-peserta">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">No</th>
                            <th width="15%">No. Pendaftaran</th>
                            <th width="15%">Nama Lengkap</th>
                            <th width="15%">Direktorat</th>
                            <th width="15%">Institusi</th>
                            <th width="10%">Tanggal Daftar</th>
                            <th width="10%">Status</th>
                            <th width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($peserta as $key => $p)
                        <tr>
                            <td>{{ ($peserta->currentPage() - 1) * $peserta->perPage() + $key + 1 }}</td>
                            <td>{{ $p->nomor_pendaftaran }}</td>
                            <td>{{ $p->nama_lengkap }}<br>
                                <small class="text-muted">{{ $p->email }}</small>
                            </td>
                            <td>{{ $p->direktorat }}<br>
                                <small>{{ $p->unit_kerja }}</small>
                            </td>
                            <td>{{ $p->asal_universitas }}<br>
                                <small>{{ $p->prodi }}</small>
                            </td>
                            <td>{{ $p->created_at->format('d-m-Y') }}</td>
                            <td>
                                <span class="badge {{ $p->status == 'Diproses' ? 'bg-warning' : ($p->status == 'Diterima' ? 'bg-success' : 'bg-danger') }} badge-status">
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
                            <td colspan="8" class="text-center py-4">
                                <div>
                                    <i class="fas fa-search fa-3x text-muted mb-3"></i>
                                    <p>Tidak ada data peserta ditemukan.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-3">
                {{ $peserta->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Detail Modals -->
@foreach($peserta as $p)
<div class="modal fade" id="detailModal{{ $p->id }}" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Detail Peserta: {{ $p->nama_lengkap }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p><strong>No. Pendaftaran:</strong> {{ $p->nomor_pendaftaran }}</p>
                        <p><strong>Nama Lengkap:</strong> {{ $p->nama_lengkap }}</p>
                        <p><strong>Direktorat:</strong> {{ $p->direktorat }}</p>
                        <p><strong>Unit Kerja:</strong> {{ $p->unit_kerja }}</p>
                        <p><strong>Email:</strong> {{ $p->email }}</p>
                        <p><strong>No. Telepon:</strong> {{ $p->no_hp }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Institusi:</strong> {{ $p->asal_universitas }}</p>
                        <p><strong>Program Studi:</strong> {{ $p->prodi }}</p>
                        <p><strong>Tanggal Daftar:</strong> {{ $p->created_at->format('d-m-Y') }}</p>
                        <p><strong>Status:</strong> 
                            <span class="badge {{ $p->status == 'Diproses' ? 'bg-warning' : ($p->status == 'Diterima' ? 'bg-success' : 'bg-danger') }}">
                                {{ $p->status }}
                            </span>
                        </p>
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
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endforeach

@endsection

@section('additional_scripts')
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/xlsx@0.17.0/dist/xlsx.full.min.js"></script>
<script>
    // DataTable initialization
    window.addEventListener('DOMContentLoaded', event => {
        const datatablesSimple = document.getElementById('datatables-peserta');
        if (datatablesSimple) {
            new simpleDatatables.DataTable(datatablesSimple, {
                perPage: 10,
                perPageSelect: [10, 20, 30, 50],
                searchable: false,
                paging: false
            });
        }
    });

    // Export to Excel
    function exportToExcel() {
        const table = document.getElementById('datatables-peserta');
        const wb = XLSX.utils.table_to_book(table, {sheet: "Peserta Magang"});
        XLSX.writeFile(wb, 'data-peserta-magang.xlsx');
    }
</script>
@endsection