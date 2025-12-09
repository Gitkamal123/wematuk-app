<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SiMatkul - Sistem Manajemen Tugas')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Poppins:wght@500;600;700&display=swap"
        rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @stack('styles')

    <style>
        :root {
            --primary-color: #4f46e5;
            /* Indigo 600 */
            --primary-hover: #4338ca;
            /* Indigo 700 */
            --secondary-color: #0f172a;
            /* Slate 900 */
            --accent-color: #38bdf8;
            /* Sky 400 */
            --bg-body: #f1f5f9;
            /* Slate 100 */
            --glass-bg: rgba(15, 23, 42, 0.85);
            /* Dark Glass */
            --glass-border: rgba(255, 255, 255, 0.1);
            --text-light: #e2e8f0;
        }

        body {
            background-color: var(--bg-body);
            font-family: 'Inter', sans-serif;
            color: #334155;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        .navbar-brand {
            font-family: 'Poppins', sans-serif;
        }

        /* Navbar Styling (Glassmorphism) */
        .navbar-custom {
            background: var(--glass-bg);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--glass-border);
            padding: 0.8rem 0;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand-custom {
            font-weight: 700;
            font-size: 1.5rem;
            color: #fff !important;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: transform 0.3s ease;
        }

        .navbar-brand-custom:hover {
            transform: translateY(-2px);
            text-shadow: 0 0 15px rgba(56, 189, 248, 0.5);
        }

        .navbar-brand-custom i {
            color: var(--accent-color);
        }

        /* Nav Links */
        .nav-link-custom {
            color: rgba(255, 255, 255, 0.7) !important;
            font-weight: 500;
            font-size: 0.95rem;
            padding: 0.6rem 1rem !important;
            border-radius: 8px;
            transition: all 0.3s ease;
            position: relative;
        }

        .nav-link-custom:hover,
        .nav-link-custom.active {
            color: #fff !important;
            background: rgba(255, 255, 255, 0.1);
        }

        .nav-link-custom.active::after {
            content: '';
            position: absolute;
            bottom: 0px;
            left: 50%;
            transform: translateX(-50%);
            width: 30%;
            height: 3px;
            background: var(--accent-color);
            border-radius: 10px;
            box-shadow: 0 0 10px var(--accent-color);
        }

        /* Admin Badge */
        .badge-admin {
            background: linear-gradient(135deg, #ef4444, #b91c1c);
            padding: 0.4rem 0.8rem;
            border-radius: 6px;
            font-size: 0.85rem;
            color: white !important;
            box-shadow: 0 2px 10px rgba(239, 68, 68, 0.3);
        }

        .badge-admin:hover {
            background: linear-gradient(135deg, #f87171, #dc2626);
        }

        /* Dropdown Menu */
        .dropdown-menu-custom {
            background: #1e293b;
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            box-shadow: 0 10px 40px -10px rgba(0, 0, 0, 0.5);
            margin-top: 10px;
            padding: 0.5rem;
            animation: slideUp 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .dropdown-item-custom {
            color: #cbd5e1;
            padding: 0.6rem 1rem;
            border-radius: 8px;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.2s;
        }

        .dropdown-item-custom:hover {
            background: var(--primary-color);
            color: #fff;
            transform: translateX(5px);
        }

        .dropdown-divider-custom {
            border-color: rgba(255, 255, 255, 0.1);
            margin: 0.5rem 0;
        }

        /* User Avatar */
        .user-avatar {
            width: 35px;
            height: 35px;
            background: linear-gradient(135deg, var(--accent-color), var(--primary-color));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 0.9rem;
            margin-right: 8px;
            border: 2px solid rgba(255, 255, 255, 0.2);
        }

        /* Main Content Animation */
        main {
            flex: 1;
            animation: fadeIn 0.6s ease-out;
            padding-top: 2rem;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Alerts */
        .alert-custom {
            border: none;
            border-radius: 12px;
            padding: 1rem 1.25rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            gap: 12px;
            color: white;
        }

        .alert-success-custom {
            background: linear-gradient(135deg, #10b981, #059669);
        }

        .alert-danger-custom {
            background: linear-gradient(135deg, #ef4444, #dc2626);
        }

        /* Footer */
        .footer-custom {
            background: white;
            border-top: 1px solid #e2e8f0;
            padding: 1.5rem 0;
            margin-top: auto;
            font-size: 0.9rem;
            color: #64748b;
        }

        /* Mobile Adjustments */
        @media (max-width: 991.98px) {
            .navbar-collapse {
                background: #1e293b;
                padding: 1rem;
                border-radius: 12px;
                margin-top: 1rem;
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            }

            .nav-link-custom.active::after {
                display: none;
                /* Disable underline on mobile */
            }

            .nav-link-custom.active {
                background: var(--primary-color);
                color: white !important;
            }
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container">
            <a class="navbar-brand-custom" href="{{ url('/') }}">
                <i class="fas fa-graduation-cap"></i> SiMatkul
            </a>

            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNav">
                <i class="fas fa-bars text-white fs-4"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                    @auth
                        <li class="nav-item">
                            <a class="nav-link-custom {{ request()->routeIs('home', 'tugas.show', 'tugas.cari') ? 'active' : '' }}"
                                href="{{ route('home') }}">
                                <i class="fas fa-layer-group me-1"></i> Daftar Tugas
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link-custom {{ request()->routeIs('my-tasks.*') ? 'active' : '' }}"
                                href="{{ route('my-tasks.index') }}">
                                <i class="fas fa-clipboard-check me-1"></i> Tugas Saya
                            </a>
                        </li>
                    @endauth
                </ul>

                <ul class="navbar-nav ms-auto align-items-lg-center">
                    @guest
                        @if (!request()->is('/') && !request()->is('login') && !request()->is('register'))
                            <li class="nav-item">
                                <a class="nav-link-custom" href="{{ route('login') }}">Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link-custom btn btn-sm btn-outline-light ms-2 px-3"
                                    style="border:1px solid rgba(255,255,255,0.3);" href="{{ route('register') }}">Register</a>
                            </li>
                        @endif
                    @endguest

                    @auth
                        @if(Auth::user()->role == 'admin')
                            <li class="nav-item dropdown me-lg-2">
                                <a class="nav-link-custom dropdown-toggle badge-admin d-inline-flex align-items-center gap-2"
                                    href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-shield-alt"></i> Admin Panel
                                </a>
                                <ul class="dropdown-menu dropdown-menu-custom" aria-labelledby="adminDropdown">
                                    <li><a class="dropdown-item-custom" href="{{ route('admin.dashboard') }}"><i
                                                class="fas fa-chart-line w-5"></i> Dashboard</a></li>
                                    <li><a class="dropdown-item-custom" href="{{ route('admin.users.index') }}"><i
                                                class="fas fa-users w-5"></i> Kelola User</a></li>
                                    <li>
                                        <hr class="dropdown-divider-custom">
                                    </li>
                                    <li><a class="dropdown-item-custom" href="{{ route('tugas.create') }}"><i
                                                class="fas fa-plus w-5"></i> Tambah Tugas</a></li>
                                    <li><a class="dropdown-item-custom" href="{{ route('tugas.trash') }}"><i
                                                class="fas fa-trash-alt w-5"></i> Sampah</a></li>
                                </ul>
                            </li>
                        @endif

                        <li class="nav-item dropdown">
                            <a class="nav-link-custom dropdown-toggle d-flex align-items-center" href="#" id="userDropdown"
                                role="button" data-bs-toggle="dropdown">
                                <div class="user-avatar">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                                <span class="d-none d-lg-inline">{{ Auth::user()->name }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-custom dropdown-menu-end" aria-labelledby="userDropdown">
                                <li class="px-3 py-2 text-muted border-bottom border-secondary mb-2 small">
                                    Signed in as <br><strong class="text-white">{{ Auth::user()->email }}</strong>
                                </li>
                                <li><a class="dropdown-item-custom" href="{{ route('profile.edit') }}"><i
                                            class="fas fa-user-circle w-5"></i> Profil Saya</a></li>
                                <li>
                                    <hr class="dropdown-divider-custom">
                                </li>
                                <li>
                                    <a class="dropdown-item-custom text-danger" href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt w-5"></i> Logout
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

    <main class="container">
        @if (session('success'))
            <div class="alert alert-success-custom alert-custom mb-4" role="alert">
                <i class="fas fa-check-circle fs-5"></i>
                <div>{{ session('success') }}</div>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger-custom alert-custom mb-4" role="alert">
                <i class="fas fa-exclamation-triangle fs-5"></i>
                <div>{{ session('error') }}</div>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="footer-custom text-center">
        <div class="container">
            <p class="mb-0">&copy; {{ date('Y') }} <strong>SiMatkul</strong>. Dibuat dengan <i
                    class="fas fa-heart text-danger"></i> untuk mahasiswa.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
    </script>

    @stack('scripts')
</body>

</html>