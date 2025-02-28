<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rangkuman Pendaftaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
    body {
        background-color: #a40000; 
        display: flex;
    }
    .list-group-item {
        display: flex;
        align-items: center;
    }

    .label {
        min-width: 160px; /* Sesuaikan panjang agar titik dua sejajar */
        font-weight: bold;
        text-align: left;
        position: relative;
    }

    .label::after {
        content: ":"; /* Tambahkan titik dua */
        position: absolute;
        right: 0;
    }

    .value {
        margin-left: 10px; /* Beri jarak agar isi tetap sejajar */
        flex: 1;
    }
    .btn-primary {
            background-color: #FFD700;
            color: #a00000
    }


</style>
<body>
    <div class="container mt-5">
        <div class="card shadow p-4">
            <h2 class="text-center"><strong>Nomor Pendaftaran:</strong> {{ $pendaftaran->nomor_pendaftaran }}</h2>
            <p class="text-center text-muted">Berikut adalah informasi yang telah Anda daftarkan:</p>

            <ul class="list-group">
            <li class="list-group-item d-flex">
                    <strong class="label">password</strong> 
                    <span class="value">{{ session('temp_password') }}</span>
                </li>
                <li class="list-group-item d-flex">
                    <strong class="label">Nama Lengkap</strong> 
                    <span class="value">{{ $pendaftaran->nama_lengkap }}</span>
                </li>
                <li class="list-group-item d-flex">
                    <strong class="label">Email</strong> 
                    <span class="value">{{ $pendaftaran->email }}</span>
                </li>
                <li class="list-group-item d-flex">
                    <strong class="label">Asal Universitas</strong> 
                    <span class="value">{{ $pendaftaran->asal_universitas }}</span>
                </li>
                <li class="list-group-item d-flex">
                    <strong class="label">Jurusan</strong> 
                    <span class="value">{{ $pendaftaran->jurusan }}</span>
                </li>
                <li class="list-group-item d-flex">
                    <strong class="label">Prodi</strong> 
                    <span class="value">{{ $pendaftaran->prodi }}</span>
                </li>
                <li class="list-group-item d-flex">
                    <strong class="label">Semester</strong> 
                    <span class="value">{{ $pendaftaran->semester }}</span>
                </li>
                <li class="list-group-item d-flex">
                    <strong class="label">Direktorat</strong> 
                    <span class="value">{{ $pendaftaran->direktorat }}</span>
                </li>
                <li class="list-group-item d-flex">
                    <strong class="label">Unit Kerja</strong> 
                    <span class="value">{{ $pendaftaran->unit_kerja }}</span>
                </li>
            </ul>



            <a href="{{ route('home') }}" class="btn w-100 mt-4" style="background-color: #FFD700; color: #a00000;">Kembali ke Dashboard</a>
        
        
        </div>
    </div>
</body>
</html>
