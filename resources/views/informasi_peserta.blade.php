@extends('layouts.header')

@section('title', 'Informasi Peserta Magang - Kementerian Sosial RI')

@section('additional_css')
<style>
    /* Variabel warna dan tampilan */
    :root {
        --primary-color: #8b0000;
        --primary-hover: #a00000;
        --secondary-color: #FFD700;
        --accent-color: #1a73e8;
        --text-light: #ffffff;
        --text-dark: #333333;
        --bg-light: #f8f9fa;
        --card-shadow: 0 10px 20px rgba(0,0,0,0.1);
        --transition: all 0.3s ease;
    }

    /* Hero section dengan background gradient */
    .hero-section {
        background: linear-gradient(135deg, var(--primary-color) 0%, #5d0000 100%);
        color: var(--text-light);
        padding: 60px 0;
        margin-bottom: 50px;
        text-align: center;
        position: relative;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }

    .hero-section::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: url('path/to/pattern.svg');
        opacity: 0.1;
        pointer-events: none;
    }

    .hero-section h1 {
        font-size: 3rem;
        font-weight: 800;
        margin-bottom: 15px;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
    }

    .hero-section p {
        font-size: 1.2rem;
        max-width: 700px;
        margin: 0 auto;
    }

    /* Kartu statistik dengan desain modern */
    .statistics-card {
        background-color: white;
        border-radius: 15px;
        box-shadow: var(--card-shadow);
        padding: 30px;
        margin-bottom: 40px;
        transition: var(--transition);
        position: relative;
        overflow: hidden;
        z-index: 1;
        border-top: 5px solid var(--secondary-color);
    }

    .statistics-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.15);
    }

    .statistics-card::after {
        content: '';
        position: absolute;
        bottom: 0;
        right: 0;
        width: 100px;
        height: 100px;
        background: radial-gradient(circle, var(--secondary-color) 0%, rgba(255,215,0,0) 70%);
        opacity: 0.3;
        z-index: -1;
        border-radius: 50%;
    }

    .statistics-title {
        color: var(--primary-color);
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 20px;
        padding-bottom: 15px;
        position: relative;
    }

    .statistics-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 80px;
        height: 4px;
        background: var(--secondary-color);
        border-radius: 2px;
    }

    .stat-number {
        font-size: 3rem;
        font-weight: 800;
        color: var(--primary-color);
        margin-bottom: 5px;
        line-height: 1;
    }

    .stat-label {
        font-size: 1.1rem;
        color: var(--text-dark);
        opacity: 0.8;
        font-weight: 500;
    }

    /* Bagian direktorat dengan kartu modern */
    .direktorat-card {
        margin-bottom: 40px;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: var(--card-shadow);
        transition: var(--transition);
    }

    .direktorat-card:hover {
        box-shadow: 0 15px 30px rgba(0,0,0,0.15);
    }

    .direktorat-header {
        background: linear-gradient(to right, var(--primary-color), #5d0000);
        color: var(--text-light);
        padding: 20px 25px;
        font-weight: 700;
        font-size: 1.4rem;
        display: flex;
        align-items: center;
    }

    .direktorat-header i {
        margin-right: 15px;
        font-size: 1.8rem;
    }

    /* Tabel dengan desain modern */
    /* CSS untuk memperbaiki kontras warna tabel */
table {
    width: 100%;
    border-collapse: collapse;
    border-spacing: 0;
    margin-bottom: 20px;
}

/* Header tabel dengan warna merah yang tetap sesuai tema Kemensos */
thead tr, th {
    background-color: #8b0000; /* Merah tua sesuai tema Kemensos */
    color: #ffffff; /* Teks putih untuk kontras tinggi */
    font-weight: 600;
    padding: 12px 15px;
    text-align: left;
    border: 1px solid #960000; /* Border sedikit lebih terang */
}

/* Warna baris ganjil */
tbody tr:nth-child(odd) {
    background-color: #f9f9f9; /* Latar belakang abu-abu sangat terang */
    color: #333333; /* Teks hitam */
}

/* Warna baris genap */
tbody tr:nth-child(even) {
    background-color: #ffffff; /* Latar belakang putih */
    color: #333333; /* Teks hitam */
}

/* Hover efek pada baris */
tbody tr:hover {
    background-color: #f0f0f0; /* Abu-abu saat hover */
}

/* Sel tabel */
td {
    padding: 12px 15px;
    border: 1px solid #dddddd;
    vertical-align: middle;
}

/* Untuk bagian heading yang masih ingin menggunakan warna merah */
.table-heading {
    background-color: #8b0000;
    color: #ffffff;
    padding: 10px 15px;
    font-weight: bold;
    border-radius: 5px 5px 0 0;
}

/* Untuk tabel dengan tema merah tapi tetap mudah dibaca */
.red-theme-table tbody tr:nth-child(odd) {
    background-color: #fff0f0; /* Pink sangat pucat */
    color: #333333;
}

.red-theme-table tbody tr:nth-child(even) {
    background-color: #ffffff;
    color: #333333;
}

    /* Pesan tidak ada data */
    .no-data {
        background-color: var(--bg-light);
        text-align: center;
        padding: 50px 30px;
        border-radius: 15px;
        color: #6c757d;
        box-shadow: inset 0 0 15px rgba(0,0,0,0.05);
    }

    .no-data h4 {
        font-weight: 600;
        margin-bottom: 15px;
        color: var(--primary-color);
    }

    .no-data i {
        font-size: 3rem;
        color: #d0d0d0;
        margin-bottom: 20px;
    }

    /* Statistik direktorat dengan mini-cards */
    .mini-stat-card {
        background-color: #f9f9f9;
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 15px;
        transition: var(--transition);
        border-left: 4px solid var(--primary-color);
    }

    .mini-stat-card:hover {
        transform: translateX(5px);
        background-color: #f0f0f0;
    }

    .mini-stat-card .stat-number {
        font-size: 2rem;
    }

    /* Animasi */
    .fade-in {
        animation: fadeIn 0.8s ease-out;
    }

    .slide-in {
        animation: slideIn 0.8s ease-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(-30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    /* Responsive */
    @media (max-width: 768px) {
        .hero-section h1 {
            font-size: 2.2rem;
        }
        
        .stat-number {
            font-size: 2.2rem;
        }
        
        .statistics-title {
            font-size: 1.3rem;
        }
        
        .direktorat-header {
            font-size: 1.2rem;
        }
    }
</style>
@endsection

@section('content')
    @include('layouts.transisi')
    <!-- Include Side Menu -->
    @include('layouts.menu')

    <!-- Hero Section -->
    <div class="hero-section">
        <div class="container">
            <h1><i class="fas fa-graduation-cap"></i> Informasi Peserta Magang</h1>
            <p>Kementerian Sosial Republik Indonesia turut berkomitmen mengembangkan talenta muda Indonesia melalui program magang berkualitas</p>
        </div>
    </div>

    <div class="container fade-in">
        <!-- Statistik dengan desain card modern -->
        <div class="row mb-5">
            <div class="col-lg-4 mb-4">
                <div class="statistics-card text-center">
                    <h3 class="statistics-title"><i class="fas fa-users"></i> Total Peserta</h3>
                    <p class="stat-number">{{ $totalPeserta }}</p>
                    <p class="stat-label">Peserta Aktif</p>
                    <div class="progress mt-3" style="height: 8px;">
                        <div class="progress-bar bg-danger" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 mb-4">
                <div class="statistics-card">
                    <h3 class="statistics-title"><i class="fas fa-chart-pie"></i> Distribusi per Direktorat</h3>
                    <div class="row">
                        @forelse($statistik as $stat)
                            <div class="col-md-4 col-sm-6 mb-3">
                                <div class="mini-stat-card text-center">
                                    <p class="stat-number">{{ $stat->total }}</p>
                                    <p class="stat-label">{{ $stat->direktorat }}</p>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="no-data">
                                    <i class="fas fa-chart-bar"></i>
                                    <h4>Belum Ada Data Statistik</h4>
                                    <p>Statistik direktorat akan ditampilkan saat data tersedia</p>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Daftar Peserta dengan desain yang lebih menarik -->
        <div class="text-center mb-5">
            <h2 style="color: var(--primary-color); font-weight: 700; position: relative; display: inline-block; padding-bottom: 10px;">
                Daftar Peserta Magang
                <span style="position: absolute; bottom: 0; left: 50%; transform: translateX(-50%); width: 80px; height: 4px; background: var(--secondary-color);"></span>
            </h2>
        </div>

        @php
            $direktoratGroups = $peserta->groupBy('direktorat');
            $icons = [
                'Direktorat Jenderal' => 'building',
                'Sekretariat Jenderal' => 'briefcase',
                'Inspektorat Jenderal' => 'search',
                'Badan Pendidikan' => 'book',
                'Direktorat Rehabilitasi Sosial' => 'hands-helping',
                'Direktorat Perlindungan Sosial' => 'shield-alt',
                'Direktorat Pemberdayaan Sosial' => 'people-carry',
                'default' => 'sitemap'
            ];
        @endphp

        @forelse($direktoratGroups as $direktorat => $pesertaGroup)
            <div class="direktorat-card slide-in">
                <div class="direktorat-header">
                    @php
                        $iconClass = isset($icons[$direktorat]) ? $icons[$direktorat] : $icons['default'];
                    @endphp
                    <i class="fas fa-{{ $iconClass }}"></i>
                    {{ $direktorat }}
                </div>
                <div class="table-responsive">
                    <table class="modern-table">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="25%">Nama Lengkap</th>
                                <th width="30%">Asal Universitas/Sekolah</th>
                                <th width="20%">Unit Kerja</th>
                                <th width="20%">Program Studi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pesertaGroup as $index => $p)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td><strong>{{ $p->nama_lengkap }}</strong></td>
                                    <td>{{ $p->asal_universitas }}</td>
                                    <td>{{ $p->unit_kerja }}</td>
                                    <td>{{ $p->prodi }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @empty
            <div class="no-data my-5">
                <i class="fas fa-user-graduate"></i>
                <h4>Belum Ada Peserta Magang yang Diterima</h4>
                <p>Silakan cek kembali nanti untuk informasi terbaru mengenai penerimaan peserta magang</p>
                <a href="#" class="btn btn-danger mt-3">Informasi Pendaftaran Magang</a>
            </div>
        @endforelse
    </div>

    @include('layouts.footer')
@endsection