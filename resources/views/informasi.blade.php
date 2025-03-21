@extends('layouts.header')

@section('title', 'Informasi - Kementerian Sosial RI')

@section('additional_css')
<style>
    :root {
        --primary-color: #8b0000;
        --primary-hover: #a00000;
        --secondary-color: #FFD700;
        --text-light: #ffffff;
        --text-dark: #333333;
        --bg-light: #f8f9fa;
        --transition: all 0.3s ease;
    }

    body {
        font-family: 'Calibri', sans-serif;
        overflow-x: hidden;
    }

    /* Page Transition Animation */
    .fade-enter-active {
        animation: fadeIn 0.5s ease-in;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Hero Section */
    .hero {
        position: relative;
        min-height: 100vh;
        background-image: url('images/bginformasi.png');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        display: flex;
        align-items: center;
        padding: 100px 10%;
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

    .hero-content {
        position: relative;
        z-index: 2;
        max-width: 600px;
        animation: slideInLeft 1s ease-out;
    }

    .hero-content h1 {
        font-size: 3.5rem;
        font-weight: 800;
        color: var(--text-light);
        margin-bottom: 1.5rem;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
    }

    .hero-content p {
        font-size: 1.2rem;
        line-height: 1.8;
        color: var(--text-light);
        margin-bottom: 2rem;
    }

    .hero-btn {
        display: inline-block;
        padding: 15px 35px;
        background-color: var(--secondary-color);
        color: var(--primary-color);
        font-weight: 600;
        border-radius: 30px;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: var(--transition);
        text-decoration: none;
    }

    .hero-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        background-color: var(--text-light);
    }

    /* Information Section */
    .information-section {
        padding: 80px 0;
        background-color: var(--bg-light);
    }

    .section-title {
        text-align: center;
        margin-bottom: 60px;
        animation: fadeIn 1s ease-out;
    }

    .section-title h2 {
        font-size: 2.5rem;
        color: var(--primary-color);
        font-weight: 700;
        margin-bottom: 20px;
    }

    .section-title::after {
        content: '';
        display: block;
        width: 80px;
        height: 4px;
        background-color: var(--secondary-color);
        margin: 20px auto;
    }

    
    .info-content {
        padding: 30px;
    }

    .info-content h4 {
        font-size: 1.8rem;
        color: var(--primary-color);
        margin-bottom: 15px;
    }

    .info-content p {
        font-size: 1.1rem;
        line-height: 1.8;
        color: var(--text-dark);
    }

    /* Struktur Organisasi Styling */
    .org-structure {
        margin-top: 50px;
        margin-bottom: 50px;
    }
    
    .direktorat-box {
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        margin-bottom: 30px;
        overflow: hidden;
        transition: transform 0.3s ease;
    }
    
    .direktorat-box:hover {
        transform: translateY(-5px);
    }
    
    .direktorat-header {
        background: var(--primary-color);
        color: #fff;
        padding: 20px;
        position: relative;
    }
    
    .direktorat-header h3 {
        margin: 0;
        font-size: 1.5rem;
        font-weight: 600;
    }
    
    .direktorat-body {
        padding: 25px;
    }
    
    .direktorat-body p {
        margin-bottom: 20px;
        line-height: 1.6;
    }
    
    .unit-accordion {
        margin-top: 20px;
    }
    
    .unit-card {
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        margin-bottom: 15px;
        overflow: hidden;
    }
    
    .unit-header {
        background-color: #f5f5f5;
        padding: 15px 20px;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-weight: 600;
        transition: background-color 0.3s ease;
    }
    
    .unit-header:hover {
        background-color: #e9e9e9;
    }
    
    .unit-body {
        padding: 20px;
        display: none;
        border-top: 1px solid #e0e0e0;
    }
    
    .unit-body.show {
        display: block;
    }
    
    .unit-body h5 {
        color: var(--primary-color);
        margin-bottom: 15px;
        font-size: 1.1rem;
        font-weight: 600;
    }
    
    .tugas-list {
        padding-left: 20px;
        margin-bottom: 20px;
    }
    
    .tugas-list li {
        margin-bottom: 8px;
        line-height: 1.5;
    }
    
    .contact-info {
        background-color: #f9f9f9;
        padding: 15px;
        border-radius: 8px;
        margin-top: 15px;
    }
    
    .contact-info p {
        margin: 5px 0;
        font-size: 0.95rem;
    }

    
    /* Animations */
    @keyframes slideInLeft {
        from {
            opacity: 0;
            transform: translateX(-100px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .hero-content h1 {
            font-size: 2.5rem;
        }

        .info-box {
            margin: 20px;
        }
    }
</style>
@endsection

@section('content')
@include('layouts.transisi')
    <!-- Hero Section -->
    <section class="hero fade-enter-active">
        <div class="hero-content">
            <h1>Informasi Layanan</h1>
            <p>Temukan berbagai informasi layanan dan program dari Kementerian Sosial Republik Indonesia untuk membantu meningkatkan kesejahteraan masyarakat Indonesia.</p>
            <a href="#informasi" class="hero-btn">Jelajahi Informasi</a>
        </div>
    </section>

    <!-- Information Section -->
    <section id="informasi" class="information-section">
        <div class="container">
            <div class="section-title">
                <h2>Informasi Penting</h2>
                <p>Pelajari lebih lanjut tentang Kementerian Sosial RI</p>
            </div>

            <div class="row">
                <div class="col-lg-12 mb-5">
                    <h2>Struktur Organisasi</h2>
                    <img src="images/informasi.png" alt="Struktur Organisasi" class="img-fluid">
                    <div class="info-content">
                        <h4>Struktur Organisasi Kementerian Sosial RI (Perpres No 110 Tahun 2021)</h4>
                        <p>Mengenal lebih dekat struktur organisasi Kementerian Sosial RI dan peran setiap bagian dalam melayani masyarakat Indonesia.</p>
                    </div>
                    
                    <!-- Struktur Organisasi Detail -->
                    <div class="org-structure">
                        <!-- Direktorat Jenderal Perlindungan dan Jaminan Sosial -->
                        <div class="direktorat-box">
                            <div class="direktorat-header">
                                <h3>Direktorat Jenderal Perlindungan dan Jaminan Sosial</h3>
                            </div>
                            <div class="direktorat-body">
                                <p><strong>Tugas dan Tanggung Jawab:</strong> Merumuskan serta melaksanakan kebijakan dan standardisasi teknis di bidang perlindungan dan jaminan sosial. Berfokus pada kegiatan penanganan bencana, perlindungan sosial korban bencana, serta penyelenggaraan jaminan sosial keluarga.</p>
                                
                                <div class="unit-accordion">
                                    <div class="unit-card">
                                        <div class="unit-header">
                                            Direktorat Perlindungan Sosial Korban Bencana Alam
                                            <span class="toggle-icon">+</span>
                                        </div>
                                        <div class="unit-body">
                                            <h5>Tugas Pokok dan Fungsi:</h5>
                                            <ul class="tugas-list">
                                                <li>Merumuskan kebijakan perlindungan sosial dan koordinasi penanganan korban bencana alam</li>
                                                <li>Memberikan bantuan sosial dan perlindungan bagi masyarakat terdampak bencana alam</li>
                                                <li>Menyusun norma, standar, prosedur, dan kriteria di bidang perlindungan sosial korban bencana alam</li>
                                                <li>Melaksanakan bimbingan teknis di bidang perlindungan sosial korban bencana alam</li>
                                                <li>Mengevaluasi dan melaporkan pelaksanaan kebijakan perlindungan sosial korban bencana alam</li>
                                            </ul>
                                            <div class="contact-info">
                                                <p><strong>Alamat:</strong> Gedung A Lt. 5, Jl. Salemba Raya No. 28, Jakarta Pusat</p>
                                                <p><strong>Telepon:</strong> (021) 3103591 ext. 231</p>
                                                <p><strong>Email:</strong> perlindungan.alam@kemsos.go.id</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="unit-card">
                                        <div class="unit-header">
                                            Direktorat Perlindungan Sosial Korban Bencana Sosial
                                            <span class="toggle-icon">+</span>
                                        </div>
                                        <div class="unit-body">
                                            <h5>Tugas Pokok dan Fungsi:</h5>
                                            <ul class="tugas-list">
                                                <li>Merumuskan kebijakan perlindungan sosial bagi korban bencana sosial</li>
                                                <li>Memberikan perlindungan dan bantuan sosial bagi korban konflik sosial, pengungsi, dan kelompok rentan lainnya</li>
                                                <li>Melaksanakan mitigasi dan pencegahan bencana sosial</li>
                                                <li>Mengoordinasikan upaya rehabilitasi sosial korban bencana sosial</li>
                                                <li>Melakukan pemantauan, evaluasi, dan pelaporan di bidang perlindungan sosial korban bencana sosial</li>
                                            </ul>
                                            <div class="contact-info">
                                                <p><strong>Alamat:</strong> Gedung A Lt. 5, Jl. Salemba Raya No. 28, Jakarta Pusat</p>
                                                <p><strong>Telepon:</strong> (021) 3103591 ext. 237</p>
                                                <p><strong>Email:</strong> perlindungan.sosial@kemsos.go.id</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="unit-card">
                                        <div class="unit-header">
                                            Direktorat Jaminan Sosial Keluarga
                                            <span class="toggle-icon">+</span>
                                        </div>
                                        <div class="unit-body">
                                            <h5>Tugas Pokok dan Fungsi:</h5>
                                            <ul class="tugas-list">
                                                <li>Merumuskan kebijakan di bidang jaminan sosial keluarga</li>
                                                <li>Mengelola Program Keluarga Harapan (PKH) dan bantuan sosial non-tunai</li>
                                                <li>Mengembangkan sistem penyaluran bantuan sosial yang terintegrasi</li>
                                                <li>Melakukan verifikasi dan validasi data penerima bantuan sosial keluarga</li>
                                                <li>Melaksanakan monitoring dan evaluasi program jaminan sosial keluarga</li>
                                            </ul>
                                            <div class="contact-info">
                                                <p><strong>Alamat:</strong> Gedung B Lt. 3, Jl. Salemba Raya No. 28, Jakarta Pusat</p>
                                                <p><strong>Telepon:</strong> (021) 3103591 ext. 248</p>
                                                <p><strong>Email:</strong> jaminan.keluarga@kemsos.go.id</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Direktorat Jenderal Rehabilitasi Sosial -->
                        <div class="direktorat-box">
                            <div class="direktorat-header">
                                <h3>Direktorat Jenderal Rehabilitasi Sosial</h3>
                            </div>
                            <div class="direktorat-body">
                                <p><strong>Tugas dan Tanggung Jawab:</strong> Merumuskan dan melaksanakan kebijakan di bidang rehabilitasi sosial sesuai dengan ketentuan perundang-undangan. Bertanggung jawab pada upaya pemulihan dan pengembangan kemampuan bagi individu yang mengalami disfungsi sosial agar dapat melaksanakan fungsi sosialnya secara wajar.</p>
                                
                                <div class="unit-accordion">
                                    <div class="unit-card">
                                        <div class="unit-header">
                                            Direktorat Rehabilitasi Sosial Anak
                                            <span class="toggle-icon">+</span>
                                        </div>
                                        <div class="unit-body">
                                            <h5>Tugas Pokok dan Fungsi:</h5>
                                            <ul class="tugas-list">
                                                <li>Menyusun kebijakan, standardisasi, dan bimbingan teknis di bidang rehabilitasi sosial anak</li>
                                                <li>Menyelenggarakan program rehabilitasi sosial bagi anak terlantar, anak jalanan, dan anak yang membutuhkan perlindungan khusus</li>
                                                <li>Melaksanakan pengembangan model rehabilitasi sosial anak</li>
                                                <li>Memfasilitasi penyelenggaraan Lembaga Kesejahteraan Sosial Anak (LKSA)</li>
                                                <li>Melakukan pemantauan, evaluasi, dan pelaporan program rehabilitasi sosial anak</li>
                                            </ul>
                                            <div class="contact-info">
                                                <p><strong>Alamat:</strong> Gedung C Lt. 6, Jl. Salemba Raya No. 28, Jakarta Pusat</p>
                                                <p><strong>Telepon:</strong> (021) 3103591 ext. 314</p>
                                                <p><strong>Email:</strong> rehabilitasi.anak@kemsos.go.id</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="unit-card">
                                        <div class="unit-header">
                                            Direktorat Rehabilitasi Sosial Penyandang Disabilitas
                                            <span class="toggle-icon">+</span>
                                        </div>
                                        <div class="unit-body">
                                            <h5>Tugas Pokok dan Fungsi:</h5>
                                            <ul class="tugas-list">
                                                <li>Merumuskan kebijakan rehabilitasi sosial penyandang disabilitas</li>
                                                <li>Melaksanakan program rehabilitasi sosial bagi penyandang disabilitas fisik, mental, intelektual, dan sensorik</li>
                                                <li>Mengembangkan aksesibilitas dan teknologi bantuan bagi penyandang disabilitas</li>
                                                <li>Menyelenggarakan bimbingan sosial, keterampilan, dan pemulihan kondisi psikososial</li>
                                                <li>Memfasilitasi pemberdayaan sosial dan ekonomi penyandang disabilitas</li>
                                            </ul>
                                            <div class="contact-info">
                                                <p><strong>Alamat:</strong> Gedung C Lt. 7, Jl. Salemba Raya No. 28, Jakarta Pusat</p>
                                                <p><strong>Telepon:</strong> (021) 3103591 ext. 325</p>
                                                <p><strong>Email:</strong> rehabilitasi.disabilitas@kemsos.go.id</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="unit-card">
                                        <div class="unit-header">
                                            Direktorat Rehabilitasi Sosial Korban Penyalahgunaan NAPZA
                                            <span class="toggle-icon">+</span>
                                        </div>
                                        <div class="unit-body">
                                            <h5>Tugas Pokok dan Fungsi:</h5>
                                            <ul class="tugas-list">
                                                <li>Merumuskan kebijakan dan program rehabilitasi sosial korban penyalahgunaan NAPZA</li>
                                                <li>Melaksanakan upaya pencegahan, penanganan, dan pemulihan bagi korban penyalahgunaan NAPZA</li>
                                                <li>Menyelenggarakan layanan rehabilitasi sosial berbasis masyarakat dan lembaga</li>
                                                <li>Memberikan bimbingan sosial, mental, dan keterampilan bagi korban penyalahgunaan NAPZA</li>
                                                <li>Memfasilitasi reintegrasi sosial eks-korban penyalahgunaan NAPZA ke dalam masyarakat</li>
                                            </ul>
                                            <div class="contact-info">
                                                <p><strong>Alamat:</strong> Gedung C Lt. 8, Jl. Salemba Raya No. 28, Jakarta Pusat</p>
                                                <p><strong>Telepon:</strong> (021) 3103591 ext. 337</p>
                                                <p><strong>Email:</strong> rehabilitasi.napza@kemsos.go.id</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Direktorat Jenderal Pemberdayaan Sosial -->
                        <div class="direktorat-box">
                            <div class="direktorat-header">
                                <h3>Direktorat Jenderal Pemberdayaan Sosial</h3>
                            </div>
                            <div class="direktorat-body">
                                <p><strong>Tugas dan Tanggung Jawab:</strong> Merumuskan dan melaksanakan kebijakan di bidang pemberdayaan sosial sesuai dengan ketentuan perundang-undangan. Fokus utama adalah pada pemberdayaan masyarakat, individu, keluarga, kelompok, dan komunitas dalam rangka peningkatan kesejahteraan sosial.</p>
                                
                                <div class="unit-accordion">
                                    <div class="unit-card">
                                        <div class="unit-header">
                                            Direktorat Pemberdayaan Sosial Perorangan, Keluarga, dan Kelembagaan Masyarakat
                                            <span class="toggle-icon">+</span>
                                        </div>
                                        <div class="unit-body">
                                            <h5>Tugas Pokok dan Fungsi:</h5>
                                            <ul class="tugas-list">
                                                <li>Merumuskan kebijakan pemberdayaan sosial perorangan, keluarga, dan kelembagaan masyarakat</li>
                                                <li>Mengembangkan program pemberdayaan keluarga rentan dan Potensi Sumber Kesejahteraan Sosial (PSKS)</li>
                                                <li>Menyelenggarakan penguatan kapasitas kelembagaan sosial masyarakat</li>
                                                <li>Memfasilitasi peningkatan partisipasi sosial masyarakat</li>
                                                <li>Melaksanakan pendampingan sosial bagi keluarga dan individu rentan</li>
                                            </ul>
                                            <div class="contact-info">
                                                <p><strong>Alamat:</strong> Gedung D Lt. 3, Jl. Salemba Raya No. 28, Jakarta Pusat</p>
                                                <p><strong>Telepon:</strong> (021) 3103591 ext. 413</p>
                                                <p><strong>Email:</strong> pemberdayaan.keluarga@kemsos.go.id</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="unit-card">
                                        <div class="unit-header">
                                            Direktorat Pemberdayaan Komunitas Adat Terpencil
                                            <span class="toggle-icon">+</span>
                                        </div>
                                        <div class="unit-body">
                                            <h5>Tugas Pokok dan Fungsi:</h5>
                                            <ul class="tugas-list">
                                                <li>Merumuskan kebijakan pemberdayaan Komunitas Adat Terpencil (KAT)</li>
                                                <li>Menyusun dan melaksanakan program pemberdayaan sosial bagi KAT</li>
                                                <li>Melakukan pemetaan sosial dan identifikasi kebutuhan KAT</li>
                                                <li>Menyelenggarakan program peningkatan akses pelayanan dasar bagi KAT</li>
                                                <li>Melaksanakan advokasi sosial dan penguatan kapasitas kelembagaan adat</li>
                                            </ul>
                                            <div class="contact-info">
                                                <p><strong>Alamat:</strong> Gedung D Lt. 4, Jl. Salemba Raya No. 28, Jakarta Pusat</p>
                                                <p><strong>Telepon:</strong> (021) 3103591 ext. 427</p>
                                                <p><strong>Email:</strong> pemberdayaan.kat@kemsos.go.id</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="unit-card">
                                        <div class="unit-header">
                                            Direktorat Kepahlawanan, Keperintisan, Kesetiakawanan, dan Restorasi Sosial
                                            <span class="toggle-icon">+</span>
                                        </div>
                                        <div class="unit-body">
                                            <h5>Tugas Pokok dan Fungsi:</h5>
                                            <ul class="tugas-list">
                                                <li>Merumuskan kebijakan di bidang kepahlawanan, keperintisan, kesetiakawanan, dan restorasi sosial</li>
                                                <li>Mengelola dan meningkatkan kesejahteraan keluarga pahlawan nasional</li>
                                                <li>Mengembangkan nilai-nilai kepahlawanan dan kesetiakawanan sosial</li>
                                                <li>Melaksanakan program peningkatan kesejahteraan perintis kemerdekaan</li>
                                                <li>Menyelenggarakan restorasi sosial dan penguatan nilai-nilai sosial budaya masyarakat</li>
                                            </ul>
                                            <div class="contact-info">
                                                <p><strong>Alamat:</strong> Gedung D Lt. 5, Jl. Salemba Raya No. 28, Jakarta Pusat</p>
                                                <p><strong>Telepon:</strong> (021) 3103591 ext. 437</p>
                                                <p><strong>Email:</strong> kepahlawanan@kemsos.go.id</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Direktorat Jenderal Penanganan Fakir Miskin -->
                        <div class="direktorat-box">
                            <div class="direktorat-header">
                                <h3>Direktorat Jenderal Penanganan Fakir Miskin</h3>
                            </div>
                            <div class="direktorat-body">
                                <p><strong>Tugas dan Tanggung Jawab:</strong> Merumuskan dan melaksanakan kebijakan di bidang penanganan fakir miskin sesuai dengan ketentuan perundang-undangan. Bertanggung jawab dalam upaya pengentasan kemiskinan melalui program-program perlindungan sosial dan pemberdayaan masyarakat miskin.</p>
                                
                                <div class="unit-accordion">
                                    <div class="unit-card">
                                        <div class="unit-header">
                                            Direktorat Penanganan Fakir Miskin Wilayah I
                                            <span class="toggle-icon">+</span>
                                        </div>
                                        <div class="unit-body">
                                            <h5>Tugas Pokok dan Fungsi:</h5>
                                            <ul class="tugas-list">
                                                <li>Merumuskan kebijakan penanganan fakir miskin di wilayah Sumatera</li>
                                                <li>Melaksanakan program penanggulangan kemiskinan berbasis pemberdayaan masyarakat</li>
                                                <li>Mengoordinasikan program bantuan sosial dan pemberdayaan ekonomi masyarakat miskin</li>
                                                <li>Melakukan pemantauan dan evaluasi program pengentasan kemiskinan di wilayah Sumatera</li>
                                                <li>Mengembangkan model penanganan fakir miskin yang adaptif dengan kondisi wilayah</li>
                                            </ul>
                                            <div>
						<div class="contact-info">
                                                <p><strong>Alamat:</strong> Gedung E Lt. 3, Jl. Salemba Raya No. 28, Jakarta Pusat</p>
                                                <p><strong>Telepon:</strong> (021) 3103591 ext. 512</p>
                                                <p><strong>Email:</strong> penanganan.wilayah1@kemsos.go.id</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="unit-card">
                                        <div class="unit-header">
                                            Direktorat Penanganan Fakir Miskin Wilayah II
                                            <span class="toggle-icon">+</span>
                                        </div>
                                        <div class="unit-body">
                                            <h5>Tugas Pokok dan Fungsi:</h5>
                                            <ul class="tugas-list">
                                                <li>Merumuskan kebijakan penanganan fakir miskin di wilayah Jawa, Bali, dan Nusa Tenggara</li>
                                                <li>Melaksanakan program penanggulangan kemiskinan berbasis pemberdayaan masyarakat</li>
                                                <li>Mengoordinasikan program bantuan sosial dan pemberdayaan ekonomi masyarakat miskin</li>
                                                <li>Melakukan pemantauan dan evaluasi program pengentasan kemiskinan di wilayah Jawa, Bali, dan Nusa Tenggara</li>
                                                <li>Mengembangkan model penanganan fakir miskin yang adaptif dengan kondisi wilayah</li>
                                            </ul>
                                            <div class="contact-info">
                                                <p><strong>Alamat:</strong> Gedung E Lt. 4, Jl. Salemba Raya No. 28, Jakarta Pusat</p>
                                                <p><strong>Telepon:</strong> (021) 3103591 ext. 524</p>
                                                <p><strong>Email:</strong> penanganan.wilayah2@kemsos.go.id</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="unit-card">
                                        <div class="unit-header">
                                            Direktorat Penanganan Fakir Miskin Wilayah III
                                            <span class="toggle-icon">+</span>
                                        </div>
                                        <div class="unit-body">
                                            <h5>Tugas Pokok dan Fungsi:</h5>
                                            <ul class="tugas-list">
                                                <li>Merumuskan kebijakan penanganan fakir miskin di wilayah Kalimantan, Sulawesi, Maluku, dan Papua</li>
                                                <li>Melaksanakan program penanggulangan kemiskinan berbasis pemberdayaan masyarakat</li>
                                                <li>Mengoordinasikan program bantuan sosial dan pemberdayaan ekonomi masyarakat miskin</li>
                                                <li>Melakukan pemantauan dan evaluasi program pengentasan kemiskinan di wilayah Kalimantan, Sulawesi, Maluku, dan Papua</li>
                                                <li>Mengembangkan model penanganan fakir miskin yang adaptif dengan kondisi wilayah</li>
                                            </ul>
                                            <div class="contact-info">
                                                <p><strong>Alamat:</strong> Gedung E Lt. 5, Jl. Salemba Raya No. 28, Jakarta Pusat</p>
                                                <p><strong>Telepon:</strong> (021) 3103591 ext. 536</p>
                                                <p><strong>Email:</strong> penanganan.wilayah3@kemsos.go.id</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Sekretariat Jenderal -->
                        <div class="direktorat-box">
                            <div class="direktorat-header">
                                <h3>Sekretariat Jenderal</h3>
                            </div>
                            <div class="direktorat-body">
                                <p><strong>Tugas dan Tanggung Jawab:</strong> Menyelenggarakan koordinasi pelaksanaan tugas, pembinaan, dan pemberian dukungan administrasi kepada seluruh unit organisasi di lingkungan Kementerian Sosial. Berperan sebagai penunjang teknis dan administratif untuk kelancaran pelaksanaan program dan kegiatan di Kementerian Sosial.</p>
                                
                                <div class="unit-accordion">
                                    <div class="unit-card">
                                        <div class="unit-header">
                                            Biro Perencanaan
                                            <span class="toggle-icon">+</span>
                                        </div>
                                        <div class="unit-body">
                                            <h5>Tugas Pokok dan Fungsi:</h5>
                                            <ul class="tugas-list">
                                                <li>Menyusun perencanaan program dan anggaran Kementerian Sosial</li>
                                                <li>Melakukan koordinasi dan sinkronisasi perencanaan program antar unit kerja</li>
                                                <li>Mengelola data dan informasi perencanaan program kerja</li>
                                                <li>Melaksanakan pemantauan, evaluasi, dan pelaporan program kerja Kementerian</li>
                                                <li>Menyusun dokumen perencanaan strategis dan rencana kerja tahunan</li>
                                            </ul>
                                            <div class="contact-info">
                                                <p><strong>Alamat:</strong> Gedung A Lt. 3, Jl. Salemba Raya No. 28, Jakarta Pusat</p>
                                                <p><strong>Telepon:</strong> (021) 3103591 ext. 152</p>
                                                <p><strong>Email:</strong> biro.perencanaan@kemsos.go.id</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="unit-card">
                                        <div class="unit-header">
                                            Biro Keuangan
                                            <span class="toggle-icon">+</span>
                                        </div>
                                        <div class="unit-body">
                                            <h5>Tugas Pokok dan Fungsi:</h5>
                                            <ul class="tugas-list">
                                                <li>Mengelola anggaran dan pelaksanaan anggaran Kementerian</li>
                                                <li>Melaksanakan perbendaharaan dan verifikasi keuangan</li>
                                                <li>Mengelola akuntansi dan pelaporan keuangan</li>
                                                <li>Menyusun laporan keuangan dan pertanggungjawaban anggaran</li>
                                                <li>Melakukan pembinaan administrasi keuangan di lingkungan Kementerian</li>
                                            </ul>
                                            <div class="contact-info">
                                                <p><strong>Alamat:</strong> Gedung A Lt. 4, Jl. Salemba Raya No. 28, Jakarta Pusat</p>
                                                <p><strong>Telepon:</strong> (021) 3103591 ext. 164</p>
                                                <p><strong>Email:</strong> biro.keuangan@kemsos.go.id</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Include Side Menu -->
    @include('layouts.menu')
    @include('layouts.footer')

    <!-- JavaScript untuk accordion -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const unitHeaders = document.querySelectorAll('.unit-header');
            
            unitHeaders.forEach(header => {
                header.addEventListener('click', function() {
                    const body = this.nextElementSibling;
                    const isOpen = body.classList.contains('show');
                    
                    // Close all other open bodies
                    document.querySelectorAll('.unit-body.show').forEach(openBody => {
                        if (openBody !== body) {
                            openBody.classList.remove('show');
                            openBody.previousElementSibling.querySelector('.toggle-icon').textContent = '+';
                        }
                    });
                    
                    // Toggle current body
                    if (isOpen) {
                        body.classList.remove('show');
                        this.querySelector('.toggle-icon').textContent = '+';
                    } else {
                        body.classList.add('show');
                        this.querySelector('.toggle-icon').textContent = '-';
                    }
                });
            });
            
            // Smooth scroll for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    document.querySelector(this.getAttribute('href')).scrollIntoView({
                        behavior: 'smooth'
                    });
                });
            });
        });
    </script>
@endsection