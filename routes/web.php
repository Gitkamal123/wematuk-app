<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TugasController;
use App\Http\Controllers\Admin\UserController; 
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

// --- HALAMAN UTAMA ---
Route::get('/', function () {
    return view('welcome');
});

// --- AUTHENTICATION ---
Auth::routes(['verify' => false, 'reset' => false]);

// --- [DIAGNOSA 1] CEK KONEKSI DATABASE & CONFIG ---
Route::get('/cek-sehat', function () {
    try {
        DB::connection()->getPdo();
        return response()->json([
            'Status' => '✅ SEHAT',
            'DB' => DB::connection()->getDatabaseName(),
            'Cache_Driver' => config('cache.default'), // Harus 'array'
            'Session_Driver' => config('session.driver'), // Harus 'cookie'
        ]);
    } catch (\Exception $e) {
        return response()->json(['Status' => '❌ ERROR', 'Pesan' => $e->getMessage()], 500);
    }
});



Route::get('/run-migrate', function () {
    try {
        // migrate:fresh = Hapus semua tabel secara aman, lalu bangun ulang
        // --force = Wajib untuk mode production (Vercel)
        Artisan::call('migrate:fresh', ['--force' => true]);
        
        return "✅ SUKSES! Database berhasil di-fresh ulang.<br><br>" . nl2br(Artisan::output());
    } catch (\Exception $e) {
        return "❌ GAGAL: " . $e->getMessage();
    }
});

Route::get('/migrate-status', function () {
    try {
        Artisan::call('migrate:status');
        return "<pre>" . Artisan::output() . "</pre>";
    } catch (\Exception $e) {
        return "Error: " . $e->getMessage();
    }
});

// --- ROUTE USER (WAJIB LOGIN) ---
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [TugasController::class, 'index'])->name('home');
    Route::get('/cari', [TugasController::class, 'cari'])->name('tugas.cari');
    Route::get('/laporan', [TugasController::class, 'cetakLaporan'])->name('laporan.cetak');
    Route::get('/tugas/{tugas}', [TugasController::class, 'show'])->name('tugas.show');

    // Profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// --- ROUTE ADMIN (WAJIB LOGIN + ADMIN) ---
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