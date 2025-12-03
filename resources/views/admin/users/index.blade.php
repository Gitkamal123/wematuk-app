@extends('layouts.master')

@section('title', 'Manajemen Pengguna')

@section('content')
        <style>
            /* ===================== */
            /* USER MANAGEMENT ANIMATIONS */
            /* ===================== */    

            .user-management-container {
                opacity: 0;
                transform: translateY(30px);
                transition: all 0.8s ease;
            }

            .table-responsive {
                overflow: visible !important;
            }



            .user-management-container.show {
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

            /* .users-table-card {
                opacity: 0;
                transition: opacity 0.6s ease;
            } */

            .dropdown-menu {
                z-index: 99999 !important;
            }


            .users-table-card.show {
                opacity: 1;
                transform: translateY(0);
            }

            .table-row {
                opacity: 0;
                transition: opacity 0.5s ease;
            }

            .table-row.show {
                opacity: 1;
            }


            .pagination-section {
                opacity: 0;
                transform: translateY(20px);
                transition: all 0.6s ease;
                transition-delay: 0.4s;
            }

            .pagination-section.show {
                opacity: 1;
                transform: translateY(0);
            }

            /* Enhanced animations */
            @keyframes slideInRight {
                from {
                    opacity: 0;
                    transform: translateX(30px);
                }

                to {
                    opacity: 1;
                    transform: translateX(0);
                }
            }

            @keyframes pulse {
                0% {
                    transform: scale(1);
                }

                50% {
                    transform: scale(1.05);
                }

                100% {
                    transform: scale(1);
                }
            }

            .stat-card:hover {
                animation: pulse 0.6s ease;
            }

            /* Existing Styles */
            .avatar-sm {
                width: 40px;
                height: 40px;
                font-size: 14px;
                transition: all 0.3s ease;
            }

            .table th {
                border-top: none;
                font-weight: 600;
                font-size: 0.875rem;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                color: #6c757d;
            }

            .table td {
                vertical-align: middle;
                padding: 1rem 0.75rem;
                transition: all 0.3s ease;
            }

            .card {
                border-radius: 12px;
                transition: all 0.3s ease;
            }

            .card:hover {
                transform: translateY(-2px);
                box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1) !important;
            }

            .badge {
                font-weight: 500;
                transition: all 0.3s ease;
            }

            .table-hover tbody tr:hover {
                background-color: rgba(67, 97, 238, 0.05);
                padding-left: 5px; /* Efek visual sama tanpa stacking context */
            }


            /* Enhanced dropdown animation */
            .dropdown-menu {
                animation: slideInRight 0.3s ease;
            }

            /* Loading animation for table rows */
            @keyframes rowHighlight {
                0% {
                    background-color: rgba(67, 97, 238, 0.1);
                }

                100% {
                    background-color: transparent;
                }
            }

            .new-row {
                animation: rowHighlight 2s ease;
            }

            .dropdown-menu {
                transform-origin: top right;
            }

            .dropdown-menu[data-popper-placement^="top"] {
                margin-bottom: 8px;
            }

            /* desain ubah role tambahan */

            /* --- AUTO DROPUP UNTUK 2 ROW TERAKHIR --- */
   


        </style>

        <div class="user-management-container" id="userManagementContainer">
            <!-- Header Section -->
            <div class="header-section d-flex justify-content-between align-items-center mb-4" id="headerSection">
                <div>
                    <h2 class="fw-bold mb-2">Manajemen Pengguna</h2>
                    <p class="text-muted mb-0">Kelola data pengguna dan peran akses sistem</p>
                </div>
                <div class="d-flex align-items-center">
                    <span class="badge bg-primary bg-opacity-10 text-primary me-3">
                        <i class="fas fa-users me-1"></i>
                        Total: {{ $users->total() }} Pengguna
                    </span>
                </div>
            </div>

            <!-- Simplified Statistics Cards -->
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <div class="stat-card card border-0 bg-primary bg-opacity-10" id="userStatCard">
                        <div class="card-body py-3">
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-primary bg-opacity-25 p-3 me-3">
                                    <i class="fas fa-user text-primary"></i>
                                </div>
                                <div>
                                    <h4 class="fw-bold mb-0">{{ $users->where('role', 'user')->count() }}</h4>
                                    <small class="text-muted">Pengguna Biasa</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="stat-card card border-0 bg-warning bg-opacity-10" id="adminStatCard">
                        <div class="card-body py-3">
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-warning bg-opacity-25 p-3 me-3">
                                    <i class="fas fa-crown text-warning"></i>
                                </div>
                                <div>
                                    <h4 class="fw-bold mb-0">{{ $users->where('role', 'admin')->count() }}</h4>
                                    <small class="text-muted">Administrator</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Users Table -->
            <div class="users-table-card card border-0 shadow-sm" id="usersTableCard">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Pengguna</th>
                                    <th>NRP</th>
                                    <th>Role</th>
                                    <th>Bergabung</th>
                                    <th class="text-end pe-4">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $index => $user)
                                    <tr class="table-row {{ Auth::id() == $user->id ? 'table-active' : '' }}"
                                        id="userRow{{ $user->id }}" style="transition-delay: {{ $index * 0.1 }}s">
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center">
                                                <div
                                                    class="avatar-sm bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3">
                                                    <span class="text-primary fw-bold">{{ substr($user->name, 0, 1) }}</span>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0 fw-semibold">{{ $user->name }}</h6>
                                                    <small class="text-muted">{{ $user->email }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <code class="text-dark">{{ $user->nrp }}</code>
                                        </td>
                                        <td>
                                            <span
                                                class="badge {{ $user->role == 'admin' ? 'bg-warning text-dark' : 'bg-primary' }} py-2 px-3">
                                                <i class="fas {{ $user->role == 'admin' ? 'fa-crown' : 'fa-user' }} me-1"></i>
                                                {{ ucfirst($user->role) }}
                                            </span>
                                        </td>
                                        <td>
                                            <div>
                                                <div class="fw-semibold">{{ $user->created_at->format('d M Y') }}</div>
                                                <small class="text-muted">{{ $user->created_at->diffForHumans() }}</small>
                                            </div>
                                        </td>
                                        <td class="text-end pe-4">
                                            @if(Auth::id() == $user->id)
                                                <span class="text-muted fst-italic">Akun Anda</span>
                                            @else
                                                <div class="dropdown dropstart">
                                                    <button type="button" class="btn btn-sm btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown"
                                                        data-bs-display="static" data-bs-auto-close="outside">
                                                        <i class="fas fa-ellipsis-h"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                        <li>
                                                            <a class="dropdown-item text-info"
                                                                href="{{ route('admin.users.edit', $user) }}">
                                                                <i class="fas fa-edit me-2"></i>Ubah Role
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <hr class="dropdown-divider">
                                                        </li>
                                                        <li>
                                                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                                                id="delete-form-{{ $user->id }}">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="button" class="dropdown-item text-danger"
                                                                    onclick="confirmDelete({{ $user->id }}, '{{ $user->name }}')">
                                                                    <i class="fas fa-trash me-2"></i>Hapus
                                                                </button>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <div class="pagination-section d-flex justify-content-between align-items-center mt-4" id="paginationSection">
                <div class="text-muted">
                    Menampilkan {{ $users->firstItem() }} - {{ $users->lastItem() }} dari {{ $users->total() }} pengguna
                </div>
                <nav>
                    {{ $users->links() }}
                </nav>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Main container animation
                const userManagementContainer = document.getElementById('userManagementContainer');

                // Header animation
                const headerSection = document.getElementById('headerSection');

                // Stat cards animations
                const userStatCard = document.getElementById('userStatCard');
                const adminStatCard = document.getElementById('adminStatCard');

                // Table card animation
                const usersTableCard = document.getElementById('usersTableCard');

                // Pagination animation
                const paginationSection = document.getElementById('paginationSection');

                // Table rows
                const tableRows = document.querySelectorAll('.table-row');

                // Sequence animations with delays
                setTimeout(() => {
                    userManagementContainer.classList.add('show');
                }, 100);

                setTimeout(() => {
                    headerSection.classList.add('show');
                }, 200);

                setTimeout(() => {
                    userStatCard.classList.add('show');
                }, 300);

                setTimeout(() => {
                    adminStatCard.classList.add('show');
                }, 400);

                setTimeout(() => {
                    usersTableCard.classList.add('show');
                }, 500);

                // Animate table rows with staggered delay
                tableRows.forEach((row, index) => {
                    setTimeout(() => {
                        row.classList.add('show');
                    }, 600 + (index * 100));
                });

                setTimeout(() => {
                    paginationSection.classList.add('show');
                }, 800 + (tableRows.length * 100));

                // Enhanced hover effects
                const cards = document.querySelectorAll('.card');
                cards.forEach(card => {
                    card.addEventListener('mouseenter', function () {
                        this.style.transform = 'translateY(-5px)';
                    });

                    card.addEventListener('mouseleave', function () {
                        this.style.transform = 'translateY(0)';
                    });
                });

                // Add click animation to dropdown items
                const dropdownItems = document.querySelectorAll('.dropdown-item');
                dropdownItems.forEach(item => {
                    item.addEventListener('click', function (e) {
                        // Add subtle scale effect
                        this.style.transform = 'scale(0.98)';
                        setTimeout(() => {
                            this.style.transform = '';
                        }, 200);
                    });
                });

                // Avatar hover effect
                const avatars = document.querySelectorAll('.avatar-sm');
                avatars.forEach(avatar => {
                    avatar.addEventListener('mouseenter', function () {
                        this.style.transform = 'scale(1.1) rotate(5deg)';
                    });

                    avatar.addEventListener('mouseleave', function () {
                        this.style.transform = 'scale(1) rotate(0deg)';
                    });
                });

                // Badge hover effects
                const badges = document.querySelectorAll('.badge');
                badges.forEach(badge => {
                    badge.addEventListener('mouseenter', function () {
                        this.style.transform = 'scale(1.05)';
                        this.style.boxShadow = '0 2px 8px rgba(0,0,0,0.1)';
                        this.style.cursor = 'pointer';                    
                        this.style.transition = 'all 0.3s ease';
                        this.style.zIndex = '10';
                        this.style.position = 'relative';
                        this.style.fontWeight = '600';
                        this.style.letterSpacing = '0.5px';
                        this.style.border = '1px solid rgba(255,255,255,0.2)';
                        this.style.backdropFilter = 'blur(10px)';
                        this.style.webkitBackdropFilter = 'blur(10px)';
                        this.style.backgroundColor = this.classList.contains('bg-primary') ?
                            'rgba(13, 110, 253, 0.9)' :
                            'rgba(255, 193, 7, 0.9)';
                    });

                    badge.addEventListener('mouseleave', function () {
                        this.style.transform = 'scale(1)';
                        this.style.boxShadow = 'none';
                        this.style.fontWeight = '500';
                        this.style.letterSpacing = 'normal';
                        this.style.border = 'none';
                        this.style.backdropFilter = 'none';
                        this.style.webkitBackdropFilter = 'none';
                        this.style.backgroundColor = this.classList.contains('bg-primary') ?
                            '' : '';
                    });

                    badge.addEventListener('click', function () {
                        // Add pulse animation on click
                        this.style.animation = 'pulse 0.6s ease';
                        setTimeout(() => {
                            this.style.animation = '';
                        }, 600);
                    });
                });
            });

            // Enhanced Confirm Delete Function with animations
            function confirmDelete(userId, userName) {
                // Add shake animation to the row being deleted
                const row = document.getElementById(`userRow${userId}`);
                if (row) {
                    row.style.animation = 'shake 0.5s ease-in-out';

                    // Remove animation after it completes
                    setTimeout(() => {
                        row.style.animation = '';
                    }, 500);
                }

                Swal.fire({
                    title: 'Hapus Pengguna?',
                    html: `Anda akan menghapus pengguna <strong>${userName}</strong>. Tindakan ini tidak dapat dibatalkan.`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true,
                    backdrop: 'rgba(0,0,0,0.4)',
                    showClass: {
                        popup: 'animate__animated animate__fadeInDown'
                    },
                    hideClass: {
                        popup: 'animate__animated animate__fadeOutUp'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Add loading state to the row
                        if (row) {
                            row.style.opacity = '0.5';
                            row.style.background = 'linear-gradient(45deg, #ff6b6b, #ee5a52)';
                            row.style.color = 'white';
                            row.style.transition = 'all 0.5s ease';

                            // Add deleting animation
                            row.style.animation = 'slideOutLeft 0.5s ease forwards';

                            setTimeout(() => {
                                document.getElementById(`delete-form-${userId}`).submit();
                            }, 500);
                        } else {
                            document.getElementById(`delete-form-${userId}`).submit();
                        }
                    }
                });
            }

            // Add CSS for delete animations
            const style = document.createElement('style');
            style.textContent = `
                    @keyframes shake {
                        0%, 100% { transform: translateX(0); }
                        25% { transform: translateX(-5px); }
                        75% { transform: translateX(5px); }
                    }

                    @keyframes slideOutLeft {
                        from {
                            opacity: 1;
                            transform: translateX(0);
                        }
                        to {
                            opacity: 0;
                            transform: translateX(-100%);
                        }
                    }

                    @keyframes rowHighlight {
                        0% {
                            background-color: rgba(67, 97, 238, 0.1);
                            transform: scale(1);
                        }
                        50% {
                            background-color: rgba(67, 97, 238, 0.2);
                            transform: scale(1.02);
                        }
                        100% {
                            background-color: transparent;
                            transform: scale(1);
                        }
                    }
                `;
            document.head.appendChild(style);

            // Re-run animations when page becomes visible
            document.addEventListener('visibilitychange', function () {
                if (!document.hidden) {
                    const elements = document.querySelectorAll('.stat-card, .users-table-card');
                    elements.forEach(el => {
                        el.style.animation = 'none';
                        setTimeout(() => {
                            el.style.animation = '';
                        }, 10);
                    });
                }
            });
        </script>

        <!-- Include SweetAlert2 -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <!-- Include Animate.css for SweetAlert animations -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
@endsection