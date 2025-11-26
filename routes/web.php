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
        // Reset sederhana untuk Neon
        DB::statement('DROP SCHEMA IF EXISTS public CASCADE');
        DB::statement('CREATE SCHEMA public');
        
        return "✅ DATABASE RESET SIMPLE BERHASIL!";
        
    } catch (\Exception $e) {
        return "❌ GAGAL: " . $e->getMessage();
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

Route::get('/migrate-direct', function () {
    try {
        // Gunakan koneksi baru
        config(['database.connections.pgsql.host' => 'ep-sweet-math-al4epe5w.ap-southeast-1.aws.neon.tech']);
        DB::reconnect();
        
        // Reset schema
        DB::statement('DROP SCHEMA IF EXISTS public CASCADE');
        DB::statement('CREATE SCHEMA public');
        
        // Migrate tanpa transaction
        Artisan::call('migrate', [
            '--force' => true,
            '--no-transaction' => true  // Non-transactional migration
        ]);
        
        return "✅ MIGRATE DIRECT BERHASIL!<br><br>" . nl2br(Artisan::output());
        
    } catch (\Exception $e) {
        return "❌ GAGAL: " . $e->getMessage();
    }
});

Route::get('/migrate-step', function () {
    try {
        DB::statement('DROP SCHEMA IF EXISTS public CASCADE');
        DB::statement('CREATE SCHEMA public');
        
        // Step 1: Create users table (tanpa unique)
        DB::statement('
            CREATE TABLE users (
                id BIGSERIAL PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                nrp VARCHAR(255) NOT NULL,
                password VARCHAR(255) NOT NULL,
                role VARCHAR(255) DEFAULT \'user\',
                remember_token VARCHAR(100) NULL,
                created_at TIMESTAMP(0) NULL,
                updated_at TIMESTAMP(0) NULL
            )
        ');
        
        // Step 2: Create sessions table
        DB::statement('
            CREATE TABLE sessions (
                id VARCHAR(255) PRIMARY KEY,
                user_id BIGINT NULL,
                ip_address VARCHAR(45) NULL,
                user_agent TEXT NULL,
                payload TEXT NOT NULL,
                last_activity INTEGER NOT NULL
            )
        ');
        
        // Step 3: Create migrations table
        DB::statement('
            CREATE TABLE migrations (
                id SERIAL PRIMARY KEY,
                migration VARCHAR(255) NOT NULL,
                batch INTEGER NOT NULL
            )
        ');
        
        // Step 4: Insert migration records
        DB::table('migrations')->insert([
            ['migration' => '0001_01_01_000000_create_users_table', 'batch' => 1],
            ['migration' => '0001_01_01_000002_create_jobs_table', 'batch' => 1],
            ['migration' => '2025_11_11_142239_add_role_to_users_table', 'batch' => 1],
            ['migration' => '2025_11_11_143145_create_tugas_table', 'batch' => 1],
            ['migration' => '2025_11_13_050323_add_soft_deletes_to_tugas_table', 'batch' => 1],
        ]);
        
        return "✅ MANUAL MIGRATION BERHASIL! Database siap digunakan.";
        
    } catch (\Exception $e) {
        return "❌ GAGAL: " . $e->getMessage();
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