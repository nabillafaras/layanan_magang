@extends('layouts.header')

@section('title', 'Hasil Cek Status - Kementerian Sosial RI')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Status Pendaftaran</h4>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h5>Informasi Pendaftaran</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <td style="width: 40%"><strong>Nomor Pendaftaran</strong></td>
                                    <td>{{ $pendaftaran->nomor_pendaftaran }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Nama Lengkap</strong></td>
                                    <td>{{ $pendaftaran->nama_lengkap }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Institusi</strong></td>
                                    <td>{{ $pendaftaran->asal_universitas }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Program Studi</strong></td>
                                    <td>{{ $pendaftaran->prodi }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Status</strong></td>
                                    <td>
                                        <span class="badge {{ $pendaftaran->status == 'Diproses' ? 'bg-warning' : 
                                            ($pendaftaran->status == 'Diterima' ? 'bg-success' : 'bg-danger') }}">
                                            {{ $pendaftaran->status }}
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    @if($pendaftaran->status == 'Diproses')
                        <div class="alert alert-warning">
                            <i class="fas fa-info-circle me-2"></i> Pendaftaran Anda sedang dalam proses. Mohon menunggu konfirmasi selanjutnya.
                        </div>
                    @elseif($pendaftaran->status == 'Ditolak')
                        <div class="alert alert-danger">
                            <h6 class="alert-heading">Pendaftaran Anda Ditolak</h6>
                            <p class="mb-0"><strong>Catatan:</strong></p>
                            <p>{{ $pendaftaran->catatan ?? 'Tidak ada catatan yang diberikan.' }}</p>
                        </div>
                    @elseif($pendaftaran->status == 'Diterima')
                        <div class="alert alert-success">
                            <h6 class="alert-heading">Selamat! Pendaftaran Anda Diterima</h6>
                            <p>Silakan login menggunakan kredensial berikut:</p>
                            <div class="row mb-2">
                                <div class="col-md-4"><strong>Nomor Pendaftaran:</strong></div>
                                <div class="col-md-8">{{ $pendaftaran->nomor_pendaftaran }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4"><strong>Password:</strong></div>
                                <div class="col-md-8">{{ session('temp_password') }}</div>
                            </div>
                            @if($pendaftaran->surat_balasan)
                                <a href="{{ asset('storage/'.$pendaftaran->surat_balasan) }}" target="_blank" class="btn btn-sm btn-success">
                                    <i class="fas fa-file-pdf me-1"></i> Unduh Surat Balasan
                                </a>
                            @endif
                        </div>
                    @endif

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('status.form') }}" class="btn btn-secondary">Kembali</a>
                        <a href="{{ route('home') }}" class="btn btn-primary">Halaman Utama</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection