<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'TaskA - Task Assistant')</title>

    <!-- CSS (Bootstrap & Font Awesome) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @stack('styles')

    <style>
        /* ===================== */
        /* DARK BLUE NAVBAR STYLES 
         * (Gradien biru gelap Anda)
        /* ===================== */

        .navbar-wematuk {
            background: linear-gradient(135deg, #1e3a8a 0%, #3730a3 100%);
            padding: 1rem 0;
            box-shadow: 0 4px 20px rgba(30, 58, 138, 0.3);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .navbar-brand-wematuk {
            font-size: 1.8rem;
            font-weight: 800;
            background: linear-gradient(135deg, #ffffff 0%, #e0f2fe 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            transition: all 0.3s ease;
            padding: 0.5rem 0;
        }

        .navbar-brand-wematuk:hover {
            transform: translateY(-1px);
            text-shadow: 0 2px 10px rgba(255, 255, 255, 0.2);
        }

        /* * CSS untuk .brand-icon dan .brand-icon svg 
         * masih ada di sini, tapi tidak terpakai 
         * (sesuai permintaan Anda untuk menghapus logo).
        */
        .brand-icon {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }

        .brand-icon svg {
            color: #ffffff;
            width: 20px;
            height: 20px;
        }


        .nav-link-custom {
            color: rgba(255, 255, 255, 0.85) !important;
            font-weight: 500;
            padding: 0.75rem 1.25rem !important;
            margin: 0 0.25rem;
            border-radius: 12px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            position: relative;
        }

        .nav-link-custom:hover {
            color: #ffffff !important;
            background: rgba(255, 255, 255, 0.12);
            transform: translateY(-1px);
        }

        .nav-link-custom.active {
            background: rgba(255, 255, 255, 0.15);
            color: #ffffff !important;
            font-weight: 600;
        }

        .nav-link-custom.active::before {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 25%;
            width: 50%;
            height: 2px;
            background: linear-gradient(90deg, #60a5fa 0%, #3b82f6 100%);
            border-radius: 2px;
        }

        .nav-link-custom i {
            font-size: 1rem;
            width: 20px;
            text-align: center;
            opacity: 0.9;
        }

        /* Dropdown Styles */
        .dropdown-menu-custom {
            background: #1f2937;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            padding: 0.5rem;
            margin-top: 0.5rem;
            min-width: 220px;
        }

        .dropdown-item-custom {
            padding: 0.75rem 1rem;
            border-radius: 12px;
            color: #f3f4f6;
            font-weight: 500;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            border: none;
        }

        .dropdown-item-custom:hover {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: #ffffff;
            transform: translateX(5px);
        }

        .dropdown-item-custom i {
            width: 18px;
            text-align: center;
            color: #9ca3af;
        }

        .dropdown-item-custom:hover i {
            color: #ffffff;
        }

        .dropdown-divider-custom {
            border-color: rgba(255, 255, 255, 0.1);
            margin: 0.5rem 0;
        }

        .admin-link-box {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            font-weight: 600 !important;
        }

        .admin-link-box:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .admin-link-box.active {
            background: rgba(255, 255, 255, 0.25);
        }

        /* User Avatar */
        .user-avatar {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: #ffffff;
            font-size: 1rem;
            margin-right: 0.75rem;
            border: 2px solid rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease;
        }

        .nav-link-custom:hover .user-avatar {
            transform: scale(1.05);
            border-color: rgba(255, 255, 255, 0.5);
        }

        /* Mobile Responsive */
        @media (max-width: 991.98px) {
            .navbar-collapse {
                background: #1e293b;
                backdrop-filter: blur(20px);
                border-radius: 16px;
                padding: 1rem;
                margin-top: 1rem;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
                border: 1px solid rgba(255, 255, 255, 0.1);
            }

            .nav-link-custom {
                color: #f3f4f6 !important;
                margin: 0.25rem 0;
                justify-content: flex-start;
            }

            .nav-link-custom:hover {
                color: #ffffff !important;
                background: rgba(59, 130, 246, 0.2);
            }

            .nav-link-custom.active::before {
                left: 10%;
                width: 80%;
            }
        }

        /* Navbar Toggler */
        .navbar-toggler {
            border: 2px solid rgba(255, 255, 255, 0.3);
            background: rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 0.5rem;
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .navbar-toggler:hover {
            background: rgba(255, 255, 255, 0.15);
            border-color: rgba(255, 255, 255, 0.4);
        }

        .navbar-toggler:focus {
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.3);
        }

        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='white' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cline x1='3' y1='12' x2='21' y2='12'%3E%3C/line%3E%3Cline x1='3' y1='6' x2='21' y2='6'%3E%3C/line%3E%3Cline x1='3' y1='18' x2='21' y2='18'%3E%3C/line%3E%3C/svg%3E");
        }

        /* Alert Styles */
        .alert-custom {
            border: none;
            border-radius: 16px;
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            gap: 0.75rem;
            border-left: 4px solid;
        }

        .alert-success-custom {
            background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
            color: #166534;
            border-left-color: #22c55e;
        }

        .alert-danger-custom {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
            color: #991b1b;
            border-left-color: #ef4444;
        }

        /* Additional Styling for Better Contrast */
        .navbar-nav .dropdown-menu {
            --bs-dropdown-link-color: #f3f4f6;
            --bs-dropdown-link-hover-color: #ffffff;
            --bs-dropdown-link-hover-bg: #374151;
            --bs-dropdown-bg: #1f2937;
            --bs-dropdown-border-color: rgba(255, 255, 255, 0.1);
        }

        /* Smooth transitions */
        * {
            transition: color 0.3s ease, background-color 0.3s ease, border-color 0.3s ease;
        }
    </style>
</head>

<body
    style="background: #f8fafc; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; min-height: 100vh;">

    <nav class="navbar navbar-expand-lg navbar-wematuk">
        <div class="container">
            <!-- Brand Logo -->
            <a class="navbar-brand-wematuk" href="@guest {{ url('/') }} @else {{ route('home') }} @endguest">               
                TaskA
            </a>

            <!-- Mobile Toggler -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
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

                <ul class="navbar-nav ms-auto">

                    <!-- 👇 PERUBAHAN 3: Login/Register HANYA tampil jika kita TIDAK di halaman utama/login/register 👇 -->
                    @guest
                        @if (!request()->is('/') && !request()->is('login') && !request()->is('register'))
                            <li class="nav-item">
                                <a class="nav-link-custom" href="{{ route('login') }}">
                                    <i class="fas fa-sign-in-alt"></i>
                                    Login
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link-custom" href="{{ route('register') }}">
                                    <i class="fas fa-user-plus"></i>
                                    Register
                                </a>
                            </li>
                        @endif
                    @endguest
                    <!-- 👆 -------------------------------------------------------------------------------------- 👆 -->

                    @auth
                        <!-- Admin Panel -->
                        @if(Auth::user()->role == 'admin')
                            <li class="nav-item dropdown">
                                <a class="nav-link-custom admin-link-box dropdown-toggle d-flex align-items-center {{ request()->is('admin/*') || request()->routeIs('tugas.create', 'tugas.edit', 'tugas.trash') ? 'active' : '' }}"
                                    href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown">                                    
                                    Web Admin
                                </a>
                                <ul class="dropdown-menu dropdown-menu-custom" aria-labelledby="adminDropdown">
                                    <li>
                                        <a class="dropdown-item-custom" href="{{ route('admin.dashboard') }}">
                                            <i class="fas fa-chart-bar"></i>
                                            Dashboard
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item-custom" href="{{ route('admin.users.index') }}">
                                            <i class="fas fa-users"></i>
                                            Kelola User
                                        </a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider-custom">
                                    </li>
                                    <li>
                                        <a class="dropdown-item-custom" href="{{ route('tugas.create') }}">
                                            <i class="fas fa-plus-circle"></i>
                                            Tambah Tugas
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item-custom" href="{{ route('tugas.trash') }}">
                                            <i class="fas fa-trash"></i>
                                            Keranjang Sampah
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
                                <span>{{ Auth::user()->name }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-custom" aria-labelledby="userDropdown">
                                <li>
                                    <a class="dropdown-item-custom" href="{{ route('profile.edit') }}">
                                        <i class="fas fa-user-edit"></i>
                                        Profil Saya
                                    </a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider-custom">
                                </li>
                                <li>
                                    <a class="dropdown-item-custom" href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt"></i>
                                        Logout
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

    <main class="container my-4">
        <!-- Flash Messages -->
        @if (session('success'))
            <div class="alert alert-success-custom alert-custom">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger-custom alert-custom">
                <i class="fas fa-exclamation-circle"></i>
                {{ session('error') }}
            </div>
        @endif

        <!-- Main Content -->
        @yield('content')
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
</body>

</html>