@extends('layouts.master')

@section('title', 'Daftar Tugas - WeMaTuK')

@section('content')
    <style>
        /* ===================== */
        /* DAFTAR TUGAS STYLES   */
        /* ===================== */

        body {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            min-height: 100vh;
        }

        .tugas-container {
            padding: 2rem 0;
        }

        /* Animation */
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

        /* Header */
        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
            margin-bottom: 2rem;
        }

        .tugas-title {
            font-size: 2.2rem;
            font-weight: 800;
            color: #1a202c;
            margin: 0;
            background: linear-gradient(135deg, #1a202c 0%, #4a5568 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        /* Buttons */
        .btn-custom {
            padding: 0.7rem 1.4rem;
            border-radius: 14px;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
            border: none;
            font-size: 0.95rem;
        }

        .btn-add {
            background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
            color: white;
            box-shadow: 0 6px 20px rgba(13, 110, 253, 0.3);
        }

        .btn-add:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(13, 110, 253, 0.4);
            color: white;
        }

        .btn-print {
            background: white;
            color: #4a5568;
            border: 2px solid #e2e8f0;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .btn-print:hover {
            border-color: #cbd5e0;
            background: #f8f9fa;
            color: #2d3748;
            transform: translateY(-2px);
        }

        /* Search */
        .search-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 1.5rem;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            margin-bottom: 2.5rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .search-wrapper {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .search-input {
            flex: 1;
            padding: 1rem 1rem 1rem 3rem;
            border: 2px solid rgba(226, 232, 240, 0.8);
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.9) url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='18' height='18' fill='%236b7280' viewBox='0 0 16 16'%3E%3Cpath d='M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z'%3E%3C/path%3E%3C/svg%3E") no-repeat 15px center;
            transition: all 0.3s ease;
            font-size: 1rem;
        }

        .search-input:focus {
            outline: none;
            border-color: #0d6efd;
            box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.15);
            background-color: white;
        }

        /* Grid Layout */
        .tasks-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(360px, 1fr));
            gap: 2rem;
        }

        /* Task Card with Full Color Background */
        .task-card {
            border-radius: 24px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            transition: all 0.4s ease;
            display: flex;
            flex-direction: column;
            height: 100%;
            position: relative;
            overflow: hidden;
            border: none;
            color: white;
        }

        .task-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: rgba(255, 255, 255, 0.3);
        }

        .task-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.25);
        }

        /* Dynamic Color Variations with Full Background */
        .color-1 {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        }

        .color-2 {
            background: linear-gradient(135deg, #10b981 0%, #047857 100%);
        }

        .color-3 {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        }

        .color-4 {
            background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
        }

        .color-5 {
            background: linear-gradient(135deg, #ec4899 0%, #db2777 100%);
        }

        .color-6 {
            background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
        }

        .task-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 1.25rem;
        }

        .task-title-text {
            font-size: 1.35rem;
            font-weight: 800;
            line-height: 1.3;
            margin: 0;
            color: white;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .task-desc {
            font-size: 1rem;
            line-height: 1.6;
            margin-bottom: 1.75rem;
            flex-grow: 1;
            opacity: 0.95;
            color: rgba(255, 255, 255, 0.95);
        }

        .task-meta {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            padding: 1.25rem;
            border-radius: 16px;
            margin-bottom: 1.5rem;
            font-size: 0.95rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .meta-row {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: rgba(255, 255, 255, 0.95);
            margin-bottom: 0.75rem;
        }

        .meta-row:last-child {
            margin-bottom: 0;
        }

        /* Badges */
        .badge-deadline {
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .bg-urgent {
            background: rgba(239, 68, 68, 0.9);
            color: white;
        }

        .bg-normal {
            background: rgba(255, 255, 255, 0.25);
            color: white;
        }

        /* Actions */
        .task-footer {
            padding-top: 1.25rem;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            display: flex;
            justify-content: flex-end;
            gap: 0.75rem;
        }

        .btn-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .btn-edit-task {
            background: rgba(255, 255, 255, 0.2);
            color: white;
        }

        .btn-edit-task:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: scale(1.1);
            box-shadow: 0 4px 15px rgba(255, 255, 255, 0.2);
        }

        .btn-delete-task {
            background: rgba(239, 68, 68, 0.2);
            color: white;
        }

        .btn-delete-task:hover {
            background: rgba(239, 68, 68, 0.3);
            transform: scale(1.1);
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
        }

        /* Download Link */
        .download-link {
            color: white !important;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.1);
        }

        .download-link:hover {
            background: rgba(255, 255, 255, 0.2);
            color: white !important;
            transform: translateY(-2px);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 5rem 2rem;
            grid-column: 1 / -1;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 24px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        .empty-state img {
            width: 180px;
            opacity: 0.8;
            margin-bottom: 1.5rem;
        }

        /* Modal Styles */
        .modal-danger-header {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
            border-bottom: none;
            border-radius: 16px 16px 0 0;
        }

        .modal-content {
            border-radius: 16px;
            border: none;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }

        /* Pagination */
        .pagination-wrapper {
            margin-top: 3rem;
        }

        .pagination .page-link {
            border-radius: 12px;
            margin: 0 0.25rem;
            border: none;
            color: #4b5563;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .pagination .page-item.active .page-link {
            background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
            border-color: #0d6efd;
        }

        .pagination .page-link:hover {
            background: #e5e7eb;
            transform: translateY(-2px);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .tasks-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }

            .header-content {
                flex-direction: column;
                text-align: center;
            }

            .search-wrapper {
                flex-direction: column;
            }

            .task-card {
                padding: 1.5rem;
            }

            .btn-custom {
                width: 100%;
                justify-content: center;
            }
        }

        @media (max-width: 480px) {
            .tugas-container {
                padding: 1rem 0;
            }

            .tugas-title {
                font-size: 1.8rem;
            }

            .task-card {
                padding: 1.25rem;
            }
        }
    </style>

    <div class="tugas-container">
        <div class="container">

            <!-- Header Section -->
            <div class="header-content fade-in-up" style="animation-delay: 0.1s;">
                <div>
                    <h1 class="tugas-title">Daftar Tugas</h1>
                    <p class="text-muted mb-0">Kelola dan pantau tugas kuliah Anda dengan mudah.</p>
                </div>

                <div class="d-flex gap-2 flex-wrap">
                    <a href="{{ route('laporan.cetak') }}" class="btn-custom btn-print" target="_blank">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                            viewBox="0 0 16 16">
                            <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z" />
                            <path
                                d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1z" />
                        </svg>
                        Cetak
                    </a>

                    @if(Auth::user()->role == 'admin')
                        <a href="{{ route('tugas.create') }}" class="btn-custom btn-add">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                viewBox="0 0 16 16">
                                <path
                                    d="M8 0a1 1 0 0 1 1 1v6h6a1 1 0 0 1 0 2H9v6a1 1 0 0 1-2 0V9H1a1 1 0 0 1 0-2h6V1a1 1 0 0 1 1-1z" />
                            </svg>
                            Tambah Tugas
                        </a>
                    @endif
                </div>
            </div>

            <!-- Search Section -->
            <div class="search-card fade-in-up" style="animation-delay: 0.2s;">
                <form action="{{ route('tugas.cari') }}" method="GET">
                    <div class="search-wrapper">
                        <input type="search" name="cari" class="search-input"
                            placeholder="Cari berdasarkan judul atau deskripsi..." value="{{ request('cari') }}">
                        <button type="submit" class="btn-custom btn-add">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="me-1"
                                viewBox="0 0 16 16">
                                <path
                                    d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                            </svg>
                            Cari
                        </button>
                    </div>
                </form>
            </div>

            <!-- Tasks Grid -->
            <div class="tasks-grid fade-in-up" style="animation-delay: 0.3s;">
                @forelse($tugas as $index => $t)
                    @php
                        // Color cycling logic (1-6)
                        $colorIndex = ($index % 6) + 1;

                        // Deadline logic
                        $deadline = \Carbon\Carbon::parse($t->deadline);
                        $isUrgent = $deadline->isPast() || $deadline->diffInDays(now()) < 3;
                    @endphp

                    <div class="task-card color-{{ $colorIndex }}">
                        <div class="task-header">
                            <h3 class="task-title-text">{{ $t->judul }}</h3>
                            <span class="badge-deadline {{ $isUrgent ? 'bg-urgent' : 'bg-normal' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="me-1"
                                    viewBox="0 0 16 16">
                                    <path
                                        d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z" />
                                    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z" />
                                </svg>
                                {{ $deadline->diffForHumans() }}
                            </span>
                        </div>

                        <div class="task-desc">
                            {{ Str::limit($t->deskripsi, 120, '...') ?: 'Tidak ada deskripsi tambahan.' }}
                        </div>

                        <div class="task-meta">
                            <div class="meta-row">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                                    viewBox="0 0 16 16">
                                    <path
                                        d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z" />
                                </svg>
                                <span>{{ $deadline->format('d M Y, H:i') }} WIB</span>
                            </div>

                            <div class="meta-row mt-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                                    viewBox="0 0 16 16">
                                    <path
                                        d="M4.5 3a2.5 2.5 0 0 1 5 0v9a1.5 1.5 0 0 1-3 0V5a.5.5 0 0 1 1 0v7a.5.5 0 0 0 1 0V3a1.5 1.5 0 1 0-3 0v9a2.5 2.5 0 0 0 5 0V5a.5.5 0 0 1 1 0v7a3.5 3.5 0 1 1-7 0z" />
                                </svg>
                                @if($t->file_path)
                                    <a href="{{ route('tugas.download', $t->id) }}" class="download-link">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                            class="me-1" viewBox="0 0 16 16">
                                            <path
                                                d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
                                            <path
                                                d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z" />
                                        </svg>
                                        Download File
                                    </a>
                                @else
                                    <span class="text-white-50 fst-italic">Tidak ada file</span>
                                @endif
                            </div>
                        </div>

                        @if(Auth::user()->role == 'admin')
                            <div class="task-footer">
                                <a href="{{ route('tugas.edit', $t->id) }}" class="btn-icon btn-edit-task" title="Edit Tugas">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                                        viewBox="0 0 16 16">
                                        <path
                                            d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z" />
                                    </svg>
                                </a>
                                <button type="button" class="btn-icon btn-delete-task" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal{{ $t->id }}" title="Hapus Tugas">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                                        viewBox="0 0 16 16">
                                        <path
                                            d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z" />
                                        <path
                                            d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z" />
                                    </svg>
                                </button>
                            </div>

                            <!-- Delete Modal -->
                            <div class="modal fade" id="deleteModal{{ $t->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 shadow">
                                        <div class="modal-header modal-danger-header">
                                            <h5 class="modal-title fw-bold">Hapus Tugas?</h5>
                                            <button type="button" class="btn-close btn-close-white"
                                                data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body text-center py-4">
                                            <p class="mb-1">Anda yakin ingin memindahkan tugas ini ke sampah?</p>
                                            <h5 class="fw-bold text-dark">{{ $t->judul }}</h5>
                                        </div>
                                        <div class="modal-footer justify-content-center border-0 pb-4">
                                            <button type="button" class="btn btn-light border px-4"
                                                data-bs-dismiss="modal">Batal</button>
                                            <form action="{{ route('tugas.destroy', $t->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger px-4">Ya, Hapus</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="empty-state">
                        <img src="https://cdni.iconscout.com/illustration/premium/thumb/folder-is-empty-illustration-download-in-svg-png-gif-file-formats--no-data-nothing-here-err-user-interface-pack-design-development-illustrations-4330693.png"
                            alt="Empty" style="width: 180px; opacity: 0.7;">
                        <h3 class="mt-3 fw-bold text-secondary">Belum Ada Tugas</h3>
                        <p class="text-muted">Ayo mulai produktif! Tambahkan tugas pertamamu sekarang.</p>
                        @if(Auth::user()->role == 'admin')
                            <a href="{{ route('tugas.create') }}" class="btn btn-primary mt-2 px-4 py-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="me-2"
                                    viewBox="0 0 16 16">
                                    <path
                                        d="M8 0a1 1 0 0 1 1 1v6h6a1 1 0 0 1 0 2H9v6a1 1 0 0 1-2 0V9H1a1 1 0 0 1 0-2h6V1a1 1 0 0 1 1-1z" />
                                </svg>
                                Buat Tugas Baru
                            </a>
                        @endif
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($tugas->hasPages())
                <div class="pagination-wrapper fade-in-up" style="animation-delay: 0.4s;">
                    {{ $tugas->links() }}
                </div>
            @endif

        </div>
    </div>
@endsection