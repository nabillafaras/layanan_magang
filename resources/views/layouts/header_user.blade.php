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
    
    <style>
        body {
            font-family: 'Calibri', sans-serif;
            background-color: #f4f6f9;
        }
        
        .sidebar {
            background-color: #8b0000;
            min-height: 100vh;
            color: white;
        }
        
        .sidebar .nav-link {
            color: white;
            padding: 10px 20px;
            margin: 5px 0;
            border-radius: 5px;
        }
        
        .sidebar .nav-link:hover {
            background-color: rgba(255,255,255,0.1);
        }
        
        .sidebar .nav-link.active {
            background-color: rgba(255,255,255,0.2);
        }
        
        .sidebar .dropdown-menu {
            background-color: #8b0000;
            border: none;
        }
        
        .sidebar .dropdown-item {
            color: white;
        }
        
        .sidebar .dropdown-item:hover {
            background-color: rgba(255,255,255,0.1);
            color: white;
        }
        
        .main-content {
            min-height: 100vh;
            background-color: #f4f6f9;
        }
        
        .navbar {
            background-color: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .user-profile {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 20px;
        }
        
        .user-profile img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin-bottom: 10px;
        }

        .dashboard-card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: transform 0.2s;
        }
        
        .dashboard-card:hover {
            transform: translateY(-5px);
        }
        
        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .stat-card h3 {
            color: #8b0000;
            margin-bottom: 5px;
        }
        
        .stat-card p {
            color: #666;
            margin-bottom: 0;
        }
        
        .card {
            box-shadow: 0 0 1px rgba(0,0,0,0.125), 0 1px 3px rgba(0,0,0,0.2);
        }
        
        .dropdown-toggle::after {
            float: right;
            margin-top: 8px;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 px-0 sidebar">
                <div class="text-center py-4">
                    <img src="{{ asset('images/ic_kemensos_1.png') }}" alt="Logo" height="60">
                    <div class="user-profile">
                        <h6 class="mb-0">{{ auth()->user()->nama_lengkap }}</h6>
                        <small>{{ auth()->user()->nomor_pendaftaran }}</small>
                    </div>
                </div>
                
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('user') ? 'active' : '' }}" href="{{ route('user') }}">
                            <i class="fas fa-home me-2"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link dropdown-toggle" href="#absensiCollapse" data-bs-toggle="collapse">
                            <i class="fas fa-id-badge me-2"></i>Absensi
                        </a>
                        <div class="collapse" id="absensiCollapse">
                            <ul class="nav flex-column ms-3">
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('attendance') ? 'active' : '' }}" href="{{ route('attendance') }}">Masuk</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('izin') ? 'active' : '' }}" href="{{ route('izin') }}">Izin</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('sakit') ? 'active' : '' }}" href="{{ route('sakit') }}">Sakit</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link dropdown-toggle" href="#laporanCollapse" data-bs-toggle="collapse">
                            <i class="fas fa-file-alt me-2"></i>Laporan
                        </a>
                        <div class="collapse" id="laporanCollapse">
                            <ul class="nav flex-column ms-3">
                                <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('laporan.bulanan') ? 'active' : '' }}" href="{{ route('laporan.bulanan') }}">Laporan Bulanan</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('laporan.akhir') ? 'active' : '' }}" href="{{ route('laporan.akhir') }}">Laporan Akhir</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 main-content px-0">
                <!-- Top Navbar -->
                <nav class="navbar navbar-expand-lg mb-4">
                    <div class="container-fluid">
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        
                        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                            <ul class="navbar-nav">
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-user me-2"></i>{{ auth()->user()->nama_lengkap }}
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                        <li>
                                            <a href="#" class="dropdown-item">
                                                <i class="fas fa-id-card me-2"></i>Profile
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form action="{{ route('logout') }}" method="POST">
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
    @yield('content')    
    <!-- Bootstrap & jQuery JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @yield('additional_scripts')
</body>
</html>