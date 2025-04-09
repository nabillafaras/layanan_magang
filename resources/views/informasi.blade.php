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

    .hero-content {
        position: relative;
        z-index: 2;
        max-width: 600px;
        animation: slideInLeft 1.2s ease-out;
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
        left: 0;
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

    .hero-btn {
        display: inline-block;
        padding: 15px 35px;
        background-color: var(--secondary-color);
        color: var(--primary-color);
        font-weight: 600;
        border-radius: 50px;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        text-decoration: none;
        position: relative;
        overflow: hidden;
        z-index: 1;
    }
    
    .hero-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 0%;
        height: 100%;
        background-color: white;
        transition: all 0.4s cubic-bezier(0.42, 0, 0.58, 1);
        z-index: -1;
    }

    .hero-btn:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
        color: var(--primary-color);
    }
    
    .hero-btn:hover::before {
        width: 100%;
    }
    
    .hero-btn i {
        margin-left: 8px;
        transition: transform 0.3s ease;
    }
    
    .hero-btn:hover i {
        transform: translateX(5px);
    }

    /* Information Section */
    .information-section {
        padding: 100px 0;
        background-color: var(--bg-light);
        position: relative;
        overflow: hidden;
    }
    
    .information-section::before {
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

    .info-content {
        padding: 30px;
        position: relative;
        z-index: 1;
    }

    .info-content h4 {
        font-size: 1.8rem;
        color: var(--primary-color);
        margin-bottom: 20px;
        font-weight: 600;
    }

    .info-content p {
        font-size: 1.1rem;
        line-height: 1.8;
        color: var(--text-dark);
    }
    
    /* Animated image container */
    .img-container {
        position: relative;
        overflow: hidden;
        border-radius: 15px;
        box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        margin-bottom: 30px;
        transition: all 0.5s ease;
    }
    
    .img-container:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.2);
    }
    
    .img-container img {
        transition: all 0.5s ease;
    }
    
    .img-container:hover img {
        transform: scale(1.05);
    }
    
    .img-container::after {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 50%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
        transform: skewX(-25deg);
        animation: shine 3s infinite;
    }
    
    @keyframes shine {
        0% {
            left: -100%;
        }
        20% {
            left: 100%;
        }
        100% {
            left: 100%;
        }
    }

    /* Struktur Organisasi Styling */
    .org-structure {
        margin-top: 70px;
        margin-bottom: 70px;
        position: relative;
        z-index: 1;
    }
    
    .direktorat-box {
        background-color: #fff;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        margin-bottom: 40px;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: 1px solid rgba(0,0,0,0.05);
        transform: translateY(0);
    }
    
    .direktorat-box:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        border-color: rgba(139,0,0,0.1);
    }
    
    .direktorat-header {
        background: linear-gradient(135deg, var(--primary-color) 0%, #a40000 100%);
        color: #fff;
        padding: 25px;
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
    
    .direktorat-header h3 {
        margin: 0;
        font-size: 1.6rem;
        font-weight: 700;
        position: relative;
        z-index: 1;
    }
    
    .direktorat-body {
        padding: 30px;
    }
    
    .direktorat-body p {
        margin-bottom: 25px;
        line-height: 1.7;
        color: #555;
    }
    
    .direktorat-body p strong {
        color: var(--primary-color);
        font-weight: 600;
    }
    
    .unit-accordion {
        margin-top: 25px;
    }
    
    .unit-card {
        border: 1px solid rgba(0,0,0,0.08);
        border-radius: 12px;
        margin-bottom: 20px;
        overflow: hidden;
        transition: all 0.3s ease;
        box-shadow: 0 5px 15px rgba(0,0,0,0.03);
    }
    
    .unit-card:hover {
        box-shadow: 0 8px 25px rgba(0,0,0,0.08);
        border-color: rgba(139,0,0,0.1);
    }
    
    .unit-header {
        background-color: #f8f8f8;
        padding: 18px 25px;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-weight: 600;
        transition: all 0.3s ease;
        color: #444;
        position: relative;
        overflow: hidden;
    }
    
    .unit-header::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        width: 5px;
        background: var(--primary-color);
        opacity: 0;
        transition: all 0.3s ease;
    }
    
    .unit-header:hover {
        background-color: #f0f0f0;
        color: var(--primary-color);
    }
    
    .unit-header:hover::before {
        opacity: 1;
    }
    
    .toggle-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 28px;
        height: 28px;
        background: rgba(139,0,0,0.1);
        color: var(--primary-color);
        border-radius: 50%;
        font-weight: bold;
        transition: all 0.3s ease;
    }
    
    .unit-header:hover .toggle-icon {
        background: var(--primary-color);
        color: white;
        transform: rotate(90deg);
    }
    
    .unit-body {
        padding: 0;
        max-height: 0;
        overflow: hidden;
        transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        border-top: 0;
        background: white;
    }
    
    .unit-body.show {
        padding: 25px;
        max-height: 1000px;
        border-top: 1px solid rgba(0,0,0,0.05);
    }
    
    .unit-body h5 {
        color: var(--primary-color);
        margin-bottom: 20px;
        font-size: 1.2rem;
        font-weight: 600;
        position: relative;
        display: inline-block;
        padding-bottom: 10px;
    }
    
    .unit-body h5::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 40px;
        height: 3px;
        background: var(--secondary-color);
        border-radius: 10px;
    }
    
    .tugas-list {
        padding-left: 20px;
        margin-bottom: 25px;
    }
    
    .tugas-list li {
        margin-bottom: 12px;
        line-height: 1.6;
        position: relative;
        padding-left: 10px;
    }
    
    .tugas-list li::before {
        content: '';
        position: absolute;
        left: -15px;
        top: 10px;
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: var(--primary-color);
    }
    
    .contact-info {
        background-color: #f9f9f9;
        padding: 20px;
        border-radius: 12px;
        margin-top: 20px;
        border-left: 4px solid var(--secondary-color);
        transition: all 0.3s ease;
    }
    
    .contact-info:hover {
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        transform: translateX(5px);
    }
    
    .contact-info p {
        margin: 8px 0;
        font-size: 0.95rem;
        display: flex;
        align-items: center;
    }
    
    .contact-info p strong {
        margin-right: 10px;
        color: #555;
        min-width: 70px;
        display: inline-block;
    }
    
    /* Animated Shapes */
    .shape {
        position: absolute;
        z-index: 0;
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

    /* Animations */
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
            text-align: center;
        }
        
        .hero-content {
            max-width: 100%;
        }
        
        .hero-content h1::after {
            left: 50%;
            transform: translateX(-50%);
        }
        
        .direktorat-header h3 {
            font-size: 1.4rem;
        }
    }

    @media (max-width: 768px) {
        .hero-content h1 {
            font-size: 2.5rem;
        }
        
        .hero-btn {
            padding: 12px 30px;
        }
        
        .information-section {
            padding: 70px 0;
        }
        
        .direktorat-box {
            margin-bottom: 30px;
        }
        
        .direktorat-header {
            padding: 20px;
        }
        
        .direktorat-body {
            padding: 25px;
        }
        
        .unit-header {
            padding: 15px 20px;
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
            font-size: 1.8rem;
        }
        
        .direktorat-header h3 {
            font-size: 1.3rem;
        }
        
        .unit-body.show {
            padding: 20px;
        }
    }
</style>
@endsection

@section('content')
@include('layouts.transisi')
    <!-- Hero Section -->
    <section class="hero">
        <!-- Animated Shapes -->
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        
        <div class="hero-content" data-aos="fade-right" data-aos-delay="200">
            <h1>Informasi Layanan</h1>
            <p>Temukan berbagai informasi layanan dan program dari Kementerian Sosial Republik Indonesia untuk membantu meningkatkan kesejahteraan masyarakat Indonesia.</p>
            <a href="#informasi" class="hero-btn">Jelajahi Informasi <i class="fas fa-arrow-right"></i></a>
        </div>
    </section>

    <!-- Information Section -->
    <section id="informasi" class="information-section">
        <div class="container">
            <div class="section-title" data-aos="fade-up">
                <h2>Informasi Penting</h2>
                <p>Pelajari lebih lanjut tentang Kementerian Sosial RI</p>
            </div>

            <div class="row">
                <div class="col-lg-12 mb-5">
                    <h2 data-aos="fade-up">Struktur Organisasi</h2>
                    <div class="img-container" data-aos="fade-up" data-aos-delay="100">
                        <img src="images/informasi.png" alt="Struktur Organisasi" class="img-fluid">
                    </div>
                    <div class="info-content" data-aos="fade-up" data-aos-delay="200">
                        <h4>Struktur Organisasi Kementerian Sosial RI (Perpres No 110 Tahun 2021)</h4>
                        <p>Mengenal lebih dekat struktur organisasi Kementerian Sosial RI dan peran setiap bagian dalam melayani masyarakat Indonesia.</p>
                    </div>
                    
                    <!-- Struktur Organisasi Detail -->
                    <div class="org-structure">
                        <!-- Direktorat Jenderal Perlindungan dan Jaminan Sosial -->
                        <div class="direktorat-box" data-aos="fade-up" data-aos-delay="100">
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
                                                <p><strong>Email:</strong>Email:</strong> jaminan.keluarga@kemsos.go.id</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Direktorat Jenderal Rehabilitasi Sosial -->
                        <div class="direktorat-box" data-aos="fade-up" data-aos-delay="200">
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
                        <div class="direktorat-box" data-aos="fade-up" data-aos-delay="300">
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
                        <div class="direktorat-box" data-aos="fade-up" data-aos-delay="400">
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
                        <div class="direktorat-box" data-aos="fade-up" data-aos-delay="500">
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
            // Initialize AOS animation library
            AOS.init({
                duration: 800,
                easing: 'ease-in-out',
                once: true,
                mirror: false
            });
            
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
                            openBody.previousElementSibling.querySelector('.toggle-icon').style.transform = 'rotate(0deg)';
                        }
                    });
                    
                    // Toggle current body with animation
                    if (isOpen) {
                        body.classList.remove('show');
                        this.querySelector('.toggle-icon').textContent = '+';
                        this.querySelector('.toggle-icon').style.transform = 'rotate(0deg)';
                    } else {
                        body.classList.add('show');
                        this.querySelector('.toggle-icon').textContent = '-';
                        this.querySelector('.toggle-icon').style.transform = 'rotate(90deg)';
                    }
                });
                
                // Add hover animation
                header.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateX(5px)';
                });
                
                header.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateX(0)';
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