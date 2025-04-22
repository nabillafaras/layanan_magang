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
        overflow: hidden;
    }
    
    /* Animated background effect */
    .hero::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 100%;
        height: 100%;
        background: radial-gradient(circle, rgba(255,215,0,0.2) 0%, rgba(139,0,0,0) 70%);
        animation: pulse-bg 8s infinite alternate;
        z-index: 1;
    }
    
    @keyframes pulse-bg {
        0% {
            transform: scale(1) rotate(0deg);
            opacity: 0.3;
        }
        100% {
            transform: scale(1.5) rotate(45deg);
            opacity: 0.6;
        }
    }

    .hero-content {
        max-width: 50%;
        animation: fadeInLeft 1.2s ease-out;
        position: relative;
        z-index: 2;
    }

    .hero-content h1 {
        font-size: clamp(2.5rem, 5vw, 4rem);
        color: var(--text-light);
        font-weight: 800;
        margin-bottom: 1.5rem;
        line-height: 1.2;
        position: relative;
        display: inline-block;
    }
    
    .hero-content h1::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 0;
        width: 80px;
        height: 5px;
        background: var(--secondary-color);
        border-radius: 10px;
        animation: expandWidth 1.5s ease-out forwards;
    }
    
    @keyframes expandWidth {
        from { width: 0; }
        to { width: 80px; }
    }

    .hero-content p {
        font-size: clamp(1.1rem, 2vw, 1.3rem);
        line-height: 1.8;
        color: rgba(255, 255, 255, 0.9);
        margin-bottom: 2.5rem;
        max-width: 90%;
    }

    .hero-image {
        max-width: 45%;
        position: relative;
        z-index: 2;
    }

    .hero-image img {
        max-width: 450px;
        width: 100%;
        height: auto;
        border-radius: 20px;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.3);
        transform: perspective(1000px) rotateY(-10deg);
        transition: all 0.5s ease;
        animation: float 5s ease-in-out infinite;
    }
    
    .hero-image:hover img {
        transform: perspective(1000px) rotateY(0deg) scale(1.02);
    }
    
    @keyframes float {
        0% {
            transform: perspective(1000px) rotateY(-10deg) translateY(0px);
        }
        50% {
            transform: perspective(1000px) rotateY(-5deg) translateY(-15px);
        }
        100% {
            transform: perspective(1000px) rotateY(-10deg) translateY(0px);
        }
    }

    /* Button Styles */
    .btn-hero {
        padding: clamp(12px, 2vw, 18px) clamp(25px, 3vw, 40px);
        font-size: clamp(1rem, 1.5vw, 1.1rem);
        font-weight: 600;
        background-color: var(--secondary-color);
        color: var(--primary-color);
        border-radius: 50px;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        text-transform: uppercase;
        letter-spacing: 1px;
        display: inline-block;
        position: relative;
        overflow: hidden;
        border: none;
        z-index: 1;
    }
    
    .btn-hero::before {
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

    .btn-hero:hover {
        color: var(--primary-color);
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
    }
    
    .btn-hero:hover::before {
        width: 100%;
    }
    
    .btn-hero i {
        margin-left: 8px;
        transition: transform 0.3s ease;
    }
    
    .btn-hero:hover i {
        transform: translateX(5px);
    }

    /* Services Cards */
    .services-section {
        padding: 100px 0;
        background-color: var(--bg-light);
        position: relative;
        overflow: hidden;
    }
    
    .services-section::before {
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
        position: relative;
        margin-bottom: 60px;
    }
    
    .section-title h2 {
        color: var(--primary-color);
        font-size: clamp(2rem, 4vw, 3rem);
        font-weight: 800;
        position: relative;
        display: inline-block;
        margin-bottom: 20px;
    }
    
    .section-title h2::after {
        content: '';
        position: absolute;
        bottom: -15px;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 4px;
        background: var(--primary-color);
        border-radius: 10px;
    }
    
    .section-title p {
        font-size: 1.2rem;
        color: #666;
        max-width: 700px;
        margin: 0 auto;
    }

    .service-card {
        background: white;
        border-radius: 20px;
        padding: 2.5rem;
        margin: 15px 0;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        height: 100%;
        position: relative;
        z-index: 1;
        overflow: hidden;
        border: 1px solid rgba(0,0,0,0.05);
    }
    
    .service-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 0;
        background: linear-gradient(135deg, rgba(139,0,0,0.03) 0%, rgba(255,215,0,0.05) 100%);
        transition: all 0.5s ease;
        z-index: -1;
    }

    .service-card:hover {
        transform: translateY(-15px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        border-color: rgba(139,0,0,0.1);
    }
    
    .service-card:hover::before {
        height: 100%;
    }
    
    .service-card .icon-wrapper {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: rgba(139,0,0,0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 25px;
        transition: all 0.3s ease;
    }
    
    .service-card:hover .icon-wrapper {
        background: var(--primary-color);
        transform: rotateY(180deg);
    }
    
    .service-card .icon-wrapper i {
        font-size: 2rem;
        color: var(--primary-color);
        transition: all 0.3s ease;
    }
    
    .service-card:hover .icon-wrapper i {
        color: white;
        transform: rotateY(180deg);
    }

    .service-card h5 {
        color: var(--primary-color);
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 1rem;
        text-align: center;
    }

    .service-card p {
        color: var(--text-dark);
        font-size: 1.1rem;
        line-height: 1.6;
        margin-bottom: 1.5rem;
        text-align: center;
    }
    
    .service-card .btn-more {
        display: inline-block;
        padding: 8px 20px;
        background: transparent;
        color: var(--primary-color);
        border: 2px solid var(--primary-color);
        border-radius: 30px;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        margin-top: 10px;
    }
    
    .service-card .btn-more:hover {
        background: var(--primary-color);
        color: white;
        transform: translateX(5px);
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
    @keyframes fadeInLeft {
        from {
            opacity: 0;
            transform: translateX(-70px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes fadeInRight {
        from {
            opacity: 0;
            transform: translateX(70px);
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

    /* Responsive Design */
    @media (max-width: 1200px) {
        .hero {
            padding: 80px 5%;
        }
    }

    @media (max-width: 992px) {
        .hero {
            flex-direction: column;
            text-align: center;
            padding: 60px 5%;
            gap: 40px;
            height: auto;
            min-height: 100vh;
        }

        .hero-content, .hero-image {
            max-width: 100%;
        }
        
        .hero-content h1::after {
            left: 50%;
            transform: translateX(-50%);
        }
        
        .hero-content p {
            margin-left: auto;
            margin-right: auto;
        }

        .btn-hero {
            margin: 0 auto;
        }
        
        .hero-image img {
            transform: perspective(1000px) rotateY(0deg);
        }
        
        @keyframes float {
            0% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-15px);
            }
            100% {
                transform: translateY(0px);
            }
        }
    }

    @media (max-width: 768px) {
        .hero {
            min-height: auto;
            padding: 50px 20px;
        }

        .hero-image {
            margin-top: 30px;
        }
        
        .hero-image img {
            max-width: 350px;
        }

        .service-card {
            padding: 1.8rem;
        }
        
        .services-section {
            padding: 70px 0;
        }
    }

    @media (max-width: 480px) {
        .hero {
            padding: 40px 15px;
        }
        
        .hero-content h1 {
            margin-bottom: 1rem;
            font-size: 2.2rem;
        }
        
        .hero-content p {
            margin-bottom: 1.5rem;
            font-size: 1rem;
        }
        
        .hero-image img {
            max-width: 280px;
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
            <h1>Portal Layanan Digital</h1>
            <p>
                Selamat datang di Portal Layanan Digital Kementerian Sosial Republik Indonesia. 
                Akses semua layanan sosial dalam satu platform terintegrasi untuk Indonesia yang lebih sejahtera.
            </p>
            <a href="#services" class="btn btn-hero">Jelajahi Layanan <i class="fas fa-arrow-right"></i></a>
        </div>
        <div class="hero-image" data-aos="fade-left" data-aos-delay="400">
            <img src="{{ asset('images/gambar2.png') }}" alt="Hero Image">
        </div>
    </section>

    @include('layouts.menu')

    <!-- Services Section -->
    <section id="services" class="services-section">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center section-title" data-aos="fade-up">
                    <h2>Layanan Kami</h2>
                    <p class="lead">Pilih layanan sesuai kebutuhan Anda untuk mendapatkan bantuan terbaik</p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="service-card text-center">
                        <div class="icon-wrapper">
                            <i class="fas fa-info-circle"></i>
                        </div>
                        <h5>Informasi</h5>
                        <p>Akses informasi terkini tentang program dan layanan sosial pemerintah.</p>
                        <a href="{{ route('informasi') }}" class="btn-more">Selengkapnya <i class="fas fa-chevron-right"></i></a>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="service-card text-center">
                        <div class="icon-wrapper">
                            <i class="fas fa-user-circle"></i>
                        </div>
                        <h5>Persyaratan</h5>
                        <p>Masuk ke akun Anda untuk mengakses layanan lebih lanjut.</p>
                        <a href="{{ route('persyaratan') }}" class="btn-more">Selengkapnya <i class="fas fa-chevron-right"></i></a>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="service-card text-center">
                        <div class="icon-wrapper">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <h5>Informasi Peserta Magang</h5>
                        <p>Daftar dan cek status Anda untuk layanan sosial pemerintah.</p>
                        <a href="{{ route('informasi_peserta') }}" class="btn-more">Selengkapnya <i class="fas fa-chevron-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('layouts.footer')
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

    // Ensure image is responsive
    window.addEventListener('load', function() {
        const heroImage = document.querySelector('.hero-image img');
        if (heroImage) {
            // Force recalculation of image size on load
            heroImage.style.maxHeight = window.innerWidth < 768 ? '300px' : 'auto';
        }
        
        // Add animation to service cards on hover
        const serviceCards = document.querySelectorAll('.service-card');
        serviceCards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-15px)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = '';
            });
        });
    });

    // Handle resize events
    window.addEventListener('resize', function() {
        const heroImage = document.querySelector('.hero-image img');
        if (heroImage) {
            // Adjust image size on viewport changes
            heroImage.style.maxHeight = window.innerWidth < 768 ? '300px' : 'auto';
        }
    });
    
    // Add parallax effect to hero section
    window.addEventListener('scroll', function() {
        const scrollPosition = window.scrollY;
        const heroContent = document.querySelector('.hero-content');
        const heroImage = document.querySelector('.hero-image');
        
        if (heroContent && heroImage && window.innerWidth > 992) {
            heroContent.style.transform = `translateY(${scrollPosition * 0.1}px)`;
            heroImage.style.transform = `translateY(${scrollPosition * 0.15}px)`;
        }
    });
</script>
@endsection
