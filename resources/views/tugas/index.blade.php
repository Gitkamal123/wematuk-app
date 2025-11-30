@extends('layouts.master')

@section('title', 'Daftar Tugas - WeMaTuK')

@section('content')
    <style>
        /* ===================== */
        /* IMPROVED TASK STYLES  */
        /* ===================== */
        body {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            min-height: 100vh;
        }

        .tugas-container {
            padding: 2rem 0;
        }

        /* Header Improvements */
        .tugas-header {
            margin-bottom: 2rem;
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.6s ease;
        }

        .tugas-header.show {
            opacity: 1;
            transform: translateY(0);
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .tugas-title {
            font-size: 2.2rem;
            font-weight: 800;
            color: #1a202c;
            margin: 0;
            background: linear-gradient(135deg, #1a202c 0%, #4a5568 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .btn-print {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            background: white;
            color: #4a5568;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .btn-print:hover {
            transform: translateY(-2px);
            border-color: #cbd5e0;
            background: #f8f9fa;
            color: #2d3748;
        }

        .btn-add {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(13, 110, 253, 0.3);
        }

        .btn-add:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(13, 110, 253, 0.4);
            color: white;
        }

        /* Search Card Improvements */
        .search-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            margin-bottom: 1.5rem;
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.6s ease;
            transition-delay: 0.1s;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .search-card.show {
            opacity: 1;
            transform: translateY(0);
        }

        .search-wrapper {
            position: relative;
            display: flex;
            gap: 0.75rem;
            align-items: center;
        }

        .search-input {
            flex: 1;
            padding: 0.75rem 1rem 0.75rem 3rem;
            font-size: 1rem;
            border: 2px solid rgba(226, 232, 240, 0.8);
            border-radius: 12px;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.9) url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='18' height='18' fill='%236b7280' viewBox='0 0 16 16'%3E%3Cpath d='M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z'%3E%3C/path%3E%3C/svg%3E") no-repeat 15px center;
        }

        .search-input:focus {
            outline: none;
            border-color: #0d6efd;
            background-color: white;
            box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.15);
        }

        .btn-search {
            padding: 0.75rem 1.5rem;
            background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
            color: #ffffff;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            white-space: nowrap;
        }

        .btn-search:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 14px rgba(13, 110, 253, 0.3);
        }

        /* Filter Section */
        .filter-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            padding: 1.25rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            margin-bottom: 1.5rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .filter-row {
            display: flex;
            gap: 1rem;
            align-items: end;
            flex-wrap: wrap;
        }

        .filter-group {
            flex: 1;
            min-width: 200px;
        }

        .filter-label {
            font-weight: 600;
            color: #4a5568;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }

        .filter-select {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            background: white;
            transition: all 0.3s ease;
        }

        .filter-select:focus {
            outline: none;
            border-color: #0d6efd;
            box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.1);
        }

        .btn-reset {
            padding: 0.75rem 1.5rem;
            background: #6b7280;
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            white-space: nowrap;
        }

        .btn-reset:hover {
            background: #4b5563;
            transform: translateY(-1px);
        }

        /* Tasks Grid - REPLACED TABLE */
        .tasks-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.6s ease;
            transition-delay: 0.2s;
        }

        .tasks-grid.show {
            opacity: 1;
            transform: translateY(0);
        }

        /* Task Card Styles */
        .task-card {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            transition: all 0.3s ease;
            border-left: 4px solid;
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
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        /* Dynamic Colors for Cards */
        .task-card.color-1 { border-color: #3b82f6; }
        .task-card.color-2 { border-color: #10b981; }
        .task-card.color-3 { border-color: #f59e0b; }
        .task-card.color-4 { border-color: #8b5cf6; }
        .task-card.color-5 { border-color: #ec4899; }
        .task-card.color-6 { border-color: #06b6d4; }

        .task-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1rem;
            gap: 1rem;
        }

        .task-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1f2937;
            line-height: 1.4;
            margin: 0;
            flex: 1;
        }

        .task-description {
            color: #6b7280;
            font-size: 0.95rem;
            line-height: 1.5;
            margin-bottom: 1.5rem;
            flex-grow: 1;
        }

        .task-meta {
            background: #f8fafc;
            padding: 1rem;
            border-radius: 12px;
            margin-bottom: 1.25rem;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #4b5563;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }

        .meta-item:last-child {
            margin-bottom: 0;
        }

        .meta-icon {
            color: #6b7280;
            flex-shrink: 0;
        }

        /* Badge & Status Improvements */
        .deadline-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            padding: 0.5rem 0.75rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 700;
            white-space: nowrap;
        }

        .deadline-urgent {
            background: rgba(229, 62, 62, 0.1);
            color: #e53e3e;
            border: 1px solid rgba(229, 62, 62, 0.2);
        }

        .deadline-soon {
            background: rgba(237, 137, 54, 0.1);
            color: #ed8936;
            border: 1px solid rgba(237, 137, 54, 0.2);
        }

        .deadline-normal {
            background: rgba(72, 187, 120, 0.1);
            color: #48bb78;
            border: 1px solid rgba(72, 187, 120, 0.2);
        }

        /* Action Buttons Improvements */
        .task-actions {
            display: flex;
            gap: 0.5rem;
            justify-content: flex-end;
            padding-top: 1rem;
            border-top: 1px solid #f1f5f9;
        }

        .btn-action {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            flex: 1;
            justify-content: center;
        }

        .btn-edit {
            background: rgba(59, 130, 246, 0.1);
            color: #3b82f6;
        }

        .btn-edit:hover {
            background: #3b82f6;
            color: #ffffff;
            transform: translateY(-2px);
        }

        .btn-delete {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
        }

        .btn-delete:hover {
            background: #ef4444;
            color: #ffffff;
            transform: translateY(-2px);
        }

        .btn-download {
            color: #3b82f6;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            background: rgba(59, 130, 246, 0.1);
        }

        .btn-download:hover {
            background: #3b82f6;
            color: white;
            text-decoration: none;
        }

        /* Enhanced Empty State */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            grid-column: 1 / -1;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            border: 2px dashed #cbd5e0;
        }

        .empty-animation {
            width: 120px;
            height: 120px;
            margin: 0 auto 2rem;
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%236b7280'%3E%3Cpath d='M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z'/%3E%3C/svg%3E") no-repeat center;
            animation: bounce 2s infinite;
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        .empty-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #374151;
            margin-bottom: 0.5rem;
        }

        .empty-text {
            color: #6b7280;
            margin-bottom: 2rem;
        }

        /* Pagination */
        .pagination-wrapper {
            display: flex;
            justify-content: center;
            margin-top: 2rem;
        }

        /* Loading Skeleton */
        .skeleton-loading {
            animation: pulse 2s infinite;
        }

        .skeleton-card {
            background: #f8fafc;
            border-radius: 16px;
            padding: 1.5rem;
            margin-bottom: 1rem;
        }

        .skeleton-line {
            height: 1rem;
            background: #e2e8f0;
            border-radius: 4px;
            margin-bottom: 0.75rem;
        }

        .skeleton-line.short {
            width: 60%;
        }

        .skeleton-line.medium {
            width: 80%;
        }

        @keyframes pulse {
            0% { opacity: 1; }
            50% { opacity: 0.5; }
            100% { opacity: 1; }
        }

        /* Enhanced Modal */
        .modal-enhanced {
            border-radius: 20px;
            overflow: hidden;
        }

        .modal-enhanced-header {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            padding: 1.5rem;
            text-align: center;
            border-bottom: none;
        }

        .modal-enhanced-icon {
            width: 64px;
            height: 64px;
            margin: 0 auto 1rem;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .task-preview-enhanced {
            background: #f8fafc;
            border-radius: 12px;
            padding: 1.25rem;
            margin: 1rem 0;
            border-left: 4px solid #ef4444;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .tasks-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .tugas-title {
                font-size: 1.8rem;
            }

            .header-content {
                flex-direction: column;
                text-align: center;
            }

            .search-wrapper {
                flex-direction: column;
            }

            .btn-search {
                width: 100%;
            }

            .filter-row {
                flex-direction: column;
            }

            .filter-group {
                min-width: 100%;
            }

            .task-card {
                padding: 1.25rem;
            }

            .task-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .deadline-badge {
                align-self: flex-start;
            }
        }

        @media (max-width: 480px) {
            .tugas-container {
                padding: 1rem 0;
            }

            .task-card {
                padding: 1rem;
            }

            .task-actions {
                flex-direction: column;
            }

            .btn-action {
                width: 100%;
            }
        }
    </style>

    <div class="tugas-container">
        <div class="container-fluid">

            <!-- Header -->
            <div class="tugas-header" id="tugasHeader">
                <div class="header-content">
                    <div>
                        <h1 class="tugas-title">Daftar Tugas</h1>
                        <p class="text-muted mb-0">Kelola dan pantau tugas kuliah Anda dengan mudah</p>
                    </div>
                    <div class="d-flex gap-2 flex-wrap">
                        <a href="{{ route('laporan.cetak') }}" class="btn-print" target="_blank">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z" />
                                <path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1z" />
                            </svg>
                            Cetak Tugas
                        </a>

                        @if(Auth::user()->role == 'admin')
                            <a href="{{ route('tugas.create') }}" class="btn-add">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M8 0a1 1 0 0 1 1 1v6h6a1 1 0 0 1 0 2H9v6a1 1 0 0 1-2 0V9H1a1 1 0 0 1 0-2h6V1a1 1 0 0 1 1-1z" />
                                </svg>
                                Tambah Tugas
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Search Card -->
            <div class="search-card" id="searchCard">
                <form action="{{ route('tugas.cari') }}" method="GET" id="searchForm">
                    <div class="search-wrapper">
                        <input type="search" name="cari" class="search-input" id="searchInput"
                            placeholder="Cari tugas berdasarkan judul atau deskripsi..." value="{{ request('cari') }}"
                            autocomplete="off">
                        <button class="btn-search" type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="me-1" viewBox="0 0 16 16">
                                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                            </svg>
                            Cari
                        </button>
                    </div>
                </form>
            </div>

            <!-- Filter Card -->
            <div class="filter-card" id="filterCard">
                <div class="filter-row">
                    <div class="filter-group">
                        <div class="filter-label">Status Deadline</div>
                        <select class="filter-select" id="statusFilter">
                            <option value="">Semua Status</option>
                            <option value="urgent">Mendesak</option>
                            <option value="soon">Segera</option>
                            <option value="normal">Normal</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <div class="filter-label">Urutkan Berdasarkan</div>
                        <select class="filter-select" id="sortBy">
                            <option value="deadline_asc">Deadline (Terdekat)</option>
                            <option value="deadline_desc">Deadline (Terjauh)</option>
                            <option value="created_desc">Terbaru Dibuat</option>
                            <option value="created_asc">Terlama Dibuat</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <button class="btn-reset w-100" type="button" id="resetFilters">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="me-1" viewBox="0 0 16 16">
                                <path d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2v1z"/>
                                <path d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466z"/>
                            </svg>
                            Reset Filter
                        </button>
                    </div>
                </div>
            </div>

            <!-- Loading State -->
            <div id="loadingState" class="d-none">
                <div class="skeleton-card skeleton-loading">
                    <div class="skeleton-line short"></div>
                    <div class="skeleton-line medium"></div>
                    <div class="skeleton-line"></div>
                    <div class="skeleton-line" style="width: 40%;"></div>
                </div>
                <div class="skeleton-card skeleton-loading">
                    <div class="skeleton-line short"></div>
                    <div class="skeleton-line medium"></div>
                    <div class="skeleton-line"></div>
                    <div class="skeleton-line" style="width: 40%;"></div>
                </div>
            </div>

            <!-- Tasks Grid (Replaced Table) -->
            <div class="tasks-grid" id="tasksGrid">
                @forelse($tugas as $index => $t)
                    @php
                        // Color cycling logic (1-6)
                        $colorIndex = ($index % 6) + 1;

                        // Deadline logic
                        $deadline = \Carbon\Carbon::parse($t->deadline);
                        $now = \Carbon\Carbon::now();
                        $diffInDays = $now->diffInDays($deadline, false);

                        if ($diffInDays < 0) {
                            $badgeClass = 'deadline-urgent';
                            $statusText = 'Terlambat';
                        } elseif ($diffInDays <= 3) {
                            $badgeClass = 'deadline-soon';
                            $statusText = 'Segera';
                        } else {
                            $badgeClass = 'deadline-normal';
                            $statusText = 'Aktif';
                        }
                    @endphp

                    <div class="task-card color-{{ $colorIndex }}" data-deadline="{{ $deadline->timestamp }}" data-created="{{ $t->created_at->timestamp }}" data-status="{{ strtolower($statusText) }}">
                        <div class="task-header">
                            <h3 class="task-title">{{ $t->judul }}</h3>
                            <span class="deadline-badge {{ $badgeClass }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="me-1"
                                    viewBox="0 0 16 16">
                                    <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z" />
                                    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z" />
                                </svg>
                                {{ $deadline->diffForHumans() }}
                            </span>
                        </div>

                        <div class="task-description">
                            {{ Str::limit($t->deskripsi, 120, '...') ?: 'Tidak ada deskripsi tambahan.' }}
                        </div>

                        <div class="task-meta">
                            <div class="meta-item">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="meta-icon"
                                    viewBox="0 0 16 16">
                                    <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z" />
                                </svg>
                                <span>{{ $deadline->format('d M Y, H:i') }} WIB</span>
                            </div>

                            <div class="meta-item">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="meta-icon"
                                    viewBox="0 0 16 16">
                                    <path d="M4.5 3a2.5 2.5 0 0 1 5 0v9a1.5 1.5 0 0 1-3 0V5a.5.5 0 0 1 1 0v7a.5.5 0 0 0 1 0V3a1.5 1.5 0 1 0-3 0v9a2.5 2.5 0 0 0 5 0V5a.5.5 0 0 1 1 0v7a3.5 3.5 0 1 1-7 0z" />
                                </svg>
                                @if($t->file_path)
                                    <a href="{{ route('tugas.download', $t->id) }}" class="btn-download">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="me-1"
                                            viewBox="0 0 16 16">
                                            <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
                                            <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z" />
                                        </svg>
                                        Download File
                                    </a>
                                @else
                                    <span class="text-muted fst-italic">Tidak ada file</span>
                                @endif
                            </div>
                        </div>

                        @if(Auth::user()->role == 'admin')
                            <div class="task-actions">
                                <a href="{{ route('tugas.edit', $t->id) }}" class="btn-action btn-edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor"
                                        viewBox="0 0 16 16">
                                        <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z" />
                                    </svg>
                                    Edit
                                </a>
                                <button type="button" class="btn-action btn-delete"
                                    onclick="showDeleteModal({{ $t->id }}, '{{ addslashes($t->judul) }}', '{{ addslashes($t->deskripsi) }}', '{{ $t->deadline }}')">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor"
                                        viewBox="0 0 16 16">
                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z" />
                                        <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z" />
                                    </svg>
                                    Hapus
                                </button>
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="empty-state">
                        <div class="empty-animation"></div>
                        <h3 class="empty-title">Belum Ada Tugas</h3>
                        <p class="empty-text">Mulai dengan membuat tugas pertama Anda</p>
                        <div class="empty-actions">
                            @if(Auth::user()->role == 'admin')
                                <a href="{{ route('tugas.create') }}" class="btn btn-primary mt-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="me-2"
                                        viewBox="0 0 16 16">
                                        <path d="M8 0a1 1 0 0 1 1 1v6h6a1 1 0 0 1 0 2H9v6a1 1 0 0 1-2 0V9H1a1 1 0 0 1 0-2h6V1a1 1 0 0 1 1-1z" />
                                    </svg>
                                    Buat Tugas Pertama
                                </a>
                            @endif
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($tugas->hasPages())
                <div class="pagination-wrapper">
                    {{ $tugas->links() }}
                </div>
            @endif

        </div>
    </div>

    <!-- Enhanced Delete Confirmation Modal -->
    <div class="modal fade modal-enhanced" id="deleteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-enhanced-header">
                    <div class="modal-enhanced-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5m.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
                        </svg>
                    </div>
                    <h5 class="modal-title mb-0 fw-bold">Konfirmasi Penghapusan</h5>
                </div>
                <div class="modal-body p-4">
                    <p class="text-center mb-3">Anda akan menghapus tugas berikut:</p>
                    
                    <div class="task-preview-enhanced">
                        <h6 id="modalTaskTitle" class="fw-bold mb-2 text-dark"></h6>
                        <p id="modalTaskDesc" class="text-muted small mb-2"></p>
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="me-1" viewBox="0 0 16 16">
                                    <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z"/>
                                    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z"/>
                                </svg>
                                <span id="modalTaskDeadline"></span>
                            </small>
                            <span id="modalTaskStatus" class="badge"></span>
                        </div>
                    </div>
                    
                    <div class="alert alert-warning mt-3">
                        <div class="d-flex align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="me-2" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                            </svg>
                            <div>Tugas akan dipindahkan ke keranjang sampah dan dapat dipulihkan dalam 30 hari</div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <form id="deleteForm" method="POST" class="modal-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger px-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="me-2" viewBox="0 0 16 16">
                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z"/>
                                <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z"/>
                            </svg>
                            Ya, Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Current task ID for deletion
        let currentTaskId = null;

        function showDeleteModal(taskId, taskTitle, taskDesc, taskDeadline) {
            currentTaskId = taskId;

            // Set modal content
            document.getElementById('modalTaskTitle').textContent = taskTitle;
            document.getElementById('modalTaskDesc').textContent = taskDesc || 'Tidak ada deskripsi';

            // Format deadline
            const deadline = new Date(taskDeadline);
            const formattedDeadline = deadline.toLocaleDateString('id-ID', {
                day: 'numeric',
                month: 'long',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
            document.getElementById('modalTaskDeadline').textContent = formattedDeadline;

            // Set status badge
            const now = new Date();
            const diffTime = deadline - now;
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            
            let statusBadge = document.getElementById('modalTaskStatus');
            if (diffDays < 0) {
                statusBadge.className = 'badge bg-danger';
                statusBadge.textContent = 'Terlambat';
            } else if (diffDays <= 3) {
                statusBadge.className = 'badge bg-warning';
                statusBadge.textContent = 'Segera';
            } else {
                statusBadge.className = 'badge bg-success';
                statusBadge.textContent = 'Aktif';
            }

            // Set form action
            document.getElementById('deleteForm').action = `/tugas/${taskId}`;

            // Show modal using Bootstrap
            const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
            modal.show();
        }

        // Filter and Sort Functionality
        document.addEventListener('DOMContentLoaded', function () {
            // Entrance animations
            const header = document.getElementById('tugasHeader');
            const searchCard = document.getElementById('searchCard');
            const filterCard = document.getElementById('filterCard');
            const tasksGrid = document.getElementById('tasksGrid');

            setTimeout(() => header.classList.add('show'), 100);
            setTimeout(() => searchCard.classList.add('show'), 200);
            setTimeout(() => filterCard.classList.add('show'), 250);
            setTimeout(() => tasksGrid.classList.add('show'), 300);

            // Filter functionality
            const statusFilter = document.getElementById('statusFilter');
            const sortBy = document.getElementById('sortBy');
            const resetFilters = document.getElementById('resetFilters');

            function applyFilters() {
                const statusValue = statusFilter.value;
                const sortValue = sortBy.value;
                
                // Show loading
                document.getElementById('loadingState').classList.remove('d-none');
                tasksGrid.style.opacity = '0.5';
                
                // Simulate API call or filtering
                setTimeout(() => {
                    filterAndSortTasks(statusValue, sortValue);
                    document.getElementById('loadingState').classList.add('d-none');
                    tasksGrid.style.opacity = '1';
                }, 500);
            }

            function filterAndSortTasks(status, sort) {
                const taskCards = Array.from(document.querySelectorAll('.task-card'));
                const container = document.getElementById('tasksGrid');
                
                // Filter by status
                let filteredTasks = taskCards;
                if (status) {
                    filteredTasks = taskCards.filter(card => {
                        return card.getAttribute('data-status') === status;
                    });
                }
                
                // Sort tasks
                filteredTasks.sort((a, b) => {
                    switch (sort) {
                        case 'deadline_asc':
                            return a.getAttribute('data-deadline') - b.getAttribute('data-deadline');
                        case 'deadline_desc':
                            return b.getAttribute('data-deadline') - a.getAttribute('data-deadline');
                        case 'created_desc':
                            return b.getAttribute('data-created') - a.getAttribute('data-created');
                        case 'created_asc':
                            return a.getAttribute('data-created') - b.getAttribute('data-created');
                        default:
                            return 0;
                    }
                });
                
                // Clear container
                container.innerHTML = '';
                
                // Add filtered and sorted tasks
                if (filteredTasks.length === 0) {
                    container.innerHTML = `
                        <div class="empty-state">
                            <div class="empty-animation"></div>
                            <h3 class="empty-title">Tidak Ada Tugas yang Cocok</h3>
                            <p class="empty-text">Coba ubah filter pencarian Anda</p>
                        </div>
                    `;
                } else {
                    filteredTasks.forEach(card => container.appendChild(card));
                }
            }

            // Event listeners for filters
            statusFilter.addEventListener('change', applyFilters);
            sortBy.addEventListener('change', applyFilters);
            
            resetFilters.addEventListener('click', function() {
                statusFilter.value = '';
                sortBy.value = 'deadline_asc';
                applyFilters();
            });

            // Enhanced search with debounce
            const searchInput = document.getElementById('searchInput');
            let searchTimeout;
            
            searchInput.addEventListener('input', function(e) {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    if (e.target.value === '') {
                        // If search is cleared, show all tasks
                        applyFilters();
                    }
                }, 500);
            });

            // Enhanced delete button interactions
            const deleteButtons = document.querySelectorAll('.btn-delete');
            deleteButtons.forEach(btn => {
                btn.addEventListener('mouseenter', function () {
                    this.style.transform = 'translateY(-2px) scale(1.05)';
                });

                btn.addEventListener('mouseleave', function () {
                    this.style.transform = 'translateY(0) scale(1)';
                });
            });

            // Initialize tooltips if using Bootstrap
            if (typeof bootstrap !== 'undefined') {
                const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });
            }
        });

        // Debounce function for search
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
    </script>
@endsection