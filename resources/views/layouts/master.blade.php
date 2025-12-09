<!DOCTYPE html>
<html lang="id" class="h-100">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SiMatkul - Sistem Manajemen Tugas')</title>

    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @stack('styles')

    <style>
        /* ========== VARIABLES ========== */
        :root {
            --primary-blue: #2563eb;
            --light-blue: #dbeafe;
            --soft-gray: #f8fafc;
            --dark-text: #1e293b;
            --medium-text: #64748b;
            --border-color: #e2e8f0;
            --shadow-sm: 0 2px 4px rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            --radius: 12px;
            --transition: all 0.3s ease;
        }

        /* ========== BASE STYLES ========== */
        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background-color: var(--soft-gray);
            color: var(--dark-text);
            line-height: 1.6;
            min-height: 100vh;
        }

        /* ========== NAVBAR ========== */
        .navbar-elegant {
            background: white;
            box-shadow: var(--shadow-md);
            padding: 0.75rem 0;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar-brand-elegant {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--primary-blue);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.5rem 0;
        }

        .navbar-brand-elegant:hover {
            color: var(--primary-blue);
        }

        .logo-circle {
            width: 40px;
            height: 40px;
            background: var(--primary-blue);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logo-circle i {
            color: white;
            font-size: 1.25rem;
        }

        /* ========== NAV LINKS ========== */
        .nav-link-elegant {
            color: var(--medium-text);
            font-weight: 500;
            padding: 0.5rem 1.25rem;
            border-radius: var(--radius);
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin: 0 0.125rem;
        }

        .nav-link-elegant:hover {
            color: var(--primary-blue);
            background-color: var(--light-blue);
        }

        .nav-link-elegant.active {
            color: var(--primary-blue);
            background-color: var(--light-blue);
            font-weight: 600;
        }

        .nav-link-elegant i {
            font-size: 1rem;
            width: 20px;
        }

        /* ========== USER AVATAR ========== */
        .avatar-elegant {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, var(--primary-blue), #3b82f6);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 0.9rem;
            margin-right: 0.75rem;
            border: 2px solid white;
            box-shadow: var(--shadow-sm);
        }

        /* ========== DROPDOWN ========== */
        .dropdown-menu-elegant {
            border: none;
            border-radius: var(--radius);
            box-shadow: var(--shadow-lg);
            padding: 0.5rem;
            margin-top: 0.5rem;
            min-width: 200px;
            border: 1px solid var(--border-color);
        }

        .dropdown-item-elegant {
            padding: 0.75rem 1rem;
            border-radius: 8px;
            color: var(--dark-text);
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .dropdown-item-elegant:hover {
            background-color: var(--light-blue);
            color: var(--primary-blue);
        }

        .dropdown-item-elegant i {
            width: 18px;
            color: var(--medium-text);
        }

        .dropdown-item-elegant:hover i {
            color: var(--primary-blue);
        }

        /* ========== ALERTS ========== */
        .alert-elegant {
            border: none;
            border-radius: var(--radius);
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: var(--shadow-sm);
            border-left: 4px solid;
            background: white;
        }

        .alert-success-elegant {
            border-left-color: #10b981;
            color: #065f46;
        }

        .alert-error-elegant {
            border-left-color: #ef4444;
            color: #991b1b;
        }

        .alert-elegant i {
            margin-right: 0.75rem;
            font-size: 1.25rem;
        }

        /* ========== MOBILE ========== */
        @media (max-width: 991.98px) {
            .navbar-collapse {
                background: white;
                border-radius: var(--radius);
                padding: 1rem;
                margin-top: 1rem;
                box-shadow: var(--shadow-lg);
                border: 1px solid var(--border-color);
            }

            .nav-link-elegant {
                margin: 0.25rem 0;
            }
        }

        /* ========== MAIN CONTENT ========== */
        .main-container {
            padding: 2rem 0;
            min-height: calc(100vh - 76px);
        }

        /* ========== UTILITIES ========== */
        .text-gradient {
            background: linear-gradient(135deg, var(--primary-blue), #3b82f6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .card-elegant {
            border: none;
            border-radius: var(--radius);
            box-shadow: var(--shadow-md);
            background: white;
            transition: var(--transition);
        }

        .card-elegant:hover {
            box-shadow: var(--shadow-lg);
        }

        /* ========== SCROLLBAR ========== */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* ========== FOOTER ========== */
        .footer-elegant {
            background: white;
            border-top: 1px solid var(--border-color);
            padding: 1.5rem 0;
            margin-top: auto;
        }

        .footer-text {
            color: var(--medium-text);
            font-size: 0.9rem;
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-elegant">
        <div class="container">
            <!-- Brand -->
            <a class="navbar-brand-elegant" href="@guest {{ url('/') }} @else {{ route('home') }} @endguest">
                <div class="logo-circle">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                SiMatkul
            </a>

            <!-- Mobile Toggle -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <i class="fas fa-bars"></i>
            </button>

            <!-- Nav Content -->
            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav me-auto">
                    @auth
                        <li class="nav-item">
                            <a class="nav-link-elegant {{ request()->routeIs('home', 'tugas.show', 'tugas.cari') ? 'active' : '' }}"
                                href="{{ route('home') }}">
                                <i class="fas fa-tasks"></i>
                                Daftar Tugas
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link-elegant {{ request()->routeIs('my-tasks.*') ? 'active' : '' }}"
                                href="{{ route('my-tasks.index') }}">
                                <i class="fas fa-user-check"></i>
                                Tugas Saya
                            </a>
                        </li>
                    @endauth
                </ul>

                <ul class="navbar-nav ms-auto align-items-center">
                    @guest
                        @if (!request()->is('/') && !request()->is('login') && !request()->is('register'))
                            <li class="nav-item">
                                <a class="nav-link-elegant" href="{{ route('login') }}">
                                    <i class="fas fa-sign-in-alt"></i>
                                    Login
                                </a>
                            </li>
                            <li class="nav-item ms-2">
                                <a class="nav-link-elegant" href="{{ route('register') }}">
                                    <i class="fas fa-user-plus"></i>
                                    Register
                                </a>
                            </li>
                        @endif
                    @endguest

                    @auth
                        <!-- Admin Menu -->
                        @if(Auth::user()->role == 'admin')
                            <li class="nav-item dropdown me-3">
                                <a class="nav-link-elegant dropdown-toggle {{ request()->is('admin/*') || request()->routeIs('tugas.create', 'tugas.edit', 'tugas.trash') ? 'active' : '' }}"
                                    href="#" id="adminMenu" data-bs-toggle="dropdown">
                                    <i class="fas fa-crown"></i>
                                    Admin
                                </a>
                                <ul class="dropdown-menu dropdown-menu-elegant" aria-labelledby="adminMenu">
                                    <li>
                                        <a class="dropdown-item-elegant" href="{{ route('admin.dashboard') }}">
                                            <i class="fas fa-chart-line"></i>
                                            Dashboard
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item-elegant" href="{{ route('admin.users.index') }}">
                                            <i class="fas fa-users"></i>
                                            Kelola User
                                        </a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <a class="dropdown-item-elegant" href="{{ route('tugas.create') }}">
                                            <i class="fas fa-plus-circle"></i>
                                            Tambah Tugas
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item-elegant" href="{{ route('tugas.trash') }}">
                                            <i class="fas fa-trash"></i>
                                            Keranjang Sampah
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif

                        <!-- User Menu -->
                        <li class="nav-item dropdown">
                            <a class="nav-link-elegant dropdown-toggle d-flex align-items-center {{ request()->routeIs('profile.edit') ? 'active' : '' }}"
                                href="#" id="userMenu" data-bs-toggle="dropdown">
                                <div class="avatar-elegant">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                                <span>{{ Auth::user()->name }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-elegant dropdown-menu-end" aria-labelledby="userMenu">
                                <li>
                                    <a class="dropdown-item-elegant" href="{{ route('profile.edit') }}">
                                        <i class="fas fa-user-edit"></i>
                                        Profil Saya
                                    </a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <a class="dropdown-item-elegant" href="{{ route('logout') }}"
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

    <!-- Main Content -->
    <main class="main-container">
        <div class="container">
            <!-- Alerts -->
            @if (session('success'))
                <div class="alert alert-success-elegant alert-elegant">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-error-elegant alert-elegant">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ session('error') }}
                </div>
            @endif

            <!-- Page Content -->
            <div class="content-area">
                @yield('content')
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer-elegant mt-auto">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="footer-text mb-0">
                        <i class="fas fa-heart text-danger me-1"></i>
                        Sistem Manajemen Tugas Kuliah
                    </p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="footer-text mb-0">
                        &copy; {{ date('Y') }} SiMatkul
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')

    <script>
        // Auto-hide alerts after 5 seconds
        setTimeout(() => {
            document.querySelectorAll('.alert-elegant').forEach(alert => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth' });
                }
            });
        });
    </script>
</body>

</html>