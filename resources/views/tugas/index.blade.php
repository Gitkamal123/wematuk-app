@extends('layouts.master')

@section('title', 'Daftar Tugas - WeMaTuK')

@section('content')
    <style>
        /* ===================== */
        /* GLOBAL STYLES         */
        /* ===================== */
        body {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            min-height: 100vh;
        }

        .tugas-container {
            padding: 2rem 0;
        }

        /* Animasi Fade In Up */
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

        /* Header Title */
        .tugas-title {
            font-size: 2.2rem;
            font-weight: 800;
            margin: 0;
            background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: -0.5px;
        }

        /* ===================== */
        /* BUTTONS               */
        /* ===================== */
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
            font-size: 0.95rem;
        }

        .btn-primary-modern {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
        }

        .btn-primary-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(37, 99, 235, 0.3);
            color: white;
        }

        .btn-light-modern {
            background: white;
            color: #475569;
            border: 1px solid #e2e8f0;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .btn-light-modern:hover {
            border-color: #cbd5e1;
            background: #f8fafc;
            color: #1e293b;
            transform: translateY(-1px);
        }

        /* ===================== */
        /* CONTROL CARD (SEARCH) */
        /* ===================== */
        .control-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            border-radius: 24px;
            padding: 1.5rem;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.6);
            margin-bottom: 4rem;
            /* Jarak Control Card ke Daftar Tugas diperlebar */
        }

        .search-input-group,
        .select-icon-wrapper {
            position: relative;
            height: 52px;
            /* Tinggi seragam */
        }

        /* Input & Select Base Style */
        .search-input,
        .form-select-styled {
            height: 100% !important;
            border-radius: 16px !important;
            border: 1px solid #e2e8f0;
            background-color: #ffffff;
            font-size: 0.95rem;
            color: #334155;
            font-weight: 500;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .search-input {
            padding-left: 48px !important;
            padding-right: 100px !important;
            /* Ruang untuk tombol Cari */
        }

        .form-select-styled {
            padding-left: 48px !important;
            padding-right: 40px !important;
            cursor: pointer;
            -webkit-appearance: none;
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%2364748b' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 1.25rem center;
            background-size: 14px 10px;
        }

        /* Focus States */
        .search-input:focus,
        .form-select-styled:focus {
            border-color: #3b82f6;
            outline: 0;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1) !important;
            transform: translateY(-1px);
        }

        .form-select-styled:focus {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%233b82f6' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e");
        }

        /* Icons */
        .search-icon,
        .select-icon {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            z-index: 2;
            pointer-events: none;
            transition: color 0.3s;
        }

        .search-input:focus~.search-icon,
        .form-select-styled:focus~.select-icon {
            color: #3b82f6;
        }

        /* Button Search Inside Input */
        .btn-search-inside {
            position: absolute;
            right: 6px;
            top: 6px;
            bottom: 6px;
            border-radius: 12px;
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            color: white;
            border: none;
            padding: 0 20px;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(37, 99, 235, 0.2);
        }

        .btn-search-inside:hover {
            background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
        }

        /* Clear Search Button (X) */
        .clear-search-btn {
            position: absolute;
            right: 90px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #cbd5e1;
            padding: 4px;
            display: none;
            z-index: 5;
            transition: color 0.2s;
        }

        .clear-search-btn:hover {
            color: #ef4444;
        }

        /* ===================== */
        /* TASK CARDS            */
        /* ===================== */
        .tasks-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .task-card {
            background: white;
            border-radius: 20px;
            padding: 1.75rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border-left: 5px solid;
            display: flex;
            flex-direction: column;
            height: 100%;
            position: relative;
            overflow: hidden;
        }

        .task-card:hover {
            transform: translateY(-8px) scale(1.01);
            box-shadow: 0 20px 40px -12px rgba(0, 0, 0, 0.15);
        }

        .task-card-theme {
            border-color: #06b6d4;
            /* Cyan Border */
            background: linear-gradient(135deg, #ffffff 0%, #f0fdff 100%);
        }

        .task-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1rem;
            gap: 1rem;
        }

        .task-title-text {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1e293b;
            line-height: 1.4;
            margin: 0;
            flex: 1;
        }

        .task-desc {
            color: #64748b;
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 1.5rem;
            flex-grow: 1;
        }

        /* Badges */
        .badge-deadline {
            padding: 0.4rem 0.8rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            white-space: nowrap;
        }

        .bg-urgent {
            background: #fef2f2;
            color: #dc2626;
            border: 1px solid #fee2e2;
        }

        .bg-soon {
            background: #fff7ed;
            color: #ea580c;
            border: 1px solid #ffedd5;
        }

        .bg-normal {
            background: #f0fdf4;
            color: #16a34a;
            border: 1px solid #dcfce7;
        }

        /* Meta Info */
        .task-meta {
            background: rgba(255, 255, 255, 0.6);
            padding: 1rem;
            border-radius: 12px;
            margin-bottom: 1.25rem;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .meta-row {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #475569;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }

        .meta-row:last-child {
            margin-bottom: 0;
        }

        .download-link {
            color: #2563eb;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.2s;
        }

        .download-link:hover {
            color: #1d4ed8;
            text-decoration: underline;
        }

        /* Footer Icons */
        .task-footer {
            padding-top: 1rem;
            border-top: 1px solid #f1f5f9;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: auto;
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
            color: #2563eb;
        }

        .btn-edit-task:hover {
            background: #2563eb;
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

        /* ===================== */
        /* EMPTY STATE           */
        /* ===================== */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            grid-column: 1 / -1;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 24px;
            border: 2px dashed #cbd5e0;
        }

        .empty-animation {
            width: 120px;
            height: 120px;
            margin: 0 auto 1.5rem;
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%2394a3b8'%3E%3Cpath d='M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z'/%3E%3C/svg%3E") no-repeat center/contain;
            opacity: 0.5;
        }

        /* ===================== */
        /* PAGINATION            */
        /* ===================== */
        .pagination-wrapper {
            display: flex;
            justify-content: center;
            margin-top: 3rem;
            padding-bottom: 2rem;
        }

        .pagination {
            display: flex;
            gap: 8px;
            padding: 0;
            margin: 0;
            list-style: none;
        }

        .page-item .page-link {
            border: none !important;
            border-radius: 12px !important;
            width: 42px;
            height: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #64748b;
            font-weight: 700;
            background: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            transition: all 0.2s;
            text-decoration: none;
        }

        .page-item.active .page-link {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%) !important;
            color: white !important;
            box-shadow: 0 8px 16px -4px rgba(37, 99, 235, 0.4);
            transform: scale(1.1);
        }

        .page-item:not(.active):not(.disabled) .page-link:hover {
            transform: translateY(-2px);
            background: #f8fafc;
            color: #2563eb;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .tasks-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 576px) {
            .tasks-grid {
                grid-template-columns: 1fr;
            }

            .tugas-title {
                font-size: 1.75rem;
            }

            .control-card {
                padding: 1rem;
            }
        }
    </style>

    <div class="tugas-container">
        <div class="container">

            <div class="d-flex justify-content-between align-items-center mb-5 fade-in-up" style="animation-delay: 0.1s;">
                <div>
                    <h1 class="tugas-title">Daftar Tugas</h1>
                    <p class="text-muted mb-0 mt-1">Kelola tugas akademik dengan mudah dan terorganisir.</p>
                </div>

                <div class="d-flex gap-2 flex-wrap">
                    <a href="{{ route('laporan.cetak') }}" class="btn-modern btn-light-modern" target="_blank">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                            viewBox="0 0 16 16">
                            <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z" />
                            <path
                                d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1z" />
                        </svg>
                        Cetak PDF
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

            <div class="control-card fade-in-up" style="animation-delay: 0.2s;">
                <form action="{{ route('home') }}" method="GET" id="filterForm">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="search-input-group">
                                <input type="text" name="cari" id="searchInput" class="form-control search-input"
                                    placeholder="Cari judul atau deskripsi..." value="{{ request('cari') }}"
                                    autocomplete="off">

                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                    class="search-icon" viewBox="0 0 16 16">
                                    <path
                                        d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                                </svg>

                                <span id="clearSearchBtn" class="clear-search-btn" title="Hapus pencarian">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                                        viewBox="0 0 16 16">
                                        <path
                                            d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                                    </svg>
                                </span>

                                <button type="submit" class="btn-search-inside">Cari</button>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="select-icon-wrapper">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                    class="select-icon" viewBox="0 0 16 16">
                                    <path
                                        d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5v-2z" />
                                </svg>
                                <select class="form-select form-select-styled" name="status"
                                    onchange="document.getElementById('filterForm').submit()">
                                    <option value="">Semua Status</option>
                                    <option value="terlambat" {{ request('status') == 'terlambat' ? 'selected' : '' }}>
                                        Terlambat</option>
                                    <option value="segera" {{ request('status') == 'segera' ? 'selected' : '' }}>Segera
                                    </option>
                                    <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="select-icon-wrapper">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                    class="select-icon" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M11.5 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L11 2.707V14.5a.5.5 0 0 0 .5.5zm-7-14a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L4 13.293V1.5a.5.5 0 0 1 .5-.5z" />
                                </svg>
                                <select class="form-select form-select-styled" name="sort"
                                    onchange="document.getElementById('filterForm').submit()">
                                    <option value="deadline_asc" {{ request('sort') == 'deadline_asc' ? 'selected' : '' }}>
                                        Deadline Terdekat</option>
                                    <option value="deadline_desc" {{ request('sort') == 'deadline_desc' ? 'selected' : '' }}>
                                        Deadline Terjauh</option>
                                    <option value="created_desc" {{ request('sort') == 'created_desc' ? 'selected' : '' }}>
                                        Terbaru Dibuat</option>
                                    <option value="created_asc" {{ request('sort') == 'created_asc' ? 'selected' : '' }}>
                                        Terlama Dibuat</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="loading-state" id="loadingState" style="display: none;">
                <div class="spinner-modern"></div>
                <p class="text-muted">Memuat data...</p>
            </div>

            <div class="tasks-grid fade-in-up" style="animation-delay: 0.3s;">
                @forelse($tugas as $t)
                    @php
                        $deadline = \Carbon\Carbon::parse($t->deadline);
                        $now = \Carbon\Carbon::now();
                        $diffInDays = $now->diffInDays($deadline, false);

                        if ($deadline->isPast()) {
                            $badgeClass = 'bg-urgent';
                            $statusDisplay = 'Terlambat';
                        } elseif ($diffInDays <= 3) {
                            $badgeClass = 'bg-soon';
                            $statusDisplay = 'Segera';
                        } else {
                            $badgeClass = 'bg-normal';
                            $statusDisplay = 'Aktif';
                        }
                    @endphp

                    <div class="task-card task-card-theme">
                        <div class="task-header">
                            <h3 class="task-title-text">{{ $t->judul }}</h3>
                            <span class="badge-deadline {{ $badgeClass }}">
                                {{ $statusDisplay }}
                            </span>
                        </div>

                        <div class="task-desc">
                            {!! Str::limit($t->deskripsi, 100, '...') ?: '<em>Tidak ada deskripsi.</em>' !!}
                        </div>

                        <div class="task-meta">
                            <div class="meta-row">
                                <span style="font-weight: 600;">DEADLINE:</span>
                                <span>{{ $deadline->format('d M Y, H:i') }}</span>
                            </div>
                            <div class="meta-row">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    viewBox="0 0 16 16">
                                    <path
                                        d="M4.5 3a2.5 2.5 0 0 1 5 0v9a1.5 1.5 0 0 1-3 0V5a.5.5 0 0 1 1 0v7a.5.5 0 0 0 1 0V3a1.5 1.5 0 1 0-3 0v9a2.5 2.5 0 0 0 5 0V5a.5.5 0 0 1 1 0v7a3.5 3.5 0 1 1-7 0z" />
                                </svg>
                                @if($t->file_path)
                                    <a href="{{ route('tugas.download', $t->id) }}" class="download-link">Download Lampiran</a>
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

                    @if(Auth::user()->role == 'admin')
                        <div class="modal fade" id="deleteModal{{ $t->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
                                    <div class="modal-header border-0"
                                        style="background: linear-gradient(135deg, #ef4444, #dc2626); border-radius: 20px 20px 0 0;">
                                        <h5 class="modal-title fw-bold text-white">Hapus Tugas?</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body text-center p-4">
                                        <div class="text-danger mb-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor"
                                                viewBox="0 0 16 16">
                                                <path
                                                    d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5m.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2" />
                                            </svg>
                                        </div>
                                        <p class="mb-1">Anda yakin ingin memindahkan tugas ini ke sampah?</p>
                                        <h5 class="fw-bold text-dark">{{ $t->judul }}</h5>
                                    </div>
                                    <div class="modal-footer justify-content-center border-0 pb-4">
                                        <button type="button" class="btn btn-light border px-4"
                                            data-bs-dismiss="modal">Batal</button>
                                        <form action="{{ route('tugas.destroy', $t->id) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-danger px-4">Ya, Hapus</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                @empty
                    <div class="empty-state">
                        <div class="empty-animation"></div>
                        <h3 class="empty-title">Tidak Ada Tugas</h3>
                        <p class="empty-text">Saat ini belum ada tugas yang sesuai dengan filter Anda.</p>
                        @if(request('cari') || request('status'))
                            <a href="{{ route('home') }}" class="btn-modern btn-light-modern">Reset Filter</a>
                        @endif
                    </div>
                @endforelse
            </div>

            @if($tugas->hasPages())
                <div class="pagination-wrapper fade-in-up" style="animation-delay: 0.4s;">
                    {{ $tugas->appends(request()->query())->onEachSide(1)->links() }}
                </div>
            @endif

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Elements
            const searchInput = document.getElementById('searchInput');
            const clearBtn = document.getElementById('clearSearchBtn');
            const filterForm = document.getElementById('filterForm');

            // --- 1. Logic Button Clear (Silang) ---
            function toggleClearButton() {
                if (searchInput && searchInput.value.trim().length > 0) {
                    clearBtn.style.display = 'block';
                } else if (clearBtn) {
                    clearBtn.style.display = 'none';
                }
            }

            // Init Check
            toggleClearButton();

            if (searchInput) {
                // Event saat ngetik
                searchInput.addEventListener('input', function () {
                    toggleClearButton();
                    // Auto submit jika dikosongkan manual
                    if (this.value === '') {
                        filterForm.submit();
                    }
                });

                // Event tombol silang
                if (clearBtn) {
                    clearBtn.addEventListener('click', function () {
                        searchInput.value = '';
                        toggleClearButton();
                        filterForm.submit();
                    });
                }
            }

            // --- 2. Button Hover Animation Effect ---
            const actionButtons = document.querySelectorAll('.btn-icon, .task-card');
            actionButtons.forEach(btn => {
                btn.addEventListener('mouseenter', function () {
                    // Optional JS hover logic if CSS isn't enough
                });
            });
        });
    </script>
@endsection