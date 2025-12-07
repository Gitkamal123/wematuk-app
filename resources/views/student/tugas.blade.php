@extends('layouts.master')

@section('content')
    <div class="container py-4">

        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Ambil Tugas Baru</h5>
                <form action="{{ route('my-tasks.store') }}" method="POST" class="d-flex gap-2">
                    @csrf
                    <select name="task_id" class="form-select" required>
                        <option value="" selected disabled>Pilih Tugas dari Dashboard...</option>
                        @foreach($availableTasks as $task)
                            <option value="{{ $task->id }}">{{ $task->judul_tugas }} - (Deadline: {{ $task->deadline }})
                            </option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-primary text-nowrap">+ Tambah ke Tugas Ku</button>
                </form>
                @if($availableTasks->isEmpty())
                    <small class="text-muted mt-2 d-block">*Semua tugas sudah Anda ambil.</small>
                @endif
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0 fw-bold">Daftar Tugas Ku</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Nama Tugas</th>
                                <th>Deadline</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($myTasks as $task)
                                <tr class="{{ $task->pivot->is_completed ? 'table-success' : '' }}">

                                    <td>
                                        <span class="fw-bold">{{ $task->judul_tugas }}</span>
                                        @if($task->pivot->is_completed)
                                            <span class="badge bg-success ms-2">Selesai</span>
                                        @endif
                                    </td>

                                    <td>{{ $task->deadline }}</td>

                                    <td>
                                        <form action="{{ route('my-tasks.update', $task->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            @if($task->pivot->is_completed)
                                                <button type="submit" class="btn btn-sm btn-outline-success active"
                                                    title="Tandai Belum Selesai">
                                                    ✅ Sudah Selesai
                                                </button>
                                            @else
                                                <button type="submit" class="btn btn-sm btn-outline-secondary"
                                                    title="Tandai Selesai">
                                                    ⬜ Belum Selesai
                                                </button>
                                            @endif
                                        </form>
                                    </td>

                                    <td>
                                        <form action="{{ route('my-tasks.destroy', $task->id) }}" method="POST"
                                            onsubmit="return confirm('Hapus tugas ini dari daftar Anda?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                🗑️ Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">
                                        Belum ada tugas yang diambil. Silakan ambil tugas di atas.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection