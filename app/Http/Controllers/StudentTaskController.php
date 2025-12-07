<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentTaskController extends Controller
{
    // 1. Halaman Daftar Tugas
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Ambil tugas yg sudah diambil mahasiswa
        $myTasks = $user->myTasks; 
        
        // Ambil tugas baru dari admin (yg belum diambil)
        // Kita filter manual agar aman
        $existingTaskIds = $user->myTasks()->pluck('task_id')->toArray();
        $availableTasks = Task::whereNotIn('id', $existingTaskIds)->get();

        return view('student.my_tasks', compact('myTasks', 'availableTasks'));
    }

    // 2. Ambil Tugas Baru
    public function store(Request $request)
    {
        $request->validate(['task_id' => 'required']);
        
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Cek duplikasi sebelum attach
        if(!$user->myTasks()->where('task_id', $request->task_id)->exists()){
            $user->myTasks()->attach($request->task_id);
        }

        return back()->with('success', 'Tugas berhasil diambil!');
    }

    // 3. Update Status (Selesai/Belum)
    public function updateStatus($taskId)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        $task = $user->myTasks()->where('task_id', $taskId)->first();

        if ($task) {
            // Toggle status (0 jadi 1, 1 jadi 0)
            $newStatus = !$task->pivot->is_completed;
            $user->myTasks()->updateExistingPivot($taskId, ['is_completed' => $newStatus]);
        }

        return back()->with('success', 'Status diperbarui!');
    }

    // 4. Hapus Tugas
    public function destroy($taskId)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->myTasks()->detach($taskId);

        return back()->with('success', 'Tugas dilepas.');
    }
}