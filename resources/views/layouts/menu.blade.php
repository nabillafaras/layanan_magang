<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>@yield('title', 'Kementerian Sosial RI')</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Side Menu Styles */
        .side-menu {
            position: fixed;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            z-index: 1100;
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 15px;
            padding: 10px 0;
        }

        .menu-item {
            display: flex;
            align-items: center;
            gap: 10px;
            background-color: rgba(0, 0, 0, 0.7);
            padding: 10px 20px;
            border-radius: 50px 0 0 50px;
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 210px;
            height: 80px;
            text-decoration: none;
            justify-content: flex-start;
            will-change: transform;
        }

        .menu-item i {
            font-size: 1.5rem;
            color: white;
            transition: color 0.3s ease;
        }

        .menu-item span {
            font-size: 1rem;
            white-space: nowrap;
            opacity: 1;
            transform: translateX(0);
            color: white;
            transition: color 0.3s ease;
        }

        .menu-item:hover {
            transform: translateX(-10px) scale(1.3);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
            background-color: #ffd700;
            color: #333;
            text-decoration: none;
        }

        .menu-item:hover i,
        .menu-item:hover span {
            color: #333;
        }

        .menu-item.active {
            background-color: #ffd700;
            color: #333;
        }

        .menu-item.active i,
        .menu-item.active span {
            color: #333;
        }

        /* Focus styles for accessibility */
        .menu-item:focus {
            outline: 2px solid #fff;
            outline-offset: -2px;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .side-menu {
                width: auto;
            }
            
            .menu-item {
                width: 160px;
                height: 60px;
                font-size: 0.9rem;
            }
            
            .menu-item i {
                font-size: 1.2rem;
            }

            .menu-item:hover {
                transform: translateX(-5px) scale(1.02);
            }
        }

        /* For very small screens */
        @media (max-width: 480px) {
            .side-menu {
                padding: 5px 0;
            }
            
            .menu-item {
                width: 140px;
                height: 50px;
                padding: 8px 15px;
            }

            .menu-item span {
                font-size: 0.9rem;
            }
        }
    </style>
    @yield('additional_css')
</head>
<body>
    @include('layouts.header')
    <!-- Side Menu -->
    <nav class="side-menu" aria-label="Side navigation">
        <a href="{{ route('informasi') }}" class="menu-item {{ Route::currentRouteName() == 'informasi' ? 'active' : '' }}" title="Informasi">
            <i class="fas fa-info-circle" aria-hidden="true"></i>
            <span>Informasi</span>
        </a>
        <a href="{{ route('persyaratan') }}" class="menu-item {{ Route::currentRouteName() == 'persyaratan' ? 'active' : '' }}" title="Persyaratan">
            <i class="fas fa-file-alt" aria-hidden="true"></i>
            <span>Persyaratan</span>
        </a>
        <a href="#xx" class="menu-item {{ Route::currentRouteName() == 'peserta-magang' ? 'active' : '' }}" title="Peserta Magang">
            <i class="fas fa-users" aria-hidden="true"></i>
            <span>Peserta Magang</span>
        </a>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Add keyboard navigation support
        document.addEventListener('DOMContentLoaded', function() {
            const menuItems = document.querySelectorAll('.menu-item');
            
            menuItems.forEach((item, index) => {
                item.addEventListener('keydown', (e) => {
                    let nextItem;
                    
                    switch(e.key) {
                        case 'ArrowUp':
                            nextItem = index > 0 ? menuItems[index - 1] : menuItems[menuItems.length - 1];
                            break;
                        case 'ArrowDown':
                            nextItem = index < menuItems.length - 1 ? menuItems[index + 1] : menuItems[0];
                            break;
                    }
                    
                    if (nextItem) {
                        e.preventDefault();
                        nextItem.focus();
                    }
                });
            });
        });
    </script>
    @yield('additional_scripts')
</body>
</html>