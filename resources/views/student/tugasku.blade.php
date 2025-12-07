@extends('layouts.master') 

@section('content')
    <div class="container-fluid">

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Manajemen Tugas Saya</h1>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="card shadow mb-5">
            <div class="card-header py-3 bg-primary">
                <h6 class="m-0 font-weight-bold text-white">Progress Tugas Saya</h6>
            </div>
            <div class="card-body bg-light">
                @if($myTasks->isEmpty())
                    <div class="text-center py-5">
                        <h4 class="text-gray-500">Belum ada tugas yang diambil.</h4>
                        <p>Silakan ambil tugas baru di tabel bawah.</p>
                    </div>
                @else
                    <div class="row">
                        @foreach($myTasks as $task)
                            <div class="col-xl-4 col-md-6 mb-4">
                                <div
                                    class="card border-left-{{ $task->pivot->is_completed ? 'success' : 'warning' }} shadow h-100 py-2 task-card">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div
                                                    class="text-xs font-weight-bold text-{{ $task->pivot->is_completed ? 'success' : 'warning' }} text-uppercase mb-1">
                                                    {{ $task->pivot->is_completed ? 'Selesai' : 'Sedang Dikerjakan' }}
                                                </div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $task->judul_tugas }}</div>
                                                <div class="text-xs text-muted mt-2">
                                                    Deadline: {{ date('d M Y', strtotime($task->deadline)) }}
                                                </div>
                                                <p class="mt-2 text-sm text-gray-600">
                                                    {{ Str::limit($task->deskripsi, 50) }}
                                                </p>
                                            </div>
                                            <div class="col-auto">
                                                <i
                                                    class="fas {{ $task->pivot->is_completed ? 'fa-check-circle' : 'fa-clock' }} fa-2x text-gray-300"></i>
                                            </div>
                                        </div>

                                        <hr>

                                        <div class="d-flex justify-content-between align-items-center">
                                            {{-- Tombol Update Status --}}
                                            <form action="{{ route('my-tasks.update', $task->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                    class="btn btn-sm {{ $task->pivot->is_completed ? 'btn-secondary' : 'btn-success' }}">
                                                    {{ $task->pivot->is_completed ? 'Batal Selesai' : 'Tandai Selesai' }}
                                                </button>
                                            </form>

                                            {{-- Tombol Hapus/Lepas Tugas --}}
                                            <form action="{{ route('my-tasks.destroy', $task->id) }}" method="POST"
                                                onsubmit="return confirm('Yakin ingin melepas tugas ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Lepas Tugas">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Tugas Baru Tersedia (Dari Admin)</h6>
            </div>
            <div class="card-body">
                @if($availableTasks->isEmpty())
                    <div class="text-center">Tidak ada tugas baru saat ini.</div>
                @else
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                            <thead class="thead-light">
                                <tr>
                                    <th>Judul Tugas</th>
                                    <th>Deskripsi</th>
                                    <th>Deadline</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($availableTasks as $task)
                                    <tr>
                                        <td class="font-weight-bold">{{ $task->judul_tugas }}</td>
                                        <td>{{ Str::limit($task->deskripsi, 80) }}</td>
                                        <td>
                                            <span class="badge badge-info">
                                                {{ date('d M Y', strtotime($task->deadline)) }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <form action="{{ route('my-tasks.store') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="task_id" value="{{ $task->id }}">
                                                <button type="submit" class="btn btn-primary btn-sm shadow-sm">
                                                    <i class="fas fa-plus fa-sm text-white-50"></i> Ambil Tugas
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

    {{-- CSS Tambahan untuk mempercantik --}}
    <style>
        .task-card {
            transition: transform 0.2s;
        }

        .task-card:hover {
            transform: translateY(-5px);
        }
    </style>
@endsection