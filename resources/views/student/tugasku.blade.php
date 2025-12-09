@extends('layouts.master')

@section('title', 'Manajemen Tugas Saya - SiMatkul')

@section('content')
    {{-- SweetAlert2 untuk notifikasi --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            background: #f8f9fa;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        /* --- 3. ANIMASI KONTEN MUNCUL DARI BAWAH --- */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translate3d(0, 40px, 0);
            }

            to {
                opacity: 1;
                transform: translate3d(0, 0, 0);
            }
        }

        .tasks-container {
            padding: 2rem 0;
            max-width: 1400px;
            margin: 0 auto;
            /* Terapkan animasi di sini */
            animation: fadeInUp 0.8s cubic-bezier(0.2, 0.8, 0.2, 1);
        }

        /* --- CSS TOMBOL KEMBALI (UPDATED) --- */
        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.6rem 1.2rem;
            /* Warna Awal: Biru */
            background: linear-gradient(135deg, #4a90e2 0%, #3182ce 100%);
            color: #ffffff;
            border: 2px solid transparent; /* Border transparan agar ukuran tetap sama */
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.9rem;
            text-decoration: none;
            box-shadow: 0 4px 6px rgba(74, 144, 226, 0.3);
            margin-bottom: 1.5rem;
                        
            transition: all 0.5s ease;
        }

        .btn-back:hover {
            /* Warna Hover: Putih dengan Border Biru */
            background: #ffffff;
            color: #3182ce;
            border-color: #3182ce;
            transform: translateX(-5px); /* Geser sedikit ke kiri */
            box-shadow: 0 6px 12px rgba(74, 144, 226, 0.2);
        }
        
        .btn-back i {
            transition: transform 0.5s ease;
        }
        
        .btn-back:hover i {
            transform: translateX(-3px); /* Animasi panah ikut bergerak */
        }

        /* Header */
        .page-header {
            margin-bottom: 2.5rem;
        }

        .page-title {
            font-size: 2rem;
            font-weight: 700;
            color: #1a202c;
            margin-bottom: 0.5rem;
        }

        .page-subtitle {
            color: #718096;
            font-size: 1rem;
        }

        /* Stats Cards */
        .stats-row {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            flex: 1;
            background: #ffffff;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
        }

        .stat-label {
            font-size: 0.85rem;
            color: #718096;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.5rem;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
        }

        .stat-value.ongoing {
            color: #4a90e2;
        }

        .stat-value.completed {
            color: #48bb78;
        }

        /* Section Title */
        .section-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1a202c;
            margin-bottom: 1.5rem;
            display: none;
            /* Hide old title because using tabs */
        }

        /* Task Grid */
        .tasks-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 1.5rem;
            margin-bottom: 3rem;
        }

        /* Task Card */
        .task-card {
            background: #ffffff;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);            
            transition: all 0.6s ease;
            border-left: 4px solid;
            position: relative;
        }

        .task-card.urgent {
            border-left-color: #e53e3e;
        }

        .task-card.warning {
            border-left-color: #ed8936;
        }

        .task-card.normal {
            border-left-color: #48bb78;
        }

        .task-card:hover {
            transform: translateY(-8px); /* Naik lebih tinggi */
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
        }

        .task-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: #1a202c;
            margin-bottom: 0.75rem;
            line-height: 1.4;
        }

        .task-desc {
            color: #718096;
            font-size: 0.9rem;
            margin-bottom: 1rem;
            line-height: 1.5;
        }

        .task-deadline {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem;
            background: #f7fafc;
            border-radius: 10px;
            margin-bottom: 1rem;
        }

        .deadline-icon {
            width: 18px;
            height: 18px;
            flex-shrink: 0;
        }

        .task-card.urgent .deadline-icon {
            color: #e53e3e;
        }

        .task-card.warning .deadline-icon {
            color: #ed8936;
        }

        .task-card.normal .deadline-icon {
            color: #48bb78;
        }

        .deadline-text {
            font-size: 0.9rem;
            font-weight: 600;
            color: #2d3748;
        }

        /* Status Badge */
        .status-badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            margin-bottom: 1rem;
        }

        .status-badge.urgent {
            background-color: #ffeaea;
            color: #e53e3e;
        }

        .status-badge.warning {
            background-color: #feebc8;
            color: #ed8936;
        }

        .status-badge.normal {
            background-color: #c6f6d5;
            color: #38a169;
        }

        /* Task Actions */
        .task-actions {
            display: flex;
            gap: 0.5rem;
        }

        .btn-task {
            flex: 1;
            padding: 0.75rem;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.6s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-complete {
            background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
            color: #ffffff;
        }

        .btn-complete:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(72, 187, 120, 0.3);
        }

        .btn-remove {
            background: #f7fafc;
            color: #718096;
            width: 44px;
            padding: 0;
        }

        .btn-remove:hover {
            background: #e53e3e;
            color: #ffffff;
        }

        /* --- 1. STYLING TAB NAVIGASI --- */
        .nav-pills .nav-link {
            color: #718096;
            font-weight: 600;
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            margin-right: 0.5rem;
            border-radius: 12px;
            padding: 0.75rem 1.5rem;
            transition: all 0.4s ease;
        }

        .nav-pills .nav-link:hover {
            background-color: #f7fafc;
            transform: translateY(-2px);
        }

        .nav-pills .nav-link.active {
            background: linear-gradient(135deg, #4a90e2 0%, #3182ce 100%);
            color: white;
            border-color: transparent;
            box-shadow: 0 4px 12px rgba(74, 144, 226, 0.4);
        }

        .tab-content {
            margin-top: 1.5rem;
            min-height: 300px;
        }

        /* --- 2. TABEL GRADASI BIRU PUTIH --- */
        .completed-table,
        .available-tasks {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
            overflow: hidden;
            margin-bottom: 3rem;
        }

        .table-header {
            padding: 1.5rem;
            background: #f7fafc;
            border-bottom: 1px solid #e2e8f0;
        }

        .table-custom {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        /* Header Tabel Gradasi Biru */
        .table-custom thead th {
            padding: 1.25rem 1.5rem;
            background: linear-gradient(180deg, #ebf8ff 0%, #ffffff 100%);
            /* Gradasi halus */
            font-size: 0.85rem;
            font-weight: 700;
            color: #2b6cb0;
            /* Biru tua */
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #bee3f8;
        }

        .table-custom tbody td {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid #f0f4f8;
            color: #2d3748;
        }

        /* Hover Baris Gradasi */
        .table-custom tbody tr {            
            transition: all 0.5s ease;
        }

        .table-custom tbody tr:hover {
            background: linear-gradient(90deg, #f0f9ff 0%, #ffffff 100%);
            /* Efek hover biru muda ke putih */
            transform: scale(1.005);
            /* Sedikit zoom effect */
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .task-name {
            font-weight: 600;
            color: #1a202c;
        }

        .completed-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.35rem 0.75rem;
            background: rgba(72, 187, 120, 0.1);
            color: #48bb78;
            border-radius: 6px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .btn-table-action {
            width: 36px;
            height: 36px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.5s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-undo {
            background: rgba(237, 137, 54, 0.1);
            color: #ed8936;
        }

        .btn-undo:hover {
            background: #ed8936;
            color: #ffffff;
        }

        .btn-delete {
            background: rgba(229, 62, 62, 0.1);
            color: #e53e3e;
            margin-left: 0.5rem;
        }

        .btn-delete:hover {
            background: #e53e3e;
            color: #ffffff;
        }

        /* Available Tasks Header */
        .available-header {
            padding: 1.5rem;
            background: linear-gradient(135deg, #ebf8ff 0%, #ffffff 100%);
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .available-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #2c5282;
            margin: 0;
        }

        .count-badge {
            padding: 0.5rem 1rem;
            background: linear-gradient(135deg, #4a90e2 0%, #63b3ed 100%);
            color: #ffffff;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .btn-take {
            padding: 0.5rem 1.25rem;
            background: linear-gradient(135deg, #4a90e2 0%, #63b3ed 100%);
            color: #ffffff;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.85rem;
            cursor: pointer;
            transition: all 0.4s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-take:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(74, 144, 226, 0.3);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 3rem;
        }

        .empty-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 1rem;
            color: #cbd5e0;
        }

        .empty-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 0.5rem;
        }

        .empty-text {
            color: #718096;
        }

        @media (max-width: 768px) {
            .page-title {
                font-size: 1.5rem;
            }

            .stats-row {
                flex-direction: column;
            }

            .tasks-grid {
                grid-template-columns: 1fr;
            }

            .table-custom {
                font-size: 0.85rem;
            }

            .table-custom thead th,
            .table-custom tbody td {
                padding: 0.75rem 1rem;
            }
        }
    </style>

    <div class="tasks-container">
        <div class="container-fluid">

            <div class="mb-4">
                <a href="{{ route('home') }}" class="btn-back">
                    <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
                </a>
            </div>

            <div class="page-header">
                <h1 class="page-title">Manajemen Tugas Saya</h1>
                <p class="page-subtitle">Kelola tugas kamu</p>
            </div>

            <div class="stats-row">
                <div class="stat-card">
                    <div class="stat-label">Sedang Berjalan</div>
                    <div class="stat-value ongoing">{{ $myTasks->where('pivot.is_completed', false)->count() }}</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Telah Selesai</div>
                    <div class="stat-value completed">{{ $myTasks->where('pivot.is_completed', true)->count() }}</div>
                </div>
            </div>

            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
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

            <div class="tab-content" id="pills-tabContent">

                <div class="tab-pane fade show active" id="pills-ongoing" role="tabpanel"
                    aria-labelledby="pills-ongoing-tab">
                    @php
                        $ongoingTasks = $myTasks->where('pivot.is_completed', false);
                    @endphp

                    @if($ongoingTasks->isEmpty())
                        <div class="empty-state"
                            style="background: #ffffff; border-radius: 16px; box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04); margin-bottom: 3rem;">
                            <svg xmlns="http://www.w3.org/2000/svg" class="empty-icon" fill="currentColor" viewBox="0 0 16 16">
                                <path
                                    d="M8.5 2.687c.654-.689 1.782-.886 3.112-.752 1.234.124 2.503.523 3.388.893v9.923c-.918-.35-2.107-.692-3.287-.81-1.094-.111-2.278-.039-3.213.492V2.687zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783z" />
                            </svg>
                            <h3 class="empty-title">Tidak Ada Tugas Berjalan</h3>
                            <p class="empty-text">Anda belum mengambil tugas apapun</p>
                        </div>
                    @else
                        <div class="tasks-grid">
                            @foreach($ongoingTasks as $task)
                                @php
                                    $deadline = \Carbon\Carbon::parse($task->deadline);
                                    $now = \Carbon\Carbon::now();
                                    $diff = $now->diffInDays($deadline, false);

                                    // LOGIKA STATUS
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
                                    {{-- LABEL STATUS --}}
                                    <div class="status-badge {{ $statusClass }}">
                                        {{ $statusLabel }}
                                    </div>

                                    <h3 class="task-title">{{ $task->judul }}</h3>
                                    <p class="task-desc">{{ Str::limit($task->deskripsi, 90) }}</p>

                                    <div class="task-deadline">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="deadline-icon" fill="currentColor"
                                            viewBox="0 0 16 16">
                                            <path
                                                d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z" />
                                            <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z" />
                                        </svg>
                                        <span class="deadline-text">{{ $deadline->format('d M Y, H:i') }}</span>
                                    </div>

                                    <div class="task-actions">
                                        <form action="{{ route('my-tasks.update', $task->id) }}" method="POST"
                                            class="confirm-finish-form" style="flex: 1;">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn-task btn-complete">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                                    viewBox="0 0 16 16">
                                                    <path
                                                        d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z" />
                                                </svg>
                                                Selesai
                                            </button>
                                        </form>
                                        <form action="{{ route('my-tasks.destroy', $task->id) }}" method="POST" class="delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-task btn-remove">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                                    viewBox="0 0 16 16">
                                                    <path
                                                        d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z" />
                                                    <path
                                                        d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="tab-pane fade" id="pills-history" role="tabpanel" aria-labelledby="pills-history-tab">
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
                                                <td class="task-name">{{ $task->judul }}</td>
                                                <td>{{ \Carbon\Carbon::parse($task->deadline)->format('d M Y') }}</td>
                                                <td>{{ \Carbon\Carbon::parse($task->pivot->updated_at)->format('d M Y, H:i') }}</td>
                                                <td>
                                                    <span class="completed-badge">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                            fill="currentColor" viewBox="0 0 16 16">
                                                            <path
                                                                d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z" />
                                                        </svg>
                                                        Selesai
                                                    </span>
                                                </td>
                                                <td style="text-align: center;">
                                                    <form action="{{ route('my-tasks.update', $task->id) }}" method="POST"
                                                        style="display: inline;">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn-table-action btn-undo"
                                                            title="Kembalikan ke aktif">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                                fill="currentColor" viewBox="0 0 16 16">
                                                                <path fill-rule="evenodd"
                                                                    d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2z" />
                                                                <path
                                                                    d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466z" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('my-tasks.destroy', $task->id) }}" method="POST"
                                                        class="delete-history-form" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="btn-table-action btn-delete btn-delete-history"
                                                            title="Hapus dari riwayat">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                                fill="currentColor" viewBox="0 0 16 16">
                                                                <path
                                                                    d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z" />
                                                                <path
                                                                    d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z" />
                                                            </svg>
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
                            <p class="empty-text">Belum ada riwayat tugas selesai.</p>
                        </div>
                    @endif
                </div>
            </div>

            <h2 class="section-title" style="margin-top: 2rem;">Tugas Tersedia</h2>

            <div class="available-tasks">
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
                        <p class="empty-text">Belum ada tugas baru dari admin</p>
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
                                        <td class="task-name">{{ $task->judul }}</td>
                                        <td>{{ Str::limit($task->deskripsi, 60) }}</td>
                                        <td>{{ \Carbon\Carbon::parse($task->deadline)->format('d M Y') }}</td>
                                        <td style="text-align: center;">
                                            <form action="{{ route('my-tasks.store') }}" method="POST" class="take-task-form">
                                                @csrf
                                                <input type="hidden" name="task_id" value="{{ $task->id }}">
                                                <button type="submit" class="btn-take">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                        fill="currentColor" viewBox="0 0 16 16">
                                                        <path
                                                            d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                                                    </svg>
                                                    Ambil Tugas
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

            // Flash message (hanya untuk session success dari controller)
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

            // Hanya konfirmasi hapus dari riwayat
            document.querySelectorAll('.btn-delete-history').forEach(button => {
                button.addEventListener('click', function (e) {
                    e.preventDefault(); // Mencegah form submit langsung
                    const form = this.closest('.delete-history-form');
                    Swal.fire({
                        title: 'Hapus dari Riwayat?',
                        text: "Data tugas ini akan dihapus dari riwayat selesai.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#e53e3e',
                        cancelButtonColor: '#718096',
                        confirmButtonText: 'Ya, Hapus',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
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
                        confirmButtonColor: '#48bb78',
                        cancelButtonColor: '#718096',
                        confirmButtonText: 'Ya, Selesai!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });

            // Konfirmasi Lepas Tugas (Opsional, agar user tidak salah klik)
            document.querySelectorAll('.btn-remove').forEach(button => {
                button.addEventListener('click', function (e) {
                    e.preventDefault();
                    const form = this.closest('.delete-form');
                    Swal.fire({
                        title: 'Lepas Tugas?',
                        text: "Anda harus mengambil ulang jika ingin mengerjakannya lagi.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#e53e3e',
                        cancelButtonColor: '#718096',
                        confirmButtonText: 'Ya, Lepas',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });

        });
    </script>

@endsection