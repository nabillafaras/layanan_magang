<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Kementerian Sosial RI')</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- AOS Animation Library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
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
            padding-top: 70px;
            background-color: #f9f9f9;
            overflow-x: hidden;
        }
        
        /* Navbar Styling - Modern & Animated with Hide on Scroll */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
            background-color: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            color: var(--text-dark);
            transition: all 0.4s ease;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            padding: 15px 0;
            transform: translateY(0);
        }

        .navbar.scrolled {
            padding: 10px 0;
            background-color: rgba(255, 255, 255, 0.98);
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.15);
        }

        /* Hide navbar when scrolling down */
        .navbar.navbar-hidden {
            transform: translateY(-100%);
        }

        /* Show navbar when scrolling up */
        .navbar.navbar-visible {
            transform: translateY(0);
        }

        .navbar a {
            color: inherit;
            transition: all 0.3s ease;
            position: relative;
            font-weight: 500;
        }
        
        .navbar a:hover {
            color: var(--primary-color);
        }

        .nav-link {
            padding: 8px 15px !important;
            margin: 0 5px;
            border-radius: 6px;
        }
        
        .nav-link:hover {
            background-color: rgba(139, 0, 0, 0.05);
        }

        .nav-link.active {
            color: var(--primary-color) !important;
            font-weight: 600;
            background-color: rgba(139, 0, 0, 0.08);
        }
        
        .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 30px;
            height: 3px;
            background-color: var(--primary-color);
            border-radius: 10px;
        }
        
        .navbar-brand {
            color: inherit;
            font-weight: bold;
            display: flex;
            align-items: center;
            transition: transform 0.3s ease;
        }
        
        .navbar-brand:hover {
            transform: scale(1.02);
        }

        .navbar-brand img {
            width: 45px;
            margin-right: 12px;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));
            transition: transform 0.3s ease;
        }
        
        .navbar-brand:hover img {
            transform: rotate(5deg);
        }

        .navbar-brand span {
            display: block;
            line-height: 1.2;
            font-weight: 700; 
            font-size: 0.95rem;
        }

        .dropdown-menu {
            background-color: white;
            border: none;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 10px;
            margin-top: 15px;
            animation: fadeInUp 0.3s ease forwards;
        }
        
        .dropdown-item {
            padding: 10px 15px;
            border-radius: 8px;
            margin-bottom: 5px;
            transition: all 0.2s ease;
        }

        .dropdown-menu a {
            color: var(--text-dark) !important;
            font-weight: 500;
        }

        .dropdown-menu a:hover {
            background-color: var(--primary-color);
            color: white !important;
            transform: translateX(5px);
        }
        
        .navbar-toggler {
            border: none;
            padding: 0;
            font-size: 1.5rem;
        }
        
        .navbar-toggler:focus {
            box-shadow: none;
        }
        
        /* Hamburger Animation */
        .navbar-toggler .navbar-toggler-icon {
            background-image: none;
            position: relative;
            width: 30px;
            height: 20px;
        }
        
        .navbar-toggler .navbar-toggler-icon:before,
        .navbar-toggler .navbar-toggler-icon:after {
            content: '';
            position: absolute;
            width: 100%;
            height: 3px;
            background-color: var(--primary-color);
            left: 0;
            transition: all 0.3s ease;
        }
        
        .navbar-toggler .navbar-toggler-icon:before {
            top: 0;
        }
        
        .navbar-toggler .navbar-toggler-icon:after {
            bottom: 0;
        }
        
        .navbar-toggler:not(.collapsed) .navbar-toggler-icon:before {
            transform: rotate(45deg);
            top: 8px;
        }
        
        .navbar-toggler:not(.collapsed) .navbar-toggler-icon:after {
            transform: rotate(-45deg);
            bottom: 9px;
        }
        
        /* Footer Improvements */
        .footer {
            background-color: #1a1a1a;
            color: var(--text-light);
            padding: 70px 0 30px;
            position: relative;
            overflow: hidden;
        }
        
        .footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
            margin-bottom: 50px;
        }

        .footer-content h4 {
            color: var(--secondary-color);
            margin-bottom: 25px;
            font-weight: 700;
            position: relative;
            display: inline-block;
            padding-bottom: 10px;
        }
        
        .footer-content h4::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 3px;
            background-color: var(--secondary-color);
            border-radius: 10px;
        }

        .footer-contact p {
            margin-bottom: 15px;
            display: flex;
            align-items: flex-start;
        }
        
        .footer-contact p i {
            margin-right: 15px;
            color: var(--secondary-color);
            font-size: 1.2rem;
            margin-top: 5px;
        }

        .social-icons {
            display: flex;
            gap: 15px;
            margin-top: 25px;
        }

        .social-icons a {
            color: var(--text-light);
            font-size: 1.2rem;
            background-color: rgba(255, 255, 255, 0.1);
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: all 0.3s ease;
        }

        .social-icons a:hover {
            color: var(--secondary-color);
            background-color: rgba(255, 255, 255, 0.2);
            transform: translateY(-5px) rotate(10deg);
        }

        .map-container {
            border-radius: 15px;
            overflow: hidden;
            margin: 30px 0;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }
        
        .map-container:hover {
            transform: scale(1.02);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
        }
        
        .footer-bottom {
            text-align: center;
            padding-top: 30px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes pulse {
            0% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
            100% {
                transform: scale(1);
            }
        }
    </style>
    @yield('additional_css')
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ asset('images/ic_kemensos_1.png') }}" alt="Logo Kemensos">
                <span>
                    Kementerian Sosial<br>
                    Republik Indonesia
                </span>
            </a>
            <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" 
                           href="{{ route('home') }}" aria-current="page">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="registrasiDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Registrasi
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="registrasiDropdown">
                            <li><a class="dropdown-item" href="{{ route('pendaftaran') }}">Pendaftaran</a></li>
                            <li><a class="dropdown-item" href="{{ route('status.form') }}">Cek Status</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('login') ? 'active' : '' }}" 
                           href="{{ route('login') }}" aria-current="page">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Content Section -->
    @yield('content')

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script>
        // Initialize AOS animation library
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true,
            mirror: false
        });
        
        // Navbar hide/show on scroll functionality
        let lastScrollTop = 0;
        let scrollThreshold = 100; // Minimum scroll distance before hiding
        let isScrolling = false;
        
        document.addEventListener("scroll", function () {
            const navbar = document.querySelector(".navbar");
            const currentScroll = window.pageYOffset || document.documentElement.scrollTop;
            
            // Add scrolled class for styling when scrolled down
            if (currentScroll > 50) {
                navbar.classList.add("scrolled");
            } else {
                navbar.classList.remove("scrolled");
            }
            
            // Hide/show navbar based on scroll direction
            // Only start hiding after scrolling past threshold
            if (currentScroll > scrollThreshold) {
                if (currentScroll > lastScrollTop && !isScrolling) {
                    // Scrolling down - hide navbar
                    navbar.classList.add("navbar-hidden");
                    navbar.classList.remove("navbar-visible");
                } else if (currentScroll < lastScrollTop) {
                    // Scrolling up - show navbar
                    navbar.classList.remove("navbar-hidden");
                    navbar.classList.add("navbar-visible");
                }
            } else {
                // Always show navbar when near top of page
                navbar.classList.remove("navbar-hidden");
                navbar.classList.add("navbar-visible");
            }
            
            lastScrollTop = currentScroll <= 0 ? 0 : currentScroll; // For Mobile or negative scrolling
        });
        
        // Prevent navbar hiding when dropdown is open (for mobile)
        const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
        const navbarCollapse = document.querySelector('.navbar-collapse');
        
        dropdownToggles.forEach(toggle => {
            toggle.addEventListener('click', function() {
                isScrolling = true;
                setTimeout(() => {
                    isScrolling = false;
                }, 300);
            });
        });
        
        // Handle mobile menu toggle
        const navbarToggler = document.querySelector('.navbar-toggler');
        if (navbarToggler) {
            navbarToggler.addEventListener('click', function() {
                isScrolling = true;
                setTimeout(() => {
                    isScrolling = false;
                }, 300);
            });
        }
        
        // Add hover effect to navbar items
        const navItems = document.querySelectorAll('.nav-link');
        navItems.forEach(item => {
            item.addEventListener('mouseenter', function() {
                if (!this.classList.contains('active')) {
                    this.style.transform = 'translateY(-3px)';
                }
            });
            
            item.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
    </script>
    @yield('additional_scripts')
</body>
</html>