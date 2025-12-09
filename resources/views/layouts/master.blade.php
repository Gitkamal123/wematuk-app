<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SiMatkul - Sistem Manajemen Tugas Kuliah')</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @stack('styles')

    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #1e3a8a 0%, #3730a3 100%);
            --secondary-bg: #f3f4f6;
            --text-color: #1f2937;
            --glass-bg: rgba(255, 255, 255, 0.95);
            --nav-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
        }

        body {
            background-color: var(--secondary-bg);
            font-family: 'Inter', sans-serif;
            color: var(--text-color);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* --- NAVBAR MEWAH --- */
        .navbar-wematuk {
            background: var(--primary-gradient);
            padding: 0.8rem 0;
            box-shadow: var(--nav-shadow);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar-brand-wematuk {
            font-size: 1.6rem;
            font-weight: 800;
            color: #ffffff;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            letter-spacing: -0.5px;
        }

        .navbar-brand-wematuk span {
            background: linear-gradient(135deg, #60a5fa 0%, #3b82f6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* --- NAV LINKS --- */
        .nav-link-custom {
            color: rgba(255, 255, 255, 0.8) !important;
            font-weight: 500;
            font-size: 0.95rem;
            padding: 0.6rem 1rem !important;
            border-radius: 8px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }

        .nav-link-custom:hover {
            color: #ffffff !important;
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-1px);
        }

        .nav-link-custom.active {
            background: rgba(255, 255, 255, 0.15);
            color: #ffffff !important;
            font-weight: 600;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .nav-link-custom i {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        /* --- DROPDOWN MEWAH --- */
        .dropdown-menu-custom {
            border: none;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            padding: 0.5rem;
            margin-top: 10px !important;
            background: #ffffff;
            animation: slideUp 0.3s ease forwards;
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
            padding: 0.7rem 1rem;
            border-radius: 8px;
            color: #4b5563;
            font-weight: 500;
            font-size: 0.9rem;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }

        .dropdown-item-custom:hover {
            background-color: #eff6ff;
            color: #2563eb;
            transform: translateX(3px);
        }

        .dropdown-item-custom i {
            color: #9ca3af;
            width: 20px;
            text-align: center;
            transition: color 0.2s;
        }

        .dropdown-item-custom:hover i {
            color: #2563eb;
        }

        .dropdown-divider-custom {
            margin: 0.5rem 0;
            border-top: 1px solid #f3f4f6;
        }

        /* --- ADMIN BADGE --- */
        .admin-badge {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            font-size: 0.85rem;
            padding: 0.4rem 0.8rem !important;
        }

        /* --- USER AVATAR --- */
        .user-avatar {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, #60a5fa 0%, #2563eb 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: #ffffff;
            font-size: 0.9rem;
            border: 2px solid rgba(255, 255, 255, 0.4);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        /* --- ALERT NOTIFIKASI --- */
        .alert-custom {
            border: none;
            border-radius: 12px;
            padding: 1rem 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            gap: 1rem;
            background: #ffffff;
            border-left: 5px solid;
            animation: fadeIn 0.5s ease;
        }

        .alert-success-custom {
            border-left-color: #10b981;
        }

        .alert-success-custom i {
            color: #10b981;
            font-size: 1.5rem;
        }

        .alert-danger-custom {
            border-left-color: #ef4444;
        }

        .alert-danger-custom i {
            color: #ef4444;
            font-size: 1.5rem;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* --- MAIN CONTENT & FOOTER --- */
        main {
            flex: 1;
        }

        .footer-wematuk {
            background: #ffffff;
            padding: 1.5rem 0;
            text-align: center;
            color: #6b7280;
            font-size: 0.9rem;
            border-top: 1px solid #e5e7eb;
            margin-top: auto;
        }

        /* --- RESPONSIVE --- */
        @media (max-width: 991.98px) {
            .navbar-collapse {
                background: rgba(255, 255, 255, 0.98);
                padding: 1rem;
                border-radius: 12px;
                margin-top: 1rem;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            }

            .nav-link-custom {
                color: #4b5563 !important;
            }

            .nav-link-custom:hover {
                background: #f3f4f6;
                color: #1e3a8a !important;
            }

            .nav-link-custom.active {
                background: #eff6ff;
                color: #2563eb !important;
            }

            .admin-badge {
                background: #1e3a8a;
                color: white !important;
            }

            .admin-badge:hover {
                color: white !important;
            }
        }

        /* Navbar Toggler */
        .navbar-toggler {
            border: none;
            padding: 0.5rem;
            color: white;
            font-size: 1.2rem;
        }

        .navbar-toggler:focus {
            box-shadow: none;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-wematuk">
        <div class="container">
            <a class="navbar-brand-wematuk" href="@guest {{ url('/') }} @else {{ route('home') }} @endguest">
                <i class="fas fa-graduation-cap fa-lg"></i>
                Si<span>Matkul</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <i class="fas fa-bars"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto ms-lg-4">
                    @auth
                        <li class="nav-item">
                            <a class="nav-link-custom {{ request()->routeIs('home', 'tugas.show', 'tugas.cari') ? 'active' : '' }}"
                                href="{{ route('home') }}">
                                <i class="fas fa-layer-group"></i>
                                Daftar Tugas
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link-custom {{ request()->routeIs('my-tasks.*') ? 'active' : '' }}"
                                href="{{ route('my-tasks.index') }}">
                                <i class="fas fa-clipboard-check"></i>
                                Tugas Saya
                            </a>
                        </li>
                    @endauth
                </ul>

                <ul class="navbar-nav ms-auto align-items-lg-center">
                    @guest
                        @if (!request()->is('/') && !request()->is('login') && !request()->is('register'))
                            <li class="nav-item">
                                <a class="nav-link-custom" href="{{ route('login') }}">
                                    <i class="fas fa-sign-in-alt"></i> Login
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link-custom" href="{{ route('register') }}">
                                    <i class="fas fa-user-plus"></i> Register
                                </a>
                            </li>
                        @endif
                    @endguest

                    @auth
                        @if(Auth::user()->role == 'admin')
                            <li class="nav-item dropdown me-lg-3">
                                <a class="nav-link-custom admin-badge dropdown-toggle" href="#" id="adminDropdown" role="button"
                                    data-bs-toggle="dropdown">
                                    <i class="fas fa-shield-alt"></i> Admin Panel
                                </a>
                                <ul class="dropdown-menu dropdown-menu-custom shadow-lg" aria-labelledby="adminDropdown">
                                    <li>
                                        <a class="dropdown-item-custom" href="{{ route('admin.dashboard') }}">
                                            <i class="fas fa-chart-pie"></i> Dashboard
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item-custom" href="{{ route('admin.users.index') }}">
                                            <i class="fas fa-users-cog"></i> Kelola User
                                        </a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider-custom">
                                    </li>
                                    <li>
                                        <a class="dropdown-item-custom" href="{{ route('tugas.create') }}">
                                            <i class="fas fa-plus-circle text-primary"></i> Tambah Tugas
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item-custom" href="{{ route('tugas.trash') }}">
                                            <i class="fas fa-trash-alt text-danger"></i> Sampah
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif

                        <li class="nav-item dropdown">
                            <a class="nav-link-custom dropdown-toggle p-0" href="#" id="userDropdown" role="button"
                                data-bs-toggle="dropdown">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="user-avatar">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                    </div>
                                    <span class="d-lg-none fw-bold">{{ Auth::user()->name }}</span>
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-custom dropdown-menu-end shadow-lg"
                                aria-labelledby="userDropdown">
                                <li class="px-3 py-2 border-bottom mb-2">
                                    <small class="text-muted d-block">Login sebagai</small>
                                    <span class="fw-bold text-dark">{{ Auth::user()->name }}</span>
                                </li>
                                <li>
                                    <a class="dropdown-item-custom" href="{{ route('profile.edit') }}">
                                        <i class="fas fa-user-circle"></i> Profil Saya
                                    </a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider-custom">
                                </li>
                                <li>
                                    <a class="dropdown-item-custom text-danger" href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt text-danger"></i> Logout
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

    <main class="container my-5">
        @if (session('success'))
            <div class="alert alert-success-custom alert-custom">
                <i class="fas fa-check-circle"></i>
                <div>
                    <h6 class="fw-bold mb-0">Berhasil!</h6>
                    <small>{{ session('success') }}</small>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger-custom alert-custom">
                <i class="fas fa-exclamation-triangle"></i>
                <div>
                    <h6 class="fw-bold mb-0">Terjadi Kesalahan!</h6>
                    <small>{{ session('error') }}</small>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="footer-wematuk">
        <div class="container">
            <p class="mb-0">&copy; {{ date('Y') }} <strong>SiMatkul</strong>. Dibuat dengan <i
                    class="fas fa-heart text-danger"></i> untuk Mahasiswa.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
</body>

</html>