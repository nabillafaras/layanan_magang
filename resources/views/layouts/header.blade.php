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
    <style>
        body {
            font-family: Calibri, sans-serif;
            padding-top: 70px;
            background-color: #a40000;
        }
        
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
            background-color: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            color: black;
            transition: background-color 0.3s ease, backdrop-filter 0.3s ease;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .navbar.scrolled {
            background-color: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            color: black;
        }

        .navbar a {
            color: inherit;
            transition: color 0.3s ease;
        }

        .nav-link.active {
            color: #a40000 !important;
            font-weight: bold;
        }
        
        .navbar-brand {
            color: inherit;
            font-weight: bold;
            display: flex;
            align-items: center;
        }

        .navbar-brand img {
            width: 40px;
            margin-right: 10px;
        }

        .navbar-brand span {
            display: block;
            line-height: 1.2;
            font-weight: bold; 
            font-size: 0.9rem;
        }

        .dropdown-menu {
            background-color: white;
            color: black;
        }

        .dropdown-menu a {
            color: black !important;
        }

        .dropdown-menu a:hover {
            background-color: #a40000;
            color: white !important;
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
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
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
                            <li><a class="dropdown-item" href="#cekstatus">Cek Status</a></li>
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
    <script>
        document.addEventListener("scroll", function () {
            const navbar = document.querySelector(".navbar");
            if (window.scrollY > 50) {
                navbar.classList.add("scrolled");
            } else {
                navbar.classList.remove("scrolled");
            }
        });
    </script>
    @yield('additional_scripts')
</body>
</html>