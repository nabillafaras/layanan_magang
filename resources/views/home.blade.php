@extends('layouts.header')

@section('title', 'Home - Kementerian Sosial RI')

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

    /* Hero Section Improvements */
    .hero {
        display: flex;
        align-items: center;
        justify-content: flex-start;
        background-image: linear-gradient(rgba(139, 0, 0, 0.85), rgba(139, 0, 0, 0.85)), url('images/bg1.png');
        background-size: cover;
        background-position: center;
        padding: 100px 10%;
        margin-bottom: 0;
        height: 100vh;
        position: relative;
    }

    .hero-content {
        max-width: 50%;
        animation: fadeInLeft 1s ease-out;
    }

    .hero-content h1 {
        font-size: 3.5rem;
        color: var(--text-light);
        font-weight: 800;
        margin-bottom: 1.5rem;
        line-height: 1.2;
    }

    .hero-content p {
        font-size: 1.2rem;
        line-height: 1.8;
        color: rgba(255, 255, 255, 0.9);
        margin-bottom: 2rem;
    }

    .hero-image {
        max-width: 45%;
        animation: fadeInRight 1s ease-out;
        z-index: 2;
    }

    .hero-image img {
        max-width: 400px; /* Batasi lebar gambar */
            width: 100%;
            height: auto;
            border-radius: 10px;
            z-index: 2;

    }

    /* Button Styles */
    .btn-hero {
        padding: 15px 35px;
        font-size: 1.1rem;
        font-weight: 600;
        background-color: var(--secondary-color);
        color: var(--primary-color);
        border-radius: 30px;
        transition: var(--transition);
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .btn-hero:hover {
        background-color: var(--text-light);
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }

    /* Services Cards */
    .services-section {
        padding: 80px 0;
        background-color: var(--bg-light);
    }

    .service-card {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        margin: 15px 0;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        transition: var(--transition);
        height: 100%;
    }

    .service-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
    }

    .service-card h5 {
        color: var(--primary-color);
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 1rem;
    }

    .service-card p {
        color: var(--text-dark);
        font-size: 1.1rem;
        line-height: 1.6;
        margin-bottom: 1.5rem;
    }

    /* Footer Improvements */
    .footer {
        background-color: #1a1a1a;
        color: var(--text-light);
        padding: 60px 0 30px;
    }

    .footer-content {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 30px;
        margin-bottom: 40px;
    }

    .footer-content h4{
        color:#FFD700;
    }

    .footer-contact h4 {
        color: var(--secondary-color);
        margin-bottom: 20px;
        font-weight: 600;
    }

    .social-icons {
        display: flex;
        gap: 15px;
        margin-top: 20px;
    }

    .social-icons a {
        color: var(--text-light);
        font-size: 1.5rem;
        transition: var(--transition);
    }

    .social-icons a:hover {
        color: var(--secondary-color);
        transform: translateY(-3px);
    }

    .map-container {
        border-radius: 15px;
        overflow: hidden;
        margin: 30px 0;
    }

    /* Animations */
    @keyframes fadeInLeft {
        from {
            opacity: 0;
            transform: translateX(-50px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes fadeInRight {
        from {
            opacity: 0;
            transform: translateX(50px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    /* Responsive Design */
    @media (max-width: 992px) {
        .hero {
            flex-direction: column;
            text-align: center;
            padding: 80px 5%;
        }

        .hero-content, .hero-image {
            max-width: 100%;
            margin-bottom: 40px;
        }

        .hero-content h1 {
            font-size: 2.5rem;
        }
    }
</style>
@endsection

@section('content')
    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1>Portal Layanan Digital</h1>
            <p>
                Selamat datang di Portal Layanan Digital Kementerian Sosial Republik Indonesia. 
                Akses semua layanan sosial dalam satu platform terintegrasi untuk Indonesia yang lebih sejahtera.
            </p>
            <a href="#services" class="btn btn-hero">Jelajahi Layanan</a>
        </div>
        <div class="hero-image">
            <img src="{{ asset('images/gambar2.png') }}" alt="Hero Image">
        </div>
    </section>

    @include('layouts.menu')

    <!-- Services Section -->
    <section id="services" class="services-section">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-5">
                    <h2 class="display-4 fw-bold" style="color: var(--primary-color)">Layanan Kami</h2>
                    <p class="lead">Pilih layanan sesuai kebutuhan Anda</p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="service-card text-center">
                        <i class="fas fa-info-circle fa-3x mb-4" style="color: var(--primary-color)"></i>
                        <h5>Informasi</h5>
                        <p>Akses informasi terkini tentang program dan layanan sosial pemerintah.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="service-card text-center">
                        <i class="fas fa-user-circle fa-3x mb-4" style="color: var(--primary-color)"></i>
                        <h5>Persyaratan</h5>
                        <p>Masuk ke akun Anda untuk mengakses layanan lebih lanjut.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="service-card text-center">
                        <i class="fas fa-user-plus fa-3x mb-4" style="color: var(--primary-color)"></i>
                        <h5>Informasi Peserta Magang</h5>
                        <p>Daftar dan cek status Anda untuk layanan sosial pemerintah.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="text-center">
                    <h4>Kementerian Sosial RI</h4>
                    <p>Jl. Salemba Raya No.28, Jakarta Pusat<br>DKI Jakarta 10430, Indonesia</p>
                </div>
            </div>

            <div class="map-container">
                <iframe
                    src="https://www.google.com/maps?q=-6.198851073402565,106.85229155217864&hl=es;z=14&output=embed"
                    width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy">
                </iframe>
            </div>

            <div class="social-icons">
                <a href="https://www.tiktok.com/@kemensosri" target="_blank"><i class="fab fa-tiktok"></i></a>
                <a href="https://www.facebook.com/KementerianSosialRI" target="_blank"><i class="fab fa-facebook"></i></a>
                <a href="https://www.instagram.com/kemensosri/" target="_blank"><i class="fab fa-instagram"></i></a>
                <a href="https://www.youtube.com/channel/UCn9V9VY9SOJTd-kIqThwD1g" target="_blank"><i class="fab fa-youtube"></i></a>
                <a href="https://twitter.com/KemensosRI" target="_blank"><i class="fab fa-twitter"></i></a>
            </div>

            <p class="text-center mt-4">&copy; 2025 Kementerian Sosial RI. All Rights Reserved.</p>
        </div>
    </footer>
@endsection

@section('additional_scripts')
<script>
    // Smooth scroll
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });

    // Animation on scroll
    window.addEventListener('scroll', function() {
        const elements = document.querySelectorAll('.info-box');
        elements.forEach(element => {
            const position = element.getBoundingClientRect();
            if(position.top < window.innerHeight) {
                element.style.opacity = '1';
                element.style.transform = 'translateY(0)';
            }
        });
    });
</script>
@endsection

@section('additional_scripts')
<script>
    // Add smooth scrolling
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });
</script>
@endsection