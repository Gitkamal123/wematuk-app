<!DOCTYPE html>
<html lang="id" class="h-100">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="SiMatkul - Sistem Manajemen Tugas Kuliah Modern">
    <meta name="theme-color" content="#1e40af">

    <title>@yield('title', 'SiMatkul - Sistem Manajemen Tugas Kuliah')</title>

    <!-- CSS (Bootstrap 5.3 & Font Awesome 6) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    @stack('styles')

    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #1e40af 0%, #3b82f6 50%, #60a5fa 100%);
            --primary-dark: #1e40af;
            --primary: #3b82f6;
            --primary-light: #60a5fa;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --dark: #1e293b;
            --light: #f8fafc;
            --glass-bg: rgba(255, 255, 255, 0.08);
            --glass-border: rgba(255, 255, 255, 0.2);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 30%, #f8fafc 100%);
            min-height: 100vh;
            color: #1f2937;
            line-height: 1.6;
        }

        /* ==================== */
        /* NAVBAR ENHANCEMENT */
        /* ==================== */
        .navbar-wematuk {
            background: var(--primary-gradient);
            padding: 0;
            box-shadow: 0 10px 40px rgba(30, 64, 175, 0.25);
            backdrop-filter: blur(20px);
            position: sticky;
            top: 0;
            z-index: 1000;
            border-bottom: none;
        }

        .navbar-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }

        /* Logo & Brand */
        .navbar-brand-wematuk {
            font-size: 2rem;
            font-weight: 900;
            background: linear-gradient(135deg, #ffffff 0%, #e0f2fe 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem 0;
            position: relative;
            overflow: hidden;
        }

        .navbar-brand-wematuk::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.7s;
        }

        .navbar-brand-wematuk:hover::before {
            left: 100%;
        }

        .logo-icon {
            width: 48px;
            height: 48px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(10px);
            border: 1px solid var(--glass-border);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .logo-icon svg {
            color: #ffffff;
            width: 24px;
            height: 24px;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.2));
        }

        .navbar-brand-wematuk:hover .logo-icon {
            transform: rotate(10deg) scale(1.1);
            background: rgba(255, 255, 255, 0.25);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        /* Navigation Links */
        .nav-link-custom {
            color: rgba(255, 255, 255, 0.9) !important;
            font-weight: 600;
            padding: 0.875rem 1.5rem !important;
            margin: 0 0.25rem;
            border-radius: 14px;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            gap: 0.75rem;
            position: relative;
            font-size: 0.95rem;
            letter-spacing: 0.3px;
        }

        .nav-link-custom i {
            font-size: 1.1rem;
            width: 24px;
            text-align: center;
            opacity: 0.9;
            transition: all 0.3s ease;
        }

        .nav-link-custom:hover {
            color: #ffffff !important;
            background: rgba(255, 255, 255, 0.15);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .nav-link-custom:hover i {
            transform: scale(1.2);
            opacity: 1;
        }

        .nav-link-custom.active {
            background: rgba(255, 255, 255, 0.2);
            color: #ffffff !important;
            font-weight: 700;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .nav-link-custom.active::after {
            content: '';
            position: absolute;
            bottom: 6px;
            left: 50%;
            transform: translateX(-50%);
            width: 24px;
            height: 3px;
            background: linear-gradient(90deg, #60a5fa 0%, #3b82f6 100%);
            border-radius: 2px;
            box-shadow: 0 2px 8px rgba(59, 130, 246, 0.5);
        }

        /* User Avatar */
        .user-avatar {
            width: 44px;
            height: 44px;
            background: linear-gradient(135deg, var(--primary-light) 0%, var(--primary) 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: #ffffff;
            font-size: 1.1rem;
            margin-right: 0.875rem;
            border: 2px solid rgba(255, 255, 255, 0.4);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 12px rgba(30, 64, 175, 0.3);
        }

        .nav-link-custom:hover .user-avatar {
            transform: scale(1.1) rotate(5deg);
            border-color: rgba(255, 255, 255, 0.8);
            box-shadow: 0 6px 20px rgba(30, 64, 175, 0.4);
        }

        /* Enhanced Dropdowns */
        .dropdown-menu-custom {
            background: rgba(30, 41, 59, 0.95);
            backdrop-filter: blur(30px);
            border: 1px solid var(--glass-border);
            border-radius: 18px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.4);
            padding: 0.75rem;
            margin-top: 0.75rem;
            min-width: 240px;
            animation: dropdownFade 0.3s ease;
            border-top: 2px solid var(--primary-light);
        }

        @keyframes dropdownFade {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .dropdown-item-custom {
            padding: 0.875rem 1.25rem;
            border-radius: 12px;
            color: #e5e7eb;
            font-weight: 500;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            gap: 0.875rem;
            margin: 0.125rem 0;
            position: relative;
            overflow: hidden;
        }

        .dropdown-item-custom::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(59, 130, 246, 0.2), transparent);
            transition: left 0.5s;
        }

        .dropdown-item-custom:hover::before {
            left: 100%;
        }

        .dropdown-item-custom:hover {
            background: linear-gradient(135deg, var(--primary) 0%, #2563eb 100%);
            color: #ffffff;
            transform: translateX(8px);
            box-shadow: 0 8px 20px rgba(59, 130, 246, 0.3);
        }

        .dropdown-item-custom i {
            width: 20px;
            text-align: center;
            color: #9ca3af;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .dropdown-item-custom:hover i {
            color: #ffffff;
            transform: scale(1.1);
        }

        .dropdown-divider-custom {
            border-color: rgba(255, 255, 255, 0.15);
            margin: 0.75rem 0;
            opacity: 0.5;
        }

        /* Admin Badge */
        .admin-badge {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
            font-size: 0.7rem;
            font-weight: 800;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            margin-left: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 2px 8px rgba(245, 158, 11, 0.3);
        }

        /* Mobile Responsive */
        @media (max-width: 991.98px) {
            .navbar-collapse {
                background: rgba(30, 41, 59, 0.98);
                backdrop-filter: blur(30px);
                border-radius: 20px;
                padding: 1.5rem;
                margin: 1rem 0;
                box-shadow: 0 20px 50px rgba(0, 0, 0, 0.4);
                border: 1px solid var(--glass-border);
            }

            .nav-link-custom {
                justify-content: flex-start;
                margin: 0.375rem 0;
                padding: 1rem 1.5rem !important;
                font-size: 1rem;
            }

            .nav-link-custom.active::after {
                left: 20px;
                transform: none;
                width: 4px;
                height: 24px;
                bottom: auto;
                top: 50%;
                transform: translateY(-50%);
            }

            .user-avatar {
                margin-right: 1rem;
            }
        }

        /* Navbar Toggler */
        .navbar-toggler-custom {
            border: 2px solid rgba(255, 255, 255, 0.3);
            background: rgba(255, 255, 255, 0.1);
            border-radius: 14px;
            padding: 0.625rem;
            width: 52px;
            height: 52px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .navbar-toggler-custom:hover {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.5);
            transform: rotate(90deg);
        }

        .navbar-toggler-custom:focus {
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.3);
            outline: none;
        }

        /* Main Content */
        .main-content {
            padding: 3rem 0;
            min-height: calc(100vh - 76px);
        }

        /* Enhanced Alert */
        .alert-custom {
            border: none;
            border-radius: 18px;
            padding: 1.25rem 1.75rem;
            margin-bottom: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            gap: 1rem;
            position: relative;
            overflow: hidden;
            backdrop-filter: blur(10px);
        }

        .alert-custom::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 6px;
            height: 100%;
        }

        .alert-success-custom {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(16, 185, 129, 0.05) 100%);
            color: #065f46;
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        .alert-success-custom::before {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        }

        .alert-danger-custom {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.1) 0%, rgba(239, 68, 68, 0.05) 100%);
            color: #991b1b;
            border: 1px solid rgba(239, 68, 68, 0.2);
        }

        .alert-danger-custom::before {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        }

        .alert-custom i {
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        /* Floating Elements */
        .floating-element {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        /* Smooth Scroll */
        html {
            scroll-behavior: smooth;
        }

        /* Selection Color */
        ::selection {
            background: rgba(59, 130, 246, 0.3);
            color: #1f2937;
        }

        /* Scrollbar Styling */
        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--primary);
            border-radius: 10px;
            border: 2px solid #f1f5f9;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary-dark);
        }

        /* Loading Animation */
        .loader {
            width: 40px;
            height: 40px;
            border: 3px solid #e5e7eb;
            border-top: 3px solid var(--primary);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">

    <!-- Enhanced Navbar -->
    <nav class="navbar navbar-expand-lg navbar-wematuk">
        <div class="container navbar-container">
            <!-- Brand Logo with Icon -->
            <a class="navbar-brand-wematuk" href="@guest {{ url('/') }} @else {{ route('home') }} @endguest">
                <div class="logo-icon floating-element">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path
                            d="M11.7 2.805a.75.75 0 0 1 .6 0A60.65 60.65 0 0 1 22.83 8.72a.75.75 0 0 1-.231 1.337 49.949 49.949 0 0 0-9.902 3.912l-.003.002-.34.18a.75.75 0 0 1-.707 0A50.009 50.009 0 0 0 7.5 12.174v-.224c0-.131.067-.248.172-.311a54.614 54.614 0 0 1 4.653-2.52.75.75 0 0 0-.65-1.352 56.129 56.129 0 0 0-4.78 2.589 1.858 1.858 0 0 0-.859 1.228 49.803 49.803 0 0 0-4.634-1.527.75.75 0 0 1-.231-1.337A60.653 60.653 0 0 1 11.7 2.805Z" />
                        <path
                            d="M13.06 15.473a48.45 48.45 0 0 1 7.666-3.282c.134 1.414.22 2.843.255 4.285a.75.75 0 0 1-.46.71 47.878 47.878 0 0 0-8.105 4.342.75.75 0 0 1-.832 0 47.877 47.877 0 0 0-8.104-4.342.75.75 0 0 1-.461-.71c.035-1.442.121-2.87.255-4.286A48.4 48.4 0 0 1 6 13.18v1.27a1.5 1.5 0 0 0-.14 2.508c-.09.38-.222.753-.397 1.11.452.213.901.434 1.346.661a6.729 6.729 0 0 0 .551-1.608 1.5 1.5 0 0 0 .14-2.67v-.645a48.549 48.549 0 0 1 3.44 1.668 2.25 2.25 0 0 0 2.12 0Z" />
                        <path
                            d="M4.462 19.462c.42-.419.753-.89.99-1.394.237-.504.371-1.035.403-1.57a.75.75 0 0 1 .524.659 43.91 43.91 0 0 0 1.423 5.105c-.26.086-.524.165-.791.236a75.728 75.728 0 0 1-2.834-.565.75.75 0 0 1-.298-1.205c.33-.33.724-.586 1.158-.756a42.037 42.037 0 0 1 1.443-4.251Zm5.221-14.22a54.627 54.627 0 0 1 3.562 3.874 2.25 2.25 0 0 0-3.562 0 54.64 54.64 0 0 1-3.562-3.874 2.25 2.25 0 0 0 3.562 0Z" />
                    </svg>
                </div>
                SiMatkul
            </a>

            <!-- Mobile Toggler -->
            <button class="navbar-toggler-custom" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navigation Items -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    @auth
                        <li class="nav-item">
                            <a class="nav-link-custom {{ request()->routeIs('home', 'tugas.show', 'tugas.cari') ? 'active' : '' }}"
                                href="{{ route('home') }}">
                                <i class="fas fa-list-check"></i>
                                Daftar Tugas
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link-custom {{ request()->routeIs('my-tasks.*') ? 'active' : '' }}"
                                href="{{ route('my-tasks.index') }}">
                                <i class="fas fa-tasks"></i>
                                Tugas Saya
                            </a>
                        </li>
                    @endauth
                </ul>

                <ul class="navbar-nav ms-auto align-items-center">
                    @guest
                        @if (!request()->is('/') && !request()->is('login') && !request()->is('register'))
                            <li class="nav-item me-2">
                                <a class="nav-link-custom" href="{{ route('login') }}">
                                    <i class="fas fa-sign-in-alt"></i>
                                    Login
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link-custom btn-login" href="{{ route('register') }}">
                                    <i class="fas fa-user-plus"></i>
                                    Register
                                </a>
                            </li>
                        @endif
                    @endguest

                    @auth
                        <!-- Admin Panel -->
                        @if(Auth::user()->role == 'admin')
                            <li class="nav-item dropdown me-2">
                                <a class="nav-link-custom dropdown-toggle d-flex align-items-center admin-panel {{ request()->is('admin/*') || request()->routeIs('tugas.create', 'tugas.edit', 'tugas.trash') ? 'active' : '' }}"
                                    href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-crown"></i>
                                    <span>Admin</span>
                                    <span class="admin-badge">PRO</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-custom" aria-labelledby="adminDropdown">
                                    <li>
                                        <a class="dropdown-item-custom" href="{{ route('admin.dashboard') }}">
                                            <i class="fas fa-chart-line"></i>
                                            Dashboard Analytics
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item-custom" href="{{ route('admin.users.index') }}">
                                            <i class="fas fa-users-cog"></i>
                                            Kelola Pengguna
                                        </a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider-custom">
                                    </li>
                                    <li>
                                        <a class="dropdown-item-custom" href="{{ route('tugas.create') }}">
                                            <i class="fas fa-plus-circle"></i>
                                            Buat Tugas Baru
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item-custom" href="{{ route('tugas.trash') }}">
                                            <i class="fas fa-trash-restore"></i>
                                            Keranjang Sampah
                                            <span
                                                class="badge bg-danger ms-auto">{{ App\Models\Tugas::onlyTrashed()->count() }}</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif

                        <!-- User Menu -->
                        <li class="nav-item dropdown">
                            <a class="nav-link-custom dropdown-toggle d-flex align-items-center {{ request()->routeIs('profile.edit') ? 'active' : '' }}"
                                href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                                <div class="user-avatar">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                                <div class="d-flex flex-column">
                                    <span class="fw-semibold">{{ Auth::user()->name }}</span>
                                    <small class="text-white-50" style="font-size: 0.75rem; opacity: 0.8;">
                                        {{ Auth::user()->role == 'admin' ? 'Administrator' : 'Mahasiswa' }}
                                    </small>
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-custom dropdown-menu-end" aria-labelledby="userDropdown">
                                <li>
                                    <div class="dropdown-header-custom px-3 py-2">
                                        <small class="text-white-50">TERDAFTAR SEJAK</small>
                                        <div class="fw-semibold">{{ Auth::user()->created_at->format('d M Y') }}</div>
                                    </div>
                                </li>
                                <li>
                                    <hr class="dropdown-divider-custom">
                                </li>
                                <li>
                                    <a class="dropdown-item-custom" href="{{ route('profile.edit') }}">
                                        <i class="fas fa-user-edit"></i>
                                        Edit Profil
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item-custom" href="#">
                                        <i class="fas fa-cog"></i>
                                        Pengaturan
                                    </a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider-custom">
                                </li>
                                <li>
                                    <a class="dropdown-item-custom text-danger" href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt"></i>
                                        Keluar
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        <div class="container">
            <!-- Enhanced Flash Messages -->
            @if (session('success'))
                <div class="alert alert-success-custom alert-custom animate__animated animate__fadeIn">
                    <i class="fas fa-check-circle fa-2x"></i>
                    <div class="flex-grow-1">
                        <h6 class="fw-bold mb-1">Berhasil!</h6>
                        <p class="mb-0">{{ session('success') }}</p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger-custom alert-custom animate__animated animate__shakeX">
                    <i class="fas fa-exclamation-triangle fa-2x"></i>
                    <div class="flex-grow-1">
                        <h6 class="fw-bold mb-1">Error!</h6>
                        <p class="mb-0">{{ session('error') }}</p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Page Content -->
            <div class="content-wrapper">
                @yield('content')
            </div>
        </div>
    </main>

    <!-- Optional Footer -->
    <footer class="mt-auto py-4 bg-white border-top">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="mb-0 text-muted">
                        <i class="fas fa-heart text-danger"></i> Dibuat dengan semangat untuk pendidikan
                    </p>
                </div>
                <div class="col-md-6 text-end">
                    <p class="mb-0 text-muted">
                        &copy; {{ date('Y') }} SiMatkul v1.0
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Optional: Add Animate.css for animations -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

    @stack('scripts')

    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', function () {
            const navbar = document.querySelector('.navbar-wematuk');
            if (window.scrollY > 50) {
                navbar.style.boxShadow = '0 5px 20px rgba(30, 64, 175, 0.2)';
                navbar.style.backdropFilter = 'blur(30px)';
            } else {
                navbar.style.boxShadow = '0 10px 40px rgba(30, 64, 175, 0.25)';
                navbar.style.backdropFilter = 'blur(20px)';
            }
        });

        // Tooltip initialization
        document.addEventListener('DOMContentLoaded', function () {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });

        // Auto-dismiss alerts after 5 seconds
        setTimeout(function () {
            const alerts = document.querySelectorAll('.alert-custom');
            alerts.forEach(alert => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    </script>
</body>

</html>