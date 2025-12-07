@extends('layouts.master')

@section('content')
    <div class="container-fluid px-lg-4 px-xl-5">

        {{-- Hero Header --}}
        <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between mb-5">
            <div class="mb-4 mb-md-0">
                <h1 class="h2 fw-bold text-gradient-primary mb-2">Manajemen Tugas Saya</h1>
                <p class="text-muted mb-0">
                    <i class="fas fa-tasks me-2"></i>Kelola tugas yang sedang Anda kerjakan dan ambil tugas baru
                </p>
            </div>
            <div class="d-flex align-items-center">
                <span class="badge bg-primary bg-opacity-10 text-primary fw-semibold py-2 px-3 me-3">
                    <i class="fas fa-check-circle me-1"></i>
                    {{ $myTasks->where('pivot.is_completed', true)->count() }} Selesai
                </span>
                <span class="badge bg-warning bg-opacity-10 text-warning fw-semibold py-2 px-3">
                    <i class="fas fa-clock me-1"></i>
                    {{ $myTasks->where('pivot.is_completed', false)->count() }} Berjalan
                </span>
            </div>
        </div>

        {{-- Success Alert --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-5" role="alert">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle fa-lg"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="alert-heading mb-1">Berhasil!</h6>
                        <p class="mb-0">{{ session('success') }}</p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif

        {{-- My Tasks Section --}}
        <div class="row mb-5">
            <div class="col-12">
                <div class="card border-0 shadow-lg overflow-hidden">
                    <div class="card-header bg-gradient-primary py-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="mb-0 text-white fw-bold">
                                    <i class="fas fa-list-check me-2"></i>Progress Tugas Saya
                                </h4>
                                <p class="mb-0 text-white-50 mt-1">Tugas yang sedang Anda kerjakan atau sudah selesai</p>
                            </div>
                            <div class="text-white">
                                <span class="badge bg-white bg-opacity-25 text-white py-2 px-3">
                                    {{ $myTasks->count() }} Tugas
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="card-body bg-light-gradient p-4">
                        @if($myTasks->isEmpty())
                            <div class="text-center py-6">
                                <div class="mb-4">
                                    <i class="fas fa-clipboard-list fa-4x text-gray-300"></i>
                                </div>
                                <h4 class="text-gray-500 mb-2">Belum ada tugas yang diambil</h4>
                                <p class="text-muted mb-4">Ambil tugas baru dari daftar tugas yang tersedia di bawah</p>
                                <a href="#available-tasks" class="btn btn-primary px-4">
                                    <i class="fas fa-plus me-2"></i>Lihat Tugas Tersedia
                                </a>
                            </div>
                        @else
                            <div class="row g-4">
                                @foreach($myTasks as $task)
                                    <div class="col-xl-4 col-lg-6">
                                        <div class="card border-0 shadow-sm h-100 task-card hover-lift">
                                            <div class="card-body p-4">
                                                {{-- Status Badge --}}
                                                <div class="d-flex justify-content-between align-items-start mb-3">
                                                    <span
                                                        class="badge {{ $task->pivot->is_completed ? 'bg-success bg-opacity-10 text-success' : 'bg-warning bg-opacity-10 text-warning' }} py-2 px-3 fw-semibold">
                                                        <i
                                                            class="fas {{ $task->pivot->is_completed ? 'fa-check-circle' : 'fa-clock' }} me-1"></i>
                                                        {{ $task->pivot->is_completed ? 'Selesai' : 'Dalam Progress' }}
                                                    </span>
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-link text-muted p-0" type="button"
                                                            data-bs-toggle="dropdown">
                                                            <i class="fas fa-ellipsis-v"></i>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end">
                                                            <li>
                                                                <form action="{{ route('my-tasks.destroy', $task->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="dropdown-item text-danger"
                                                                        onclick="return confirm('Yakin ingin melepas tugas ini?')">
                                                                        <i class="fas fa-trash me-2"></i>Lepas Tugas
                                                                    </button>
                                                                </form>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>

                                                {{-- Task Title --}}
                                                <h5 class="fw-bold text-dark mb-2">{{ $task->judul_tugas }}</h5>

                                                {{-- Task Description --}}
                                                <p class="text-muted mb-3">
                                                    {{ Str::limit($task->deskripsi, 80) }}
                                                </p>

                                                {{-- Deadline --}}
                                                <div class="d-flex align-items-center mb-4">
                                                    <div class="flex-shrink-0">
                                                        <i class="fas fa-calendar-day text-primary"></i>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <small class="text-muted d-block">Deadline</small>
                                                        <span
                                                            class="fw-semibold {{ $task->isDeadlineNear() ? 'text-danger' : 'text-dark' }}">
                                                            {{ date('d M Y', strtotime($task->deadline)) }}
                                                        </span>
                                                        @if($task->isDeadlineNear())
                                                            <span
                                                                class="badge bg-danger bg-opacity-10 text-danger ms-2">Mendekati</span>
                                                        @endif
                                                    </div>
                                                </div>

                                                {{-- Progress Bar
                                                @if(!$task->pivot->is_completed)
                                                    <div class="mb-4">
                                                        <div class="d-flex justify-content-between mb-1">
                                                            <small class="text-muted">Progress</small>
                                                            <small
                                                                class="text-primary fw-semibold">{{ $task->progress ?? '0' }}%</small>
                                                        </div>
                                                        <div class="progress" style="height: 6px;">
                                                            <div class="progress-bar bg-primary" role="progressbar"
                                                                style="width: {{ $task->progress ?? '0' }}%"></div>
                                                        </div>
                                                    </div>
                                                @endif --}}

                                                {{-- Action Buttons --}}
                                                <div class="d-flex gap-2">
                                                    <form action="{{ route('my-tasks.update', $task->id) }}" method="POST"
                                                        class="flex-grow-1">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit"
                                                            class="btn {{ $task->pivot->is_completed ? 'btn-outline-secondary' : 'btn-primary' }} w-100">
                                                            <i
                                                                class="fas {{ $task->pivot->is_completed ? 'fa-undo' : 'fa-check' }} me-1"></i>
                                                            {{ $task->pivot->is_completed ? 'Batalkan Selesai' : 'Tandai Selesai' }}
                                                        </button>
                                                    </form>
                                                    <a href="#" class="btn btn-outline-primary" data-bs-toggle="modal"
                                                        data-bs-target="#detailModal{{ $task->id }}">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Detail Modal --}}
                                    <div class="modal fade" id="detailModal{{ $task->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">{{ $task->judul_tugas }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p><strong>Deskripsi:</strong></p>
                                                    <p class="text-muted">{{ $task->deskripsi }}</p>
                                                    <hr>
                                                    <p><strong>Deadline:</strong>
                                                        {{ date('d M Y H:i', strtotime($task->deadline)) }}</p>
                                                    <p><strong>Status:</strong>
                                                        <span
                                                            class="badge {{ $task->pivot->is_completed ? 'bg-success' : 'bg-warning' }}">
                                                            {{ $task->pivot->is_completed ? 'Selesai' : 'Dalam Progress' }}
                                                        </span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Available Tasks Section --}}
        <div class="row mb-5" id="available-tasks">
            <div class="col-12">
                <div class="card border-0 shadow-lg">
                    <div class="card-header bg-gradient-info py-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="mb-0 text-white fw-bold">
                                    <i class="fas fa-bolt me-2"></i>Tugas Baru Tersedia
                                </h4>
                                <p class="mb-0 text-white-50 mt-1">Tugas yang dapat Anda ambil dari admin</p>
                            </div>
                            <div class="text-white">
                                <span class="badge bg-white bg-opacity-25 text-white py-2 px-3">
                                    {{ $availableTasks->count() }} Tugas Tersedia
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        @if($availableTasks->isEmpty())
                            <div class="text-center py-5">
                                <div class="mb-4">
                                    <i class="fas fa-inbox fa-4x text-gray-300"></i>
                                </div>
                                <h4 class="text-gray-500 mb-2">Tidak ada tugas baru saat ini</h4>
                                <p class="text-muted">Admin belum menambahkan tugas baru. Silakan cek kembali nanti.</p>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover align-middle" id="availableTasksTable">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="ps-4" width="25%">
                                                <i class="fas fa-heading me-2"></i>Judul Tugas
                                            </th>
                                            <th width="35%">
                                                <i class="fas fa-align-left me-2"></i>Deskripsi
                                            </th>
                                            <th width="20%">
                                                <i class="fas fa-calendar me-2"></i>Deadline
                                            </th>
                                            <th class="text-center" width="20%">
                                                <i class="fas fa-cogs me-2"></i>Aksi
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($availableTasks as $task)
                                            <tr class="hover-shadow">
                                                <td class="ps-4">
                                                    <div class="d-flex align-items-center">
                                                        <div
                                                            class="avatar-sm bg-info bg-opacity-10 text-info rounded-circle d-flex align-items-center justify-content-center me-3">
                                                            <i class="fas fa-tasks"></i>
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-0 fw-semibold">{{ $task->judul_tugas }}</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <p class="mb-0 text-muted">{{ Str::limit($task->deskripsi, 100) }}</p>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <i class="fas fa-clock text-warning me-2"></i>
                                                        </div>
                                                        <div>
                                                            <div class="fw-semibold">{{ date('d M Y', strtotime($task->deadline)) }}
                                                            </div>
                                                            <small
                                                                class="text-muted">{{ \Carbon\Carbon::parse($task->deadline)->diffForHumans() }}</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <form action="{{ route('my-tasks.store') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="task_id" value="{{ $task->id }}">
                                                        <button type="submit" class="btn btn-primary btn-gradient px-4 shadow-sm">
                                                            <i class="fas fa-plus-circle me-2"></i>Ambil Tugas
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
        </div>

    </div>

    {{-- Custom CSS --}}
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --info-gradient: linear-gradient(135deg, #17ead9 0%, #6078ea 100%);
            --shadow-lg: 0 10px 25px rgba(0, 0, 0, 0.1);
            --shadow-hover: 0 15px 35px rgba(0, 0, 0, 0.15);
        }

        .bg-gradient-primary {
            background: var(--primary-gradient) !important;
        }

        .bg-gradient-info {
            background: var(--info-gradient) !important;
        }

        .bg-light-gradient {
            background: linear-gradient(180deg, #f8f9fa 0%, #ffffff 100%);
        }

        .text-gradient-primary {
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .task-card {
            border-radius: 12px;
            transition: all 0.3s ease;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .task-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-hover) !important;
            border-color: rgba(102, 126, 234, 0.2);
        }

        .hover-lift {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .hover-lift:hover {
            transform: translateY(-5px);
        }

        .hover-shadow:hover {
            box-shadow: var(--shadow-lg);
            transition: box-shadow 0.3s ease;
        }

        .btn-gradient {
            background: var(--primary-gradient);
            color: white;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .avatar-sm {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .progress {
            border-radius: 10px;
            overflow: hidden;
        }

        .progress-bar {
            border-radius: 10px;
        }

        #availableTasksTable thead th {
            border-bottom: 2px solid #e3e6f0;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
            color: #6c757d;
        }

        #availableTasksTable tbody tr {
            transition: all 0.3s ease;
        }

        #availableTasksTable tbody tr:hover {
            background-color: rgba(102, 126, 234, 0.05);
        }

        .badge {
            border-radius: 8px;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .task-card {
            animation: fadeIn 0.5s ease;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .card-header .d-flex {
                flex-direction: column;
                align-items: flex-start !important;
            }

            .card-header .badge {
                margin-top: 10px;
            }

            #availableTasksTable th,
            #availableTasksTable td {
                white-space: nowrap;
            }
        }
    </style>

    {{-- JavaScript for animations --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Add animation to task cards
            const taskCards = document.querySelectorAll('.task-card');
            taskCards.forEach((card, index) => {
                card.style.animationDelay = `${index * 0.1}s`;
            });

            // Add hover effect to table rows
            const tableRows = document.querySelectorAll('#availableTasksTable tbody tr');
            tableRows.forEach(row => {
                row.addEventListener('mouseenter', function () {
                    this.style.transform = 'translateX(5px)';
                });

                row.addEventListener('mouseleave', function () {
                    this.style.transform = 'translateX(0)';
                });
            });

            // Smooth scroll to available tasks
            const scrollLinks = document.querySelectorAll('a[href="#available-tasks"]');
            scrollLinks.forEach(link => {
                link.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });
        });
    </script>
@endsection