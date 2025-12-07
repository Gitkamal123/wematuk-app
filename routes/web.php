<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TugasController;
use App\Http\Controllers\StudentTaskController;
use App\Http\Controllers\Admin\UserController; 
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

// --- HALAMAN UTAMA ---
Route::get('/', function () {
    return view('welcome');
});

// --- ROUTE USER (WAJIB LOGIN) ---
// Route::middleware(['auth'])->group(function () {
Route::middleware(['auth', 'prevent-back-history'])->group(function () {

    Route::get('/home', [TugasController::class, 'index'])->name('home');
    Route::get('/cari', [TugasController::class, 'cari'])->name('tugas.cari');
    Route::get('/laporan', [TugasController::class, 'cetakLaporan'])->name('laporan.cetak');
    Route::get('/tugas/{tugas}', [TugasController::class, 'show'])->name('tugas.show');

    // Profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Route khusus untuk download file Base64
    Route::get('/tugas/{tugas}/download', [TugasController::class, 'downloadFile'])->name('tugas.download');
    // Route khusus untuk preview file
    Route::get('/tugas/{tugas}/preview', [TugasController::class, 'previewFile'])->name('tugas.preview');
// --- ROUTE ADMIN (WAJIB LOGIN + ADMIN) ---


    Route::prefix('tugas-ku')->group(function () {
    Route::get('/', [StudentTaskController::class, 'index'])->name('my-tasks.index');
    Route::post('/add', [StudentTaskController::class, 'store'])->name('my-tasks.store');
    Route::patch('/update/{id}', [StudentTaskController::class, 'updateStatus'])->name('my-tasks.update');
    Route::delete('/delete/{id}', [StudentTaskController::class, 'destroy'])->name('my-tasks.destroy');

    });

    Route::middleware(['auth', 'admin'])->group(function () {
        // Tugas Admin
        Route::get('/tugas/buat/baru', [TugasController::class, 'create'])->name('tugas.create');
        Route::post('/tugas', [TugasController::class, 'store'])->name('tugas.store');
        Route::get('/tugas/{tugas}/edit', [TugasController::class, 'edit'])->name('tugas.edit');
        Route::put('/tugas/{tugas}', [TugasController::class, 'update'])->name('tugas.update');
        Route::delete('/tugas/{tugas}', [TugasController::class, 'destroy'])->name('tugas.destroy');
        
        // Trash & Restore
        Route::get('/admin/tugas/trash', [TugasController::class, 'trash'])->name('tugas.trash');
        Route::put('/admin/tugas/{id}/restore', [TugasController::class, 'restore'])->name('tugas.restore');
        Route::delete('/admin/tugas/{id}/force-delete', [TugasController::class, 'forceDelete'])->name('tugas.forceDelete');
        Route::delete('/admin/tugas/trash/clear', [TugasController::class, 'clearTrash'])->name('tugas.clearTrash');

        // Manajemen User
        Route::get('/admin/dashboard', [UserController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
        Route::get('/admin/users/{user}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
        Route::put('/admin/users/{user}', [UserController::class, 'update'])->name('admin.users.update');
        Route::delete('/admin/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');
    });

});