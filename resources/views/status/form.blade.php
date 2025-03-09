@extends('layouts.header')

@section('title', 'Cek Status Pendaftaran - Kementerian Sosial RI')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Cek Status Pendaftaran</h4>
                </div>
                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    
                    <p class="mb-4">Masukkan nomor pendaftaran Anda untuk memeriksa status pendaftaran magang.</p>
                    
                    <form action="{{ route('status.check') }}" method="POST">
                        @csrf
                        <div class="form-group mb-4">
                            <label for="nomor_pendaftaran" class="form-label">Nomor Pendaftaran</label>
                            <input type="text" class="form-control @error('nomor_pendaftaran') is-invalid @enderror" 
                                id="nomor_pendaftaran" name="nomor_pendaftaran" required>
                            @error('nomor_pendaftaran')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Cek Status</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection