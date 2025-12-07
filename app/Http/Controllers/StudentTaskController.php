<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentTaskController extends Controller
{
    // 1. Tampilkan Halaman "Tugas Ku"
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Ambil tugas milik mahasiswa
        $myTasks = $user->myTasks; 
        
        // Ambil tugas admin yang BELUM diambil mahasiswa
        $availableTasks = Task::whereDoesntHave('users', function($q) use ($user) {
            $q->where('user_id', $user->id);
        })->get();

        // PASTIKAN nama view sesuai dengan nama file blade Anda!
        // Jika nama filenya 'my_tasks.blade.php', gunakan 'student.my_tasks'
        return view('student.tugas', compact('myTasks', 'availableTasks'));
    }

    // 2. Tambah Tugas
    public function store(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $request->validate(['task_id' => 'required|exists:tasks,id']);
        
        // Cek agar tidak duplikat (opsional, karena database sudah handle)
        if(!$user->myTasks()->where('task_id', $request->task_id)->exists()){
            $user->myTasks()->attach($request->task_id);
        }

        return back()->with('success', 'Tugas berhasil ditambahkan ke daftar Anda!');
    }

    // 3. Update Status
    public function updateStatus($taskId)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        // Cari tugas spesifik di pivot table
        $taskPivot = $user->myTasks()->where('task_id', $taskId)->first();

        // Cek null safety (jaga-jaga jika tugas tidak ditemukan)
        if ($taskPivot) {
            $currentStatus = $taskPivot->pivot->is_completed;
            
            $user->myTasks()->updateExistingPivot($taskId, [
                'is_completed' => !$currentStatus
            ]);
        }

        return back()->with('success', 'Status tugas diperbarui!');
    }

    // 4. Hapus Tugas
    public function destroy($taskId)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $user->myTasks()->detach($taskId);

        return back()->with('success', 'Tugas dihapus dari daftar Anda.');
    }
}