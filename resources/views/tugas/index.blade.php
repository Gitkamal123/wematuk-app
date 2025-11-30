@extends('layouts.master')

@section('title', 'Daftar Tugas - WeMaTuK')

@section('content')
        <style>
            /* ===================== */
            /* MODERN TASK STYLES - BLUE WHITE THEME */
            /* ===================== */
            body {
                background: linear-gradient(135deg, #f0f8ff 0%, #e6f3ff 100%);
                font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
                min-height: 100vh;
            }

            .tugas-container {
                padding: 3rem 0;
            }

            /* Enhanced Animations */
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

            /* Blue Theme Header */
            .tugas-title {
                font-size: 3rem;
                font-weight: 900;
                color: #1a202c;
                margin: 0;
                background: linear-gradient(135deg, #1e40af 0%, #3b82f6 50%, #60a5fa 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
                position: relative;
            }

            .tugas-title::after {
                content: '';
                position: absolute;
                bottom: -10px;
                left: 0;
                width: 60px;
                height: 4px;
                background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
                border-radius: 2px;
            }

            .header-subtitle {
                font-size: 1.2rem; 
                font-weight: 500;  
                color: #64748b;   
            }
            .task-header,
            .task-desc,
            .task-meta,
            .task-footer {
                position: relative;
                z-index: 1;
            }

            /* Enhanced Control Card - Blue Theme */
            .control-card {
                background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(248, 250, 252, 0.95) 100%);
                backdrop-filter: blur(20px);
                border-radius: 24px;
                padding: 2rem;
                box-shadow:
                    0 20px 40px rgba(30, 64, 175, 0.1),
                    0 0 0 1px rgba(255, 255, 255, 0.8);
                border: 1px solid rgba(255, 255, 255, 0.3);
                margin-bottom: 3rem;
                position: relative;
                overflow: hidden;
            }

            .control-card::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                height: 3px;
                background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
            }

            /* Enhanced Search Input - Blue Theme */
            .search-input-group {
                position: relative;
            }

            .search-icon {
                position: absolute;
                left: 1.25rem;
                top: 50%;
                transform: translateY(-50%);
                color: #64748b;
                z-index: 3;
                transition: all 0.3s ease;
            }

            .search-input {
                padding-left: 3.5rem !important;
                padding-right: 140px;
                height: 56px;
                border: 2px solid #e0f2fe;
                border-radius: 16px;
                font-size: 1rem;
                font-weight: 500;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                background: rgba(255, 255, 255, 0.9);
            }

            .search-input:focus {
                border-color: #3b82f6;
                background: white;
                box-shadow:
                    0 0 0 4px rgba(59, 130, 246, 0.1),
                    0 10px 20px rgba(30, 64, 175, 0.05);
                transform: translateY(-2px);
            }

            .search-input:focus+.search-icon {
                color: #3b82f6;
                transform: translateY(-50%) scale(1.1);
            }

            /* Enhanced Buttons - Blue Theme */
            .btn-modern {
                padding: 0.875rem 1.75rem;
                border-radius: 16px;
                font-weight: 600;
                transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
                display: inline-flex;
                align-items: center;
                gap: 0.75rem;
                text-decoration: none;
                border: none;
                font-size: 1.2rem;
                position: relative;
                overflow: hidden;
            }

            .btn-modern::before {
                content: '';
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100%;
                background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
                transition: left 0.5s;
            }

            .btn-modern:hover::before {
                left: 100%;
            }

            .btn-primary-modern {
                background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
                color: white;
                box-shadow:
                    0 8px 25px rgba(30, 64, 175, 0.3),
                    0 2px 4px rgba(30, 64, 175, 0.1);
            }

            .btn-primary-modern:hover {
                transform: translateY(-3px) scale(1.02);
                box-shadow:
                    0 15px 35px rgba(30, 64, 175, 0.4),
                    0 5px 10px rgba(30, 64, 175, 0.2);
            }

            .btn-light-modern {
                background: linear-gradient(135deg, rgba(255, 255, 255, 0.9) 0%, rgba(248, 250, 252, 0.9) 100%);
                color: #475569;
                border: 2px solid #e0f2fe;
                box-shadow:
                    0 4px 15px rgba(30, 64, 175, 0.05),
                    0 1px 2px rgba(30, 64, 175, 0.1);
                backdrop-filter: blur(10px);
            }

            .btn-light-modern:hover {
                border-color: #bfdbfe;
                background: white;
                color: #334155;
                transform: translateY(-2px);
                box-shadow:
                    0 8px 25px rgba(30, 64, 175, 0.1),
                    0 3px 6px rgba(30, 64, 175, 0.05);
            }

            /* Enhanced Tasks Grid */
            .tasks-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(380px, 1fr));
                gap: 2rem;
                margin-bottom: 3rem;
            }

            /* Enhanced Task Card - Blue Theme */
            .task-card {
                background: linear-gradient(135deg, #e0f2fe 0%, #f0f9ff 50%, #ffffff 100%);
                border-radius: 24px;
                padding: 2rem;
                box-shadow: 
                    0 10px 30px rgba(30, 64, 175, 0.1),
                    0 1px 3px rgba(30, 64, 175, 0.05);
                transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
                border-left: 6px solid #3b82f6;
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
                height: 5px;
                background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
                opacity: 0.8;
            }

            .task-card::after {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: linear-gradient(135deg, rgba(59, 130, 246, 0.05) 0%, transparent 50%);
                pointer-events: none;
            }

            .task-card:hover {
                transform: translateY(-8px) scale(1.02);
                box-shadow:
                    0 30px 60px rgba(30, 64, 175, 0.15),
                    0 5px 15px rgba(30, 64, 175, 0.1);
            }

            /* Enhanced Task Header */
            .task-header {
                display: flex;
                justify-content: space-between;
                align-items: flex-start;
                margin-bottom: 1.5rem;
                gap: 1rem;
            }

            .task-title-text {
                font-size: 1.4rem;
                font-weight: 800;
                color: #1f2937;
                line-height: 1.4;
                margin: 0;
                flex: 1;
                background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }

            /* Enhanced Badges - Blue Theme */
            .badge-deadline {
                padding: 0.6rem 1.2rem;
                border-radius: 50px;
                font-size: 0.8rem;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                white-space: nowrap;
                backdrop-filter: blur(10px);
                border: 1px solid rgba(255, 255, 255, 0.3);
                box-shadow: 0 2px 8px rgba(30, 64, 175, 0.1);
            }

            .bg-urgent {
                background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
                color: #dc2626;
                border-color: #fecaca;
            }

            .bg-soon {
                background: linear-gradient(135deg, #fffbeb 0%, #fed7aa 100%);
                color: #c2410c;
                border-color: #fdba74;
            }

            .bg-normal {
                background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
                color: #0369a1;
                border-color: #7dd3fc;
            }

            /* Enhanced Task Description */
            .task-desc {
                color: #6b7280;
                font-size: 1rem;
                line-height: 1.7;
                margin-bottom: 2rem;
                flex-grow: 1;
                background: rgba(255, 255, 255, 0.5);
                padding: 1.25rem;
                border-radius: 12px;
                border-left: 3px solid #e0f2fe;
            }

            /* Enhanced Metadata Box - Blue Theme */
            .task-meta {
                background: linear-gradient(135deg, rgba(255, 255, 255, 0.9) 0%, rgba(240, 249, 255, 0.9) 100%);
                backdrop-filter: blur(15px);
                padding: 1.5rem;
                border-radius: 16px;
                margin-bottom: 2rem;
                border: 1px solid rgba(255, 255, 255, 0.6); /* ← perkuat border */
                box-shadow: 0 4px 12px rgba(30, 64, 175, 0.08);
                position: relative; /* ← tambahkan ini */
                z-index: 1; /* ← tambahkan ini */
            }

            .meta-row {
                display: flex;
                align-items: center;
                gap: 1rem;
                color: #4b5563;
                margin-bottom: 1rem;
                font-size: 0.95rem;
            }

            .meta-row:last-child {
                margin-bottom: 0;
            }

            .meta-icon {
                color: #3b82f6;
                flex-shrink: 0;
                width: 20px;
                height: 20px;
            }

            /* Enhanced Download Link - Blue Theme */
            .download-link {
                color: #3b82f6;
                text-decoration: none;
                font-weight: 600;
                transition: all 0.3s ease;
                display: inline-flex;
                align-items: center;
                gap: 0.75rem;
                padding: 0.75rem 1.25rem;
                border-radius: 12px;
                background: rgba(59, 130, 246, 0.1);
                border: 1px solid rgba(59, 130, 246, 0.2);
            }

            .download-link:hover {
                background: #3b82f6;
                color: white;
                text-decoration: none;
                transform: translateY(-2px);
                box-shadow: 0 8px 20px rgba(59, 130, 246, 0.3);
            }

            /* Enhanced Footer Actions */
            .task-footer {
                padding-top: 1.5rem;
                border-top: 1px solid rgba(59, 130, 246, 0.1);
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-top: auto;
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
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                backdrop-filter: blur(10px);
                position: relative;
                overflow: hidden;
            }

            .btn-icon::before {
                content: '';
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100%;
                background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
                transition: left 0.5s;
            }

            .btn-icon:hover::before {
                left: 100%;
            }

            .btn-edit-task {
                background: rgba(59, 130, 246, 0.1);
                color: #3b82f6;
                border: 1px solid rgba(59, 130, 246, 0.3);
            }

            .btn-edit-task:hover {
                background: #3b82f6;
                color: white;
                transform: scale(1.1) rotate(5deg);
                box-shadow: 0 8px 20px rgba(59, 130, 246, 0.4);
            }

            .btn-delete-task {
                background: rgba(239, 68, 68, 0.1);
                color: #ef4444;
                border: 1px solid rgba(239, 68, 68, 0.3);
            }

            .btn-delete-task:hover {
                background: #ef4444;
                color: white;
                transform: scale(1.1) rotate(-5deg);
                box-shadow: 0 8px 20px rgba(239, 68, 68, 0.4);
            }

            /* Enhanced Empty State - Blue Theme */
            .empty-state {
                text-align: center;
                padding: 6rem 3rem;
                grid-column: 1 / -1;
                background: linear-gradient(135deg, #ffffff 0%, #f8faff 100%);
                backdrop-filter: blur(20px);
                border-radius: 28px;
                box-shadow:
                    0 20px 40px rgba(30, 64, 175, 0.1),
                    0 0 0 1px rgba(255, 255, 255, 0.8);
                border: 2px dashed #bfdbfe;
                position: relative;
                overflow: hidden;
            }

            .empty-state::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                height: 4px;
                background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
            }

            .empty-animation {
                width: 120px;
                height: 120px;
                margin: 0 auto 2.5rem;
                background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                animation: float 3s ease-in-out infinite;
            }

            .empty-animation::before {
                content: '📝';
                font-size: 3rem;
            }

            @keyframes float {

                0%,
                100% {
                    transform: translateY(0px);
                }

                50% {
                    transform: translateY(-20px);
                }
            }

            .empty-title {
                font-size: 2rem;
                font-weight: 800;
                color: #1f2937;
                margin-bottom: 1rem;
                background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }

            .empty-text {
                color: #6b7280;
                font-size: 1.2rem;
                margin-bottom: 2.5rem;
                line-height: 1.6;
            }

            /* MODERN PAGINATION STYLES */
            .pagination-wrapper {
                margin-top: 3rem;
                padding-bottom: 2rem;
                width: 100%;
            }

            .pagination-wrapper nav > div.d-sm-flex {
                display: flex !important;
                flex-direction: column !important; /* Tumpuk Atas-Bawah */
                align-items: center !important;    /* Rata Tengah */
                justify-content: center !important;
                gap: 15px; /* Jarak antara Teks "Showing" dan Tombol */
            }

            .pagination-wrapper .small.text-muted {
                font-size: 0.9rem;
                color: #64748b !important;
                font-weight: 500;
                text-align: center;
                /* Opsional: Beri background tipis biar rapi */
                background: rgba(255, 255, 255, 0.6);
                padding: 5px 15px;
                border-radius: 20px;
            }

            .pagination {
                display: flex;
                gap: 8px;
                padding: 10px 15px; /* Padding dalam kotak */
                margin: 0;
                list-style: none;

                /* Style Glassmorphism */
                background: linear-gradient(135deg, rgba(255, 255, 255, 0.9) 0%, rgba(240, 249, 255, 0.9) 100%);
                backdrop-filter: blur(10px);
                border-radius: 20px;
                box-shadow: 
                    0 10px 25px rgba(30, 64, 175, 0.08),
                    0 0 0 1px rgba(255, 255, 255, 0.6);
                border: 1px solid rgba(226, 232, 240, 0.6);

                justify-content: center;
                flex-wrap: wrap;
            }

            .page-item .page-link {
                border: none !important;
                border-radius: 12px !important;
                width: 40px;  /* Ukuran fix */
                height: 40px; /* Ukuran fix */
                display: flex;
                align-items: center;
                justify-content: center;
                color: #64748b;
                font-weight: 700;
                font-size: 0.95rem;
                background: transparent; /* Transparan agar ikut background induk */
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }

            .page-item:not(.active):not(.disabled) .page-link:hover {
                transform: translateY(-3px);
                background: #fff;
                color: #3b82f6;
                box-shadow: 0 4px 12px rgba(59, 130, 246, 0.15);
            }

                .page-item:not(.active):not(.disabled) .page-link:hover::before {
                left: 100%;
            }    

            .page-item.active .page-link {
                background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%) !important;
                color: white !important;
                box-shadow: 0 8px 16px -4px rgba(37, 99, 235, 0.4);
                transform: scale(1.1);
                z-index: 1;
            }

            .page-item.disabled .page-link {
                background: transparent;
                color: #cbd5e1;
                cursor: not-allowed;
            }

            .page-link:focus {
                box-shadow: none !important;
            }

            .pagination .text-sm {
                text-align: center;
                width: 100%;
                margin-bottom: 1rem;
                color: #64748b;
                font-size: 0.9rem;
                font-weight: 500;
                order: -1; /* ← Letakkan di atas button pagination */
            }

            .page-item {
                margin: 0;
            }

            .page-link {
                border: none !important;
                border-radius: 14px !important;
                width: 48px;
                height: 48px;
                display: flex;
                align-items: center;
                justify-content: center;
                color: #64748b;
                font-weight: 700;
                font-size: 1rem;
                background: transparent;
                transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
                position: relative;
                overflow: hidden;
            }

            .page-link::before {
                content: '';
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100%;
                background: linear-gradient(90deg, transparent, rgba(59, 130, 246, 0.1), transparent);
                transition: left 0.5s;
            }                          


            /* Enhanced Clear Search Button */
            .clear-search-btn {
                position: absolute;
                right: 90px;
                top: 50%;
                transform: translateY(-50%);
                cursor: pointer;
                color: #9ca3af;
                display: none;
                padding: 8px;
                border-radius: 50%;
                transition: all 0.3s ease;
                z-index: 4;
                background: rgba(255, 255, 255, 0.9);
                backdrop-filter: blur(10px);
                border: 1px solid #e0f2fe;
            }

            .clear-search-btn:hover {
                background-color: #f3f4f6;
                color: #ef4444;
                transform: translateY(-50%) scale(1.1);
            }

            /* Search Button Enhancement */
            .search-submit-btn {
                position: absolute;
                right: 5px;
                top: 15%;
                transform: translateY(-15%);
                height: calc(100% - 10px);
                border-radius: 12px;
                padding: 0 1.5rem;
            }

            /* Responsive Design */
            @media (max-width: 1200px) {
                .tasks-grid {
                    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
                    gap: 1.5rem;
                }
            }

            @media (max-width: 768px) {
                .tugas-container {
                    padding: 2rem 0;
                }

                .tugas-title {
                    font-size: 2.5rem;
                }

                .control-card {
                    padding: 1.5rem;
                    margin-bottom: 2rem;
                }

                .tasks-grid {
                    grid-template-columns: 1fr;
                    gap: 1.5rem;
                }

                .task-card {
                    padding: 1.5rem;
                }

                .search-input {
                    padding-right: 120px;
                }

                .clear-search-btn {
                    right: 80px;
                }

                /* Mobile Pagination */
                .pagination {
                    padding: 0.75rem 1rem;
                    border-radius: 16px;
                }

                .page-link {
                    width: 42px;
                    height: 42px;
                    font-size: 0.9rem;
                    border-radius: 12px !important;
                }
            }

            @media (max-width: 480px) {
                .tugas-title {
                    font-size: 2rem;
                }

                .control-card {
                    padding: 1.25rem;
                }

                .task-card {
                    padding: 1.25rem;
                }

                .btn-modern {
                    padding: 0.75rem 1.5rem;
                }

                .pagination {
                    gap: 0.25rem;
                    padding: 0.5rem;
                }

                .page-link {
                    width: 38px;
                    height: 38px;
                    min-width: 38px;
                }
            }
        </style>

        <div class="tugas-container">
        <div class="container">
            <!-- Enhanced Header Section -->
            <div class="d-flex justify-content-between align-items-center mb-5 fade-in-up" style="animation-delay: 0.1s;">
                <div>
                    <h1 class="tugas-title">Daftar Tugas</h1>
                    <p class="text-muted mb-0 mt-2 header-subtitle">Website Manajemen Tugas - Untuk Siswa atau Mahasiswa</p>
                </div>

                <div class="d-flex gap-3 flex-wrap">
                    <a href="{{ route('laporan.cetak') }}" class="btn-modern btn-light-modern" target="_blank">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                            viewBox="0 0 16 16">
                            <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z" />
                            <path
                                d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1z" />
                        </svg>
                        Cetak Tugas (PDF)
                    </a>

                    @if(Auth::user()->role == 'admin')
                        <a href="{{ route('tugas.create') }}" class="btn-modern btn-primary-modern">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
                                viewBox="0 0 16 16">
                                <path
                                    d="M8 0a1 1 0 0 1 1 1v6h6a1 1 0 0 1 0 2H9v6a1 1 0 0 1-2 0V9H1a1 1 0 0 1 0-2h6V1a1 1 0 0 1 1-1z" />
                            </svg>
                            Tambah Tugas Baru
                        </a>
                    @endif
                </div>
            </div>

            <!-- Enhanced Control Card -->
            <div class="control-card fade-in-up" style="animation-delay: 0.2s;">
                <form action="{{ route('home') }}" method="GET" id="filterForm">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="search-input-group position-relative">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                    class="search-icon" viewBox="0 0 16 16">
                                    <path
                                        d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                                </svg>

                                <input type="text" name="cari" id="searchInput" class="form-control search-input"
                                    placeholder="Cari tugas berdasarkan judul atau deskripsi..."
                                    value="{{ request('cari') }}" autocomplete="off">

                                <span id="clearSearchBtn" class="clear-search-btn" title="Hapus pencarian">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                                        viewBox="0 0 16 16">
                                        <path
                                            d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                                    </svg>
                                </span>

                                <button type="submit" class="btn-modern btn-primary-modern search-submit-btn">
                                    Cari
                                </button>
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
                                    <option value="Lewat Deadline" {{ request('status') == 'Lewat Deadline' ? 'selected' : '' }}>Lewat Deadline</option>
                                    <option value="Mendekati Deadline" {{ request('status') == 'Mendekati Deadline' ? 'selected' : '' }}>Mendekati Deadline</option>
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
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Tasks Grid -->
            <div class="tasks-grid fade-in-up" id="tasksGrid" style="animation-delay: 0.3s;">
                @forelse($tugas as $index => $t)
                    @php
        $deadline = \Carbon\Carbon::parse($t->deadline);
        $now = \Carbon\Carbon::now();
        $diffInDays = $now->diffInDays($deadline, false);

        if ($deadline->isPast()) {
            $badgeClass = 'bg-urgent';
            $statusText = 'terlambat';
            $statusDisplay = 'Terlambat';
        } elseif ($diffInDays <= 3) {
            $badgeClass = 'bg-soon';
            $statusText = 'Mendekati Deadline';
            $statusDisplay = 'Mendekati Deadline';
        } else {
            $badgeClass = 'bg-normal';
            $statusText = 'aktif';
            $statusDisplay = 'Aktif';
        }
                    @endphp

                    <div class="task-card task-card-theme" data-deadline="{{ $deadline->timestamp }}"
                        data-status="{{ $statusText }}">
                        <div class="task-header">
                            <h3 class="task-title-text">{{ $t->judul }}</h3>
                            <span class="badge-deadline {{ $badgeClass }}">{{ $statusDisplay }}</span>
                        </div>

                        <div class="task-desc">
                            {!! Str::limit($t->deskripsi, 150, '...') ?: '<em class="text-muted">Tidak ada deskripsi</em>' !!}
                        </div>

                        <div class="task-meta">
                            <div class="meta-row">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                    class="meta-icon" viewBox="0 0 16 16">
                                    <path
                                        d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z" />
                                    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z" />
                                </svg>
                                <div>
                                    <strong>Deadline:</strong><br>
                                    <span>{{ $deadline->format('d F Y, H:i') }} WIB</span>
                                </div>
                            </div>

                            <div class="meta-row">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                    class="meta-icon" viewBox="0 0 16 16">
                                    <path
                                        d="M4.5 3a2.5 2.5 0 0 1 5 0v9a1.5 1.5 0 0 1-3 0V5a.5.5 0 0 1 1 0v7a.5.5 0 0 0 1 0V3a1.5 1.5 0 1 0-3 0v9a2.5 2.5 0 0 0 5 0V5a.5.5 0 0 1 1 0v7a3.5 3.5 0 1 1-7 0V3z" />
                                </svg>
                                <div>
                                    @if($t->file_path)
                                        <a href="{{ route('tugas.download', $t->id) }}" class="download-link">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                                viewBox="0 0 16 16">
                                                <path
                                                    d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
                                                <path
                                                    d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z" />
                                            </svg>
                                            Download File Tugas
                                        </a>
                                    @else
                                        <span class="text-muted fst-italic">Tidak ada file terlampir</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                    <div class="task-footer">

                        <small class="text-muted d-flex align-items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z" />
                                <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z" />
                            </svg>
                            {{ $deadline->diffForHumans() }}
                        </small>

                        @if(Auth::user()->role == 'admin')
                            <div class="d-flex gap-2">
                                <a href="{{ route('tugas.edit', $t->id) }}" class="btn-icon btn-edit-task" title="Edit Tugas">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                                        <path
                                            d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z" />
                                    </svg>
                                </a>
                                <button type="button" class="btn-icon btn-delete-task" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal{{ $t->id }}" title="Hapus Tugas">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                                        <path
                                            d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z" />
                                        <path
                                            d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z" />
                                    </svg>
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
                    @empty
                        <div class="empty-state">
                            <div class="empty-animation"></div>
                            <h3 class="empty-title">Belum Ada Tugas</h3>                                                                                                
                        </div>
                    @endforelse
                </div>

                <!-- Enhanced Pagination -->
                @if($tugas->hasPages())
                    <div class="pagination-wrapper fade-in-up" style="animation-delay: 0.4s;">
                        {{ $tugas->appends(request()->query())->onEachSide(1)->links() }}
                    </div>
                @endif
            </div>
        </div>

        <!-- Delete Modals -->
        @foreach($tugas as $t)
            @if(Auth::user()->role == 'admin')
                <div class="modal fade" id="deleteModal{{ $t->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content border-0 shadow-lg" style="border-radius: 24px;">
                            <div class="modal-header border-0 text-white"
                                style="background: linear-gradient(135deg, #1e40af, #3b82f6); border-radius: 24px 24px 0 0;">
                                <h5 class="modal-title fw-bold">Konfirmasi Hapus</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body text-center p-5">
                                <div class="mb-4">
                                    <div
                                        style="width: 80px; height: 80px; background: linear-gradient(135deg, #fef2f2, #fee2e2); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="#ef4444"
                                            viewBox="0 0 16 16">
                                            <path
                                                d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5m.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2" />
                                        </svg>
                                    </div>
                                </div>
                                <p class="mb-3">Anda yakin ingin memindahkan tugas ini ke sampah?</p>
                                <h6 class="fw-bold text-dark my-3">{{ $t->judul }}</h6>
                                <small class="text-muted">Data masih bisa dipulihkan dari menu Sampah.</small>
                            </div>
                            <div class="modal-footer justify-content-center border-0 pb-5">
                                <button type="button" class="btn btn-light border px-4 py-2" style="border-radius: 12px;"
                                    data-bs-dismiss="modal">Batal</button>
                                <form action="{{ route('tugas.destroy', $t->id) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger px-4 py-2"
                                        style="border-radius: 12px; background: linear-gradient(135deg, #ef4444, #dc2626); border: none;">Ya,
                                        Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Enhanced animations and interactions
                const actionButtons = document.querySelectorAll('.btn-icon');
                actionButtons.forEach(btn => {
                    btn.addEventListener('mouseenter', function () {
                        this.style.transform = 'scale(1.1)';
                    });
                    btn.addEventListener('mouseleave', function () {
                        this.style.transform = 'scale(1)';
                    });
                });

                // Search functionality
                const searchInput = document.getElementById('searchInput');
                const clearBtn = document.getElementById('clearSearchBtn');
                const filterForm = document.getElementById('filterForm');

                function toggleClearButton() {
                    if (searchInput.value.trim().length > 0) {
                        clearBtn.style.display = 'block';
                    } else {
                        clearBtn.style.display = 'none';
                    }
                }

                // Initialize animations
                const elements = document.querySelectorAll('.fade-in-up');
                elements.forEach((el, index) => {
                    setTimeout(() => {
                        el.style.animationPlayState = 'running';
                    }, index * 100);
                });

                if (searchInput) {
                    toggleClearButton();

                    searchInput.addEventListener('input', function () {
                        toggleClearButton();
                        if (this.value === '') {
                            filterForm.submit();
                        }
                    });

                    clearBtn.addEventListener('click', function () {
                        searchInput.value = '';
                        toggleClearButton();
                        filterForm.submit();
                    });
                }

                // Add hover effects to task cards
                const taskCards = document.querySelectorAll('.task-card');
                taskCards.forEach(card => {
                    card.addEventListener('mouseenter', function () {
                        this.style.transform = 'translateY(-8px) scale(1.02)';
                    });
                    card.addEventListener('mouseleave', function () {
                        this.style.transform = 'translateY(0) scale(1)';
                    });
                });

                // Enhanced pagination interactions
                const paginationLinks = document.querySelectorAll('.page-link');
                paginationLinks.forEach(link => {
                    link.addEventListener('mouseenter', function () {
                        if (!this.parentElement.classList.contains('active') && !this.parentElement.classList.contains('disabled')) {
                            this.style.transform = 'translateY(-3px)';
                        }
                    });
                    link.addEventListener('mouseleave', function () {
                        if (!this.parentElement.classList.contains('active')) {
                            this.style.transform = 'translateY(0)';
                        }
                    });
                });
            });                
        </script>
@endsection