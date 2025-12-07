@extends('layouts.master')

@section('content')
    <div class="container-fluid px-lg-4 px-xl-5">

        {{-- Tombol Kembali --}}
        <div class="mb-4 mt-3">
            <a href="{{ route('home') }}" class="btn btn-outline-primary shadow-sm px-4">
                <i class="fas fa-arrow-left me-2"></i> Kembali ke Dashboard
            </a>
        </div>

        {{-- Hero Header --}}
        <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between mb-5">
            <div class="mb-4 mb-md-0">
                <h1 class="h2 fw-bold text-gradient-primary mb-2">Manajemen Tugas Saya</h1>
                <p class="text-muted mb-0">
                    <i class="fas fa-tasks me-2"></i>Kelola tugas yang sedang Anda kerjakan dan ambil tugas baru
                </p>
            </div>
            <div class="d-flex align-items-center">
                <span class="badge bg-primary bg-opacity-10 text-primary fw-semibold py-2 px-3 me-3">
                    <i class="fas fa-clock me-1"></i>
                    {{ $myTasks->where('pivot.is_completed', false)->count() }} Berjalan
                </span>
                <span class="badge bg-success bg-opacity-10 text-success fw-semibold py-2 px-3 me-3">
                    <i class="fas fa-check-circle me-1"></i>
                    {{ $completedTasks->count() }} Selesai
                </span>
                <span class="badge bg-info bg-opacity-10 text-info fw-semibold py-2 px-3">
                    <i class="fas fa-inbox me-1"></i>
                    {{ $availableTasks->count() }} Tersedia
                </span>
            </div>
        </div>

        {{-- Success Alert --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-5" role="alert">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle fa-lg"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="alert-heading mb-1">Berhasil!</h6>
                        <p class="mb-0">{{ session('success') }}</p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif

        {{-- Deadline Status Cards --}}
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card border-left-success shadow-sm h-100 py-3">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-check-circle fa-2x text-success"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="fw-bold mb-0">{{ $activeTasksCount }}</h5>
                                <p class="text-muted mb-0">Aktif (>3 hari)</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-left-warning shadow-sm h-100 py-3">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-triangle fa-2x text-warning"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="fw-bold mb-0">{{ $nearDeadlineTasksCount }}</h5>
                                <p class="text-muted mb-0">Mendekati Deadline</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-left-danger shadow-sm h-100 py-3">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-clock fa-2x text-danger"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="fw-bold mb-0">{{ $overdueTasksCount }}</h5>
                                <p class="text-muted mb-0">Lewat Deadline</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tabs Navigation --}}
        <ul class="nav nav-tabs mb-4" id="tasksTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="ongoing-tab" data-bs-toggle="tab" data-bs-target="#ongoing" type="button" role="tab">
                    <i class="fas fa-spinner me-2"></i>Tugas Berjalan
                    <span class="badge bg-warning ms-2">{{ $myTasks->where('pivot.is_completed', false)->count() }}</span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="completed-tab" data-bs-toggle="tab" data-bs-target="#completed" type="button" role="tab">
                    <i class="fas fa-check-circle me-2"></i>Riwayat Selesai
                    <span class="badge bg-success ms-2">{{ $completedTasks->count() }}</span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="available-tab" data-bs-toggle="tab" data-bs-target="#available" type="button" role="tab">
                    <i class="fas fa-bolt me-2"></i>Tugas Tersedia
                    <span class="badge bg-info ms-2">{{ $availableTasks->count() }}</span>
                </button>
            </li>
        </ul>

        <div class="tab-content" id="tasksTabContent">
            
            {{-- Tab 1: Tugas Berjalan --}}
            <div class="tab-pane fade show active" id="ongoing" role="tabpanel">
                <div class="card border-0 shadow-lg overflow-hidden">
                    <div class="card-header bg-gradient-warning py-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="mb-0 text-white fw-bold">
                                    <i class="fas fa-spinner me-2"></i>Tugas yang Sedang Berjalan
                                </h4>
                                <p class="mb-0 text-white-50 mt-1">Tugas yang sedang dalam pengerjaan</p>
                            </div>
                            <div class="text-white">
                                <span class="badge bg-white bg-opacity-25 text-white py-2 px-3">
                                    {{ $myTasks->where('pivot.is_completed', false)->count() }} Tugas
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="card-body bg-light-gradient p-4">
                        @if($myTasks->where('pivot.is_completed', false)->isEmpty())
                            <div class="text-center py-6">
                                <div class="mb-4">
                                    <i class="fas fa-clipboard-list fa-4x text-gray-300"></i>
                                </div>
                                <h4 class="text-gray-500 mb-2">Belum ada tugas yang berjalan</h4>
                                <p class="text-muted mb-4">Ambil tugas baru dari tab "Tugas Tersedia"</p>
                            </div>
                        @else
                            <div class="row g-4">
                                @foreach($myTasks->where('pivot.is_completed', false) as $task)
                                    @php
                                        $daysUntilDeadline = \Carbon\Carbon::parse($task->deadline)->diffInDays(now(), false);
                                        $deadlineStatus = 'aktif';
                                        if ($daysUntilDeadline > 0) {
                                            $deadlineStatus = 'lewat';
                                        } elseif ($daysUntilDeadline >= -3) {
                                            $deadlineStatus = 'mendekati';
                                        }
                                    @endphp
                                    
                                    <div class="col-xl-4 col-lg-6">
                                        <div class="card border-0 shadow-sm h-100 task-card hover-lift">
                                            <div class="card-body p-4 position-relative">
                                                {{-- Deadline Status Ribbon --}}
                                                <div class="deadline-ribbon deadline-{{ $deadlineStatus }}">
                                                    <i class="fas fa-{{ $deadlineStatus == 'lewat' ? 'clock' : ($deadlineStatus == 'mendekati' ? 'exclamation-triangle' : 'check-circle') }} me-1"></i>
                                                    {{ $deadlineStatus == 'lewat' ? 'Lewat' : ($deadlineStatus == 'mendekati' ? 'Mendekati' : 'Aktif') }}
                                                </div>

                                                {{-- Task Title --}}
                                                <h5 class="fw-bold text-dark mb-2">{{ $task->judul_tugas }}</h5>

                                                {{-- Task Description --}}
                                                <p class="text-muted mb-3">
                                                    {{ Str::limit($task->deskripsi, 80) }}
                                                </p>

                                                {{-- Deadline & Progress --}}
                                                <div class="mb-4">
                                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                                        <small class="text-muted">Deadline</small>
                                                        <small class="fw-semibold {{ $deadlineStatus == 'lewat' ? 'text-danger' : ($deadlineStatus == 'mendekati' ? 'text-warning' : 'text-success') }}">
                                                            {{ date('d M Y', strtotime($task->deadline)) }}
                                                        </small>
                                                    </div>
                                                    <div class="progress" style="height: 8px;">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated 
                                                            {{ $deadlineStatus == 'lewat' ? 'bg-danger' : ($deadlineStatus == 'mendekati' ? 'bg-warning' : 'bg-success') }}" 
                                                            role="progressbar" 
                                                            style="width: {{ $task->progress ?? '50' }}%">
                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- Time Info --}}
                                                <div class="d-flex justify-content-between mb-3">
                                                    <div>
                                                        <small class="text-muted d-block">Sisa Waktu</small>
                                                        <span class="fw-semibold {{ $deadlineStatus == 'lewat' ? 'text-danger' : ($deadlineStatus == 'mendekati' ? 'text-warning' : 'text-success') }}">
                                                            @if($daysUntilDeadline > 0)
                                                                {{ abs($daysUntilDeadline) }} hari lewat
                                                            @else
                                                                {{ abs($daysUntilDeadline) }} hari lagi
                                                            @endif
                                                        </span>
                                                    </div>
                                                    <div class="text-end">
                                                        <small class="text-muted d-block">Progress</small>
                                                        <span class="fw-semibold">{{ $task->progress ?? '50' }}%</span>
                                                    </div>
                                                </div>

                                                {{-- Action Buttons --}}
                                                <div class="d-flex gap-2">
                                                    <button class="btn btn-success flex-grow-1 complete-task-btn"
                                                        data-task-id="{{ $task->id }}"
                                                        data-task-title="{{ $task->judul_tugas }}">
                                                        <i class="fas fa-check me-1"></i>Tandai Selesai
                                                    </button>
                                                    <button class="btn btn-outline-primary view-detail-btn"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#detailModal{{ $task->id }}">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <div class="dropdown">
                                                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" 
                                                            data-bs-toggle="dropdown">
                                                            <i class="fas fa-ellipsis-v"></i>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end">
                                                            <li>
                                                                <button class="dropdown-item text-danger delete-task-btn"
                                                                    data-task-id="{{ $task->id }}"
                                                                    data-task-title="{{ $task->judul_tugas }}">
                                                                    <i class="fas fa-trash me-2"></i>Lepas Tugas
                                                                </button>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Detail Modal --}}
                                    <div class="modal fade" id="detailModal{{ $task->id }}" tabindex="-1">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">{{ $task->judul_tugas }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-8">
                                                            <p><strong>Deskripsi:</strong></p>
                                                            <p class="text-muted">{{ $task->deskripsi }}</p>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="card bg-light">
                                                                <div class="card-body">
                                                                    <p><strong>Deadline:</strong><br>
                                                                        {{ date('d M Y H:i', strtotime($task->deadline)) }}</p>
                                                                    <p><strong>Status Deadline:</strong><br>
                                                                        <span class="badge {{ $deadlineStatus == 'lewat' ? 'bg-danger' : ($deadlineStatus == 'mendekati' ? 'bg-warning' : 'bg-success') }}">
                                                                            {{ $deadlineStatus == 'lewat' ? 'Lewat' : ($deadlineStatus == 'mendekati' ? 'Mendekati' : 'Aktif') }}
                                                                        </span>
                                                                    </p>
                                                                    <p><strong>Sisa Waktu:</strong><br>
                                                                        @if($daysUntilDeadline > 0)
                                                                            {{ abs($daysUntilDeadline) }} hari lewat
                                                                        @else
                                                                            {{ abs($daysUntilDeadline) }} hari lagi
                                                                        @endif
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Tab 2: Riwayat Tugas Selesai --}}
            <div class="tab-pane fade" id="completed" role="tabpanel">
                <div class="card border-0 shadow-lg overflow-hidden">
                    <div class="card-header bg-gradient-success py-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="mb-0 text-white fw-bold">
                                    <i class="fas fa-history me-2"></i>Riwayat Tugas Selesai
                                </h4>
                                <p class="mb-0 text-white-50 mt-1">Tugas yang telah Anda selesaikan</p>
                            </div>
                            <div class="text-white">
                                <span class="badge bg-white bg-opacity-25 text-white py-2 px-3">
                                    {{ $completedTasks->count() }} Tugas
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        @if($completedTasks->isEmpty())
                            <div class="text-center py-6">
                                <div class="mb-4">
                                    <i class="fas fa-history fa-4x text-gray-300"></i>
                                </div>
                                <h4 class="text-gray-500 mb-2">Belum ada tugas yang selesai</h4>
                                <p class="text-muted">Selesaikan tugas dari tab "Tugas Berjalan" untuk melihat riwayat di sini</p>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0" id="completedTasksTable">
                                    <thead class="table-success">
                                        <tr>
                                            <th class="ps-4" width="25%">
                                                <i class="fas fa-heading me-2"></i>Judul Tugas
                                            </th>
                                            <th width="35%">
                                                <i class="fas fa-align-left me-2"></i>Deskripsi
                                            </th>
                                            <th width="20%">
                                                <i class="fas fa-calendar-check me-2"></i>Diselesaikan
                                            </th>
                                            <th class="text-center" width="20%">
                                                <i class="fas fa-cogs me-2"></i>Aksi
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($completedTasks as $index => $task)
                                            <tr class="{{ $index % 2 == 0 ? 'table-row-even' : 'table-row-odd' }} hover-lift">
                                                <td class="ps-4">
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar-sm bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center me-3">
                                                            <i class="fas fa-check"></i>
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-0 fw-semibold">{{ $task->judul_tugas }}</h6>
                                                            <small class="text-muted">Deadline: {{ date('d M Y', strtotime($task->deadline)) }}</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <p class="mb-0 text-muted">{{ Str::limit($task->deskripsi, 100) }}</p>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <i class="fas fa-clock text-success me-2"></i>
                                                        </div>
                                                        <div>
                                                            <div class="fw-semibold">{{ date('d M Y', strtotime($task->pivot->updated_at)) }}</div>
                                                            <small class="text-muted">{{ \Carbon\Carbon::parse($task->pivot->updated_at)->diffForHumans() }}</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <div class="btn-group">
                                                        <button class="btn btn-sm btn-outline-success view-completed-detail-btn"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#completedDetailModal{{ $task->id }}">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-outline-danger delete-history-btn"
                                                            data-task-id="{{ $task->id }}"
                                                            data-task-title="{{ $task->judul_tugas }}">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>

                                            {{-- Completed Detail Modal --}}
                                            <div class="modal fade" id="completedDetailModal{{ $task->id }}" tabindex="-1">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">{{ $task->judul_tugas }}</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p><strong>Deskripsi:</strong></p>
                                                            <p class="text-muted">{{ $task->deskripsi }}</p>
                                                            <hr>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <p><strong>Deadline:</strong><br>
                                                                        {{ date('d M Y', strtotime($task->deadline)) }}</p>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <p><strong>Diselesaikan:</strong><br>
                                                                        {{ date('d M Y H:i', strtotime($task->pivot->updated_at)) }}</p>
                                                                </div>
                                                            </div>
                                                            <hr>
                                                            <p class="text-success"><i class="fas fa-check-circle me-2"></i>Tugas ini telah berhasil diselesaikan</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Tab 3: Tugas Tersedia --}}
            <div class="tab-pane fade" id="available" role="tabpanel">
                <div class="card border-0 shadow-lg">
                    <div class="card-header bg-gradient-info py-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="mb-0 text-white fw-bold">
                                    <i class="fas fa-bolt me-2"></i>Tugas Baru Tersedia
                                </h4>
                                <p class="mb-0 text-white-50 mt-1">Tugas yang dapat Anda ambil dari admin</p>
                            </div>
                            <div class="">
                                <span class="badge bg-white bg-opacity-25 text-white py-2 px-3">
                                    {{ $availableTasks->count() }} Tugas Tersedia
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        @if($availableTasks->isEmpty())
                            <div class="text-center py-5">
                                <div class="mb-4">
                                    <i class="fas fa-inbox fa-4x text-gray-300"></i>
                                </div>
                                <h4 class="text-gray-500 mb-2">Tidak ada tugas baru saat ini</h4>
                                <p class="text-muted">Admin belum menambahkan tugas baru. Silakan cek kembali nanti.</p>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0" id="availableTasksTable">
                                    <thead class="table-info">
                                        <tr>
                                            <th class="ps-4" width="25%">
                                                <i class="fas fa-heading me-2"></i>Judul Tugas
                                            </th>
                                            <th width="35%">
                                                <i class="fas fa-align-left me-2"></i>Deskripsi
                                            </th>
                                            <th width="20%">
                                                <i class="fas fa-calendar me-2"></i>Deadline
                                            </th>
                                            <th class="text-center" width="20%">
                                                <i class="fas fa-cogs me-2"></i>Aksi
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($availableTasks as $index => $task)
                                            @php
                                                $daysUntilDeadline = \Carbon\Carbon::parse($task->deadline)->diffInDays(now(), false);
                                                $deadlineStatus = $daysUntilDeadline >= -3 ? 'mendekati' : 'aktif';
                                            @endphp
                                            
                                            <tr class="{{ $index % 2 == 0 ? 'table-row-even' : 'table-row-odd' }} hover-lift">
                                                <td class="ps-4">
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar-sm bg-info bg-opacity-10 text-info rounded-circle d-flex align-items-center justify-content-center me-3">
                                                            <i class="fas fa-tasks"></i>
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-0 fw-semibold">{{ $task->judul_tugas }}</h6>
                                                            <small class="text-muted deadline-badge deadline-badge-{{ $deadlineStatus }}">
                                                                <i class="fas fa-{{ $deadlineStatus == 'mendekati' ? 'exclamation-triangle' : 'check-circle' }} me-1"></i>
                                                                {{ $deadlineStatus == 'mendekati' ? 'Mendekati Deadline' : 'Aktif' }}
                                                            </small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <p class="mb-0 text-muted">{{ Str::limit($task->deskripsi, 100) }}</p>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <i class="fas fa-clock text-warning me-2"></i>
                                                        </div>
                                                        <div>
                                                            <div class="fw-semibold">{{ date('d M Y', strtotime($task->deadline)) }}</div>
                                                            <small class="text-muted">{{ \Carbon\Carbon::parse($task->deadline)->diffForHumans() }}</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <button class="btn btn-primary px-4 shadow-sm take-task-btn"
                                                        data-task-id="{{ $task->id }}"
                                                        data-task-title="{{ $task->judul_tugas }}">
                                                        <i class="fas fa-plus-circle me-2"></i>Ambil Tugas
                                                    </button>
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
        </div>

    </div>

    {{-- Custom CSS --}}
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --warning-gradient: linear-gradient(135deg, #f6ad55 0%, #f6e05e 100%);
            --success-gradient: linear-gradient(135deg, #68d391 0%, #38a169 100%);
            --info-gradient: linear-gradient(135deg, #63b3ed 0%, #4299e1 100%);
            --danger-gradient: linear-gradient(135deg, #fc8181 0%, #f56565 100%);
            --shadow-lg: 0 10px 25px rgba(0, 0, 0, 0.1);
            --shadow-hover: 0 15px 35px rgba(0, 0, 0, 0.15);
        }

        /* Tabs Styling */
        .nav-tabs {
            border-bottom: 2px solid #e9ecef;
        }

        .nav-tabs .nav-link {
            border: none;
            color: #6c757d;
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            transition: all 0.3s ease;
            position: relative;
        }

        .nav-tabs .nav-link:hover {
            color: #495057;
            transform: translateY(-2px);
        }

        .nav-tabs .nav-link.active {
            color: #fff;
            background: var(--primary-gradient);
            border-radius: 8px 8px 0 0;
            transform: translateY(0);
        }

        .nav-tabs .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 100%;
            height: 2px;
            background: var(--primary-gradient);
        }

        /* Deadline Ribbon */
        .deadline-ribbon {
            position: absolute;
            top: 15px;
            right: -30px;
            padding: 5px 30px;
            color: white;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            transform: rotate(45deg);
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }

        .deadline-aktif {
            background: var(--success-gradient);
        }

        .deadline-mendekati {
            background: var(--warning-gradient);
        }

        .deadline-lewat {
            background: var(--danger-gradient);
        }

        .deadline-badge {
            font-size: 0.7rem;
            padding: 2px 8px;
            border-radius: 12px;
        }

        .deadline-badge-aktif {
            background: rgba(104, 211, 145, 0.1);
            color: #38a169;
        }

        .deadline-badge-mendekati {
            background: rgba(246, 173, 85, 0.1);
            color: #d69e2e;
        }

        /* Progress Bar Animation */
        .progress-bar-animated {
            animation: progress-animation 1.5s ease-in-out infinite;
        }

        @keyframes progress-animation {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Card Headers */
        .bg-gradient-warning {
            background: var(--warning-gradient) !important;
        }

        .bg-gradient-success {
            background: var(--success-gradient) !important;
        }

        .bg-gradient-info {
            background: var(--info-gradient) !important;
        }

        /* Table Styling */
        #availableTasksTable thead,
        #completedTasksTable thead {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
        }

        #availableTasksTable thead {
            background: var(--info-gradient);
        }

        #completedTasksTable thead {
            background: var(--success-gradient);
        }

        #availableTasksTable thead th,
        #completedTasksTable thead th {
            color: white !important;
            font-weight: 600;
            border: none;
            padding: 1rem 1.5rem;
        }

        /* Table Row Gradients */
        .table-row-even {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        }

        .table-row-odd {
            background: linear-gradient(135deg, #ffffff 0%, #f1f3f4 100%);
        }

        /* Hover Effects */
        .task-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: var(--shadow-hover) !important;
        }

        .hover-lift:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }

        /* Button Animations */
        .complete-task-btn:hover {
            animation: pulse-green 0.6s ease;
        }

        .take-task-btn:hover {
            animation: pulse-blue 0.6s ease;
        }

        @keyframes pulse-green {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        @keyframes pulse-blue {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        /* Avatar Styling */
        .avatar-sm {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        /* Animations */
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

        .task-card,
        #availableTasksTable tbody tr,
        #completedTasksTable tbody tr {
            animation: fadeInUp 0.5s ease;
            animation-fill-mode: both;
        }

        /* Staggered Animation */
        #availableTasksTable tbody tr,
        #completedTasksTable tbody tr {
            animation-delay: calc(var(--row-index) * 0.05s);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .nav-tabs .nav-link {
                padding: 0.5rem 1rem;
                font-size: 0.875rem;
            }
            
            .deadline-ribbon {
                right: -25px;
                padding: 4px 25px;
                font-size: 0.65rem;
            }
        }
    </style>

    {{-- JavaScript --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Initialize animations
            initAnimations();
            
            // Setup event listeners
            setupEventListeners();
            
            // Check and show deadline notifications
            checkDeadlineNotifications();
        });

        function initAnimations() {
            // Add staggered animation to table rows
            const tableRows = document.querySelectorAll('#availableTasksTable tbody tr, #completedTasksTable tbody tr');
            tableRows.forEach((row, index) => {
                row.style.setProperty('--row-index', index);
            });

            // Add animation to task cards
            const taskCards = document.querySelectorAll('.task-card');
            taskCards.forEach((card, index) => {
                card.style.animationDelay = `${index * 0.1}s`;
            });
        }

        function setupEventListeners() {
            // Complete Task Button
            document.querySelectorAll('.complete-task-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const taskId = this.dataset.taskId;
                    const taskTitle = this.dataset.taskTitle;
                    showCompleteTaskConfirmation(taskId, taskTitle);
                });
            });

            // Take Task Button
            document.querySelectorAll('.take-task-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const taskId = this.dataset.taskId;
                    const taskTitle = this.dataset.taskTitle;
                    showTakeTaskConfirmation(taskId, taskTitle);
                });
            });

            // Delete Task Button (Ongoing)
            document.querySelectorAll('.delete-task-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const taskId = this.dataset.taskId;
                    const taskTitle = this.dataset.taskTitle;
                    showDeleteTaskConfirmation(taskId, taskTitle, false);
                });
            });

            // Delete History Button (Completed)
            document.querySelectorAll('.delete-history-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const taskId = this.dataset.taskId;
                    const taskTitle = this.dataset.taskTitle;
                    showDeleteTaskConfirmation(taskId, taskTitle, true);
                });
            });
        }

        function checkDeadlineNotifications() {
            // Check for tasks near deadline or overdue
            const deadlineElements = document.querySelectorAll('[class*="deadline-"]');
            let hasNearDeadline = false;
            let hasOverdue = false;

            deadlineElements.forEach(el => {
                if (el.classList.contains('deadline-mendekati')) {
                    hasNearDeadline = true;
                }
                if (el.classList.contains('deadline-lewat')) {
                    hasOverdue = true;
                }
            });

            // Show notifications if needed
            if (hasOverdue) {
                showNotification('warning', 'Peringatan!', 'Ada tugas yang sudah lewat deadline. Segera selesaikan!');
            } else if (hasNearDeadline) {
                showNotification('info', 'Perhatian', 'Ada tugas yang mendekati deadline. Percepat pengerjaan!');
            }
        }

        function showNotification(type, title, message) {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 5000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer);
                    toast.addEventListener('mouseleave', Swal.resumeTimer);
                }
            });

            Toast.fire({
                icon: type,
                title: title,
                text: message,
                background: type === 'warning' ? '#fff3cd' : '#d1ecf1',
                color: type === 'warning' ? '#856404' : '#0c5460'
            });
        }

        function showCompleteTaskConfirmation(taskId, taskTitle) {
            Swal.fire({
                title: 'Tandai Selesai?',
                html: `Apakah Anda yakin ingin menandai tugas <strong>"${taskTitle}"</strong> sebagai selesai?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Tandai Selesai',
                cancelButtonText: 'Batal',
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    return fetch(`/my-tasks/${taskId}`, {
                        method: 'PATCH',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(response.statusText);
                        }
                        return response.json();
                    })
                    .catch(error => {
                        Swal.showValidationMessage(`Request failed: ${error}`);
                    });
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: 'Tugas berhasil ditandai sebagai selesai',
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });
                }
            });
        }

        function showTakeTaskConfirmation(taskId, taskTitle) {
            Swal.fire({
                title: 'Ambil Tugas?',
                html: `Apakah Anda yakin ingin mengambil tugas <strong>"${taskTitle}"</strong>?`,
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#007bff',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Ambil Tugas',
                cancelButtonText: 'Batal',
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    return fetch('/my-tasks', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ task_id: taskId })
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(response.statusText);
                        }
                        return response.json();
                    })
                    .catch(error => {
                        Swal.showValidationMessage(`Request failed: ${error}`);
                    });
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: 'Tugas berhasil diambil',
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });
                }
            });
        }

        function showDeleteTaskConfirmation(taskId, taskTitle, isHistory = false) {
            const actionText = isHistory ? 'menghapus dari riwayat' : 'melepas tugas';
            const successText = isHistory ? 'dihapus dari riwayat' : 'dilepas';
            
            Swal.fire({
                title: `${isHistory ? 'Hapus Riwayat?' : 'Lepas Tugas?'}`,
                html: `Apakah Anda yakin ingin ${actionText} <strong>"${taskTitle}"</strong>?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: `Ya, ${isHistory ? 'Hapus' : 'Lepas'}`,
                cancelButtonText: 'Batal',
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    return fetch(`/my-tasks/${taskId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(response.statusText);
                        }
                        return response.json();
                    })
                    .catch(error => {
                        Swal.showValidationMessage(`Request failed: ${error}`);
                    });
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: `Tugas berhasil ${successText}`,
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });
                }
            });
        }

        // Tab functionality
        const triggerTabList = document.querySelectorAll('#tasksTab button');
        triggerTabList.forEach(triggerEl => {
            const tabTrigger = new bootstrap.Tab(triggerEl);
            triggerEl.addEventListener('click', event => {
                event.preventDefault();
                tabTrigger.show();
            });
        });
    </script>
@endsection