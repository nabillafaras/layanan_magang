@extends('layouts.header')

@section('title', 'Persyaratan - Kementerian Sosial RI')

@section('additional_css')
<style>
    .hero {
        display: flex;
        align-items: center;
        justify-content: flex-start;
        background-image: url('images/bg1.png');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        padding: 100px 10%;
        margin-bottom: 0;
        height: 100vh;
        position: relative;
        }

        /* Optional: Add a semi-transparent overlay to improve text readability */
        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(164, 0, 0, 0.7); /* Keeps the original red color with transparency */
            z-index: 1;
        }

        .hero-content {
            max-width: 40%; /* Batasi lebar teks agar proporsional */
            margin-right: 20px; /* Beri jarak antara teks dan gambar */
            z-index: 2;
        }

        .hero-content h1 {
            font-size: 2.5rem;
            color: #ffffff;
            font-weight: bold;
        }

        .hero-content p {
            font-size: 1rem;
            margin-bottom: 20px;
            color:#f2f2f2; /* Sesuaikan warna teks dengan latar */
        }

        .hero-content .btn {
            background-color: #FFD700;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
        }

        .hero-content .btn:hover {
            background-color: #8b0000;
        }

        .hero-image img {
            max-width: 400px; /* Batasi lebar gambar */
            width: 100%;
            height: auto;
            border-radius: 10px;
        }

    .information-section {
        padding: 50px 10%;
        background-color: #f8f9fa;
    }

    .information-section h2 {
        font-size: 2rem;
        font-weight: bold;
        margin-bottom: 20px;
    }

    .info-box {
        display: flex;
        align-items: flex-start;
        margin-bottom: 30px;
    }

    .info-box img {
        width: 150px;
        height: 150px;
        margin-right: 20px;
        border-radius: 10px;
    }

    footer {
        background-color: #f2f2f2;
        color: #333;
        text-align: center;
        padding: 20px 0;
    }

    .social-icons a {
        margin: 0 10px;
        color: #333;
        font-size: 1.5rem;
    }

    .social-icons a:hover {
        color: #a40000;
    }
</style>
@endsection

@section('content')
    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1>Selamat Datang</h1>
            <p>
                Portal Layanan Digital Kementerian Sosial Republik Indonesia. Akses semua layanan sosial dalam satu
                platform terintegrasi.
            </p>
            <a href="#services" class="btn">Lihat Layanan</a>
        </div>
    </section>

    <!-- Information Section -->
    <section id="persyaratan" class="information-section">
        <h2>Persyaratan Pendaftaran Magang di Kemensos RI</h2>
        <div class="info-box">
            <img src="images/info1.jpg" alt="Informasi 1">
            <div>
                <h3>Bantuan Sosial</h3>
                <p>
                    Dapatkan informasi tentang program bantuan sosial dari Kementerian Sosial RI. Program ini mencakup
                    subsidi, pelatihan, dan bantuan langsung.
                </p>
            </div>
        </div>
        <div class="info-box">
            <img src="images/info2.jpg" alt="Informasi 2">
            <div>
                <h3>Program Pelatihan</h3>
                <p>
                    Ikuti pelatihan-pelatihan unggulan untuk meningkatkan keterampilan dan kemampuan Anda melalui
                    program resmi dari pemerintah.
                </p>
            </div>
        </div>
        <div class="info-box">
            <img src="images/info3.jpg" alt="Informasi 3">
            <div>
                <h3>Layanan Masyarakat</h3>
                <p>
                    Berbagai layanan masyarakat tersedia, mulai dari konsultasi hingga akses dokumen. Semua tersedia
                    untuk membantu Anda.
                </p>
            </div>
        </div>
    </section>

    <!-- Include Side Menu -->
    @include('layouts.menu')

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-address text-center mb-3">
                <p><strong>Alamat:</strong></p>
                <p>Kementerian Sosial RI, Jl. Salemba Raya No.28, RT.15/RW.6, Paseban, Kec. Senen, Kota Jakarta Pusat,
                    Daerah Khusus Ibukota Jakarta 10430, Indonesia</p>
            </div>
            <div class="text-center mb-4">
                <iframe
                    src="https://www.google.com/maps?q=-6.198851073402565,106.85229155217864&hl=es;z=14&output=embed"
                    width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy">
                </iframe>
            </div>
            <div class="social-icons text-center mb-3">
                <a href="https://www.tiktok.com/@kemensosri" target="_blank"><i class="fab fa-tiktok"></i></a>
                <a href="https://www.facebook.com/KementerianSosialRI" target="_blank"><i class="fab fa-facebook"></i></a>
                <a href="https://www.instagram.com/kemensosri/" target="_blank"><i class="fab fa-instagram"></i></a>
                <a href="https://www.youtube.com/channel/UCn9V9VY9SOJTd-kIqThwD1g" target="_blank"><i class="fab fa-youtube"></i></a>
                <a href="https://twitter.com/KemensosRI" target="_blank"><i class="fab fa-twitter"></i></a>
            </div>
            <p class="text-center">&copy; 2025 Kementerian Sosial RI. All Rights Reserved.</p>
        </div>
    </footer>
@endsection

@section('additional_scripts')
@endsection