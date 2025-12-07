<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class StudentTaskController extends Controller
{
    // 1. Halaman Daftar Tugas dengan Tabs
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Ambil tugas yang sedang berjalan (belum selesai)
        $myTasks = $user->myTasks()->wherePivot('is_completed', false)->get();
        
        // Ambil riwayat tugas yang sudah selesai
        $completedTasks = $user->myTasks()->wherePivot('is_completed', true)->get();
        
        // Ambil tugas baru dari admin (yang belum diambil)
        $existingTaskIds = $user->myTasks()->pluck('task_id')->toArray();
        $availableTasks = Task::whereNotIn('id', $existingTaskIds)->get();

        // Hitung status deadline untuk tugas yang berjalan
        $activeTasksCount = 0;
        $nearDeadlineTasksCount = 0;
        $overdueTasksCount = 0;

        foreach ($myTasks as $task) {
            $deadline = Carbon::parse($task->deadline);
            $daysUntilDeadline = $deadline->diffInDays(Carbon::now(), false);
            
            if ($daysUntilDeadline > 0) {
                // Sudah lewat deadline
                $overdueTasksCount++;
            } elseif ($daysUntilDeadline >= -3) {
                // Kurang dari atau sama dengan 3 hari menuju deadline
                $nearDeadlineTasksCount++;
            } else {
                // Masih lebih dari 3 hari
                $activeTasksCount++;
            }
        }

        // Tambahkan progress untuk setiap tugas (contoh: random atau dari database)
        foreach ($myTasks as $task) {
            $task->progress = $this->calculateTaskProgress($task);
        }

        foreach ($completedTasks as $task) {
            $task->progress = 100; // Tugas selesai selalu 100%
        }

        return view('student.tugasku', compact(
            'myTasks',
            'completedTasks',
            'availableTasks',
            'activeTasksCount',
            'nearDeadlineTasksCount',
            'overdueTasksCount'
        ));
    }

    // 2. Ambil Tugas Baru
    public function store(Request $request)
    {
        $request->validate(['task_id' => 'required']);
        
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Cek duplikasi sebelum attach
        if(!$user->myTasks()->where('task_id', $request->task_id)->exists()){
            $user->myTasks()->attach($request->task_id, [
                'is_completed' => false,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        return back()->with('success', 'Tugas berhasil diambil!');
    }

    // 3. Update Status (Selesai/Belum)
    public function update(Request $request, $taskId)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        // Cek apakah tugas ada dan milik user
        $task = $user->myTasks()->where('task_id', $taskId)->first();
        
        if (!$task) {
            return back()->with('error', 'Tugas tidak ditemukan!');
        }

        // Toggle status (0 jadi 1, 1 jadi 0)
        $newStatus = !$task->pivot->is_completed;
        
        // Update dengan timestamp
        $user->myTasks()->updateExistingPivot($taskId, [
            'is_completed' => $newStatus,
            'updated_at' => now()
        ]);

        $statusText = $newStatus ? 'selesai' : 'dibatalkan';
        return back()->with('success', "Tugas berhasil ditandai {$statusText}!");
    }

    // 4. Hapus Tugas (dari tugas berjalan atau riwayat)
    public function destroy($taskId)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        // Cek apakah tugas ada di pivot table
        $taskExists = $user->myTasks()->where('task_id', $taskId)->exists();
        
        if (!$taskExists) {
            return back()->with('error', 'Tugas tidak ditemukan!');
        }

        $user->myTasks()->detach($taskId);

        return back()->with('success', 'Tugas berhasil dihapus.');
    }

    // 5. Method untuk menghitung progress tugas
    private function calculateTaskProgress($task)
    {
        // Logic untuk menghitung progress
        // Contoh 1: Berdasarkan waktu (deadline vs sekarang)
        $deadline = Carbon::parse($task->deadline);
        $createdAt = Carbon::parse($task->created_at);
        $now = Carbon::now();
        
        $totalDuration = $createdAt->diffInHours($deadline);
        $elapsedDuration = $createdAt->diffInHours($now);
        
        if ($totalDuration <= 0) {
            return 100; // Jika deadline sudah lewat
        }
        
        $progress = ($elapsedDuration / $totalDuration) * 100;
        
        // Batasi antara 0-100
        return min(max(round($progress), 0), 100);
        
        // Contoh 2: Jika Anda punya field progress di database
        // return $task->progress ?? 0;
        
        // Contoh 3: Random untuk demo
        // return rand(10, 90);
    }

    // 6. Method untuk mengecek apakah deadline mendekati
    public function isDeadlineNear($task)
    {
        $deadline = Carbon::parse($task->deadline);
        $daysUntilDeadline = $deadline->diffInDays(Carbon::now(), false);
        
        return $daysUntilDeadline >= -3 && $daysUntilDeadline <= 0;
    }

    // 7. Method untuk mendapatkan status deadline
    public function getDeadlineStatus($task)
    {
        $deadline = Carbon::parse($task->deadline);
        $daysUntilDeadline = $deadline->diffInDays(Carbon::now(), false);
        
        if ($daysUntilDeadline > 0) {
            return 'lewat';
        } elseif ($daysUntilDeadline >= -3) {
            return 'mendekati';
        } else {
            return 'aktif';
        }
    }
}