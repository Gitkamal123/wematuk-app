@extends('layouts.master')

@section('content')
    {{-- Memuat SweetAlert2 (CDN) untuk Notifikasi Cantik --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="container-fluid px-lg-4 px-xl-5">

        {{-- 1. HEADER SECTION --}}
        <div class="d-flex justify-content-between align-items-center mb-4 mt-3">
            <a href="{{ route('home') }}" class="btn btn-white-blue shadow-sm rounded-pill px-4">
                <i class="fas fa-arrow-left me-2"></i> Dashboard
            </a>
            <div class="text-end d-none d-md-block">
                <small class="text-muted">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</small>
            </div>
        </div>

        <div class="row align-items-center mb-5">
            <div class="col-md-7">
                <h1 class="h2 fw-bold text-gradient-primary mb-2">Manajemen Tugas Saya</h1>
                <p class="text-muted mb-0">
                    Pantau progress, deadline, dan riwayat tugas Anda di sini.
                </p>
            </div>
            {{-- Statistik Ringkas --}}
            <div class="col-md-5 mt-3 mt-md-0 d-flex justify-content-md-end gap-3">
                <div class="card border-0 shadow-sm px-3 py-2 text-center" style="min-width: 100px;">
                    <small class="text-muted d-block fw-bold" style="font-size: 0.7rem;">BERJALAN</small>
                    <span
                        class="h4 fw-bold text-primary mb-0">{{ $myTasks->where('pivot.is_completed', false)->count() }}</span>
                </div>
                <div class="card border-0 shadow-sm px-3 py-2 text-center" style="min-width: 100px;">
                    <small class="text-muted d-block fw-bold" style="font-size: 0.7rem;">SELESAI</small>
                    <span
                        class="h4 fw-bold text-success mb-0">{{ $myTasks->where('pivot.is_completed', true)->count() }}</span>
                </div>
            </div>
        </div>

        {{-- 2. TABS NAVIGASI (UI/UX Improvement) --}}
        <ul class="nav nav-pills mb-4 gap-2" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active rounded-pill px-4" id="pills-ongoing-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-ongoing" type="button" role="tab">
                    <i class="fas fa-spinner me-2"></i> Tugas Berjalan
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link rounded-pill px-4" id="pills-history-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-history" type="button" role="tab">
                    <i class="fas fa-history me-2"></i> Riwayat Selesai
                </button>
            </li>
            <li class="nav-item ms-auto" role="presentation">
                <button class="nav-link btn-outline-dashed px-4"
                    onclick="document.getElementById('available-tasks').scrollIntoView({behavior: 'smooth'})">
                    <i class="fas fa-plus me-2"></i> Ambil Baru
                </button>
            </li>
        </ul>

        {{-- 3. CONTENT TABS --}}
        <div class="tab-content mb-5" id="pills-tabContent">

            {{-- TAB 1: TUGAS BERJALAN (Card View) --}}
            <div class="tab-pane fade show active" id="pills-ongoing" role="tabpanel">
                @php
                    $ongoingTasks = $myTasks->where('pivot.is_completed', false);
                @endphp

                @if($ongoingTasks->isEmpty())
                    <div class="text-center py-5 card border-0 shadow-sm">
                        <div class="mb-3">
                            <i class="fas fa-mug-hot fa-3x text-gray-300"></i>
                        </div>
                        <h5 class="text-gray-500">Tidak ada tugas yang sedang berjalan.</h5>
                        <p class="text-muted">Santai sejenak atau ambil tugas baru di bawah.</p>
                    </div>
                @else
                    <div class="row g-4">
                        @foreach($ongoingTasks as $task)
                            @php
                                // --- LOGIKA DEADLINE ---
                                $deadline = \Carbon\Carbon::parse($task->deadline);
                                $now = \Carbon\Carbon::now();
                                $diff = $now->diffInDays($deadline, false); // false agar bisa negatif

                                if ($diff < 0) {
                                    // Lewat Deadline
                                    $statusColor = 'danger'; // Merah
                                    $statusText = 'Lewat Deadline';
                                    $icon = 'fa-exclamation-triangle';
                                    $borderClass = 'border-danger';
                                } elseif ($diff <= 3) {
                                    // Mendekati (0-3 hari)
                                    $statusColor = 'warning'; // Kuning/Oranye
                                    $statusText = 'Mendekati Deadline';
                                    $icon = 'fa-hourglass-half';
                                    $borderClass = 'border-warning';
                                } else {
                                    // Masih Lama (> 3 hari)
                                    $statusColor = 'success'; // Hijau
                                    $statusText = 'Aktif';
                                    $icon = 'fa-check-circle';
                                    $borderClass = 'border-success-subtle'; // Border halus
                                }
                            @endphp

                            <div class="col-xl-4 col-lg-6">
                                <div class="card border-0 shadow-sm h-100 task-card hover-lift {{ $borderClass }}"
                                    style="border-left: 5px solid !important;">
                                    <div class="card-body p-4 d-flex flex-column">

                                        {{-- Header Kartu --}}
                                        <div class="d-flex justify-content-between align-items-start mb-3">
                                            <span
                                                class="badge bg-{{ $statusColor }} bg-opacity-10 text-{{ $statusColor }} py-2 px-3 rounded-pill fw-bold">
                                                <i class="fas {{ $icon }} me-1"></i> {{ $statusText }}
                                            </span>

                                            {{-- Dropdown Menu --}}
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-light rounded-circle" type="button"
                                                    data-bs-toggle="dropdown">
                                                    <i class="fas fa-ellipsis-v text-muted"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                                                    <li>
                                                        <form action="{{ route('my-tasks.destroy', $task->id) }}" method="POST"
                                                            class="delete-form">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button" class="dropdown-item text-danger btn-delete-task">
                                                                <i class="fas fa-trash me-2"></i>Lepas Tugas
                                                            </button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                        {{-- Isi Kartu --}}
                                        <h5 class="fw-bold text-dark mb-2">{{ $task->judul_tugas }}</h5>
                                        <p class="text-muted mb-4 flex-grow-1">
                                            {{ Str::limit($task->deskripsi, 90) }}
                                        </p>

                                        {{-- Info Bawah --}}
                                        <div class="d-flex align-items-center mb-4 bg-light rounded p-2">
                                            <div class="flex-shrink-0 bg-white p-2 rounded shadow-sm">
                                                <i class="fas fa-calendar-alt text-{{ $statusColor }}"></i>
                                            </div>
                                            <div class="ms-3">
                                                <small class="text-muted d-block" style="font-size: 0.75rem;">Batas Waktu</small>
                                                <span class="fw-bold text-dark" style="font-size: 0.9rem;">
                                                    {{ $deadline->translatedFormat('d F Y, H:i') }}
                                                </span>
                                            </div>
                                        </div>

                                        {{-- Tombol Aksi --}}
                                        <div class="d-flex gap-2 mt-auto">
                                            <form action="{{ route('my-tasks.update', $task->id) }}" method="POST"
                                                class="flex-grow-1 confirm-finish-form">
                                                @csrf
                                                @method('PATCH')
                                                <button type="button" class="btn btn-primary w-100 btn-finish-task">
                                                    <i class="fas fa-check me-2"></i> Tandai Selesai
                                                </button>
                                            </form>
                                            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                                                data-bs-target="#detailModal{{ $task->id }}">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Modal Detail (Sama seperti sebelumnya) --}}
                            @include('student.partials.detail_modal', ['task' => $task])
                            {{-- *Catatan: Jika error, copy paste kode modal manual ke sini di dalam loop* --}}

                            {{-- Manual Modal Code (Jaga-jaga) --}}
                            <div class="modal fade" id="detailModal{{ $task->id }}" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 shadow">
                                        <div class="modal-header bg-light">
                                            <h5 class="modal-title fw-bold">{{ $task->judul_tugas }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <h6 class="fw-bold text-primary">Deskripsi Lengkap</h6>
                                            <p class="text-muted bg-light p-3 rounded">{{ $task->deskripsi }}</p>

                                            <div class="row mt-4">
                                                <div class="col-6">
                                                    <small class="text-muted d-block">Deadline</small>
                                                    <span class="fw-bold">{{ $deadline->translatedFormat('l, d F Y') }}</span>
                                                </div>
                                                <div class="col-6 text-end">
                                                    <small class="text-muted d-block">Sisa Waktu</small>
                                                    <span
                                                        class="badge bg-{{ $statusColor }}">{{ $deadline->diffForHumans() }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        @endforeach
                    </div>
                @endif
            </div>

            {{-- TAB 2: RIWAYAT SELESAI (Table View) --}}
            <div class="tab-pane fade" id="pills-history" role="tabpanel">
                @php
                    $completedTasks = $myTasks->where('pivot.is_completed', true);
                @endphp

                <div class="card border-0 shadow-sm overflow-hidden">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold text-success"><i class="fas fa-check-double me-2"></i> Tugas Telah
                            Diselesaikan</h5>
                    </div>
                    <div class="card-body p-0">
                        @if($completedTasks->isEmpty())
                            <div class="text-center py-5">
                                <p class="text-muted mb-0">Belum ada tugas yang diselesaikan.</p>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="ps-4">Judul Tugas</th>
                                            <th>Deadline Awal</th>
                                            <th>Tanggal Selesai</th>
                                            <th>Status</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($completedTasks as $task)
                                            <tr>
                                                <td class="ps-4 fw-semibold">{{ $task->judul_tugas }}</td>
                                                <td class="text-muted small">
                                                    {{ \Carbon\Carbon::parse($task->deadline)->format('d M Y') }}</td>
                                                <td class="text-primary small">
                                                    <i class="fas fa-calendar-check me-1"></i>
                                                    {{ $task->pivot->updated_at->format('d M Y, H:i') }}
                                                </td>
                                                <td>
                                                    <span class="badge bg-success bg-opacity-10 text-success rounded-pill">
                                                        Selesai
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    {{-- Tombol Hapus History --}}
                                                    <form action="{{ route('my-tasks.destroy', $task->id) }}" method="POST"
                                                        class="d-inline delete-history-form">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button"
                                                            class="btn btn-sm btn-outline-danger btn-delete-history"
                                                            title="Hapus dari Riwayat">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                    {{-- Tombol Batal Selesai (Opsional) --}}
                                                    <form action="{{ route('my-tasks.update', $task->id) }}" method="POST"
                                                        class="d-inline ms-1">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-sm btn-outline-secondary"
                                                            title="Kembalikan ke Aktif">
                                                            <i class="fas fa-undo"></i>
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

        {{-- 4. AVAILABLE TASKS SECTION (Tetap Ada di Bawah) --}}
        <div class="row mb-5" id="available-tasks">
            <div class="col-12">
                <div class="card border-0 shadow-lg">
                    <div class="card-header bg-gradient-blue-white py-4 d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0 text-primary fw-bold"><i class="fas fa-bolt me-2"></i>Tugas Baru Tersedia</h4>
                            <p class="mb-0 text-muted mt-1 small">Daftar tugas dari admin yang belum diambil.</p>
                        </div>
                        <span class="badge bg-primary rounded-pill px-3">{{ $availableTasks->count() }} Tersedia</span>
                    </div>

                    <div class="card-body p-0">
                        @if($availableTasks->isEmpty())
                            <div class="text-center py-5">
                                <div class="mb-3 text-gray-300"><i class="fas fa-inbox fa-3x"></i></div>
                                <h6 class="text-muted">Tidak ada tugas baru saat ini.</h6>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0" id="availableTasksTable">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="ps-4">Judul Tugas</th>
                                            <th>Deskripsi</th>
                                            <th>Deadline</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($availableTasks as $task)
                                            <tr class="hover-lift-row">
                                                <td class="ps-4 fw-bold text-dark">{{ $task->judul_tugas }}</td>
                                                <td class="text-muted text-truncate" style="max-width: 250px;">
                                                    {{ Str::limit($task->deskripsi, 60) }}</td>
                                                <td>
                                                    <span class="badge bg-light text-dark border">
                                                        <i class="far fa-calendar me-1"></i>
                                                        {{ date('d M Y', strtotime($task->deadline)) }}
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <form action="{{ route('my-tasks.store') }}" method="POST"
                                                        class="take-task-form">
                                                        @csrf
                                                        <input type="hidden" name="task_id" value="{{ $task->id }}">
                                                        <button type="button"
                                                            class="btn btn-sm btn-primary px-3 rounded-pill btn-take-task">
                                                            <i class="fas fa-plus me-1"></i> Ambil
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
            --blue-white-gradient: linear-gradient(135deg, #f0f9ff 0%, #ffffff 100%);
        }

        /* Nav Pills Styling */
        .nav-pills .nav-link {
            color: #64748b;
            font-weight: 600;
            background: #fff;
            border: 1px solid #e2e8f0;
            transition: all 0.3s;
        }

        .nav-pills .nav-link.active {
            background: var(--primary-gradient);
            color: white;
            border: none;
            box-shadow: 0 4px 10px rgba(102, 126, 234, 0.3);
        }

        .btn-outline-dashed {
            border: 2px dashed #cbd5e1;
            color: #64748b;
            font-weight: 600;
        }

        .btn-outline-dashed:hover {
            border-color: #667eea;
            color: #667eea;
            background: #f8fafc;
        }

        /* Text Gradients */
        .text-gradient-primary {
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .bg-gradient-blue-white {
            background: var(--blue-white-gradient) !important;
            border-bottom: 1px solid #e2e8f0;
        }

        /* Buttons */
        .btn-white-blue {
            background: white;
            color: #4f46e5;
            border: 1px solid #e0e7ff;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-white-blue:hover {
            transform: translateX(-3px);
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.1);
            border-color: #4f46e5;
        }

        /* Cards & Hover Effects */
        .task-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .hover-lift:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1) !important;
        }

        .hover-lift-row:hover {
            background-color: #f8fafc;
        }

        /* Status Borders */
        .border-success-subtle {
            border-color: #86efac !important;
        }

        .border-warning {
            border-color: #fca5a5 !important;
        }

        /* Sedikit merah muda untuk warning agar beda */
        .border-danger {
            border-color: #ef4444 !important;
        }

        /* Smooth Scroll */
        html {
            scroll-behavior: smooth;
        }
    </style>

    {{-- JAVASCRIPT LOGIC & NOTIFICATIONS --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            // 1. Cek Flash Message dari Laravel (Server Side)
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

            // 2. Konfirmasi Tandai Selesai (Button Click)
            document.querySelectorAll('.btn-finish-task').forEach(button => {
                button.addEventListener('click', function () {
                    const form = this.closest('.confirm-finish-form');

                    Swal.fire({
                        title: 'Tandai Selesai?',
                        text: "Tugas akan dipindahkan ke tab Riwayat Selesai.",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#10b981', // Hijau
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Ya, Selesai!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });

            // 3. Konfirmasi Lepas Tugas (Ongoing)
            document.querySelectorAll('.btn-delete-task').forEach(button => {
                button.addEventListener('click', function () {
                    const form = this.closest('.delete-form');

                    Swal.fire({
                        title: 'Lepas Tugas ini?',
                        text: "Anda harus mengambilnya lagi jika ingin mengerjakannya.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#ef4444',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Ya, Lepas!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });

            // 4. Konfirmasi Hapus History (Completed)
            document.querySelectorAll('.btn-delete-history').forEach(button => {
                button.addEventListener('click', function () {
                    const form = this.closest('.delete-history-form');

                    Swal.fire({
                        title: 'Hapus Riwayat?',
                        text: "Data tugas ini akan dihapus permanen dari riwayat Anda.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, Hapus Permanen!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });

            // 5. Konfirmasi Ambil Tugas Baru
            document.querySelectorAll('.btn-take-task').forEach(button => {
                button.addEventListener('click', function () {
                    const form = this.closest('.take-task-form');
                    // Langsung submit atau bisa tambah konfirmasi ringan
                    // Kita buat efek loading biar keren
                    let btn = this;
                    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
                    btn.disabled = true;
                    setTimeout(() => {
                        form.submit();
                    }, 500); // Simulasi delay dikit
                });
            });

        });
    </script>
@endsection