@extends('layouts.master')

@section('title', 'Daftar Tugas - WeMaTuK')

@section('content')
    <style>
        body {
            background: #f8f9fa;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .tugas-container {
            padding: 2rem 0;
        }

        /* Header */
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
            font-size: 2rem;
            font-weight: 700;
            color: #1a202c;
            margin: 0;
        }

        .btn-print {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            background: linear-gradient(135deg, #4a90e2 0%, #63b3ed 100%);
            color: #ffffff;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 14px rgba(74, 144, 226, 0.3);
        }

        .btn-print:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(74, 144, 226, 0.4);
            color: #ffffff;
        }

        /* Search Card */
        .search-card {
            background: #ffffff;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
            margin-bottom: 1.5rem;
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.6s ease;
            transition-delay: 0.1s;
        }

        .search-card.show {
            opacity: 1;
            transform: translateY(0);
        }

        .search-wrapper {
            position: relative;
            display: flex;
            gap: 0.75rem;
        }

        .search-input {
            flex: 1;
            padding: 0.75rem 1rem 0.75rem 2.75rem;
            font-size: 1rem;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            transition: all 0.3s ease;
            background: #f7fafc;
        }

        .search-input:focus {
            outline: none;
            border-color: #4a90e2;
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.1);
        }

        .search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #a0aec0;
            pointer-events: none;
        }

        .btn-search {
            padding: 0.75rem 1.5rem;
            background: linear-gradient(135deg, #4a90e2 0%, #63b3ed 100%);
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
            box-shadow: 0 4px 14px rgba(74, 144, 226, 0.3);
        }

        /* Task Grid */
        .tasks-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        /* Task Card */
        .task-card {
            background: #ffffff;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 0.5s ease forwards;
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .task-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
        }

        /* Deadline Stripe */
        .deadline-stripe {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
        }

        .stripe-urgent {
            background: linear-gradient(90deg, #e53e3e, #fc8181);
        }

        .stripe-soon {
            background: linear-gradient(90deg, #ed8936, #fbd38d);
        }

        .stripe-normal {
            background: linear-gradient(90deg, #48bb78, #9ae6b4);
        }

        /* Task Header */
        .task-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1rem;
        }

        .task-icon-wrapper {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .icon-urgent {
            background: rgba(229, 62, 62, 0.1);
        }

        .icon-soon {
            background: rgba(237, 137, 54, 0.1);
        }

        .icon-normal {
            background: rgba(72, 187, 120, 0.1);
        }

        .task-icon {
            width: 24px;
            height: 24px;
        }

        .icon-urgent .task-icon {
            color: #e53e3e;
        }

        .icon-soon .task-icon {
            color: #ed8936;
        }

        .icon-normal .task-icon {
            color: #48bb78;
        }

        /* Task Content */
        .task-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1a202c;
            margin-bottom: 0.75rem;
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .task-description {
            color: #718096;
            font-size: 0.9rem;
            margin-bottom: 1rem;
            line-height: 1.6;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Deadline Badge */
        .deadline-info {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem;
            border-radius: 10px;
            margin-bottom: 1rem;
        }

        .deadline-urgent-bg {
            background: rgba(229, 62, 62, 0.08);
        }

        .deadline-soon-bg {
            background: rgba(237, 137, 54, 0.08);
        }

        .deadline-normal-bg {
            background: rgba(72, 187, 120, 0.08);
        }

        .deadline-icon {
            width: 20px;
            height: 20px;
            flex-shrink: 0;
        }

        .deadline-urgent-bg .deadline-icon {
            color: #e53e3e;
        }

        .deadline-soon-bg .deadline-icon {
            color: #ed8936;
        }

        .deadline-normal-bg .deadline-icon {
            color: #48bb78;
        }

        .deadline-text {
            flex: 1;
        }

        .deadline-date {
            font-weight: 600;
            font-size: 0.9rem;
            display: block;
            margin-bottom: 0.15rem;
        }

        .deadline-urgent-bg .deadline-date {
            color: #e53e3e;
        }

        .deadline-soon-bg .deadline-date {
            color: #ed8936;
        }

        .deadline-normal-bg .deadline-date {
            color: #48bb78;
        }

        .deadline-relative {
            font-size: 0.8rem;
            color: #718096;
        }

        /* Task Footer */
        .task-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            padding-top: 1rem;
            border-top: 1px solid #f7fafc;
        }

        /* File Badge */
        .file-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.4rem 0.75rem;
            background: rgba(74, 144, 226, 0.08);
            color: #4a90e2;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .file-badge:hover {
            background: rgba(74, 144, 226, 0.15);
            color: #2b6cb0;
            transform: translateY(-1px);
        }

        .file-badge svg {
            width: 14px;
            height: 14px;
        }

        .no-file {
            color: #cbd5e0;
            font-size: 0.85rem;
        }

        /* Action Buttons */
        .task-actions {
            display: flex;
            gap: 0.5rem;
        }

        .btn-action {
            width: 36px;
            height: 36px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
        }

        .btn-edit {
            background: rgba(237, 137, 54, 0.1);
            color: #ed8936;
        }

        .btn-edit:hover {
            background: #ed8936;
            color: #ffffff;
            transform: translateY(-2px) scale(1.05);
        }

        .btn-delete {
            background: rgba(229, 62, 62, 0.1);
            color: #e53e3e;
        }

        .btn-delete:hover {
            background: #e53e3e;
            color: #ffffff;
            transform: translateY(-2px) scale(1.05);
        }

        .btn-action svg {
            width: 16px;
            height: 16px;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
        }

        .empty-icon {
            width: 100px;
            height: 100px;
            margin: 0 auto 1.5rem;
            color: #cbd5e0;
        }

        .empty-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 0.5rem;
        }

        .empty-text {
            color: #718096;
            font-size: 1.1rem;
        }

        /* Pagination */
        .pagination-wrapper {
            display: flex;
            justify-content: center;
            margin-top: 2rem;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1050;
            overflow: auto;
        }

        .modal.show {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-dialog {
            max-width: 500px;
            width: 90%;
            margin: 1rem;
        }

        .modal-content {
            background: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            animation: slideInUp 0.3s ease;
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .modal-header-danger {
            background: linear-gradient(135deg, #e53e3e 0%, #c53030 100%);
            color: white;
            padding: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-title {
            font-size: 1.25rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-close {
            background: transparent;
            border: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
            opacity: 0.8;
            transition: opacity 0.3s;
        }

        .btn-close:hover {
            opacity: 1;
        }

        .modal-body {
            padding: 2rem;
        }

        .task-preview {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 1.25rem;
            margin: 1rem 0;
        }

        .task-preview-title {
            font-weight: 700;
            color: #1a202c;
            margin-bottom: 0.5rem;
            font-size: 1.1rem;
        }

        .task-preview-desc {
            color: #718096;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }

        .alert-warning {
            background: #fef3cd;
            border: 1px solid #f6e5a8;
            border-radius: 8px;
            padding: 1rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-top: 1rem;
        }

        .modal-footer {
            padding: 1.5rem;
            display: flex;
            justify-content: center;
            gap: 1rem;
            border-top: 1px solid #f7fafc;
        }

        .btn-modal {
            padding: 0.75rem 2rem;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-secondary {
            background: #f7fafc;
            color: #4a5568;
        }

        .btn-secondary:hover {
            background: #edf2f7;
            transform: translateY(-2px);
        }

        .btn-danger {
            background: #e53e3e;
            color: white;
        }

        .btn-danger:hover {
            background: #c53030;
            transform: translateY(-2px);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .tugas-title {
                font-size: 1.5rem;
            }

            .header-content {
                flex-direction: column;
                align-items: stretch;
            }

            .btn-print {
                width: 100%;
                justify-content: center;
            }

            .search-wrapper {
                flex-direction: column;
            }

            .btn-search {
                width: 100%;
            }

            .tasks-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .task-footer {
                flex-direction: column;
                align-items: stretch;
            }

            .task-actions {
                justify-content: stretch;
            }

            .btn-action {
                flex: 1;
            }

            .modal-footer {
                flex-direction: column;
            }

            .btn-modal {
                width: 100%;
                justify-content: center;
            }
        }

        @media (min-width: 769px) and (max-width: 1024px) {
            .tasks-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>

    <div class="tugas-container">
        <div class="container-fluid">

            <!-- Header -->
            <div class="tugas-header" id="tugasHeader">
                <div class="header-content">
                    <h1 class="tugas-title">Daftar Tugas</h1>
                    <a href="{{ route('laporan.cetak') }}" class="btn-print" target="_blank">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
                            <path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1z"/>
                        </svg>
                        Cetak Tugas
                    </a>
                </div>
            </div>

            <!-- Search Card -->
            <div class="search-card" id="searchCard">
                <form action="{{ route('tugas.cari') }}" method="GET">
                    <div class="search-wrapper">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="search-icon" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                        </svg>
                        <input type="search" name="cari" class="search-input" id="searchInput"
                            placeholder="Cari tugas berdasarkan judul atau deskripsi..." value="{{ request('cari') }}">
                        <button class="btn-search" type="submit">Cari</button>
                    </div>
                </form>
            </div>

            <!-- Tasks Grid -->
            @if($tugas->count() > 0)
                <div class="tasks-grid">
                    @foreach($tugas as $index => $t)
                        @php
                            $deadline = \Carbon\Carbon::parse($t->deadline);
                            $now = \Carbon\Carbon::now();
                            $diffInDays = $now->diffInDays($deadline, false);

                            if ($diffInDays < 0) {
                                $statusClass = 'urgent';
                            } elseif ($diffInDays <= 3) {
                                $statusClass = 'soon';
                            } else {
                                $statusClass = 'normal';
                            }
                        @endphp

                        <div class="task-card" style="animation-delay: {{ $index * 0.1 }}s">
                            <div class="deadline-stripe stripe-{{ $statusClass }}"></div>

                            <div class="task-header">
                                <div class="task-icon-wrapper icon-{{ $statusClass }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="task-icon" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M5.5 7a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1zM5 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5"/>
                                        <path d="M9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.5zm0 1v2A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1z"/>
                                    </svg>
                                </div>
                            </div>

                            <h3 class="task-title">{{ $t->judul }}</h3>
                            <p class="task-description">{{ $t->deskripsi ?: 'Tidak ada deskripsi' }}</p>

                            <div class="deadline-info deadline-{{ $statusClass }}-bg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="deadline-icon" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z"/>
                                    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z"/>
                                </svg>
                                <div class="deadline-text">
                                    <span class="deadline-date">{{ $deadline->format('d M Y, H:i') }}</span>
                                    <span class="deadline-relative">{{ $deadline->diffForHumans() }}</span>
                                </div>
                            </div>

                            <div class="task-footer">
                                @if($t->file_path)
                                    <a href="{{ route('tugas.download', $t->id) }}" class="file-badge">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16">
                                            <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                                            <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/>
                                        </svg>
                                        Download
                                    </a>
                                @else
                                    <span class="no-file">Tidak ada file</span>
                                @endif

                                @if(Auth::user()->role == 'admin')
                                    <div class="task-actions">
                                        <a href="{{ route('tugas.edit', $t) }}" class="btn-action btn-edit" title="Edit tugas">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16">
                                                <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                                            </svg>
                                        </a>
                                        <button type="button" class="btn-action btn-delete" 
                                            onclick="showDeleteModal({{ $t->id }}, '{{ addslashes($t->judul) }}', '{{ addslashes($t->deskripsi) }}', '{{ $t->deadline }}')" 
                                            title="Hapus tugas">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16">
                                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z"/>
                                                <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z"/>
                                            </svg>
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">