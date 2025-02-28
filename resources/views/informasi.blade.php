@extends('layouts.header')

@section('title', 'Informasi - Kementerian Sosial RI')

@section('additional_css')
<style>
    :root {
        --primary-color: #8b0000;
        --secondary-color: #FFD700;
        --text-light: #ffffff;
        --text-dark: #333333;
        --bg-light: #f8f9fa;
        --transition: all 0.3s ease-in-out;
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

    /* Footer */
    .footer {
        background: linear-gradient(to right, #1a1a1a, #333);
        color: var(--text-light);
        padding: 60px 0 30px;
    }

    .footer-content {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 30px;
    }

    .social-icons {
        display: flex;
        gap: 15px;
        justify-content: center;
        margin-top: 30px;
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
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
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
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="info-box">
                        <img src="images/info2.jpg" alt="Program Pelatihan">
                        <div class="info-content">
                            <h3>Program Pelatihan</h3>
                            <p>Berbagai program pelatihan yang dirancang untuk meningkatkan keterampilan dan pemberdayaan masyarakat Indonesia.</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="info-box">
                        <img src="images/info3.jpg" alt="Layanan Masyarakat">
                        <div class="info-content">
                            <h3>Layanan Masyarakat</h3>
                            <p>Informasi lengkap tentang berbagai layanan masyarakat yang tersedia, dari konsultasi hingga bantuan sosial.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('layouts.menu')

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