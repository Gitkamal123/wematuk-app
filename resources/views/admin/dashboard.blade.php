@extends('layouts.master')

@section('title', 'Admin Dashboard')

@section('content')
    <style>
        /* ===================== */
        /* DASHBOARD ANIMATIONS  */
        /* ===================== */
        .dashboard-container {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s ease;
        }

        .dashboard-container.show {
            opacity: 1;
            transform: translateY(0);
        }

        .header-section {
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.6s ease;
        }

        .header-section.show {
            opacity: 1;
            transform: translateY(0);
        }

        .stat-card {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s ease;
        }

        .stat-card.show {
            opacity: 1;
            transform: translateY(0);
        }

        .quick-actions-card {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s ease;
            transition-delay: 0.3s;
        }

        .quick-actions-card.show {
            opacity: 1;
            transform: translateY(0);
        }

        .action-item {
            opacity: 0;
            transform: translateX(-20px);
            transition: all 0.5s ease;
        }

        .action-item.show {
            opacity: 1;
            transform: translateX(0);
        }

        /* Existing Styles */
        .hover-shadow {
            transition: all 0.3s ease;
        }

        .hover-shadow:hover {
            box-shadow: 0 0.125rem 0.5rem rgba(0, 0, 0, 0.1) !important;
            transform: translateY(-2px);
        }

        .transition {
            transition: all 0.3s ease;
        }

        .card {
            border-radius: 12px;
        }

        .btn {
            border-radius: 8px;
            font-weight: 500;
        }

        .rounded-circle {
            border-radius: 12px !important;
        }

        /* Enhanced card hover effects */
        .card {
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1) !important;
        }

        /* Pulse animation for icons */
        @keyframes pulse-glow {
            0% {
                box-shadow: 0 0 0 0 rgba(74, 144, 226, 0.4);
            }

            70% {
                box-shadow: 0 0 0 10px rgba(74, 144, 226, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(74, 144, 226, 0);
            }
        }

        /* Gradient backgrounds for cards */
        .gradient-bg-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .gradient-bg-success {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }

        /* Text colors for gradient backgrounds */
        .text-gradient-primary {
            color: #667eea;
        }

        .text-gradient-success {
            color: #4facfe;
        }
    </style>

    <div class="dashboard-container" id="dashboardContainer">
        <!-- Header Section -->
        <div class="header-section mb-4" id="headerSection">
            <h2 class="fw-bold mb-2">Dashboard</h2>
            <p class="text-muted">Hi admin <strong>{{ Auth::user()->name }}</strong>! Selamat datang kembali di dashboard.
            </p>
        </div>

        <!-- Statistics Cards -->
        <div class="row g-4 mb-4">
            <!-- Total Users Card -->
            <div class="col-md-6 col-lg-6">
                <div class="stat-card card border-0 shadow-sm h-100 overflow-hidden" id="usersCard">
                    <div class="card-body p-4 position-relative">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="rounded-circle bg-primary bg-opacity-10 p-3 pulse-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor"
                                    class="bi bi-people-fill text-primary" viewBox="0 0 16 16">
                                    <path
                                        d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5.784 6A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1zM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5" />
                                </svg>
                            </div>
                            <span class="badge bg-primary bg-opacity-10 text-primary">Pengguna</span>
                        </div>
                        <h3 class="fw-bold mb-2">{{ $totalUsers }}</h3>
                        <p class="text-muted mb-3 small">Total pengguna terdaftar</p>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-primary btn-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-arrow-right me-1" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8" />
                            </svg>
                            Kelola Pengguna
                        </a>
                    </div>
                </div>
            </div>

            <!-- Total Tasks Card -->
            <div class="col-md-6 col-lg-6">
                <div class="stat-card card border-0 shadow-sm h-100 overflow-hidden" id="tasksCard">
                    <div class="card-body p-4 position-relative">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="rounded-circle bg-success bg-opacity-10 p-3 pulse-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor"
                                    class="bi bi-list-check text-success" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M5 11.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5M3.854 2.146a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708L2 3.293l1.146-1.147a.5.5 0 0 1 .708 0m0 4a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708L2 7.293l1.146-1.147a.5.5 0 0 1 .708 0m0 4a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 0 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0" />
                                </svg>
                            </div>
                            <span class="badge bg-success bg-opacity-10 text-success">Tugas</span>
                        </div>
                        <h3 class="fw-bold mb-2">{{ $totalTugas }}</h3>
                        <p class="text-muted mb-3 small">Total tugas saat ini</p>
                        <a href="{{ route('home') }}" class="btn btn-success btn-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-arrow-right me-1" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8" />
                            </svg>
                            Lihat Tugas
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row g-4">
            <div class="col-12">
                <div class="quick-actions-card card border-0 shadow-sm" id="quickActionsCard">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">                            
                                <path
                                    d="M11.251.068a.5.5 0 0 1 .227.58L9.677 6.5H13a.5.5 0 0 1 .364.843l-8 8.5a.5.5 0 0 1-.842-.49L6.323 9.5H3a.5.5 0 0 1-.364-.843l8-8.5a.5.5 0 0 1 .615-.09z" />
                            </svg>
                            Menu Lainnya
                        </h5>
                        <div class="row g-3">
                            <!-- Tambah Tugas Baru -->
                            <div class="col-md-6">
                                <div class="action-item" id="actionItem1">
                                    <a href="{{ route('tugas.create') }}" class="text-decoration-none">
                                        <div class="p-3 border rounded hover-shadow transition">
                                            <div class="d-flex align-items-center">
                                                <div class="rounded bg-success bg-opacity-10 p-2 me-3">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                        fill="currentColor" class="bi bi-plus-circle text-success"
                                                        viewBox="0 0 16 16">
                                                        <path
                                                            d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                                        <path
                                                            d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4" />
                                                    </svg>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0 fw-semibold">Tambah Tugas Baru</h6>
                                                    <small class="text-muted">Buat tugas baru untuk mahasiswa</small>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>

                            <!-- Keranjang Sampah -->
                            <div class="col-md-6">
                                <div class="action-item" id="actionItem2">
                                    <a href="{{ route('tugas.trash') }}" class="text-decoration-none">
                                        <div class="p-3 border rounded hover-shadow transition">
                                            <div class="d-flex align-items-center">
                                                <div class="rounded bg-danger bg-opacity-10 p-2 me-3">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                        fill="currentColor" class="bi bi-trash text-danger"
                                                        viewBox="0 0 16 16">
                                                        <path
                                                            d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
                                                        <path
                                                            d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
                                                    </svg>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0 fw-semibold">Keranjang Sampah</h6>
                                                    <small class="text-muted">Kelola tugas yang telah dihapus</small>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Main container animation
            const dashboardContainer = document.getElementById('dashboardContainer');

            // Header animation
            const headerSection = document.getElementById('headerSection');

            // Stat cards animations
            const usersCard = document.getElementById('usersCard');
            const tasksCard = document.getElementById('tasksCard');

            // Quick actions animations
            const quickActionsCard = document.getElementById('quickActionsCard');
            const actionItem1 = document.getElementById('actionItem1');
            const actionItem2 = document.getElementById('actionItem2');

            // Sequence animations with delays
            setTimeout(() => {
                dashboardContainer.classList.add('show');
            }, 100);

            setTimeout(() => {
                headerSection.classList.add('show');
            }, 200);

            setTimeout(() => {
                usersCard.classList.add('show');
            }, 400);

            setTimeout(() => {
                tasksCard.classList.add('show');
            }, 500);

            setTimeout(() => {
                quickActionsCard.classList.add('show');
            }, 600);

            setTimeout(() => {
                actionItem1.classList.add('show');
            }, 700);

            setTimeout(() => {
                actionItem2.classList.add('show');
            }, 800);

            // Add hover effects to cards
            const cards = document.querySelectorAll('.card');
            cards.forEach(card => {
                card.addEventListener('mouseenter', function () {
                    this.style.transform = 'translateY(-5px)';
                });

                card.addEventListener('mouseleave', function () {
                    this.style.transform = 'translateY(0)';
                });
            });

            // Add click animation to action items
            const actionItems = document.querySelectorAll('.action-item a');
            actionItems.forEach(item => {
                item.addEventListener('click', function (e) {
                    // Add ripple effect
                    const rect = this.getBoundingClientRect();
                    const x = e.clientX - rect.left;
                    const y = e.clientY - rect.top;

                    const ripple = document.createElement('span');
                    ripple.style.position = 'absolute';
                    ripple.style.background = 'rgba(255, 255, 255, 0.5)';
                    ripple.style.borderRadius = '50%';
                    ripple.style.transform = 'scale(0)';
                    ripple.style.animation = 'ripple 0.6s linear';
                    ripple.style.left = x + 'px';
                    ripple.style.top = y + 'px';
                    ripple.style.width = '100px';
                    ripple.style.height = '100px';
                    ripple.style.pointerEvents = 'none';

                    this.style.position = 'relative';
                    this.style.overflow = 'hidden';
                    this.appendChild(ripple);

                    setTimeout(() => {
                        ripple.remove();
                    }, 600);
                });
            });

            // Add CSS for ripple effect
            const style = document.createElement('style');
            style.textContent = `
                    @keyframes ripple {
                        to {
                            transform: scale(4);
                            opacity: 0;
                        }
                    }
                `;
            document.head.appendChild(style);
        });

        // Re-run animations when page becomes visible again
        document.addEventListener('visibilitychange', function () {
            if (!document.hidden) {
                // Trigger subtle re-animation for cards
                const cards = document.querySelectorAll('.stat-card, .quick-actions-card');
                cards.forEach(card => {
                    card.style.animation = 'none';
                    setTimeout(() => {
                        card.style.animation = '';
                    }, 10);
                });
            }
        });
    </script>
@endsection