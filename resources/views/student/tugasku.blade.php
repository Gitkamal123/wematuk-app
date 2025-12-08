@extends('layouts.master')

@section('title', 'Manajemen Tugas Saya - WeMaTuK')

@section('content')
    {{-- SweetAlert2 untuk notifikasi --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root {
            --urgent-color: #e53e3e;
            --warning-color: #ed8936;
            --normal-color: #48bb78;
            --primary-color: #4a90e2;
            --bg-light: #f8f9fa;
            --card-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            --card-shadow-hover: 0 12px 40px rgba(0, 0, 0, 0.15);
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e8f0 100%);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            min-height: 100vh;
        }

        .tasks-container {
            padding: 2rem 0;
            max-width: 1400px;
            margin: 0 auto;
        }

        /* Header dengan efek glassmorphism */
        .page-header {
            margin-bottom: 3rem;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: var(--card-shadow);
            border: 1px solid rgba(255, 255, 255, 0.2);
            animation: slideInDown 0.6s ease-out;
        }

        .page-title {
            font-size: 2.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, #1a202c 0%, #4a5568 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.5rem;
            letter-spacing: -0.5px;
        }

        .page-subtitle {
            color: #718096;
            font-size: 1.1rem;
            font-weight: 500;
        }

        /* Stats Cards dengan efek glass */
        .stats-row {
            display: flex;
            gap: 1.5rem;
            margin-bottom: 3rem;
            animation: fadeInUp 0.6s ease-out 0.2s both;
        }

        .stat-card {
            flex: 1;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: var(--card-shadow);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), var(--normal-color));
            opacity: 0;
            transition: opacity 0.4s ease;
        }

        .stat-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--card-shadow-hover);
        }

        .stat-card:hover::before {
            opacity: 1;
        }

        .stat-label {
            font-size: 0.85rem;
            color: #718096;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 0.75rem;
            font-weight: 600;
        }

        .stat-value {
            font-size: 3rem;
            font-weight: 800;
            line-height: 1;
        }

        .stat-value.ongoing {
            background: linear-gradient(135deg, var(--primary-color), #63b3ed);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .stat-value.completed {
            background: linear-gradient(135deg, var(--normal-color), #68d391);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Section Title */
        .section-title {
            font-size: 1.8rem;
            font-weight: 800;
            color: #1a202c;
            margin-bottom: 2rem;
            padding-left: 1rem;
            position: relative;
            animation: fadeInUp 0.6s ease-out 0.3s both;
        }

        .section-title::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 6px;
            height: 24px;
            background: linear-gradient(135deg, var(--primary-color), #63b3ed);
            border-radius: 3px;
        }

        /* Task Grid dengan stagger animation */
        .tasks-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 2rem;
            margin-bottom: 4rem;
        }

        /* Task Card dengan efek glassmorphism */
        .task-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: var(--card-shadow);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            animation: fadeInUp 0.6s ease-out;
            animation-fill-mode: both;
        }

        .task-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            transition: all 0.4s ease;
        }

        .task-card.urgent::before {
            background: linear-gradient(90deg, var(--urgent-color), #fc8181);
        }

        .task-card.warning::before {
            background: linear-gradient(90deg, var(--warning-color), #f6ad55);
        }

        .task-card.normal::before {
            background: linear-gradient(90deg, var(--normal-color), #68d391);
        }

        .task-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: var(--card-shadow-hover);
        }

        .task-card:hover::before {
            height: 6px;
            filter: brightness(1.2);
        }

        /* Status Badge dengan animasi */
        .status-badge {
            display: inline-block;
            padding: 0.5rem 1.25rem;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            animation: badgePulse 2s infinite;
        }

        .status-badge::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.6s ease;
        }

        .task-card:hover .status-badge::before {
            left: 100%;
        }

        .status-badge.urgent {
            background: linear-gradient(135deg, #fed7d7, #fc8181);
            color: #9b2c2c;
            box-shadow: 0 4px 15px rgba(229, 62, 62, 0.2);
        }

        .status-badge.warning {
            background: linear-gradient(135deg, #feebc8, #f6ad55);
            color: #744210;
            box-shadow: 0 4px 15px rgba(237, 137, 54, 0.2);
        }

        .status-badge.normal {
            background: linear-gradient(135deg, #c6f6d5, #68d391);
            color: #22543d;
            box-shadow: 0 4px 15px rgba(72, 187, 120, 0.2);
        }

        @keyframes badgePulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }
        }

        .task-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: #1a202c;
            margin-bottom: 1rem;
            line-height: 1.4;
            transition: color 0.3s ease;
        }

        .task-card:hover .task-title {
            color: var(--primary-color);
        }

        .task-desc {
            color: #718096;
            font-size: 0.95rem;
            margin-bottom: 1.5rem;
            line-height: 1.6;
        }

        /* Deadline dengan efek glow */
        .task-deadline {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 1rem;
            background: linear-gradient(135deg, rgba(247, 250, 252, 0.8), rgba(226, 232, 240, 0.8));
            border-radius: 12px;
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .task-card:hover .task-deadline {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.9), rgba(247, 250, 252, 0.9));
            transform: translateX(5px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .deadline-icon {
            width: 20px;
            height: 20px;
            flex-shrink: 0;
            transition: transform 0.3s ease;
        }

        .task-card:hover .deadline-icon {
            transform: rotate(15deg);
        }

        .deadline-text {
            font-size: 0.95rem;
            font-weight: 600;
            color: #2d3748;
            font-feature-settings: "tnum";
        }

        /* Task Actions dengan efek hover */
        .task-actions {
            display: flex;
            gap: 0.75rem;
            margin-top: 1rem;
        }

        .btn-task {
            flex: 1;
            padding: 0.875rem;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
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
            background: rgba(255, 255, 255, 0.2);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .btn-task:hover::before {
            width: 300px;
            height: 300px;
        }

        .btn-complete {
            background: linear-gradient(135deg, var(--normal-color), #38a169);
            color: #ffffff;
            box-shadow: 0 4px 15px rgba(72, 187, 120, 0.3);
        }

        .btn-complete:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(72, 187, 120, 0.4);
        }

        .btn-remove {
            background: linear-gradient(135deg, #f7fafc, #e2e8f0);
            color: #718096;
            width: 50px;
            padding: 0;
            box-shadow: 0 4px 15px rgba(113, 128, 150, 0.1);
        }

        .btn-remove:hover {
            background: linear-gradient(135deg, var(--urgent-color), #c53030);
            color: #ffffff;
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(229, 62, 62, 0.4);
        }

        /* Completed Section dengan efek glass */
        .completed-table {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: var(--card-shadow);
            overflow: hidden;
            margin-bottom: 4rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
            animation: fadeInUp 0.6s ease-out 0.4s both;
        }

        .table-responsive {
            overflow-x: auto;
            border-radius: 20px;
        }

        .table-custom {
            width: 100%;
            border-collapse: collapse;
        }

        .table-custom thead th {
            padding: 1.5rem;
            background: linear-gradient(135deg, rgba(247, 250, 252, 0.9), rgba(226, 232, 240, 0.9));
            font-size: 0.85rem;
            font-weight: 700;
            color: #4a5568;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid rgba(226, 232, 240, 0.5);
            position: sticky;
            top: 0;
            backdrop-filter: blur(10px);
        }

        .table-custom tbody tr {
            transition: all 0.3s ease;
            border-bottom: 1px solid rgba(226, 232, 240, 0.3);
        }

        .table-custom tbody tr:hover {
            background: rgba(247, 250, 252, 0.7);
            transform: translateX(5px);
        }

        .table-custom tbody td {
            padding: 1.5rem;
            color: #2d3748;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .table-custom tbody tr:hover td {
            color: #1a202c;
        }

        .task-name {
            font-weight: 600;
            color: #1a202c;
            font-size: 1rem;
        }

        .completed-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            background: linear-gradient(135deg, rgba(72, 187, 120, 0.1), rgba(56, 161, 105, 0.1));
            color: var(--normal-color);
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 700;
        }

        /* Table Action Buttons */
        .btn-table-action {
            width: 40px;
            height: 40px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .btn-table-action::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .btn-table-action:hover::before {
            width: 200px;
            height: 200px;
        }

        .btn-undo {
            background: linear-gradient(135deg, rgba(237, 137, 54, 0.1), rgba(214, 158, 46, 0.1));
            color: var(--warning-color);
        }

        .btn-undo:hover {
            background: linear-gradient(135deg, var(--warning-color), #d69e2e);
            color: #ffffff;
            transform: translateY(-3px);
            box-shadow: 0 4px 15px rgba(237, 137, 54, 0.3);
        }

        .btn-delete {
            background: linear-gradient(135deg, rgba(229, 62, 62, 0.1), rgba(197, 48, 48, 0.1));
            color: var(--urgent-color);
            margin-left: 0.5rem;
        }

        .btn-delete:hover {
            background: linear-gradient(135deg, var(--urgent-color), #c53030);
            color: #ffffff;
            transform: translateY(-3px);
            box-shadow: 0 4px 15px rgba(229, 62, 62, 0.3);
        }

        /* Available Tasks dengan efek glass */
        .available-tasks {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: var(--card-shadow);
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.2);
            animation: fadeInUp 0.6s ease-out 0.5s both;
        }

        .available-header {
            padding: 1.75rem 2rem;
            background: linear-gradient(135deg, rgba(74, 144, 226, 0.1), rgba(99, 179, 237, 0.1));
            border-bottom: 1px solid rgba(74, 144, 226, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .available-title {
            font-size: 1.4rem;
            font-weight: 700;
            color: #1a202c;
            margin: 0;
        }

        .count-badge {
            padding: 0.5rem 1.25rem;
            background: linear-gradient(135deg, var(--primary-color), #63b3ed);
            color: #ffffff;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 700;
            box-shadow: 0 4px 15px rgba(74, 144, 226, 0.3);
            animation: pulse 2s infinite;
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

        .btn-take {
            padding: 0.625rem 1.5rem;
            background: linear-gradient(135deg, var(--primary-color), #63b3ed);
            color: #ffffff;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            position: relative;
            overflow: hidden;
        }

        .btn-take::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .btn-take:hover::before {
            width: 200px;
            height: 200px;
        }

        .btn-take:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(74, 144, 226, 0.4);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            margin: 2rem 0;
        }

        .empty-icon {
            width: 100px;
            height: 100px;
            margin: 0 auto 1.5rem;
            color: #cbd5e0;
            opacity: 0.7;
        }

        .empty-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 0.75rem;
        }

        .empty-text {
            color: #718096;
            font-size: 1rem;
            max-width: 400px;
            margin: 0 auto;
        }

        /* Animations */
        @keyframes slideInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
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

        /* Stagger animation untuk task cards */
        .task-card {
            animation-delay: calc(var(--card-index) * 0.1s);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .page-title {
                font-size: 2rem;
            }

            .stats-row {
                flex-direction: column;
            }

            .stat-card {
                padding: 1.5rem;
            }

            .stat-value {
                font-size: 2.5rem;
            }

            .tasks-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }

            .section-title {
                font-size: 1.5rem;
            }

            .table-custom thead th,
            .table-custom tbody td {
                padding: 1rem;
                font-size: 0.85rem;
            }

            .btn-table-action {
                width: 36px;
                height: 36px;
            }
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(247, 250, 252, 0.5);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, var(--primary-color), #63b3ed);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #3182ce, #4299e1);
        }
    </style>

    <div class="tasks-container">
        <div class="container-fluid">

            <!-- Header -->
            <div class="page-header">
                <h1 class="page-title">Manajemen Tugas Saya</h1>
                <p class="page-subtitle">Kelola dan pantau progress tugas Anda</p>
            </div>

            <!-- Stats -->
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

            <!-- Ongoing Tasks -->
            @php
                $ongoingTasks = $myTasks->where('pivot.is_completed', false);
            @endphp

            <h2 class="section-title">Tugas Berjalan</h2>

            @if($ongoingTasks->isEmpty())
                <div class="empty-state" style="margin-bottom: 3rem;">
                    <svg xmlns="http://www.w3.org/2000/svg" class="empty-icon" fill="currentColor" viewBox="0 0 16 16">
                        <path
                            d="M8.5 2.687c.654-.689 1.782-.886 3.112-.752 1.234.124 2.503.523 3.388.893v9.923c-.918-.35-2.107-.692-3.287-.81-1.094-.111-2.278-.039-3.213.492V2.687zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783z" />
                    </svg>
                    <h3 class="empty-title">Tidak Ada Tugas Berjalan</h3>
                    <p class="empty-text">Ambil tugas baru dari bagian "Tugas Tersedia" untuk memulai</p>
                </div>
            @else
                <div class="tasks-grid">
                    @foreach($ongoingTasks as $index => $task)
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

                        <div class="task-card {{ $statusClass }}" style="--card-index: {{ $index % 10 }};">
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

            <!-- Completed Tasks -->
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

            <!-- Available Tasks -->
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
            // Flash message
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: "{{ session('success') }}",
                    timer: 3000,
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end',
                    background: 'linear-gradient(135deg, #48bb78 0%, #38a169 100%)',
                    color: '#ffffff'
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
                        cancelButtonText: 'Batal',
                        background: 'rgba(255, 255, 255, 0.95)',
                        backdrop: 'rgba(0, 0, 0, 0.4)',
                        showClass: {
                            popup: 'animate__animated animate__fadeInDown'
                        },
                        hideClass: {
                            popup: 'animate__animated animate__fadeOutUp'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });

            // Konfirmasi Selesai dengan efek hover
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
                        cancelButtonText: 'Batal',
                        background: 'rgba(255, 255, 255, 0.95)',
                        backdrop: 'rgba(0, 0, 0, 0.4)',
                        showClass: {
                            popup: 'animate__animated animate__fadeInDown'
                        },
                        hideClass: {
                            popup: 'animate__animated animate__fadeOutUp'
                        }
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
                        cancelButtonText: 'Batal',
                        background: 'rgba(255, 255, 255, 0.95)',
                        backdrop: 'rgba(0, 0, 0, 0.4)',
                        showClass: {
                            popup: 'animate__animated animate__fadeInDown'
                        },
                        hideClass: {
                            popup: 'animate__animated animate__fadeOutUp'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });

            // Efek hover untuk card dengan delay staggered
            const taskCards = document.querySelectorAll('.task-card');
            taskCards.forEach((card, index) => {
                card.style.animationDelay = `${index * 0.1}s`;

                // Efek glow saat hover
                card.addEventListener('mouseenter', () => {
                    card.style.transform = 'translateY(-8px) scale(1.02)';
                    card.style.boxShadow = '0 20px 60px rgba(0, 0, 0, 0.2)';
                });

                card.addEventListener('mouseleave', () => {
                    card.style.transform = 'translateY(0) scale(1)';
                    card.style.boxShadow = 'var(--card-shadow)';
                });
            });

            // Efek ripple untuk semua tombol
            const buttons = document.querySelectorAll('.btn-task, .btn-take, .btn-table-action');
            buttons.forEach(button => {
                button.addEventListener('click', function (e) {
                    const rect = this.getBoundingClientRect();
                    const x = e.clientX - rect.left;
                    const y = e.clientY - rect.top;

                    const ripple = document.createElement('span');
                    ripple.style.left = x + 'px';
                    ripple.style.top = y + 'px';
                    ripple.classList.add('ripple');

                    this.appendChild(ripple);

                    setTimeout(() => {
                        ripple.remove();
                    }, 600);
                });
            });

            // Tambah style untuk ripple effect
            const style = document.createElement('style');
            style.textContent = `
                    .ripple {
                        position: absolute;
                        border-radius: 50%;
                        background: rgba(255, 255, 255, 0.6);
                        transform: scale(0);
                        animation: ripple-animation 0.6s linear;
                        pointer-events: none;
                    }

                    @keyframes ripple-animation {
                        to {
                            transform: scale(4);
                            opacity: 0;
                        }
                    }
                `;
            document.head.appendChild(style);
        });
    </script>

@endsection