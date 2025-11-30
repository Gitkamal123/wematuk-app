@extends('layouts.master')

@section('title', 'Daftar Tugas - WeMaTuK')

@section('content')
    <style>
        /* ===================== */
        /* STYLING HALAMAN TUGAS */
        /* ===================== */
        body {
            background: #f8f9fa;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .tugas-container {
            padding: 2rem 0;
        }

        /* Animasi Masuk */
        .fade-in-up {
            animation: fadeInUp 0.6s ease forwards;
            opacity: 0;
            transform: translateY(20px);
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Header & Title */
        .tugas-title {
            font-size: 2rem;
            font-weight: 800;
            color: #1a202c;
            margin: 0;
            background: linear-gradient(135deg, #1a202c 0%, #2d3748 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Card Style (Search & Filter) */
        .control-card {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(0, 0, 0, 0.05);
            margin-bottom: 2rem;
        }

        .form-control-custom,
        .form-select-custom {
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            padding: 0.6rem 1rem;
            transition: 0.3s;
        }

        .form-control-custom:focus,
        .form-select-custom:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        /* Grid Layout Tasks */
        .tasks-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 1.5rem;
        }

        /* Task Card Styling */
        .task-card {
            background: white;
            border-radius: 20px;
            padding: 1.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.02);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border-top: 5px solid;
            display: flex;
            flex-direction: column;
            height: 100%;
            position: relative;
            overflow: hidden;
        }

        .task-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        /* Warna Warni Kartu */
        .color-1 {
            border-color: #3b82f6;
            background: linear-gradient(to bottom right, #ffffff, #eff6ff);
        }

        .color-2 {
            border-color: #10b981;
            background: linear-gradient(to bottom right, #ffffff, #ecfdf5);
        }

        .color-3 {
            border-color: #f59e0b;
            background: linear-gradient(to bottom right, #ffffff, #fffbeb);
        }

        .color-4 {
            border-color: #8b5cf6;
            background: linear-gradient(to bottom right, #ffffff, #f5f3ff);
        }

        .color-5 {
            border-color: #ec4899;
            background: linear-gradient(to bottom right, #ffffff, #fdf2f8);
        }

        .color-6 {
            border-color: #06b6d4;
            background: linear-gradient(to bottom right, #ffffff, #ecfeff);
        }

        .task-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 1rem;
        }

        .task-title-text {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1f2937;
            line-height: 1.4;
            margin: 0;
        }

        .task-desc {
            color: #6b7280;
            font-size: 0.9rem;
            line-height: 1.6;
            margin-bottom: 1.5rem;
            flex-grow: 1;
        }

        /* Metadata Box */
        .task-meta {
            background: rgba(255, 255, 255, 0.6);
            padding: 0.75rem;
            border-radius: 12px;
            margin-bottom: 1rem;
            font-size: 0.85rem;
        }

        .meta-row {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #4b5563;
            margin-bottom: 0.5rem;
        }

        /* Badges */
        .badge-deadline {
            padding: 0.35rem 0.75rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .bg-urgent {
            background: #fee2e2;
            color: #ef4444;
            border: 1px solid #fecaca;
        }

        .bg-soon {
            background: #ffedd5;
            color: #c2410c;
            border: 1px solid #fed7aa;
        }

        .bg-normal {
            background: #dcfce7;
            color: #15803d;
            border: 1px solid #bbf7d0;
        }

        /* Footer Actions */
        .task-footer {
            padding-top: 1rem;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .btn-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-edit-task {
            background: #eff6ff;
            color: #3b82f6;
        }

        .btn-edit-task:hover {
            background: #3b82f6;
            color: white;
        }

        .btn-delete-task {
            background: #fef2f2;
            color: #ef4444;
        }

        .btn-delete-task:hover {
            background: #ef4444;
            color: white;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 4rem 1rem;
            grid-column: 1 / -1;
            background: white;
            border-radius: 20px;
        }

        /* Pagination Customization */
        .pagination {
            justify-content: center;
            gap: 0.5rem;
        }

        .page-link {
            border-radius: 8px;
            border: none;
            color: #4b5563;
            font-weight: 600;
            padding: 0.5rem 1rem;
        }

        .page-item.active .page-link {
            background: #3b82f6;
            color: white;
        }
    </style>

    <div class="tugas-container">
        <div class="container">

            <div class="d-flex justify-content-between align-items-center mb-4 fade-in-up" style="animation-delay: 0.1s;">
                <div>
                    <h1 class="tugas-title">Daftar Tugas</h1>
                    <p class="text-muted mb-0">Kelola tugas kuliah Anda dengan lebih rapi.</p>
                </div>

                <div class="d-flex gap-2">
                    <a href="{{ route('laporan.cetak') }}" class="btn btn-light border" target="_blank">
                        <i class="bi bi-printer me-2"></i> Cetak
                    </a>

                    @if(Auth::user()->role == 'admin')
                        <a href="{{ route('tugas.create') }}" class="btn btn-primary"
                            style="background: linear-gradient(135deg, #0d6efd, #0a58ca); border: none;">
                            <i class="bi bi-plus-lg me-2"></i> Tambah Tugas
                        </a>
                    @endif
                </div>
            </div>

            <div class="control-card fade-in-up" style="animation-delay: 0.2s;">
                <div class="row g-3">
                    <div class="col-md-6">
                        <form action="{{ route('tugas.cari') }}" method="GET">
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#a0aec0"
                                        viewBox="0 0 16 16">
                                        <path
                                            d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                                    </svg>
                                </span>
                                <input type="search" name="cari" class="form-control form-control-custom border-start-0"
                                    id="searchInput" placeholder="Cari judul tugas..." value="{{ request('cari') }}">
                                <button type="submit" class="btn btn-primary">Cari</button>
                            </div>
                        </form>
                    </div>

                    <div class="col-md-3">
                        <select class="form-select form-select-custom" id="statusFilter">
                            <option value="">Semua Status</option>
                            <option value="terlambat">Terlambat</option>
                            <option value="segera">Segera</option>
                            <option value="aktif">Aktif</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select form-select-custom" id="sortBy">
                            <option value="deadline_asc">Deadline Terdekat</option>
                            <option value="deadline_desc">Deadline Terjauh</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="tasks-grid fade-in-up" id="tasksGrid" style="animation-delay: 0.3s;">
                @forelse($tugas as $index => $t)
                    @php
                        $colorIndex = ($index % 6) + 1;
                        $deadline = \Carbon\Carbon::parse($t->deadline);
                        $now = \Carbon\Carbon::now();
                        $diffInDays = $now->diffInDays($deadline, false);

                        if ($deadline->isPast()) {
                            $badgeClass = 'bg-urgent';
                            $statusText = 'Terlambat';
                        } elseif ($diffInDays <= 3) {
                            $badgeClass = 'bg-soon';
                            $statusText = 'Segera';
                        } else {
                            $badgeClass = 'bg-normal';
                            $statusText = 'Aktif';
                        }
                    @endphp

                    <div class="task-card color-{{ $colorIndex }}" data-deadline="{{ $deadline->timestamp }}"
                        data-status="{{ strtolower($statusText) }}">

                        <div class="task-header">
                            <h3 class="task-title-text">{{ $t->judul }}</h3>
                            <span class="badge-deadline {{ $badgeClass }}">
                                {{ $statusText }}
                            </span>
                        </div>

                        <div class="task-desc">
                            {{ Str::limit($t->deskripsi, 100, '...') ?: 'Tidak ada deskripsi tambahan.' }}
                        </div>

                        <div class="task-meta">
                            <div class="meta-row">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    viewBox="0 0 16 16">
                                    <path
                                        d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z" />
                                </svg>
                                {{ $deadline->format('d M Y, H:i') }}
                            </div>
                            <div class="meta-row">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    viewBox="0 0 16 16">
                                    <path
                                        d="M4.5 3a2.5 2.5 0 0 1 5 0v9a1.5 1.5 0 0 1-3 0V5a.5.5 0 0 1 1 0v7a.5.5 0 0 0 1 0V3a1.5 1.5 0 1 0-3 0v9a2.5 2.5 0 0 0 5 0V5a.5.5 0 0 1 1 0v7a3.5 3.5 0 1 1-7 0z" />
                                </svg>
                                @if($t->file_path)
                                    <a href="{{ route('tugas.download', $t->id) }}"
                                        class="text-primary text-decoration-none fw-bold">
                                        Download File
                                    </a>
                                @else
                                    <span class="text-muted fst-italic">Tidak ada file</span>
                                @endif
                            </div>
                        </div>

                        @if(Auth::user()->role == 'admin')
                            <div class="task-footer">
                                <small class="text-muted">
                                    <i class="bi bi-clock"></i> {{ $deadline->diffForHumans() }}
                                </small>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('tugas.edit', $t->id) }}" class="btn-icon btn-edit-task" title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                            viewBox="0 0 16 16">
                                            <path
                                                d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z" />
                                        </svg>
                                    </a>
                                    <button type="button" class="btn-icon btn-delete-task" data-bs-toggle="modal"
                                        data-bs-target="#deleteModal{{ $t->id }}" title="Hapus">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                            viewBox="0 0 16 16">
                                            <path
                                                d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z" />
                                            <path
                                                d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="empty-state">
                        <img src="https://cdni.iconscout.com/illustration/premium/thumb/folder-is-empty-illustration-download-in-svg-png-gif-file-formats--no-data-nothing-here-err-user-interface-pack-design-development-illustrations-4330693.png"
                            alt="Empty" style="width: 150px; opacity: 0.7;">
                        <h3 class="mt-3 fw-bold text-secondary">Belum Ada Tugas</h3>
                        <p class="text-muted">Ayo mulai produktif! Tambahkan tugas pertamamu sekarang.</p>
                        @if(Auth::user()->role == 'admin')
                            <a href="{{ route('tugas.create') }}" class="btn btn-primary mt-2">Buat Tugas Baru</a>
                        @endif
                    </div>
                @endforelse
            </div>

            @if($tugas->hasPages())
                <div class="d-flex justify-content-center mt-5">
                    {{ $tugas->links() }}
                </div>
            @endif

        </div>
    </div>

    @foreach($tugas as $t)
        @if(Auth::user()->role == 'admin')
            <div class="modal fade" id="deleteModal{{ $t->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
                        <div class="modal-header border-0 text-white"
                            style="background: linear-gradient(135deg, #ef4444, #dc2626); border-radius: 16px 16px 0 0;">
                            <h5 class="modal-title fw-bold">Hapus Tugas?</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body text-center p-4">
                            <p class="mb-1">Anda yakin ingin memindahkan tugas ini ke sampah?</p>
                            <h5 class="fw-bold text-dark my-3">{{ $t->judul }}</h5>
                            <small class="text-muted">Data masih bisa dipulihkan dari menu Sampah.</small>
                        </div>
                        <div class="modal-footer justify-content-center border-0 pb-4">
                            <button type="button" class="btn btn-light border px-4" data-bs-dismiss="modal">Batal</button>
                            <form action="{{ route('tugas.destroy', $t->id) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger px-4">Ya, Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endforeach

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const statusFilter = document.getElementById('statusFilter');
            const sortBy = document.getElementById('sortBy');
            const tasksGrid = document.getElementById('tasksGrid');

            // Filter & Sort Logic
            function updateGrid() {
                const cards = Array.from(document.querySelectorAll('.task-card'));
                const statusValue = statusFilter.value;
                const sortValue = sortBy.value;

                // 1. Filtering
                cards.forEach(card => {
                    if (statusValue === '' || card.dataset.status === statusValue) {
                        // Tampilkan cardnya, bukan parent wrapper
                        card.parentElement.style.display = 'block';
                        card.style.display = 'flex';
                    } else {
                        card.style.display = 'none';
                    }
                });

                // 2. Sorting
                const visibleCards = cards.filter(card => card.style.display !== 'none');

                visibleCards.sort((a, b) => {
                    const dateA = parseInt(a.dataset.deadline);
                    const dateB = parseInt(b.dataset.deadline);

                    if (sortValue === 'deadline_asc') return dateA - dateB;
                    if (sortValue === 'deadline_desc') return dateB - dateA;
                    return 0;
                });

                // Re-append
                visibleCards.forEach(card => tasksGrid.appendChild(card));
            }

            if (statusFilter) statusFilter.addEventListener('change', updateGrid);
            if (sortBy) sortBy.addEventListener('change', updateGrid);
        });
    </script>
@endsection