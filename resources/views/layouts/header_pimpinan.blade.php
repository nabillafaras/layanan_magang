<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Kementerian Sosial RI')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    
    <style>
        :root {
            --primary-color: #8b0000;
            --primary-light: #c13030;
            --secondary-color: #f8f9fa;
            --text-color: #333;
            --sidebar-width: 280px;
            --header-height: 70px;
            --transition-speed: 0.3s;
            --gold-color: #FFD700;
        }
        
        body {
            font-family: 'Calibri', sans-serif;
            background-color: #f4f6f9;
            overflow-x: hidden;
            color: var(--text-color);
        }
        
        /* Sidebar Styles */
        .sidebar {
            background: linear-gradient(135deg, var(--primary-color) 0%, #6a0000 100%);
            min-height: 100vh;
            color: white;
            width: var(--sidebar-width);
            position: fixed;
            left: 0;
            top: 0;
            z-index: 100;
            transition: all var(--transition-speed);
            box-shadow: 3px 0 10px rgba(0,0,0,0.1);
            overflow-y: auto;
            max-height: 100vh;
        }
        
        .sidebar-collapsed .sidebar {
            left: calc(-1 * var(--sidebar-width) + 60px);
        }
        
        .sidebar .logo-container {
            padding: 20px 0;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        .sidebar .logo-container img {
            height: 60px;
            transition: all var(--transition-speed);
        }
        
        .sidebar-collapsed .logo-container img {
            height: 40px;
        }
        
        .user-profile {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 20px;
            transition: all var(--transition-speed);
        }
        
        .user-profile img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin-bottom: 10px;
            border: 3px solid rgba(255,255,255,0.2);
            transition: all var(--transition-speed);
            object-fit: cover;
        }
        
        .user-profile img:hover {
            border-color: rgba(255,255,255,0.5);
            transform: scale(1.05);
        }
        
        .sidebar .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 12px 20px;
            margin: 5px 15px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            transition: all var(--transition-speed);
            position: relative;
            overflow: hidden;
        }
        
        .sidebar .nav-link i {
            margin-right: 10px;
            font-size: 18px;
            width: 24px;
            text-align: center;
            transition: all var(--transition-speed);
        }
        
        .sidebar .nav-link:hover {
            background-color: rgba(255,255,255,0.1);
            color: white;
            transform: translateX(5px);
        }
        
        .sidebar .nav-link.active {
            background-color: rgba(255,255,255,0.2);
            color: white;
            font-weight: 500;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        
        .sidebar .nav-link.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 4px;
            background-color: var(--gold-color);
        }
        
        /* Main Content Styles */
        .main-content {
            min-height: 100vh;
            background-color: #f4f6f9;
            margin-left: var(--sidebar-width);
            transition: all var(--transition-speed);
            padding-top: var(--header-height);
        }
        
        .sidebar-collapsed .main-content {
            margin-left: 60px;
        }
        
        /* Navbar Styles */
        .dropdown-toggle::after {
            display: none;
        }
        
        .navbar {
            background-color: white;
            box-shadow: 0 2px 15px rgba(0,0,0,0.1);
            height: var(--header-height);
            padding: 0 20px;
            position: fixed;
            top: 0;
            right: 0;
            left: var(--sidebar-width);
            z-index: 99;
            transition: all var(--transition-speed);
        }
        
        .sidebar-collapsed .navbar {
            left: 60px;
        }
        
        .navbar .toggle-sidebar {
            background: none;
            border: none;
            color: var(--primary-color);
            font-size: 20px;
            cursor: pointer;
            padding: 5px 10px;
            border-radius: 5px;
            transition: all var(--transition-speed);
        }
        
        .navbar .toggle-sidebar:hover {
            background-color: rgba(139, 0, 0, 0.1);
            transform: scale(1.1);
        }
        
        .navbar .nav-link {
            color: var(--text-color);
            padding: 10px 15px;
            border-radius: 5px;
            transition: all var(--transition-speed);
        }
        
        .navbar .nav-link:hover {
            background-color: rgba(139, 0, 0, 0.1);
        }
        
        .navbar .dropdown-menu {
            border: none;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            border-radius: 10px;
            padding: 10px 0;
            min-width: 200px;
            animation: fadeIn 0.3s ease-in-out;
        }
        
        .navbar .dropdown-item {
            padding: 10px 20px;
            transition: all var(--transition-speed);
        }
        
        .navbar .dropdown-item:hover {
            background-color: rgba(139, 0, 0, 0.1);
        }
        
        .navbar .dropdown-divider {
            margin: 5px 0;
        }
        
        /* Card Styles */
        .dashboard-card {
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            transition: all var(--transition-speed);
            border: none;
            overflow: hidden;
        }
        
        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        
        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            margin-bottom: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            transition: all var(--transition-speed);
            border: none;
            position: relative;
            overflow: hidden;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        
        .stat-card::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 100px;
            height: 100px;
            background: rgba(139, 0, 0, 0.05);
            border-radius: 50%;
            transform: translate(50%, -50%);
            z-index: 0;
        }
        
        .stat-card h3 {
            color: var(--primary-color);
            margin-bottom: 10px;
            font-weight: 600;
            position: relative;
            z-index: 1;
        }
        
        .stat-card p {
            color: #666;
            margin-bottom: 0;
            position: relative;
            z-index: 1;
        }
        
        /* Animation Classes */
        .fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }
        
        .slide-in-left {
            animation: slideInLeft 0.5s ease-in-out;
        }
        
        .slide-in-right {
            animation: slideInRight 0.5s ease-in-out;
        }
        
        .bounce-in {
            animation: bounceIn 0.6s ease-in-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        @keyframes slideInLeft {
            from { transform: translateX(-50px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        
        @keyframes slideInRight {
            from { transform: translateX(50px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        
        @keyframes bounceIn {
            0% { transform: scale(0.8); opacity: 0; }
            50% { transform: scale(1.05); opacity: 0.8; }
            100% { transform: scale(1); opacity: 1; }
        }
        
        /* Responsive Adjustments */
        @media (max-width: 992px) {
            :root {
                --sidebar-width: 0px;
            }
            
            .sidebar {
                left: -280px;
            }
            
            .sidebar.show {
                left: 0;
                width: 280px;
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .navbar {
                left: 0;
            }
            
            .sidebar-collapsed .main-content {
                margin-left: 0;
            }
            
            .sidebar-collapsed .navbar {
                left: 0;
            }
        }
        
        /* Pulse Animation for Notifications */
        .pulse {
            position: relative;
        }
        
        .pulse::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 8px;
            height: 8px;
            background-color: #ff4757;
            border-radius: 50%;
            animation: pulse 1.5s infinite;
        }
        
        @keyframes pulse {
            0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(255, 71, 87, 0.7); }
            70% { transform: scale(1); box-shadow: 0 0 0 10px rgba(255, 71, 87, 0); }
            100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(255, 71, 87, 0); }
        }
        
        /* Badge Styles */
        .badge-pimpinan {
            background-color: var(--gold-color);
            color: var(--primary-color);
            font-size: 0.7rem;
            padding: 0.25em 0.6em;
            border-radius: 10px;
            font-weight: 600;
            margin-left: 5px;
        }
    </style>
    @yield('additional_css')
</head>
<body>
    <div class="wrapper" id="app">
        <!-- Sidebar -->
        <div class="sidebar slide-in-left">
            <div class="logo-container">
                <img src="{{ asset('images/ic_kemensos_1.png') }}" alt="Logo" class="logo">
            </div>
            <div class="user-profile">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::guard('admin')->user()->nama_lengkap) }}&background=8b0000&color=fff" alt="Pimpinan" class="profile-img">
                <h6 class="mb-0 text-white">{{ Auth::guard('admin')->user()->nama_lengkap }}</h6>
                <small class="text-white-50">
                    <span class="badge-pimpinan">Pimpinan</span>
                </small>
            </div>
            
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="{{ route('pimpinan.dashboard') }}" class="nav-link {{ request()->routeIs('pimpinan.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-home"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('pimpinan.peserta.index') }}" class="nav-link {{ request()->routeIs('pimpinan.peserta.index') ? 'active' : '' }}">
                        <i class="fas fa-users"></i> Data Peserta
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('pimpinan.absensi') }}" class="nav-link {{ request()->routeIs('pimpinan.absensi') ? 'active' : '' }}">
                        <i class="fas fa-clipboard-list"></i> Data Absensi
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('pimpinan.laporan') }}" class="nav-link {{ request()->routeIs('pimpinan.laporan') ? 'active' : '' }}">
                        <i class="fas fa-file-alt"></i> Laporan
                    </a>
                </li>
                
            </ul>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Top Navbar -->
            <nav class="navbar navbar-expand-lg fade-in">
                <div class="container-fluid">
                    <button class="toggle-sidebar me-3" id="sidebarToggle">
                        <i class="fas fa-bars"></i>
                    </button>
                    
                    <div class="d-flex align-items-center">
                        <div class="current-date me-3">
                            <span id="currentDate"></span>
                        </div>
                    </div>
                    
                    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link pulse" href="#">
                                    <i class="fas fa-bell"></i>
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-user me-2"></i>{{ Auth::guard('admin')->user()->nama_lengkap }}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end animate__animated animate__fadeIn" aria-labelledby="userDropdown">
                                  
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form action="{{ route('pimpinan.logout') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="dropdown-item">
                                                <i class="fas fa-sign-out-alt me-2"></i>Logout
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <!-- Content Section -->
            <div class="container-fluid py-4">
                @yield('content')
            </div>
        </div>
    </div>
    
    <!-- Bootstrap & jQuery JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        // Initialize sidebar toggle
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const wrapper = document.getElementById('app');
            const sidebar = document.querySelector('.sidebar');
            
            if (sidebarToggle && sidebar) {
                sidebarToggle.addEventListener('click', function() {
                    // Untuk layar mobile
                    if (window.innerWidth <= 992) {
                        sidebar.classList.toggle('show');
                    } 
                    
                    // Untuk semua ukuran layar
                    wrapper.classList.toggle('sidebar-collapsed');
                });
                
                // Tambahkan event listener untuk menutup sidebar di layar mobile
                document.addEventListener('click', function(event) {
                    if (window.innerWidth <= 992 && 
                        sidebar.classList.contains('show') && 
                        !sidebar.contains(event.target) && 
                        !sidebarToggle.contains(event.target)) {
                        sidebar.classList.remove('show');
                        wrapper.classList.add('sidebar-collapsed');
                    }
                });
            }

            // Display current date
            const dateElement = document.getElementById('currentDate');
            if (dateElement) {
                const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                const today = new Date();
                dateElement.textContent = today.toLocaleDateString('id-ID', options);
            }
            
            // Add animation classes to elements when they come into view
            const animateOnScroll = function() {
                const elements = document.querySelectorAll('.dashboard-card, .stat-card');
                
                elements.forEach(function(element, index) {
                    const elementTop = element.getBoundingClientRect().top;
                    const elementVisible = 150;
                    
                    if (elementTop < window.innerHeight - elementVisible) {
                        setTimeout(function() {
                            element.classList.add('bounce-in');
                        }, index * 100);
                    }
                });
            };
            
            // Run animation on load
            animateOnScroll();
            
            // Run animation on scroll
            window.addEventListener('scroll', animateOnScroll);
            
            // Animasi dropdown menu
            const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
            dropdownToggles.forEach(function(toggle) {
                toggle.addEventListener('click', function() {
                    const chevron = this.querySelector('.fa-chevron-down');
                    if (chevron) {
                        chevron.style.transform = this.getAttribute('aria-expanded') === 'true' ? 'rotate(0deg)' : 'rotate(180deg)';
                    }
                });
            });
        });
    </script>
    
    @yield('additional_scripts')
</body>
</html>