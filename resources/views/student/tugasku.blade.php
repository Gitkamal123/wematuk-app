@extends('layouts.master')

@section('title', 'Manajemen Tugas Saya - WeMaTuK')

@section('content')
    {{-- SweetAlert2 untuk notifikasi --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .tasks-container {
            padding: 2rem 0;
            max-width: 1400px;
            margin: 0 auto;
        }

        /* Header dengan animasi */
        .page-header {
            margin-bottom: 2.5rem;
            animation: fadeInDown 0.6s ease-out;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .page-title {
            font-size: 2.5rem;
            font-weight: 800;
            color: #ffffff;
            margin-bottom: 0.5rem;
            text-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .page-subtitle {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1.1rem;
            font-weight: 400;
        }

        /* Stats Cards dengan efek hover */
        .stats-row {
            display: flex;
            gap: 1.5rem;
            margin-bottom: 2.5rem;
            animation: fadeInUp 0.6s ease-out 0.2s both;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .stat-card {
            flex: 1;
            background: #ffffff;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.4s ease;
        }

        .stat-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .stat-card:hover::before {
            transform: scaleX(1);
        }

        .stat-label {
            font-size: 0.9rem;
            color: #718096;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 0.75rem;
            font-weight: 600;
        }

        .stat-value {
            font-size: 2.5rem;
            font-weight: 800;
            transition: transform 0.3s ease;
        }

        .stat-card:hover .stat-value {
            transform: scale(1.1);
        }

        .stat-value.ongoing {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .stat-value.completed {
            background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Section Title */
        .section-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 1.5rem;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            animation: fadeInUp 0.6s ease-out 0.3s both;
        }

        /* Task Grid dengan animasi stagger */
        .tasks-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
            gap: 1.5rem;
            margin-bottom: 3rem;
        }

        .tasks-grid .task-card {
            animation: fadeInUp 0.6s ease-out both;
        }

        .tasks-grid .task-card:nth-child(1) {
            animation-delay: 0.4s;
        }

        .tasks-grid .task-card:nth-child(2) {
            animation-delay: 0.5s;
        }

        .tasks-grid .task-card:nth-child(3) {
            animation-delay: 0.6s;
        }

        .tasks-grid .task-card:nth-child(4) {
            animation-delay: 0.7s;
        }

        .tasks-grid .task-card:nth-child(5) {
            animation-delay: 0.8s;
        }

        .tasks-grid .task-card:nth-child(6) {
            animation-delay: 0.9s;
        }

        /* Task Card dengan efek hover premium */
        .task-card {
            background: #ffffff;
            border-radius: 20px;
            padding: 1.75rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border-left: 5px solid;
            position: relative;
            overflow: hidden;
        }

        .task-card::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg,
                    transparent,
                    rgba(255, 255, 255, 0.1),
                    transparent);
            transform: rotate(45deg);
            transition: all 0.5s ease;
        }

        .task-card:hover::after {
            left: 100%;
        }

        /* Warna Border Status */
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
            transform: translateY(-12px) scale(1.02);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
        }

        .task-title {
            font-size: 1.2rem;
            font-weight: 700;
            color: #1a202c;
            margin-bottom: 0.75rem;
            line-height: 1.4;
            transition: color 0.3s ease;
        }

        .task-card:hover .task-title {
            color: #667eea;
        }

        .task-desc {
            color: #718096;
            font-size: 0.95rem;
            margin-bottom: 1.25rem;
            line-height: 1.6;
        }

        .task-deadline {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.85rem;
            background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);
            border-radius: 12px;
            margin-bottom: 1.25rem;
            transition: all 0.3s ease;
        }

        .task-card:hover .task-deadline {
            background: linear-gradient(135deg, #edf2f7 0%, #e2e8f0 100%);
            transform: translateX(5px);
        }

        .deadline-icon {
            width: 20px;
            height: 20px;
            flex-shrink: 0;
            transition: transform 0.3s ease;
        }

        .task-card:hover .deadline-icon {
            transform: rotate(360deg);
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
            font-size: 0.95rem;
            font-weight: 600;
            color: #2d3748;
        }

        /* Status Badge dengan animasi */
        .status-badge {
            display: inline-block;
            padding: 0.4rem 1rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            margin-bottom: 1rem;
            letter-spacing: 0.5px;
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }
        }

        .status-badge.urgent {
            background: linear-gradient(135deg, #fc8181 0%, #e53e3e 100%);
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(229, 62, 62, 0.3);
        }

        .status-badge.warning {
            background: linear-gradient(135deg, #f6ad55 0%, #ed8936 100%);
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(237, 137, 54, 0.3);
        }

        .status-badge.normal {
            background: linear-gradient(135deg, #68d391 0%, #38a169 100%);
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(72, 187, 120, 0.3);
        }

        /* Task Actions dengan efek hover */
        .task-actions {
            display: flex;
            gap: 0.75rem;
        }

        .btn-task {
            flex: 1;
            padding: 0.85rem;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            position: relative;
            overflow: hidden;
        }

        .btn-task::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: translate(-50%, -50%);
            transition: width 0.6s ease, height 0.6s ease;
        }

        .btn-task:hover::before {
            width: 300px;
            height: 300px;
        }

        .btn-complete {
            background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
            color: #ffffff;
            box-shadow: 0 4px 15px rgba(72, 187, 120, 0.3);
        }

        .btn-complete:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(72, 187, 120, 0.4);
        }

        .btn-remove {
            background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);
            color: #718096;
            width: 50px;
            padding: 0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .btn-remove:hover {
            background: linear-gradient(135deg, #e53e3e 0%, #c53030 100%);
            color: #ffffff;
            transform: translateY(-3px) rotate(10deg);
            box-shadow: 0 8px 20px rgba(229, 62, 62, 0.3);
        }

        /* Completed Section & Tables */
        .completed-table {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            margin-bottom: 3rem;
            animation: fadeInUp 0.6s ease-out 0.5s both;
        }

        .table-custom {
            width: 100%;
        }

        .table-custom thead th {
            padding: 1.25rem 1.75rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            font-size: 0.9rem;
            font-weight: 700;
            color: #ffffff;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            border: none;
        }

        .table-custom tbody td {
            padding: 1.5rem 1.75rem;
            border-bottom: 1px solid #f7fafc;
            color: #2d3748;
            transition: all 0.3s ease;
        }

        .table-custom tbody tr {
            transition: all 0.3s ease;
        }

        .table-custom tbody tr:hover {
            background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);
            transform: scale(1.01);
        }

        .task-name {
            font-weight: 700;
            color: #1a202c;
        }

        .completed-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            background: linear-gradient(135deg, #68d391 0%, #48bb78 100%);
            color: #ffffff;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(72, 187, 120, 0.2);
        }

        .btn-table-action {
            width: 40px;
            height: 40px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-undo {
            background: linear-gradient(135deg, #f6ad55 0%, #ed8936 100%);
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(237, 137, 54, 0.2);
        }

        .btn-undo:hover {
            transform: translateY(-4px) rotate(-15deg);
            box-shadow: 0 8px 20px rgba(237, 137, 54, 0.3);
        }

        .btn-delete {
            background: linear-gradient(135deg, #fc8181 0%, #e53e3e 100%);
            color: #ffffff;
            margin-left: 0.5rem;
            box-shadow: 0 4px 12px rgba(229, 62, 62, 0.2);
        }

        .btn-delete:hover {
            transform: translateY(-4px) rotate(15deg);
            box-shadow: 0 8px 20px rgba(229, 62, 62, 0.3);
        }

        /* Available Tasks */
        .available-tasks {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            animation: fadeInUp 0.6s ease-out 0.6s both;
        }

        .available-header {
            padding: 1.75rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .available-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #ffffff;
            margin: 0;
        }

        .count-badge {
            padding: 0.6rem 1.25rem;
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(10px);
            color: #ffffff;
            border-radius: 50px;
            font-size: 0.9rem;
            font-weight: 700;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .btn-take {
            padding: 0.65rem 1.5rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #ffffff;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .btn-take:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            animation: fadeIn 0.8s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .empty-icon {
            width: 100px;
            height: 100px;
            margin: 0 auto 1.5rem;
            color: #cbd5e0;
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .empty-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 0.75rem;
        }

        .empty-text {
            color: #718096;
            font-size: 1rem;
        }

        @media (max-width: 768px) {
            .page-title {
                font-size: 1.75rem;
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
                padding: 1rem 1.25rem;
            }
        }

        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
        }
    </style>

    <div class="tasks-container">
        <div class="container-fluid">

            <div class="page-header">
                <h1 class="page-title">Manajemen Tugas Saya</h1>
                <p class="page-subtitle">Kelola dan pantau progress tugas Anda dengan mudah</p>
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

            @php
                $ongoingTasks = $myTasks->where('pivot.is_completed', false);
            @endphp

            <h2 class="section-title">Tugas Berjalan</h2>

            @if($ongoingTasks->isEmpty())
                <div class="empty-state"
                    style="background: #ffffff; border-radius: 20px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08); margin-bottom: 3rem;">
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
                            <div class="status-badge {{ $statusClass }}">
                                {{ $statusLabel }}
                            </div>

                            <h3 class="task-title">{{ $task->judul }}</h3>
                            <p class="task-desc">{{ Str::limit($task->deskripsi, 90) }}</p>

                            <div class="task-deadline">
                                <svg xmlns="http://www.w3.org/2000/svg" class="deadline-icon" fill="currentColor"
                                    viewBox="0 0 16 16">
                                    <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z" />
                                    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z" />
                                </svg>
                                <span class="deadline-text">{{ $deadline->format('d M Y, H:i') }}</span>
                            </div>

                            <div class="task-actions">
                                <form action="{{ route('my-tasks.update', $task->id) }}" method="POST" class="confirm-finish-form"
                                    style="flex: 1;">
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

            @php
                $completedTasks = $myTasks->where('pivot.is_completed', true);
            @endphp

            @if($completedTasks->isNotEmpty())
                <h2 class="section-title">Riwayat Selesai</h2>

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
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor"
                                                    viewBox="0 0 16 16">
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
                                                <button type="submit" class="btn-table-action btn-undo" title="Kembalikan ke aktif">
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
            @endif

            <h2 class="section-title">Tugas Tersedia</h2>

            <div class="available-tasks">
                <div class="available-header">
                    <h3 class="available-title">Ambil Tugas Baru</h3>
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
                    e.preventDefault();
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

            // Konfirmasi Lepas Tugas
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