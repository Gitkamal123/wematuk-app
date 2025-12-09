<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'WeMaTuK - Sistem Manajemen Tugas Kuliah')</title>

    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @stack('styles')

    <style>
        /* Reset & Base */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #f8f9fa;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            min-height: 100vh;
        }

        /* Navbar */
        .navbar-wematuk {
            background: #ffffff;
            padding: 1rem 0;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
            border-bottom: 1px solid #f0f0f0;
        }

        /* Brand */
        .navbar-brand-wematuk {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1a202c;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
        }

        .navbar-brand-wematuk:hover {
            color: #4a90e2;
        }

        .brand-logo {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, #4a90e2 0%, #63b3ed 100%);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .brand-logo svg {
            width: 20px;
            height: 20px;
            color: #ffffff;
        }

        /* Nav Links */
        .nav-link-custom {
            color: #4a5568 !important;
            font-weight: 500;
            font-size: 0.95rem;
            padding: 0.5rem 1rem !important;
            margin: 0 0.25rem;
            border-radius: 10px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .nav-link-custom:hover {
            color: #4a90e2 !important;
            background: rgba(74, 144, 226, 0.08);
        }

        .nav-link-custom.active {
            color: #4a90e2 !important;
            background: rgba(74, 144, 226, 0.1);
            font-weight: 600;
        }

        .nav-link-custom i {
            font-size: 0.9rem;
            width: 18px;
            text-align: center;
        }

        /* Admin Badge */
        .admin-badge {
            background: rgba(74, 144, 226, 0.1);
            border: 1px solid rgba(74, 144, 226, 0.2);
            padding: 0.5rem 1rem;
            border-radius: 10px;
            color: #4a90e2 !important;
            font-weight: 600;
        }

        .admin-badge:hover {
            background: rgba(74, 144, 226, 0.15);
        }

        /* User Menu */
        .user-menu {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.5rem 1rem;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .user-menu:hover {
            background: rgba(74, 144, 226, 0.08);
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, #4a90e2 0%, #63b3ed 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: #ffffff;
            font-size: 0.9rem;
        }

        .user-name {
            font-weight: 600;
            color: #2d3748;
            font-size: 0.95rem;
        }

        /* Dropdown */
        .dropdown-menu-custom {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
            padding: 0.5rem;
            margin-top: 0.5rem;
            min-width: 200px;
        }

        .dropdown-item-custom {
            padding: 0.75rem 1rem;
            border-radius: 8px;
            color: #4a5568;
            font-weight: 500;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            border: none;
            background: transparent;
        }

        .dropdown-item-custom:hover {
            background: rgba(74, 144, 226, 0.08);
            color: #4a90e2;
        }

        .dropdown-item-custom i {
            width: 18px;
            text-align: center;
            color: #a0aec0;
        }

        .dropdown-item-custom:hover i {
            color: #4a90e2;
        }

        .dropdown-divider-custom {
            border-color: #f0f0f0;
            margin: 0.5rem 0;
        }

        /* Logout Item */
        .logout-item {
            color: #e53e3e !important;
        }

        .logout-item:hover {
            background: rgba(229, 62, 62, 0.08);
            color: #e53e3e !important;
        }

        .logout-item i {
            color: #e53e3e;
        }

        /* Mobile Toggler */
        .navbar-toggler {
            border: 1px solid #e2e8f0;
            background: #ffffff;
            border-radius: 10px;
            padding: 0.5rem;
            width: 44px;
            height: 44px;
        }

        .navbar-toggler:focus {
            box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.2);
        }

        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='%234a5568' stroke-width='2'%3E%3Cline x1='3' y1='12' x2='21' y2='12'%3E%3C/line%3E%3Cline x1='3' y1='6' x2='21' y2='6'%3E%3C/line%3E%3Cline x1='3' y1='18' x2='21' y2='18'%3E%3C/line%3E%3C/svg%3E");
        }

        /* Alert */
        .alert-custom {
            border: none;
            border-radius: 12px;
            padding: 1rem 1.25rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            border-left: 4px solid;
        }

        .alert-success-custom {
            background: rgba(72, 187, 120, 0.1);
            color: #166534;
            border-left-color: #48bb78;
        }

        .alert-danger-custom {
            background: rgba(229, 62, 62, 0.1);
            color: #991b1b;
            border-left-color: #e53e3e;
        }

        .alert-custom i {
            font-size: 1.1rem;
        }

        /* Mobile */
        @media (max-width: 991.98px) {
            .navbar-collapse {
                background: #ffffff;
                border-radius: 12px;
                padding: 1rem;
                margin-top: 1rem;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
                border: 1px solid #f0f0f0;
            }

            .nav-link-custom {
                justify-content: flex-start;
                margin: 0.25rem 0;
            }

            .user-menu {
                justify-content: flex-start;
            }

            .dropdown-menu-custom {
                box-shadow: none;
                border: none;
                padding: 0.5rem 0;
            }
        }

        /* Main Content */
        main {
            padding-top: 2rem;
            padding-bottom: 2rem;
        }

        /* Smooth Scrolling */
        html {
            scroll-behavior: smooth;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-wematuk">
        <div class="container">

            <!-- Brand -->
            <a class="navbar-brand-wematuk" href="@guest {{ url('/') }} @else {{ route('home') }} @endguest">
                <div class="brand-logo">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                        <path
                            d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z" />
                    </svg>
                </div>
                <span>WeMaTuK</span>
            </a>

            <!-- Mobile Toggle -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navigation -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    @auth
                        <li class="nav-item">
                            <a class="nav-link-custom {{ request()->routeIs('home', 'tugas.show', 'tugas.cari') ? 'active' : '' }}"
                                href="{{ route('home') }}">
                                <i class="fas fa-list-check"></i>
                                <span>Daftar Tugas</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link-custom {{ request()->routeIs('my-tasks.*') ? 'active' : '' }}"
                                href="{{ route('my-tasks.index') }}">
                                <i class="fas fa-tasks"></i>
                                <span>Tugas Saya</span>
                            </a>
                        </li>
                    @endauth
                </ul>

                <ul class="navbar-nav ms-auto">
                    @guest
                        @if (!request()->is('/') && !request()->is('login') && !request()->is('register'))
                            <li class="nav-item">
                                <a class="nav-link-custom" href="{{ route('login') }}">
                                    <i class="fas fa-sign-in-alt"></i>
                                    <span>Login</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link-custom" href="{{ route('register') }}">
                                    <i class="fas fa-user-plus"></i>
                                    <span>Register</span>
                                </a>
                            </li>
                        @endif
                    @endguest

                    @auth
                        <!-- Admin Menu -->
                        @if(Auth::user()->role == 'admin')
                            <li class="nav-item dropdown">
                                <a class="nav-link-custom admin-badge dropdown-toggle {{ request()->is('admin/*') || request()->routeIs('tugas.create', 'tugas.edit', 'tugas.trash') ? 'active' : '' }}"
                                    href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-shield-alt"></i>
                                    <span>Admin</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-custom">
                                    <li>
                                        <a class="dropdown-item-custom" href="{{ route('admin.dashboard') }}">
                                            <i class="fas fa-chart-line"></i>
                                            <span>Dashboard</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item-custom" href="{{ route('admin.users.index') }}">
                                            <i class="fas fa-users"></i>
                                            <span>Kelola User</span>
                                        </a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider-custom">
                                    </li>
                                    <li>
                                        <a class="dropdown-item-custom" href="{{ route('tugas.create') }}">
                                            <i class="fas fa-plus-circle"></i>
                                            <span>Tambah Tugas</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item-custom" href="{{ route('tugas.trash') }}">
                                            <i class="fas fa-trash"></i>
                                            <span>Keranjang Sampah</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif

                        <!-- User Menu -->
                        <li class="nav-item dropdown">
                            <a class="nav-link-custom dropdown-toggle {{ request()->routeIs('profile.edit') ? 'active' : '' }}"
                                href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                                <div class="user-menu">
                                    <div class="user-avatar">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                    </div>
                                    <span
                                        class="user-name d-none d-lg-inline">{{ Str::limit(Auth::user()->name, 15) }}</span>
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-custom">
                                <li>
                                    <a class="dropdown-item-custom" href="{{ route('profile.edit') }}">
                                        <i class="fas fa-user-circle"></i>
                                        <span>Profil Saya</span>
                                    </a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider-custom">
                                </li>
                                <li>
                                    <a class="dropdown-item-custom logout-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt"></i>
                                        <span>Logout</span>
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container">
        <!-- Flash Messages -->
        @if (session('success'))
            <div class="alert alert-success-custom alert-custom">
                <i class="fas fa-check-circle"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger-custom alert-custom">
                <i class="fas fa-exclamation-circle"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- Page Content -->
        @yield('content')
    </main>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')

    <script>
        // Auto close alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function () {
            const alerts = document.querySelectorAll('.alert-custom');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateY(-20px)';
                    setTimeout(() => {
                        alert.remove();
                    }, 300);
                }, 5000);
            });
        });

        // Close mobile menu after clicking link
        document.querySelectorAll('.navbar-collapse .nav-link').forEach(link => {
            link.addEventListener('click', () => {
                const navbar = document.querySelector('.navbar-collapse');
                if (navbar.classList.contains('show')) {
                    bootstrap.Collapse.getInstance(navbar).hide();
                }
            });
        });
    </script>

</body>

</html>