@extends('layouts.header')

@section('title', 'Persyaratan - Kementerian Sosial RI')

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
        min-height: 100vh;
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

    .information-section .container {
        position: relative;
        z-index: 1;
    }

    .information-section h2 {
        font-size: clamp(2rem, 4vw, 2.5rem);
        color: var(--primary-color);
        font-weight: 700;
        margin-bottom: 30px;
        text-align: center;
        position: relative;
        display: inline-block;
        left: 20%;
        transform: translateX(-20%);
    }
    
    .information-section h2::after {
        content: '';
        position: absolute;
        bottom: -20px;
        left: 50%;
        transform: translateX(-20%);
        width: 80px;
        height: 4px;
        background: var(--primary-color);
        border-radius: 10px;
    }

    /* Requirements Box Styling */
    .requirements-box {
        background-color: #fff;
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        margin-bottom: 40px;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: 1px solid rgba(0,0,0,0.05);
        transform: translateY(0);
    }
    
    .requirements-box:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    }
    
    .requirements-box h3 {
        color: var(--primary-color);
        font-size: 1.8rem;
        font-weight: 700;
        padding-bottom: 15px;
        margin-bottom: 25px;
        position: relative;
    }
    
    .requirements-box h3::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100px;
        height: 3px;
        background: var(--secondary-color);
        border-radius: 10px;
    }
    
    .requirements-box ul {
        padding-left: 0;
        list-style: none;
    }
    
    .requirements-box li {
        margin-bottom: 25px;
        position: relative;
        padding-left: 30px;
        transition: all 0.3s ease;
    }
    
    .requirements-box li:hover {
        transform: translateX(5px);
    }
    
    .requirements-box li::before {
        content: "\f00c";
        font-family: "Font Awesome 5 Free";
        font-weight: 900;
        color: var(--primary-color);
        position: absolute;
        left: 0;
        top: 2px;
    }
    
    .requirements-box li strong {
        display: block;
        color: var(--primary-color);
        font-size: 1.2rem;
        margin-bottom: 8px;
    }
    
    .requirements-box li p {
        color: #555;
        line-height: 1.6;
        margin-bottom: 0;
    }

    /* Steps Box Styling */
    .steps-box {
        background-color: #fff;
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        margin-bottom: 40px;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: 1px solid rgba(0,0,0,0.05);
    }
    
    .steps-box:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    }
    
    .steps-box h3 {
        color: var(--primary-color);
        font-size: 1.8rem;
        font-weight: 700;
        padding-bottom: 15px;
        margin-bottom: 25px;
        position: relative;
    }
    
    .steps-box h3::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100px;
        height: 3px;
        background: var(--secondary-color);
        border-radius: 10px;
    }
    
    .step-item {
        display: flex;
        margin-bottom: 30px;
        transition: all 0.3s ease;
    }
    
    .step-item:hover {
        transform: translateX(10px);
    }
    
    .step-number {
        background: linear-gradient(135deg, var(--primary-color) 0%, #a40000 100%);
        color: white;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 20px;
        flex-shrink: 0;
        font-weight: 700;
        box-shadow: 0 5px 15px rgba(139,0,0,0.3);
        position: relative;
        z-index: 1;
        transition: all 0.3s ease;
    }
    
    .step-item:hover .step-number {
        transform: scale(1.1) rotate(10deg);
    }
    
    .step-content {
        flex-grow: 1;
    }
    
    .step-content h4 {
        margin-bottom: 10px;
        color: #444;
        font-weight: 600;
        font-size: 1.2rem;
    }
    
    .step-content p {
        color: #555;
        line-height: 1.6;
    }
    
    .step-content p strong {
        color: var(--primary-color);
        font-weight: 600;
    }

    /* Info Box Styling */
    .info-box {
    display: flex;
    align-items: flex-start;
    background: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    height: 100%;
    transition: transform 0.3s ease;
}

.info-box:hover {
    transform: translateY(-5px);
}

.icon-container {
    margin-right: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.info-box h3 {
    margin-top: 0;
    color: #333;
    font-weight: 600;
    margin-bottom: 10px;
}

.info-box p {
    color: #666;
    margin-bottom: 0;
}
    
    .info-box p strong {
        color: var(--primary-color);
        font-weight: 600;
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
        
        .information-section {
            padding: 70px 20px;
        }
    }

    @media (max-width: 768px) {
        .hero-content h1 {
            font-size: 2.5rem;
        }
        
        .hero-btn {
            padding: 12px 30px;
        }
        
        .info-box {
            flex-direction: column;
            align-items: center;
            text-align: center;
        }
        
        .info-box img {
            margin-right: 0;
            margin-bottom: 20px;
        }
        
        .info-box h3::after {
            left: 50%;
            transform: translateX(-50%);
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
        
        .requirements-box, .steps-box {
            padding: 20px;
        }
        
        .requirements-box h3, .steps-box h3 {
            font-size: 1.5rem;
        }
        
        .step-item {
            flex-direction: column;
        }
        
        .step-number {
            margin-bottom: 15px;
            margin-right: 0;
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
        <h1>Persyaratan Magang</h1>
        <p>Temukan informasi lengkap tentang persyaratan dan tata cara pendaftaran program magang di Kementerian Sosial Republik Indonesia.</p>
        <a href="#persyaratan" class="hero-btn">Lihat Persyaratan <i class="fas fa-arrow-right"></i></a>
    </div>
</section>

<!-- Information Section -->
<section id="persyaratan" class="information-section">
    <div class="container">
        <h2 data-aos="fade-up">Persyaratan Pendaftaran Magang di Kemensos RI</h2>
        
        <div class="requirements-box" data-aos="fade-up" data-aos-delay="100">
            <h3>Berkas dan Persyaratan yang Perlu Disiapkan</h3>
            <ul>
                <li>
                    <strong>Data Diri Lengkap</strong>
                    <p>Calon peserta magang wajib menyiapkan data diri lengkap meliputi nama lengkap, tempat dan tanggal lahir, jenis kelamin, nomor handphone (10-15 digit), dan alamat email aktif.</p>
                </li>
                <li>
                    <strong>Informasi Akademik</strong>
                    <p>Calon peserta harus menyiapkan informasi asal institusi pendidikan, jurusan/bidang keilmuan, program/keahlian yang diambil, semester yang sedang ditempuh (minimal semester 1), dan IPK/nilai rata-rata.</p>
                </li>
                <li>
                    <strong>Transkrip Nilai/Rata-Rata Raport</strong>
                    <p>Dokumen transkrip nilai terbaru dari institusi pendidikan dalam format PDF, JPG, atau PNG yang menunjukkan prestasi akademik peserta.</p>
                </li>
                <li>
                    <strong>Surat Pengantar Institusi Pendidikan</strong>
                    <p>Surat pengantar resmi dari institusi pendidikan yang menyatakan bahwa mahasiswa yang bersangkutan direkomendasikan untuk melaksanakan program magang di Kementerian Sosial RI dalam format PDF, JPG, atau PNG.</p>
                </li>
                <li>
                    <strong>Curriculum Vitae (CV)</strong>
                    <p>CV yang berisi informasi lengkap tentang data diri, riwayat pendidikan, pengalaman organisasi, kemampuan, dan keahlian yang dimiliki dalam format PDF, JPG, atau PNG.</p>
                </li>
                <li>
                    <strong>Pas Foto</strong>
                    <p>Pas foto formal terbaru dengan format JPG atau PNG yang akan digunakan sebagai foto profil dalam sistem magang.</p>
                </li>
                <li>
                    <strong>Informasi Periode Magang</strong>
                    <p>Rencana periode pelaksanaan magang dengan menentukan tanggal mulai dan tanggal selesai yang spesifik.</p>
                </li>
            </ul>
        </div>
        
        <div class="steps-box" data-aos="fade-up" data-aos-delay="200">
                <h3>Tata Cara Pendaftaran Magang</h3>
                
                <div class="step-item" data-aos="fade-up" data-aos-delay="250">
                    <div class="step-number">1</div>
                    <div class="step-content">
                        <h4>Akses Website Layanan Magang</h4>
                        <p>Kunjungi portal resmi Kemensos RI di <strong>layanan.magang.go.id</strong> dan klik tombol "Registrasi" lalu pilih menu "Pendaftaran".</p>
                    </div>
                </div>
                
                <div class="step-item" data-aos="fade-up" data-aos-delay="300">
                    <div class="step-number">2</div>
                    <div class="step-content">
                        <h4>Mengisi Formulir Pendaftaran</h4>
                        <p>Lengkapi formulir pendaftaran online dengan data diri, informasi pendidikan, pilihan bidang magang, dan periode magang yang diinginkan. Pastikan semua informasi yang dimasukkan benar dan sesuai dengan dokumen pendukung.</p>
                    </div>
                </div>
                
                <div class="step-item" data-aos="fade-up" data-aos-delay="350">
                    <div class="step-number">3</div>
                    <div class="step-content">
                        <h4>Unggah Dokumen Persyaratan</h4>
                        <p>Unggah semua dokumen persyaratan (CV, transkrip nilai, surat pengantar, dll.) dalam format PDF dengan ukuran maksimal 2MB per file. Pastikan semua file dapat dibuka dan jelas terbaca.</p>
                    </div>
                </div>
                
                <div class="step-item" data-aos="fade-up" data-aos-delay="400">
                    <div class="step-number">4</div>
                    <div class="step-content">
                        <h4>Menunggu Verifikasi dan Konfirmasi</h4>
                        <p>Setelah mengirimkan pendaftaran, peserta akan diberikan nomor pendaftaran. Tim Kemensos akan memverifikasi kelengkapan dokumen dan eligibilitas pendaftar. Proses ini memakan waktu 7-14 hari kerja. Status pendaftaran dapat dipantau dengan memasukkan nomor pendaftaran yang telah diberikan melalui menu "Cek Status" pada portal layanan magang.</p>
                    </div>
                </div>
                
                <div class="step-item" data-aos="fade-up" data-aos-delay="450">
                    <div class="step-number">5</div>
                    <div class="step-content">
                        <h4>Pengumuman Hasil</h4>
                        <p>Pengumuman hasil seleksi dapat dilihat di portal layanan magang Kemensos dengam mengakses menu "Cek Status". Peserta yang lolos seleksi akan menerima Surat Penerimaan Magang secara resmi dan mendapatkan akun untuk mengakses absensi selama kegiatan magang.</p>
                    </div>
                </div>
                
                <div class="step-item" data-aos="fade-up" data-aos-delay="500">
                    <div class="step-number">6</div>
                    <div class="step-content">
                        <h4>Login ke Portal Layanan Magang</h4>
                        <p>Setelah akun diberikan, login ke sistem menggunakan nomor pendaftaran dan password yang telah diberikan. Pastikan menggunakan browser terbaru untuk pengalaman pengguna yang optimal.</p>
                    </div>
                </div>

                <div class="step-item" data-aos="fade-up" data-aos-delay="500">
                    <div class="step-number">7</div>
                    <div class="step-content">
                        <h4>Selesai Magang</h4>
                        <p>Setelah kegiatan magang selesai dan laporan akhir telah dikirimkan,  apabila akun peserta masih dapat diakses, hal ini menandakan bahwa laporan akhir tersebut belum disetujui (ACC). Setelah laporan akhir disetujui, maka peserta tidak akan lagi dapat mengakses akun tersebut. Peserta dapat mengunjungi <strong>layanan.magang.go.id</strong> dan mengakses menu 'Cek Status' untuk memperoleh Surat Keterangan Penyelesaian Kegiatan Magang dan sertifikat.</p>
                    </div>
                </div>

                <div class="row">
    <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
        <div class="info-box">
            <div class="icon-container">
                <i class="fas fa-building fa-3x" style="color: #4e73df; background: rgba(78, 115, 223, 0.1); padding: 25px; border-radius: 50%; display: inline-block;"></i>
            </div>
            <div>
                <h3>Pilihan Direktorat</h3>
                <p>
                    Kementerian Sosial RI menyediakan berbagai pilihan direktorat untuk program magang, antara lain: Sekretariat Jenderal, Direktorat Jenderal Perlindungan dan Jaminan Sosial, Direktorat Jenderal Rehabilitasi Sosial, Direktorat Jenderal Pemberdayaan Sosial, dan Inspektorat Jenderal.
                </p>
            </div>
        </div>
    </div>
    
    <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
        <div class="info-box">
            <div class="icon-container">
                <i class="fas fa-file-alt fa-3x" style="color: #1cc88a; background: rgba(28, 200, 138, 0.1); padding: 25px; border-radius: 50%; display: inline-block;"></i>
            </div>
            <div>
                <h3>Persyaratan Dokumen</h3>
                <p>
                    Pastikan semua dokumen yang diunggah memenuhi persyaratan format (PDF, JPG, atau PNG) dan dapat dibaca dengan jelas. Dokumen yang tidak memenuhi persyaratan dapat menyebabkan pendaftaran ditolak atau tertunda.
                </p>
            </div>
        </div>
    </div>
    
    <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
        <div class="info-box">
            <div class="icon-container">
                <i class="fas fa-headset fa-3x" style="color: #f6c23e; background: rgba(246, 194, 62, 0.1); padding: 25px; border-radius: 50%; display: inline-block;"></i>
            </div>
            <div>
                <h3>Bantuan Pendaftaran</h3>
                <p>
                    Jika mengalami kesulitan dalam proses pendaftaran atau memiliki pertanyaan, silakan hubungi tim dukungan Kemensos melalui email <strong>magang@kemsos.go.id</strong> atau nomor telepon <strong>(171)</strong> pada jam kerja (Senin-Jumat, 08.00-16.00 WIB).
                </p>
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
        
        // Add hover animations for requirements and steps
        const requirementItems = document.querySelectorAll('.requirements-box li');
        requirementItems.forEach(item => {
            item.addEventListener('mouseenter', function() {
                this.style.transform = 'translateX(10px)';
            });
            
            item.addEventListener('mouseleave', function() {
                this.style.transform = 'translateX(0)';
            });
        });
        
        const stepItems = document.querySelectorAll('.step-item');
        stepItems.forEach(item => {
            item.addEventListener('mouseenter', function() {
                this.style.transform = 'translateX(10px)';
                this.querySelector('.step-number').style.transform = 'scale(1.1) rotate(10deg)';
            });
            
            item.addEventListener('mouseleave', function() {
                this.style.transform = 'translateX(0)';
                this.querySelector('.step-number').style.transform = 'scale(1) rotate(0)';
            });
        });
    });
</script>
@endsection