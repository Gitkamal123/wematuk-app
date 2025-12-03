<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TugasController;
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

Route::get('/migrate-remaining', function () {
    try {
        // Jalankan migration yang belum di-execute
        Artisan::call('migrate', [
            '--force' => true,
            '--path' => [
                'database/migrations/0001_01_01_000001_create_cache_table.php',
                'database/migrations/0001_01_01_000002_create_jobs_table.php', 
                'database/migrations/2025_11_11_142239_add_role_to_users_table.php',
                'database/migrations/2025_11_11_143145_create_tugas_table.php',
                'database/migrations/2025_11_13_050323_add_soft_deletes_to_tugas_table.php'
            ]
        ]);
        
        return "✅ MIGRATION REMAINING BERHASIL!<br><br>" . nl2br(Artisan::output());
        
    } catch (\Exception $e) {
        return "❌ GAGAL: " . $e->getMessage();
    }
});

Route::get('/migrate-status-now', function () {
    try {
        Artisan::call('migrate:status');
        return "<pre>Migration Status:\n" . Artisan::output() . "</pre>";
    } catch (\Exception $e) {
        return "Error: " . $e->getMessage();
    }
});

Route::get('/skip-cache-table', function () {
    try {
        // Mark cache migration as done tanpa menjalankannya
        DB::table('migrations')->insert([
            ['migration' => '0001_01_01_000001_create_cache_table', 'batch' => 1],
        ]);
        
        return "✅ CACHE TABLE DI-SKIP! Migration marked as completed.";
        
    } catch (\Exception $e) {
        return "❌ GAGAL: " . $e->getMessage();
    }
});
Route::get('/test-app', function () {
    try {
        // Test basic functionality
        $userCount = DB::table('users')->count();
        $tugasCount = DB::table('tugas')->count();
        
        return "✅ APLIKASI READY!<br>" .
               "Users: $userCount<br>" .
               "Tugas: $tugasCount<br>" .
               "Cache table bisa di-skip tidak masalah.";
               
    } catch (\Exception $e) {
        return "❌ APLIKASI ERROR: " . $e->getMessage();
    }
});

Route::get('/check-tables', function () {
    try {
        $tables = DB::select("
            SELECT table_name 
            FROM information_schema.tables 
            WHERE table_schema = 'public'
        ");
        
        $tableList = [];
        foreach ($tables as $table) {
            $tableList[] = $table->table_name;
        }
        
        return "✅ TABLES YANG ADA: " . implode(', ', $tableList);
        
    } catch (\Exception $e) {
        return "❌ GAGAL: " . $e->getMessage();
    }
});

Route::get('/create-all-missing-tables', function () {
    try {
        // Step 1: Hapus migration records yang salah
        DB::table('migrations')->truncate();

        // Step 2: Buat jobs tables (dari 0001_01_01_000002_create_jobs_table.php)
        if (!Schema::hasTable('jobs')) {
            Schema::create('jobs', function (Blueprint $table) {
                $table->id();
                $table->string('queue')->index();
                $table->longText('payload');
                $table->unsignedTinyInteger('attempts');
                $table->unsignedInteger('reserved_at')->nullable();
                $table->unsignedInteger('available_at');
                $table->unsignedInteger('created_at');
            });
        }

        if (!Schema::hasTable('job_batches')) {
            Schema::create('job_batches', function (Blueprint $table) {
                $table->string('id')->primary();
                $table->string('name');
                $table->integer('total_jobs');
                $table->integer('pending_jobs');
                $table->integer('failed_jobs');
                $table->longText('failed_job_ids');
                $table->mediumText('options')->nullable();
                $table->integer('cancelled_at')->nullable();
                $table->integer('created_at');
                $table->integer('finished_at')->nullable();
            });
        }

        if (!Schema::hasTable('failed_jobs')) {
            Schema::create('failed_jobs', function (Blueprint $table) {
                $table->id();
                $table->string('uuid')->unique();
                $table->text('connection');
                $table->text('queue');
                $table->longText('payload');
                $table->longText('exception');
                $table->timestamp('failed_at')->useCurrent();
            });
        }

        // Step 3: Pastikan table users punya kolom role
        if (Schema::hasTable('users') && !Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('role')->default('user');
            });
        }

        // Step 4: Buat table tugas (dari create_tugas_table.php)
        if (!Schema::hasTable('tugas')) {
            Schema::create('tugas', function (Blueprint $table) {
                $table->id();
                $table->string('judul');
                $table->text('deskripsi')->nullable();
                $table->dateTime('deadline');
                $table->longText('file_path')->nullable();
                $table->timestamps();
            });
        }

        // Step 5: Tambah soft deletes ke tugas (dari add_soft_deletes_to_tugas_table.php)
        if (Schema::hasTable('tugas') && !Schema::hasColumn('tugas', 'deleted_at')) {
            Schema::table('tugas', function (Blueprint $table) {
                $table->softDeletes();
            });
        }

        // Step 6: Insert migration records yang benar
        $migrations = [
            '0001_01_01_000000_create_users_table',
            '0001_01_01_000002_create_jobs_table',
            '2025_11_11_142239_add_role_to_users_table',
            '2025_11_11_143145_create_tugas_table',
            '2025_11_13_050323_add_soft_deletes_to_tugas_table'
        ];

        foreach ($migrations as $migration) {
            DB::table('migrations')->insert([
                'migration' => $migration,
                'batch' => 1
            ]);
        }

        return "✅ SEMUA TABLE BERHASIL DIBUAT!<br><br>" .
               "Table yang dibuat:<br>" .
               "- jobs<br>" .
               "- job_batches<br>" .
               "- failed_jobs<br>" .
               "- role column di users<br>" .
               "- tugas<br>" .
               "- softDeletes di tugas";

    } catch (\Exception $e) {
        return "❌ GAGAL: " . $e->getMessage() . "<br><br>File: " . $e->getFile() . ":" . $e->getLine();
    }
});

Route::get('/verify-all-tables', function () {
    try {
        $tables = ['users', 'sessions', 'migrations', 'jobs', 'job_batches', 'failed_jobs', 'tugas'];
        
        $results = [];
        foreach ($tables as $table) {
            $exists = DB::select("SELECT EXISTS (SELECT FROM information_schema.tables WHERE table_name = '$table')")[0]->exists;
            $results[] = "$table: " . ($exists ? '✅ ADA' : '❌ TIDAK ADA');
        }
        
        // Check columns
        $usersHasRole = Schema::hasColumn('users', 'role');
        $tugasHasSoftDeletes = Schema::hasColumn('tugas', 'deleted_at');
        
        $results[] = "users.role: " . ($usersHasRole ? '✅ ADA' : '❌ TIDAK ADA');
        $results[] = "tugas.deleted_at: " . ($tugasHasSoftDeletes ? '✅ ADA' : '❌ TIDAK ADA');
        
        return "✅ VERIFIKASI TABLES:<br>" . implode('<br>', $results);
        
    } catch (\Exception $e) {
        return "❌ GAGAL: " . $e->getMessage();
    }
});

Route::get('/add-unique-nrp-fixed', function () {
    try {
        // Method lebih simple untuk PostgreSQL
        DB::statement('
            DELETE FROM users 
            WHERE id NOT IN (
                SELECT MIN(id) 
                FROM users 
                GROUP BY nrp
            )
        ');

        // Tambahkan unique constraint
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasIndex('users', 'users_nrp_unique')) {
                $table->unique('nrp', 'users_nrp_unique');
            }
        });

        return "✅ UNIQUE CONSTRAINT BERHASIL DITAMBAH!";

    } catch (\Exception $e) {
        return "❌ GAGAL: " . $e->getMessage();
    }
});
 

// --- ROUTE USER (WAJIB LOGIN) ---
    // Gabungkan dengan middleware auth
Route::middleware(['auth', 'prevent-back-history'])->group(function () {
    
    // Masukkan semua route yang harus diproteksi di sini
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    
    // Route admin, tugas, dll masukkan ke sini juga

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