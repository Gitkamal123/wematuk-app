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

Route::get('/migrate-fresh', function () {
    try {
        // Reset transaction state dulu
        DB::statement('DISCARD ALL');
        
        // Jalankan migrate fresh
        Artisan::call('migrate:fresh', ['--force' => true]);
        
        return "✅ MIGRATE FRESH BERHASIL!<br><br>" . nl2br(Artisan::output());
        
    } catch (\Exception $e) {
        return "❌ GAGAL: " . $e->getMessage();
    }
});

Route::get('/db-reset', function () {
    try {
        // Method lebih agresif untuk reset
        DB::statement('DROP SCHEMA IF EXISTS public CASCADE');
        DB::statement('CREATE SCHEMA public');
        DB::statement('GRANT ALL ON SCHEMA public TO postgres');
        DB::statement('GRANT ALL ON SCHEMA public TO public');
        
        return "✅ DATABASE RESET BERHASIL! Schema public telah dihapus dan dibuat ulang.";
        
    } catch (\Exception $e) {
        return "❌ GAGAL RESET: " . $e->getMessage();
    }
});

Route::get('/db-test', function () {
    try {
        DB::statement('DISCARD ALL'); // Reset transaction
        DB::connection()->getPdo();
        
        return "✅ DATABASE CONNECTION OK!<br>" .
               "Database: " . DB::connection()->getDatabaseName();
               
    } catch (\Exception $e) {
        return "❌ CONNECTION FAILED: " . $e->getMessage();
    }
});

Route::get('/migrate-normal', function () {
    try {
        // Reset transaction state
        DB::statement('DISCARD ALL');
        
        // Jalankan migrate normal
        Artisan::call('migrate', ['--force' => true]);
        
        return "✅ MIGRATE NORMAL BERHASIL!<br><br>" . nl2br(Artisan::output());
        
    } catch (\Exception $e) {
        return "❌ GAGAL: " . $e->getMessage() . 
               "<br><br>File: " . $e->getFile() . ":" . $e->getLine();
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