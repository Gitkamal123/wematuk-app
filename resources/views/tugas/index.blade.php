@extends('layouts.master')

@section('title', 'Daftar Tugas - WeMaTuK')

@section('content')
    <style>
        /* ===================== */
        /* MODERN TASK STYLES */
        /* ===================== */
        body {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            min-height: 100vh;
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
            font-size: 2.5rem;
            font-weight: 800;
            color: #1a202c;
            margin: 0;
            background: linear-gradient(135deg, #1a202c 0%, #4a5568 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        /* Button Styles */
        .btn-modern {
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
            border: none;
        }

        .btn-primary-modern {
            background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(13, 110, 253, 0.3);
        }

        .btn-primary-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(13, 110, 253, 0.4);
            color: white;
        }

        .btn-light-modern {
            background: white;
            color: #4a5568;
            border: 2px solid #e2e8f0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .btn-light-modern:hover {
            border-color: #cbd5e0;
            background: #f8f9fa;
            color: #2d3748;
            transform: translateY(-1px);
        }

        /* Control Card */
        .control-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 1.5rem;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            margin-bottom: 2rem;
        }

        .form-control-custom,
        .form-select-custom {
            border: 2px solid rgba(226, 232, 240, 0.8);
            border-radius: 12px;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.9);
        }

        .form-control-custom:focus,
        .form-select-custom:focus {
            border-color: #0d6efd;
            background: white;
            box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.15);
            outline: none;
        }

        /* Search Input Group */
        .search-input-group {
            position: relative;
        }

        .search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #6b7280;
            z-index: 3;
        }

        .search-input {
            padding-left: 3rem !important;
        }

        /* Grid Layout Tasks - 3 CARDS PER ROW */
        .tasks-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        /* Task Card Styling */
        .task-card {
            background: white;
            border-radius: 20px;
            padding: 1.75rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border-left: 5px solid;
            display: flex;
            flex-direction: column;
            height: 100%;
            position: relative;
            overflow: hidden;
        }

        .task-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: inherit;
            opacity: 0.1;
        }

        .task-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        /* Warna Warni Kartu dengan Gradien */
        .color-1 {
            border-color: #3b82f6;
            background: linear-gradient(135deg, #ffffff 0%, #f0f7ff 100%);
        }

        .color-2 {
            border-color: #10b981;
            background: linear-gradient(135deg, #ffffff 0%, #f0fff4 100%);
        }

        .color-3 {
            border-color: #f59e0b;
            background: linear-gradient(135deg, #ffffff 0%, #fffbeb 100%);
        }

        .color-4 {
            border-color: #8b5cf6;
            background: linear-gradient(135deg, #ffffff 0%, #f5f3ff 100%);
        }

        .color-5 {
            border-color: #ec4899;
            background: linear-gradient(135deg, #ffffff 0%, #fdf2f8 100%);
        }

        .color-6 {
            border-color: #06b6d4;
            background: linear-gradient(135deg, #ffffff 0%, #f0fff9 100%);
        }

        .task-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1.25rem;
            gap: 1rem;
        }

        .task-title-text {
            font-size: 1.3rem;
            font-weight: 800;
            color: #1f2937;
            line-height: 1.4;
            margin: 0;
            flex: 1;
        }

        .task-desc {
            color: #6b7280;
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 1.5rem;
            flex-grow: 1;
        }

        /* Metadata Box */
        .task-meta {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            padding: 1.25rem;
            border-radius: 14px;
            margin-bottom: 1.5rem;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .meta-row {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: #4b5563;
            margin-bottom: 0.75rem;
            font-size: 0.9rem;
        }

        .meta-row:last-child {
            margin-bottom: 0;
        }

        .meta-icon {
            color: #6b7280;
            flex-shrink: 0;
        }

        /* Badges */
        .badge-deadline {
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            white-space: nowrap;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .bg-urgent {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
            color: #dc2626;
        }

        .bg-soon {
            background: linear-gradient(135deg, #fed7aa 0%, #fdba74 100%);
            color: #c2410c;
        }

        .bg-normal {
            background: linear-gradient(135deg, #bbf7d0 0%, #86efac 100%);
            color: #15803d;
        }

        /* Footer Actions */
        .task-footer {
            padding-top: 1.25rem;
            border-top: 1px solid rgba(0, 0, 0, 0.08);
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: auto;
        }

        .btn-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .btn-edit-task {
            background: rgba(59, 130, 246, 0.1);
            color: #3b82f6;
            border: 1px solid rgba(59, 130, 246, 0.2);
        }

        .btn-edit-task:hover {
            background: #3b82f6;
            color: white;
            transform: scale(1.1);
        }

        .btn-delete-task {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
            border: 1px solid rgba(239, 68, 68, 0.2);
        }

        .btn-delete-task:hover {
            background: #ef4444;
            color: white;
            transform: scale(1.1);
        }

        /* Download Link */
        .download-link {
            color: #3b82f6;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            background: rgba(59, 130, 246, 0.1);
        }

        .download-link:hover {
            background: #3b82f6;
            color: white;
            text-decoration: none;
            transform: translateY(-1px);
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
            border: 2px dashed #cbd5e0;
        }

        .empty-animation {
            width: 150px;
            height: 150px;
            margin: 0 auto 2rem;
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%236b7280'%3E%3Cpath d='M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z'/%3E%3C/svg%3E") no-repeat center;
            animation: bounce 2s infinite;
        }

        @keyframes bounce {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-15px);
            }
        }

        .empty-title {
            font-size: 1.75rem;
            font-weight: 800;
            color: #374151;
            margin-bottom: 0.75rem;
        }

        .empty-text {
            color: #6b7280;
            font-size: 1.1rem;
            margin-bottom: 2rem;
        }

        /* Pagination Customization */
        .pagination-wrapper {
            display: flex;
            justify-content: center;
            margin-top: 3rem;
        }

        .pagination {
            display: flex;
            gap: 0.5rem;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .page-item {
            margin: 0;
        }

        .page-link {
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 45px;
            height: 45px;
            padding: 0.5rem 0.75rem;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            color: #4a5568;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            background: white;
        }

        .page-link:hover {
            background: #f7fafc;
            border-color: #cbd5e0;
            color: #2d3748;
            transform: translateY(-1px);
        }

        .page-item.active .page-link {
            background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
            border-color: #0d6efd;
            color: white;
            box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
        }

        .page-item.disabled .page-link {
            background: #f7fafc;
            color: #a0aec0;
            cursor: not-allowed;
            transform: none;
        }

        /* Loading State */
        .loading-state {
            display: none;
            grid-column: 1 / -1;
            text-align: center;
            padding: 3rem;
        }

        .spinner-modern {
            width: 50px;
            height: 50px;
            border: 4px solid #f3f4f6;
            border-left: 4px solid #3b82f6;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 1rem;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Responsive Design */
        @media (max-width: 1200px) {
            .tasks-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .tasks-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .tugas-title {
                font-size: 2rem;
            }

            .header-content {
                flex-direction: column;
                text-align: center;
                gap: 1rem;
            }

            .task-card {
                padding: 1.5rem;
            }

            .task-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .deadline-badge {
                align-self: flex-start;
                margin-top: 0.5rem;
            }

            .pagination {
                flex-wrap: wrap;
                justify-content: center;
            }
        }

        @media (max-width: 480px) {
            .tugas-container {
                padding: 1rem 0;
            }

            .task-card {
                padding: 1.25rem;
            }

            .control-card {
                padding: 1.25rem;
            }

            .page-link {
                min-width: 40px;
                height: 40px;
                padding: 0.4rem 0.6rem;
                font-size: 0.9rem;
            }
        }
    </style>

    <div class="tugas-container">
        <div class="container">

            <!-- Header Section -->
            <div class="d-flex justify-content-between align-items-center mb-4 fade-in-up" style="animation-delay: 0.1s;">
                <div>
                    <h1 class="tugas-title">Daftar Tugas</h1>
                    <p class="text-muted mb-0">Kelola dan pantau tugas kuliah Anda dengan mudah</p>
                </div>

                <div class="d-flex gap-2 flex-wrap">
                    <a href="{{ route('laporan.cetak') }}" class="btn-modern btn-light-modern" target="_blank">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                            viewBox="0 0 16 16">
                            <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z" />
                            <path
                                d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1z" />
                        </svg>
                        Cetak Tugas
                    </a>

                    @if(Auth::user()->role == 'admin')
                        <a href="{{ route('tugas.create') }}" class="btn-modern btn-primary-modern">
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

            <!-- Control Card -->
            <div class="control-card fade-in-up" style="animation-delay: 0.2s;">
                <div class="row g-3">
                    <div class="col-md-6">
                        <form action="{{ route('tugas.cari') }}" method="GET" id="searchForm">
                            <div class="search-input-group">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                                    class="search-icon" viewBox="0 0 16 16">
                                    <path
                                        d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                                </svg>
                                <input type="search" name="cari" class="form-control form-control-custom search-input"
                                    placeholder="Cari tugas berdasarkan judul atau deskripsi..."
                                    value="{{ request('cari') }}" autocomplete="off">
                                <button type="submit" class="btn-modern btn-primary-modern position-absolute"
                                    style="right: 5px; top: 50%; transform: translateY(-50%); height: calc(100% - 10px);">
                                    Cari
                                </button>
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

            <!-- Loading State -->
            <div class="loading-state" id="loadingState">
                <div class="spinner-modern"></div>
                <p class="text-muted">Memuat tugas...</p>
            </div>

            <!-- Tasks Grid -->
            <div class="tasks-grid fade-in-up" id="tasksGrid" style="animation-delay: 0.3s;">
                @forelse($tugas as $index => $t)
                @php
                    // Color cycling logic (1-6)
                    $colorIndex = ($index % 6) + 1;

                    // Deadline logic
                    $deadline = \Carbon\Carbon::parse($t->deadline);
                    $now = \Carbon\Carbon::now();
                    $diffInDays = $now->diffInDays($deadline, false);

                    if ($deadline->isPast()) {
                        $badgeClass = 'bg-urgent';
                        $statusText = 'terlambat';
                        $statusDisplay = 'Terlambat';
                    } elseif ($diffInDays <= 3) {
                        $badgeClass = 'bg-soon';
                        $statusText = 'segera';
                        $statusDisplay = 'Segera';
                    } else {
                        $badgeClass = 'bg-normal';
                        $statusText = 'aktif';
                        $statusDisplay = 'Aktif';
                    }
                @endphp

                <div class="task-card color-{{ $colorIndex }}" data-deadline="{{ $deadline->timestamp }}"
                    data-created="{{ $t->created_at->timestamp }}" data-status="{{ $statusText }}"
                    data-search="{{ strtolower($t->judul . ' ' . $t->deskripsi) }}">

                    <div class="task-header">
                        <h3 class="task-title-text">{{ $t->judul }}</h3>
                        <span class="badge-deadline {{ $badgeClass }}">
                            {{ $statusDisplay }}
                        </span>
                    </div>

                    <div class="task-desc">
                        {!! Str::limit($t->deskripsi, 120, '...') ?: '<em>Tidak ada deskripsi.</em>' !!}
                    </div>


                    <div class="task-meta">
                        <div class="meta-row">
                            <span class="deadline-label">
                                <b>DEADLINE:</b> 
                            </span>
                            <span>{{ $deadline->format('d M Y, H:i') }} WIB</span>
                        </div>

                        <div class="meta-row">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="meta-icon"
                                viewBox="0 0 16 16">
                                <path
                                    d="M4.5 3a2.5 2.5 0 0 1 5 0v9a1.5 1.5 0 0 1-3 0V5a.5.5 0 0 1 1 0v7a.5.5 0 0 0 1 0V3a1.5 1.5 0 1 0-3 0v9a2.5 2.5 0 0 0 5 0V5a.5.5 0 0 1 1 0v7a3.5 3.5 0 1 1-7 0z" />
                            </svg>
                            @if($t->file_path)
                                <a href="{{ route('tugas.download', $t->id) }}" class="download-link">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="me-1"
                                        viewBox="0 0 16 16">
                                        <path
                                            d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
                                        <path
                                            d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z" />
                                    </svg>
                                    Download File
                                </a>
                            @else
                                <span class="text-muted fst-italic">Tidak ada file</span>
                            @endif
                        </div>
                    </div>

                    @if(Auth::user()->role == 'admin')
                        <div class="task-footer">
                            <small class="text-muted d-flex align-items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor"
                                    viewBox="0 0 16 16">
                                    <path
                                        d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z" />
                                    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z" />
                                </svg>
                                {{ $deadline->diffForHumans() }}
                            </small>
                            <div class="d-flex gap-2">
                                <a href="{{ route('tugas.edit', $t->id) }}" class="btn-icon btn-edit-task" title="Edit Tugas">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        viewBox="0 0 16 16">
                                        <path
                                            d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z" />
                                    </svg>
                                </a>
                                <button type="button" class="btn-icon btn-delete-task" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal{{ $t->id }}" title="Hapus Tugas">
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
                        <div class="empty-animation"></div>
                        <h3 class="empty-title">Tidak Ada Tugas</h3>                        
                        <div class="empty-actions">
                            {{-- @if(Auth::user()->role == 'admin')
                                <a href="{{ route('tugas.create') }}" class="btn-modern btn-primary-modern mt-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="me-2"
                                        viewBox="0 0 16 16">
                                        <path
                                            d="M8 0a1 1 0 0 1 1 1v6h6a1 1 0 0 1 0 2H9v6a1 1 0 0 1-2 0V9H1a1 1 0 0 1 0-2h6V1a1 1 0 0 1 1-1z" />
                                    </svg>
                                    Buat Tugas Pertama
                                </a>
                            @endif --}}
                        </div>
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

    <!-- Delete Modals -->
    @foreach($tugas as $t)
        @if(Auth::user()->role == 'admin')
            <div class="modal fade" id="deleteModal{{ $t->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
                        <div class="modal-header border-0 text-white"
                            style="background: linear-gradient(135deg, #ef4444, #dc2626); border-radius: 20px 20px 0 0;">
                            <h5 class="modal-title fw-bold">Hapus Tugas?</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body text-center p-4">
                            <div class="mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor"
                                    class="text-danger" viewBox="0 0 16 16">
                                    <path
                                        d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5m.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2" />
                                </svg>
                            </div>
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
            const loadingState = document.getElementById('loadingState');
            const searchInput = document.getElementById('searchInput');

            // Filter & Sort Logic
            function updateGrid() {
                const cards = Array.from(document.querySelectorAll('.task-card'));
                const statusValue = statusFilter.value;
                const sortValue = sortBy.value;

                // Show loading
                loadingState.style.display = 'block';
                tasksGrid.style.opacity = '0.5';

                setTimeout(() => {
                    // Filter by status
                    cards.forEach(card => {
                        const cardStatus = card.dataset.status;
                        if (statusValue === '' || cardStatus === statusValue) {
                            card.style.display = 'flex';
                        } else {
                            card.style.display = 'none';
                        }
                    });

                    // Sort tasks
                    const visibleCards = cards.filter(card => card.style.display !== 'none');

                    visibleCards.sort((a, b) => {
                        const deadlineA = parseInt(a.dataset.deadline);
                        const deadlineB = parseInt(b.dataset.deadline);
                        const createdA = parseInt(a.dataset.created);
                        const createdB = parseInt(b.dataset.created);

                        switch (sortValue) {
                            case 'deadline_asc':
                                return deadlineA - deadlineB;
                            case 'deadline_desc':
                                return deadlineB - deadlineA;
                            case 'created_desc':
                                return createdB - createdA;
                            case 'created_asc':
                                return createdA - createdB;
                            default:
                                return 0;
                        }
                    });

                    // Re-append sorted cards
                    visibleCards.forEach(card => tasksGrid.appendChild(card));

                    // Hide loading
                    loadingState.style.display = 'none';
                    tasksGrid.style.opacity = '1';

                    // Show empty state if no cards visible
                    const visibleCount = visibleCards.filter(card => card.style.display !== 'none').length;
                    const emptyState = document.querySelector('.empty-state');

                    if (visibleCount === 0 && emptyState) {
                        emptyState.style.display = 'block';
                    } else if (emptyState) {
                        emptyState.style.display = 'none';
                    }
                }, 300);
            }

            // Event listeners
            if (statusFilter) statusFilter.addEventListener('change', updateGrid);
            if (sortBy) sortBy.addEventListener('change', updateGrid);

            // Search functionality
            if (searchInput) {
                searchInput.addEventListener('input', debounce(function (e) {
                    const searchTerm = e.target.value.toLowerCase();
                    const cards = document.querySelectorAll('.task-card');

                    cards.forEach(card => {
                        const searchData = card.dataset.search;
                        if (searchData.includes(searchTerm)) {
                            card.style.display = 'flex';
                        } else {
                            card.style.display = 'none';
                        }
                    });
                }, 300));
            }

            // Enhanced button interactions
            const actionButtons = document.querySelectorAll('.btn-icon');
            actionButtons.forEach(btn => {
                btn.addEventListener('mouseenter', function () {
                    this.style.transform = 'scale(1.1)';
                });
                btn.addEventListener('mouseleave', function () {
                    this.style.transform = 'scale(1)';
                });
            });

            // Debounce function
            function debounce(func, wait) {
                let timeout;
                return function executedFunction(...args) {
                    const later = () => {
                        clearTimeout(timeout);
                        func(...args);
                    };
                    clearTimeout(timeout);
                    timeout = setTimeout(later, wait);
                };
            }

            // Initialize animations
            const elements = document.querySelectorAll('.fade-in-up');
            elements.forEach((el, index) => {
                setTimeout(() => {
                    el.style.animationPlayState = 'running';
                }, index * 100);
            });
        });
    </script>
@endsection