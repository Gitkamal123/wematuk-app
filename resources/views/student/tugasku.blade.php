@extends('layouts.master')

@section('title', 'Manajemen Tugas Saya - SiMatkul')

@section('content')
    {{-- SweetAlert2 untuk notifikasi --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            background: #f8f9fa;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        /* --- 1. ANIMASI LOAD HALAMAN (Sama seperti referensi) --- */
        .fade-in-up {
            animation: fadeInUp 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94) forwards;
            opacity: 0;
            transform: translateY(30px);
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .tasks-container {
            padding: 2rem 0;
            max-width: 1400px;
            margin: 0 auto;
        }

        /* --- 2. TRANSISI UTAMA (KUNCI EFEK SMOOTH) --- */
        /* Kita terapkan cubic-bezier dari kode referensi ke semua elemen interaktif */
        .btn-back,
        .stat-card,
        .nav-pills .nav-link,
        .task-card,
        .btn-task,
        .table-custom tbody tr,
        .btn-take,
        .btn-table-action {
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1) !important;
            /* Timing function dari referensi */
            position: relative;
            z-index: 1;
        }

        /* --- BUTTON BACK --- */
        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            background: white;
            color: #64748b;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.9rem;
            text-decoration: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.02);
        }

        .btn-back:hover {
            transform: translateY(-3px);
            /* Naik sedikit */
            color: #3b82f6;
            border-color: #3b82f6;
            box-shadow: 0 10px 20px rgba(59, 130, 246, 0.1);
        }

        /* Header */
        .page-header {
            margin-bottom: 2.5rem;
        }

        .page-title {
            font-size: 2rem;
            font-weight: 800;
            color: #1f2937;
            margin-bottom: 0.5rem;
        }

        .page-subtitle {
            color: #6b7280;
            font-size: 1rem;
        }

        /* --- STATS CARDS --- */
        .stats-row {
            display: flex;
            gap: 1.5rem;
            margin-bottom: 2.5rem;
        }

        .stat-card {
            flex: 1;
            background: white;
            border-radius: 20px;
            padding: 1.5rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }

        /* Efek Hover Stat Card (Mengikuti gaya referensi) */
        .stat-card:hover {
            transform: translateY(-8px) scale(1.02);
            /* Naik & Zoom dikit */
            box-shadow: 0 30px 60px rgba(30, 64, 175, 0.1), 0 5px 15px rgba(30, 64, 175, 0.05);
            z-index: 10;
        }

        .stat-label {
            font-size: 0.85rem;
            color: #64748b;
            text-transform: uppercase;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .stat-value {
            font-size: 2.5rem;
            font-weight: 800;
            margin-top: 0.5rem;
        }

        .stat-value.ongoing {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .stat-value.completed {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* --- NAV TABS --- */
        .nav-pills .nav-link {
            color: #64748b;
            font-weight: 600;
            background: white;
            border: 1px solid #f1f5f9;
            margin-right: 1rem;
            border-radius: 12px;
            padding: 0.75rem 1.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
        }

        .nav-pills .nav-link:hover {
            transform: translateY(-3px);
            color: #3b82f6;
            background: white;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
        }

        .nav-pills .nav-link.active {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            box-shadow: 0 10px 20px rgba(37, 99, 235, 0.2);
            border-color: transparent;
        }

        /* Task Grid */
        .tasks-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }

        /* --- TASK CARD (CORE EFFECT) --- */
        .task-card {
            background: white;
            border-radius: 24px;
            /* Lebih bulat sesuai referensi */
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
            border: 1px solid #f1f5f9;
            border-left: 6px solid;
            display: flex;
            flex-direction: column;
        }

        .task-card.urgent {
            border-left-color: #ef4444;
        }

        .task-card.warning {
            border-left-color: #f97316;
        }

        .task-card.normal {
            border-left-color: #3b82f6;
        }

        /* EFEK HOVER KARTU TUGAS - SAMA PERSIS REFERENSI */
        .task-card:hover {
            transform: translateY(-8px) scale(1.02);
            /* Naik tinggi & zoom */
            box-shadow:
                0 30px 60px rgba(30, 64, 175, 0.15),
                0 5px 15px rgba(30, 64, 175, 0.1);
            z-index: 5;
        }

        .task-title {
            font-size: 1.25rem;
            font-weight: 800;
            color: #1f2937;
            margin-bottom: 0.75rem;
            line-height: 1.4;
        }

        .task-desc {
            color: #6b7280;
            font-size: 0.95rem;
            margin-bottom: 1.5rem;
            line-height: 1.6;
            flex-grow: 1;
        }

        .task-deadline {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            background: #f8fafc;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            border: 1px solid #e2e8f0;
        }

        .deadline-text {
            font-size: 0.9rem;
            font-weight: 600;
            color: #334155;
        }

        /* Status Badge */
        .status-badge {
            display: inline-block;
            padding: 0.4rem 1rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            margin-bottom: 1.25rem;
            letter-spacing: 0.5px;
        }

        .status-badge.urgent {
            background: #fef2f2;
            color: #ef4444;
            border: 1px solid #fee2e2;
        }

        .status-badge.warning {
            background: #fff7ed;
            color: #f97316;
            border: 1px solid #ffedd5;
        }

        .status-badge.normal {
            background: #eff6ff;
            color: #3b82f6;
            border: 1px solid #dbeafe;
        }

        /* Buttons Action */
        .task-actions {
            display: flex;
            gap: 0.75rem;
        }

        .btn-task {
            padding: 0.75rem;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-complete {
            flex: 1;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            box-shadow: 0 4px 10px rgba(16, 185, 129, 0.2);
        }

        .btn-complete:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(16, 185, 129, 0.3);
        }

        .btn-remove {
            width: 44px;
            background: #fee2e2;
            color: #ef4444;
        }

        .btn-remove:hover {
            transform: translateY(-3px) rotate(5deg);
            background: #ef4444;
            color: white;
            box-shadow: 0 10px 20px rgba(239, 68, 68, 0.2);
        }

        /* --- TABLE STYLES --- */
        .completed-table,
        .available-tasks {
            background: white;
            border-radius: 24px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
            overflow: hidden;
            border: 1px solid #f1f5f9;
        }

        .table-custom {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .table-custom thead th {
            padding: 1.5rem;
            background: #f8fafc;
            font-size: 0.85rem;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #e2e8f0;
        }

        .table-custom tbody td {
            padding: 1.5rem;
            border-bottom: 1px solid #f1f5f9;
            color: #334155;
        }

        /* Efek Hover Row Tabel (Smooth Lift) */
        .table-custom tbody tr:hover {
            background: #f8fafc;
            transform: translateY(-4px) scale(1.01);
            /* Naik sedikit */
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
            position: relative;
            z-index: 2;
        }

        .btn-undo {
            background: #fff7ed;
            color: #f97316;
        }

        .btn-undo:hover {
            transform: translateY(-3px);
            background: #f97316;
            color: white;
        }

        .btn-delete {
            background: #fef2f2;
            color: #ef4444;
            margin-left: 0.5rem;
        }

        .btn-delete:hover {
            transform: translateY(-3px);
            background: #ef4444;
            color: white;
        }

        /* Available Tasks */
        .available-header {
            padding: 2rem;
            background: white;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .available-title {
            font-size: 1.5rem;
            font-weight: 800;
            color: #1f2937;
            margin: 0;
        }

        .count-badge {
            padding: 0.5rem 1rem;
            background: #eff6ff;
            color: #3b82f6;
            border-radius: 50px;
            font-weight: 700;
            font-size: 0.85rem;
        }

        .btn-take {
            padding: 0.6rem 1.25rem;
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.85rem;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-take:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 16px rgba(59, 130, 246, 0.3);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
        }

        .empty-icon {
            width: 80px;
            height: 80px;
            margin-bottom: 1.5rem;
            color: #e2e8f0;
        }

        .empty-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 0.5rem;
        }

        @media (max-width: 768px) {
            .stats-row {
                flex-direction: column;
            }

            .tasks-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="tasks-container">
        <div class="container-fluid">

            <div class="mb-5 fade-in-up" style="animation-delay: 0.1s;">
                <a href="{{ route('home') }}" class="btn-back">
                    <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
                </a>
            </div>

            <div class="page-header fade-in-up" style="animation-delay: 0.2s;">
                <h1 class="page-title">Manajemen Tugas Saya</h1>
                <p class="page-subtitle">Kelola tugas aktif dan riwayat pengerjaan Anda.</p>
            </div>

            <div class="stats-row fade-in-up" style="animation-delay: 0.3s;">
                <div class="stat-card">
                    <div class="stat-label">Sedang Berjalan</div>
                    <div class="stat-value ongoing">{{ $myTasks->where('pivot.is_completed', false)->count() }}</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Telah Selesai</div>
                    <div class="stat-value completed">{{ $myTasks->where('pivot.is_completed', true)->count() }}</div>
                </div>
            </div>

            <ul class="nav nav-pills mb-4 fade-in-up" id="pills-tab" role="tablist" style="animation-delay: 0.4s;">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pills-ongoing-tab" data-bs-toggle="pill"
                        data-bs-target="#pills-ongoing" type="button" role="tab" aria-controls="pills-ongoing"
                        aria-selected="true">
                        <i class="fas fa-tasks me-2"></i> Tugas Berjalan
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-history-tab" data-bs-toggle="pill" data-bs-target="#pills-history"
                        type="button" role="tab" aria-controls="pills-history" aria-selected="false">
                        <i class="fas fa-history me-2"></i> Riwayat Selesai
                    </button>
                </li>
            </ul>

            <div class="tab-content fade-in-up" id="pills-tabContent" style="animation-delay: 0.5s;">

                <div class="tab-pane fade show active" id="pills-ongoing" role="tabpanel">
                    @php
                        $ongoingTasks = $myTasks->where('pivot.is_completed', false);
                    @endphp

                    @if($ongoingTasks->isEmpty())
                        <div class="empty-state bg-white rounded-4 shadow-sm border">
                            <svg xmlns="http://www.w3.org/2000/svg" class="empty-icon" fill="currentColor" viewBox="0 0 16 16">
                                <path
                                    d="M8.5 2.687c.654-.689 1.782-.886 3.112-.752 1.234.124 2.503.523 3.388.893v9.923c-.918-.35-2.107-.692-3.287-.81-1.094-.111-2.278-.039-3.213.492V2.687zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783z" />
                            </svg>
                            <h3 class="empty-title">Tidak Ada Tugas Berjalan</h3>
                            <p class="text-muted">Anda belum mengambil tugas apapun.</p>
                        </div>
                    @else
                        <div class="tasks-grid">
                            @foreach($ongoingTasks as $task)
                                @php
                                    $deadline = \Carbon\Carbon::parse($task->deadline);
                                    $now = \Carbon\Carbon::now();
                                    $diff = $now->diffInDays($deadline, false);

                                    if ($diff < 0) {
                                        $statusClass = 'urgent';
                                        $statusLabel = 'Lewat Deadline';
                                    } elseif ($diff <= 3) {
                                        $statusClass = 'warning';
                                        $statusLabel = 'Mendekati Deadline';
                                    } else {
                                        $statusClass = 'normal';
                                        $statusLabel = 'Aktif';
                                    }
                                @endphp

                                <div class="task-card {{ $statusClass }}">
                                    <div class="status-badge {{ $statusClass }}">
                                        {{ $statusLabel }}
                                    </div>

                                    <h3 class="task-title">{{ $task->judul }}</h3>
                                    <p class="task-desc">{{ Str::limit($task->deskripsi, 90) }}</p>

                                    <div class="task-deadline">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" class="text-muted"
                                            fill="currentColor" viewBox="0 0 16 16">
                                            <path
                                                d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z" />
                                            <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z" />
                                        </svg>
                                        <span class="deadline-text">{{ $deadline->format('d M Y, H:i') }}</span>
                                    </div>

                                    <div class="task-actions">
                                        <form action="{{ route('my-tasks.update', $task->id) }}" method="POST"
                                            class="confirm-finish-form" style="flex: 1;">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="btn-task btn-complete">
                                                <i class="fas fa-check"></i> Selesai
                                            </button>
                                        </form>
                                        <form action="{{ route('my-tasks.destroy', $task->id) }}" method="POST" class="delete-form">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn-task btn-remove" title="Lepas Tugas">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="tab-pane fade" id="pills-history" role="tabpanel">
                    @php
                        $completedTasks = $myTasks->where('pivot.is_completed', true);
                    @endphp

                    @if($completedTasks->isNotEmpty())
                        <div class="completed-table">
                            <div class="table-responsive">
                                <table class="table-custom">
                                    <thead>
                                        <tr>
                                            <th>Judul Tugas</th>
                                            <th>Deadline</th>
                                            <th>Selesai Pada</th>
                                            <th>Status</th>
                                            <th style="text-align: center;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($completedTasks as $task)
                                            <tr>
                                                <td class="fw-bold text-dark">{{ $task->judul }}</td>
                                                <td>{{ \Carbon\Carbon::parse($task->deadline)->format('d M Y') }}</td>
                                                <td>{{ \Carbon\Carbon::parse($task->pivot->updated_at)->format('d M Y, H:i') }}</td>
                                                <td>
                                                    <span
                                                        class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">
                                                        <i class="fas fa-check-circle me-1"></i> Selesai
                                                    </span>
                                                </td>
                                                <td style="text-align: center;">
                                                    <form action="{{ route('my-tasks.update', $task->id) }}" method="POST"
                                                        style="display: inline;">
                                                        @csrf @method('PATCH')
                                                        <button type="submit" class="btn-table-action btn-undo"
                                                            title="Kembalikan ke aktif">
                                                            <i class="fas fa-undo"></i>
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('my-tasks.destroy', $task->id) }}" method="POST"
                                                        class="delete-history-form" style="display: inline;">
                                                        @csrf @method('DELETE')
                                                        <button type="button" class="btn-table-action btn-delete btn-delete-history"
                                                            title="Hapus Permanen">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @else
                        <div class="empty-state">
                            <p class="text-muted">Belum ada riwayat tugas selesai.</p>
                        </div>
                    @endif
                </div>
            </div>

            <h2 class="page-title mt-5 mb-4 fade-in-up" style="font-size: 1.5rem; animation-delay: 0.6s;">Tugas Tersedia
            </h2>

            <div class="available-tasks fade-in-up" style="animation-delay: 0.7s;">
                <div class="available-header">
                    <h3 class="available-title">Tugas Yang Tersedia</h3>
                    <span class="count-badge">{{ $availableTasks->count() }} Tersedia</span>
                </div>

                @if($availableTasks->isEmpty())
                    <div class="empty-state">
                        <svg xmlns="http://www.w3.org/2000/svg" class="empty-icon" fill="currentColor" viewBox="0 0 16 16">
                            <path
                                d="M4.98 4a.5.5 0 0 0-.39.188L1.54 8H6a.5.5 0 0 1 .5.5 1.5 1.5 0 1 0 3 0A.5.5 0 0 1 10 8h4.46l-3.05-3.812A.5.5 0 0 0 11.02 4zm-1.17-.437A1.5 1.5 0 0 1 4.98 3h6.04a1.5 1.5 0 0 1 1.17.563l3.7 4.625a.5.5 0 0 1 .106.374l-.39 3.124A1.5 1.5 0 0 1 14.117 13H1.883a1.5 1.5 0 0 1-1.489-1.314l-.39-3.124a.5.5 0 0 1 .106-.374z" />
                        </svg>
                        <h3 class="empty-title">Tidak Ada Tugas Tersedia</h3>
                        <p class="text-muted">Belum ada tugas baru dari admin.</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table-custom">
                            <thead>
                                <tr>
                                    <th>Judul Tugas</th>
                                    <th>Deskripsi</th>
                                    <th>Deadline</th>
                                    <th style="text-align: center;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($availableTasks as $task)
                                    <tr>
                                        <td class="fw-bold text-dark">{{ $task->judul }}</td>
                                        <td>{{ Str::limit($task->deskripsi, 60) }}</td>
                                        <td>{{ \Carbon\Carbon::parse($task->deadline)->format('d M Y') }}</td>
                                        <td style="text-align: center;">
                                            <form action="{{ route('my-tasks.store') }}" method="POST" class="take-task-form">
                                                @csrf
                                                <input type="hidden" name="task_id" value="{{ $task->id }}">
                                                <button type="submit" class="btn-take">
                                                    <i class="fas fa-plus-circle"></i> Ambil Tugas
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // SweetAlert Logic (Sama seperti sebelumnya)
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: "{{ session('success') }}",
                    timer: 3000,
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end'
                });
            @endif

            // Konfirmasi Hapus History
            document.querySelectorAll('.btn-delete-history').forEach(button => {
                button.addEventListener('click', function (e) {
                    const form = this.closest('.delete-history-form');
                    Swal.fire({
                        title: 'Hapus dari Riwayat?',
                        text: "Data tugas ini akan dihapus dari riwayat selesai.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#ef4444',
                        cancelButtonColor: '#64748b',
                        confirmButtonText: 'Ya, Hapus',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) form.submit();
                    });
                });
            });

            // Konfirmasi Selesai
            document.querySelectorAll('.btn-complete').forEach(button => {
                button.addEventListener('click', function (e) {
                    e.preventDefault();
                    const form = this.closest('.confirm-finish-form');
                    Swal.fire({
                        title: 'Tandai Selesai?',
                        text: "Tugas akan dipindahkan ke riwayat selesai.",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#10b981',
                        cancelButtonColor: '#64748b',
                        confirmButtonText: 'Ya, Selesai!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) form.submit();
                    });
                });
            });

            // Konfirmasi Lepas Tugas
            document.querySelectorAll('.btn-remove').forEach(button => {
                button.addEventListener('click', function (e) {
                    e.preventDefault();
                    const form = this.closest('.delete-form');
                    Swal.fire({
                        title: 'Lepas Tugas?',
                        text: "Anda harus mengambil ulang jika ingin mengerjakannya lagi.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#ef4444',
                        cancelButtonColor: '#64748b',
                        confirmButtonText: 'Ya, Lepas',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) form.submit();
                    });
                });
            });
        });
    </script>
@endsection