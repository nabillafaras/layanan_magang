@extends('layouts.header')

@section('title', 'Informasi Peserta Magang - Kementerian Sosial RI')

@section('additional_css')
<style>
    /* Modern Variable Colors */
    :root {
        --primary-color: #8b0000;
        --primary-hover: #a00000;
        --secondary-color: #FFD700;
        --text-light: #ffffff;
        --text-dark: #333333;
        --bg-light: #f8f9fa;
        --transition: all 0.3s ease;
    }

    /* Hero Section */
    .hero {
        position: relative;
        min-height: 60vh;
        background-image: url('images/bg1.png');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        display: flex;
        align-items: center;
        padding: 100px 10%;
        overflow: hidden;
    }

    .hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(139, 0, 0, 0.9) 0%, rgba(139, 0, 0, 0.7) 100%);
        z-index: 1;
    }
    
    /* Animated particles effect */
    .hero::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjxwYXR0ZXJuIGlkPSJwYXR0ZXJuIiB4PSIwIiB5PSIwIiB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHBhdHRlcm5Vbml0cz0idXNlclNwYWNlT25Vc2UiIHBhdHRlcm5UcmFuc2Zvcm09InJvdGF0ZSg0NSkiPjxyZWN0IHg9IjAiIHk9IjAiIHdpZHRoPSIyIiBoZWlnaHQ9IjIiIGZpbGw9IiNGRkQ3MDAiIGZpbGwtb3BhY2l0eT0iMC4xNSIvPjwvcGF0dGVybj48cmVjdCB4PSIwIiB5PSIwIiB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSJ1cmwoI3BhdHRlcm4pIi8+PC9zdmc+');
        opacity: 0.4;
        z-index: 1;
        animation: moveBackground 20s linear infinite;
    }
    
    @keyframes moveBackground {
        0% {
            background-position: 0 0;
        }
        100% {
            background-position: 100px 100px;
        }
    }

    /* Animated Shapes */
    .shape {
        position: absolute;
        z-index: 2;
        opacity: 0.5;
    }
    
    .shape-1 {
        top: 10%;
        left: 5%;
        width: 50px;
        height: 50px;
        background: var(--secondary-color);
        border-radius: 50%;
        animation: floatAnimation 8s infinite alternate;
    }
    
    .shape-2 {
        bottom: 20%;
        right: 10%;
        width: 80px;
        height: 80px;
        background: var(--primary-color);
        border-radius: 10px;
        transform: rotate(45deg);
        animation: floatAnimation 12s infinite alternate-reverse;
    }
    
    @keyframes floatAnimation {
        0% {
            transform: translate(0, 0) rotate(0deg);
        }
        50% {
            transform: translate(20px, 20px) rotate(10deg);
        }
        100% {
            transform: translate(-20px, 10px) rotate(-10deg);
        }
    }

    .hero-content {
        position: relative;
        z-index: 2;
        max-width: 800px;
        margin: 0 auto;
        text-align: center;
        animation: fadeInUp 1.2s ease-out;
    }

    .hero-content h1 {
        font-size: clamp(2.5rem, 5vw, 3.5rem);
        font-weight: 800;
        color: var(--text-light);
        margin-bottom: 1.5rem;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        position: relative;
        display: inline-block;
    }
    
    .hero-content h1::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 4px;
        background: var(--secondary-color);
        border-radius: 10px;
        animation: expandWidth 1.5s ease-out forwards;
    }
    
    @keyframes expandWidth {
        from { width: 0; }
        to { width: 80px; }
    }

    .hero-content p {
        font-size: clamp(1.1rem, 2vw, 1.2rem);
        line-height: 1.8;
        color: var(--text-light);
        margin-bottom: 2.5rem;
        text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.2);
    }

    /* Main Content Section */
    .content-section {
        padding: 100px 0;
        background-color: var(--bg-light);
        position: relative;
        overflow: hidden;
    }
    
    .content-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjxwYXR0ZXJuIGlkPSJwYXR0ZXJuIiB4PSIwIiB5PSIwIiB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHBhdHRlcm5Vbml0cz0idXNlclNwYWNlT25Vc2UiIHBhdHRlcm5UcmFuc2Zvcm09InJvdGF0ZSg0NSkiPjxyZWN0IHg9IjAiIHk9IjAiIHdpZHRoPSIyIiBoZWlnaHQ9IjIiIGZpbGw9IiM4YjAwMDAiIGZpbGwtb3BhY2l0eT0iMC4wNSIvPjwvcGF0dGVybj48cmVjdCB4PSIwIiB5PSIwIiB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSJ1cmwoI3BhdHRlcm4pIi8+PC9zdmc+');
        opacity: 0.5;
    }

    .section-title {
        text-align: center;
        margin-bottom: 60px;
        position: relative;
    }
    
    .section-title h2 {
        font-size: clamp(2rem, 4vw, 2.5rem);
        color: var(--primary-color);
        font-weight: 700;
        margin-bottom: 20px;
        position: relative;
        display: inline-block;
    }
    
    .section-title h2::after {
        content: '';
        position: absolute;
        bottom: -15px;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 4px;
        background-color: var(--primary-color);
        border-radius: 10px;
    }
    
    .section-title p {
        font-size: 1.2rem;
        color: #666;
        max-width: 700px;
        margin: 20px auto 0;
    }

    /* Statistics Card Styling */
    .statistics-card {
        background-color: #fff;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        padding: 30px;
        margin-bottom: 40px;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: 1px solid rgba(0,0,0,0.05);
        position: relative;
        overflow: hidden;
        z-index: 1;
    }
    
    .statistics-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.15);
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
        display: flex;
        align-items: center;
    }
    
    .statistics-title i {
        margin-right: 10px;
        font-size: 1.8rem;
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
        transition: all 0.3s ease;
    }
    
    .statistics-card:hover .statistics-title::after {
        width: 120px;
    }
    
    .stat-number {
        font-size: 3rem;
        font-weight: 800;
        color: var(--primary-color);
        margin-bottom: 5px;
        line-height: 1;
        transition: all 0.3s ease;
    }
    
    .statistics-card:hover .stat-number {
        transform: scale(1.1);
    }
    
    .stat-label {
        font-size: 1.1rem;
        color: var(--text-dark);
        opacity: 0.8;
        font-weight: 500;
    }
    
    .progress {
        height: 8px;
        border-radius: 4px;
        overflow: hidden;
        margin-top: 15px;
        background-color: rgba(139, 0, 0, 0.1);
    }
    
    .progress-bar {
        background: linear-gradient(to right, var(--primary-color), #a40000);
        border-radius: 4px;
        transition: width 1.5s ease-in-out;
    }

    /* Mini Stat Card Styling */
    .mini-stat-card {
        background-color: #f9f9f9;
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 15px;
        transition: all 0.3s ease;
        border-left: 4px solid var(--primary-color);
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }
    
    .mini-stat-card:hover {
        transform: translateX(5px);
        background-color: #f0f0f0;
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    }
    
    .mini-stat-card .stat-number {
        font-size: 2rem;
        transition: all 0.3s ease;
    }
    
    .mini-stat-card:hover .stat-number {
        transform: scale(1.1);
        color: var(--primary-hover);
    }
    
    .mini-stat-card .stat-label {
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }
    
    .mini-stat-card:hover .stat-label {
        color: var(--primary-color);
    }

    /* Direktorat Card Styling */
    .direktorat-card {
        margin-bottom: 40px;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: 1px solid rgba(0,0,0,0.05);
        background-color: #fff;
    }
    
    .direktorat-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    }
    
    .direktorat-header {
        background: linear-gradient(135deg, var(--primary-color) 0%, #5d0000 100%);
        color: var(--text-light);
        padding: 20px 25px;
        font-weight: 700;
        font-size: 1.4rem;
        display: flex;
        align-items: center;
        position: relative;
        overflow: hidden;
    }
    
    .direktorat-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: rgba(255,255,255,0.1);
        z-index: 0;
    }
    
    .direktorat-header i {
        margin-right: 15px;
        font-size: 1.8rem;
        position: relative;
        z-index: 1;
        transition: all 0.3s ease;
    }
    
    .direktorat-card:hover .direktorat-header i {
        transform: scale(1.2) rotate(10deg);
    }

    /* Table Styling */
    .table-responsive {
    padding: 0;
    border-radius: 0 0 15px 15px;
    overflow-x: auto; /* Pastikan scroll horizontal aktif */
    overflow-y: hidden;
    -webkit-overflow-scrolling: touch; /* Smooth scroll di iOS */
    width: 100%;
    max-width: 100%;
}
    
    .modern-table {
    width: 100%;
    min-width: 800px; /* Minimum width agar bisa di-scroll */
    border-collapse: collapse;
    border-spacing: 0;
    margin-bottom: 0;
    }
    
    .modern-table thead tr {
        background-color: rgba(139, 0, 0, 0.05);
    }
    
    .modern-table th {
        background-color: var(--primary-color);
        color: #ffffff;
        font-weight: 600;
        padding: 15px;
        text-align: left;
        border: none;
        position: relative;
    }
    
    .modern-table th:after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 2px;
        background: var(--secondary-color);
        transform: scaleX(0);
        transition: transform 0.3s ease;
        transform-origin: right;
    }
    
    .direktorat-card:hover .modern-table th:after {
        transform: scaleX(1);
        transform-origin: left;
    }
    
    .modern-table tbody tr {
        transition: all 0.3s ease;
    }
    
    .modern-table tbody tr:nth-child(odd) {
        background-color: #f9f9f9;
    }
    
    .modern-table tbody tr:hover {
        background-color: rgba(255, 215, 0, 0.1);
        transform: translateX(5px);
    }
    
    .modern-table td {
        padding: 15px;
        border-bottom: 1px solid #eee;
        vertical-align: middle;
        transition: all 0.3s ease;
    }
    
    .modern-table tbody tr:last-child td {
        border-bottom: none;
    }
    
    .modern-table td strong {
        color: var(--primary-color);
        font-weight: 600;
    }

    /* No Data Styling */
    .no-data {
        background-color: #fff;
        text-align: center;
        padding: 60px 30px;
        border-radius: 15px;
        color: #6c757d;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: 1px solid rgba(0,0,0,0.05);
        position: relative;
        overflow: hidden;
    }
    
    .no-data:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    }
    
    .no-data::after {
        content: '';
        position: absolute;
        bottom: 0;
        right: 0;
        width: 150px;
        height: 150px;
        background: radial-gradient(circle, rgba(139, 0, 0, 0.1) 0%, rgba(139, 0, 0, 0) 70%);
        z-index: 0;
        border-radius: 50%;
    }
    
    .no-data h4 {
        font-weight: 700;
        margin-bottom: 15px;
        color: var(--primary-color);
        font-size: 1.5rem;
    }
    
    .no-data i {
        font-size: 4rem;
        color: rgba(139, 0, 0, 0.2);
        margin-bottom: 20px;
        transition: all 0.3s ease;
    }
    
    .no-data:hover i {
        transform: scale(1.2) rotate(10deg);
        color: rgba(139, 0, 0, 0.3);
    }
    
    .no-data p {
        font-size: 1.1rem;
        max-width: 500px;
        margin: 0 auto 20px;
    }
    
    .no-data .btn {
        background-color: var(--primary-color);
        color: white;
        border: none;
        padding: 10px 25px;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 5px 15px rgba(139, 0, 0, 0.3);
    }
    
    .no-data .btn:hover {
        background-color: var(--primary-hover);
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(139, 0, 0, 0.4);
    }

    /* Animations */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(50px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes slideInLeft {
        from {
            opacity: 0;
            transform: translateX(-70px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
    
    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(70px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
    
    @keyframes pulse {
        0% {
            transform: scale(1);
            opacity: 1;
        }
        50% {
            transform: scale(1.05);
            opacity: 0.8;
        }
        100% {
            transform: scale(1);
            opacity: 1;
        }
    }

    /* Responsive Design */
    @media (max-width: 992px) {
        .hero {
            padding: 80px 5%;
        }
        
        .content-section {
            padding: 70px 20px;
        }
        
        .statistics-title {
            font-size: 1.3rem;
        }
        
        .stat-number {
            font-size: 2.5rem;
        }
        
        .direktorat-header {
            font-size: 1.3rem;
        }
    }

    @media (max-width: 768px) {
        .hero-content h1 {
            font-size: 2.5rem;
        }
        
        .hero-content p {
            font-size: 1rem;
        }
        
        .section-title h2 {
            font-size: 1.8rem;
        }
        
        .statistics-title {
            font-size: 1.2rem;
        }
        
        .stat-number {
            font-size: 2.2rem;
        }
        
        .direktorat-header {
            font-size: 1.2rem;
            padding: 15px 20px;
        }
        
        .direktorat-header i {
            font-size: 1.5rem;
        }
        
        .modern-table th, .modern-table td {
            padding: 12px 10px;
        }
    }

    @media (max-width: 576px) {
        .hero {
            min-height: auto;
            padding: 60px 20px;
        }
        
        .hero-content h1 {
            font-size: 2.2rem;
        }
        
        .hero-content p {
            font-size: 1rem;
        }
        
        .section-title h2 {
            font-size: 1.6rem;
        }
        
        .statistics-card, .direktorat-card {
            padding: 20px;
        }
        
        .statistics-title {
            font-size: 1.1rem;
        }
        
        .stat-number {
            font-size: 2rem;
        }
        
        .mini-stat-card .stat-number {
            font-size: 1.8rem;
        }
        
        .modern-table {
            font-size: 0.9rem;
        }
    }
</style>
@endsection

@section('content')
@include('layouts.transisi')
    <!-- Include Side Menu -->
    @include('layouts.menu')

    <!-- Hero Section -->
    <section class="hero">
        <!-- Animated Shapes -->
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        
        <div class="hero-content">
            <h1 data-aos="fade-up"><i class="fas fa-graduation-cap"></i> Informasi Peserta Magang</h1>
            <p data-aos="fade-up" data-aos-delay="100">Kementerian Sosial Republik Indonesia turut berkomitmen mengembangkan talenta muda Indonesia melalui program magang berkualitas</p>
        </div>
    </section>

    <!-- Content Section -->
    <section class="content-section">
        <div class="container">
            <!-- Statistik dengan desain card modern -->
            <div class="section-title">
                <h2 data-aos="fade-up">Statistik Peserta Magang</h2>
                <p data-aos="fade-up" data-aos-delay="100">Informasi statistik peserta magang di Kementerian Sosial RI</p>
            </div>
            
            <div class="row mb-5">
                <div class="col-lg-4 mb-4">
                    <div class="statistics-card text-center" data-aos="fade-up" data-aos-delay="100">
                        <h3 class="statistics-title"><i class="fas fa-users"></i> Total Peserta</h3>
                        <p class="stat-number" data-aos="fade-up" data-aos-delay="150">{{ $totalPeserta }}</p>
                        <p class="stat-label">Peserta Aktif</p>
                        <div class="progress mt-3" style="height: 8px;">
                            <div class="progress-bar bg-danger" role="progressbar" style="width: 0%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 mb-4">
                    <div class="statistics-card" data-aos="fade-up" data-aos-delay="200">
                        <h3 class="statistics-title"><i class="fas fa-chart-pie"></i> Distribusi per Direktorat</h3>
                        <div class="row">
                            @forelse($statistik as $stat)
                                <div class="col-md-4 col-sm-6 mb-3">
                                    <div class="mini-stat-card text-center" data-aos="fade-up" data-aos-delay="{{ 250 + $loop->index * 50 }}">
                                        <p class="stat-number">{{ $stat->total }}</p>
                                        <p class="stat-label">{{ $stat->direktorat }}</p>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12">
                                    <div class="no-data" data-aos="fade-up" data-aos-delay="250">
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
            <div class="section-title">
                <h2 data-aos="fade-up">Daftar Peserta Magang</h2>
                <p data-aos="fade-up" data-aos-delay="100">Informasi peserta magang yang sedang aktif di Kementerian Sosial RI</p>
            </div>

            @php
                $direktoratGroups = $peserta->groupBy('direktorat');
                $icons = [
                    'Sekretariat Jenderal' => 'briefcase',
                    'Direktorat Jenderal Perlindungan dan Jaminan Sosial' => 'shield-alt',
                    'Direktorat Jenderal Rehabilitasi Sosial' => 'hands-helping',
                    'Direktorat Jenderal Pemberdayaan Sosial' => 'people-carry',
                    'Inspektorat Jenderal' => 'search',
                    'default' => 'sitemap'
                ];
            @endphp

            @forelse($direktoratGroups as $direktorat => $pesertaGroup)
                <div class="direktorat-card" data-aos="fade-up" data-aos-delay="{{ 100 + $loop->index * 100 }}">
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
                                    <th width="20%">Program/Keahlian</th>
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
                <div class="no-data my-5" data-aos="fade-up">
                    <i class="fas fa-user-graduate"></i>
                    <h4>Belum Ada Peserta Magang yang Diterima</h4>
                    <p>Silakan cek kembali nanti untuk informasi terbaru mengenai penerimaan peserta magang</p>
                    <a href="#" class="btn btn-danger mt-3">Informasi Pendaftaran Magang</a>
                </div>
            @endforelse
        </div>
    </section>

    @include('layouts.footer')
@endsection

@section('additional_scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize AOS animation library
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true,
            mirror: false
        });
        
        // Animate progress bar
        setTimeout(function() {
            document.querySelector('.progress-bar').style.width = '100%';
        }, 500);
        
        // Add hover animations for statistics cards
        const statCards = document.querySelectorAll('.statistics-card');
        statCards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.querySelector('.stat-number').style.transform = 'scale(1.1)';
                this.querySelector('.statistics-title::after').style.width = '120px';
            });
            
            card.addEventListener('mouseleave', function() {
                this.querySelector('.stat-number').style.transform = 'scale(1)';
                this.querySelector('.statistics-title::after').style.width = '80px';
            });
        });
        
        // Add hover animations for direktorat cards
        const direktoratCards = document.querySelectorAll('.direktorat-card');
        direktoratCards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.querySelector('.direktorat-header i').style.transform = 'scale(1.2) rotate(10deg)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.querySelector('.direktorat-header i').style.transform = 'scale(1) rotate(0)';
            });
        });
        
        // Add parallax effect to hero section
        window.addEventListener('scroll', function() {
            const scrollPosition = window.scrollY;
            const heroContent = document.querySelector('.hero-content');
            
            if (heroContent && window.innerWidth > 992) {
                heroContent.style.transform = `translateY(${scrollPosition * 0.1}px)`;
            }
        });
    });
</script>
@endsection