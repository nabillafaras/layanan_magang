<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Kementerian Sosial RI')</title>
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
        .card {
            box-shadow: 0 0 1px rgba(0,0,0,0.125), 0 1px 3px rgba(0,0,0,0.2);
        }
        .card {
            box-shadow: 0 0 1px rgba(0,0,0,0.125), 0 1px 3px rgba(0,0,0,0.2);
        }
        .user-profile {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar px-0">
                <div class="d-flex flex-column">
                    <div class="text-center py-4">
                        <img src="{{ asset('images/ic_kemensos_1.png') }}" alt="Logo" height="60">
                        <div class="user-profile">
                            <h6 class="mb-0">{{ Auth::guard('admin')->user()->nama_lengkap }}</h6>
                            <small>Admin Dashboard</small>
                        </div>
                    </div>
                    <div class="nav flex-column">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i class="fas fa-home me-2"></i> Dashboard
                        </a>
                        <a href="{{ route('admin.create') }}" class="nav-link {{ request()->routeIs('admin.create') ? 'active' : '' }}">
                            <i class="fas fa-user-plus me-2"></i> Create Admin
                        </a>
                        <a href="{{ route('admin.peserta') }}" class="nav-link {{ request()->routeIs('admin.peserta') ? 'active' : '' }}">
                            <i class="fas fa-user me-2"></i> Peserta Pendaftar
                        </a>
                        <a href="#ff" class="nav-link">
                            <i class="fas fa-clipboard-list me-2"></i> Rekapitulasi Absensi
                        </a>
                        <a href="#ff" class="nav-link">
                            <i class="fas fa-file-alt me-2"></i> Rekapitulasi Laporan
                        </a>
                        <a class="nav-link dropdown-toggle" href="#direktoratCollapse" data-bs-toggle="collapse">
                            <i class="fas fa-building me-2"></i> Direktorat
                        </a>
                        <div class="collapse" id="direktoratCollapse">
                            <ul class="nav flex-column ms-3">
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Direktorat Rehabilitasi Sosial</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Direktorat Perlindungan Sosial</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Direktorat Pemberdayaan Sosial</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Direktorat Penanganan Fakir Miskin</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Direktorat Jaminan Sosial</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 main-content px-0">
                <!-- Navbar -->
                <nav class="navbar navbar-expand-lg mb-4">
                    <div class="container-fluid">
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarNav">
                            <ul class="navbar-nav ms-auto">
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-user me-2"></i>{{ Auth::guard('admin')->user()->nama_lengkap }}
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                            <a href="#" class="dropdown-item">
                                                <i class="fas fa-id-card me-2"></i>Profile
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                        <form action="{{ route('admin.logout') }}" method="POST">
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
    @yield('additional_scripts')
</body>
</html>