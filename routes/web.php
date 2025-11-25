<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TugasController;
use App\Http\Controllers\Admin\UserController; 
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Artisan;

use Illuminate\Support\Facades\DB;

Route::get('/', function () {
    return view('welcome');
});



// NONAKTIFKAN FITUR EMAIL (Verifikasi & Reset Password)
Auth::routes(['verify' => false, 'reset' => false]);

// // LOGIN
// Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])
//     ->name('login');
// Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);

// // LOGOUT
// Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])
//     ->name('logout');

// // REGISTER
// Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])
//     ->name('register');
// Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'register']);
// === GRUP UNTUK SEMUA USER (TERMASUK ADMIN) ===
// Hapus middleware 'verified' dari sini
Route::middleware(['auth'])->group(function () {

    // Rute Utama: Melihat daftar tugas (Read-Only)
    Route::get('/home', [TugasController::class, 'index'])->name('home');
    Route::get('/cari', [TugasController::class, 'cari'])->name('tugas.cari');
    Route::get('/laporan', [TugasController::class, 'cetakLaporan'])->name('laporan.cetak');
    Route::get('/tugas/{tugas}', [TugasController::class, 'show'])->name('tugas.show');

    // --- PENGATURAN PROFIL PENGGUNA ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Grup Admin tetap sama
Route::middleware(['auth', 'admin'])->group(function () {
    
    // --- ADMIN: Manajemen Tugas ---
    Route::get('/tugas/buat/baru', [TugasController::class, 'create'])->name('tugas.create');
    Route::post('/tugas', [TugasController::class, 'store'])->name('tugas.store');
    Route::get('/tugas/{tugas}/edit', [TugasController::class, 'edit'])->name('tugas.edit');
    Route::put('/tugas/{tugas}', [TugasController::class, 'update'])->name('tugas.update');
    Route::delete('/tugas/{tugas}', [TugasController::class, 'destroy'])->name('tugas.destroy');
    
    // --- ADMIN: Fitur Keranjang Sampah (Soft Deletes) ---
    Route::get('/admin/tugas/trash', [TugasController::class, 'trash']) ->name('tugas.trash');
    Route::put('/admin/tugas/{id}/restore', [TugasController::class, 'restore'])
         ->name('tugas.restore');
    Route::delete('/admin/tugas/{id}/force-delete', [TugasController::class, 'forceDelete'])
         ->name('tugas.forceDelete');
    Route::delete('/admin/tugas/trash/clear', [TugasController::class, 'clearTrash'])
         ->name('tugas.clearTrash');

    // --- ADMIN: Manajemen User ---
    Route::get('/admin/dashboard', [UserController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::get('/admin/users/{user}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/admin/users/{user}', [UserController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');

});

// Route::get('/cek-sehat', function () {
//     try {
//         // 1. Tes Koneksi Database Neon
//         // Ini akan mencoba ping ke server Neon
//         DB::connection()->getPdo();
//         $dbName = DB::connection()->getDatabaseName();
        
//         // 2. Cek Apakah Config Vercel Terbaca?
//         // Kita lihat apakah env var yang kita setting di Vercel masuk atau tidak
//         $config = [
//             'Status' => '✅ ALHAMDULILLAH SEHAT!',
//             'Database_Neon' => "Terhubung ke: " . $dbName,
//             'Session_Driver' => config('session.driver'), // Target: 'cookie'
//             'Cache_Driver' => config('cache.default'),   // Target: 'array'
//             'App_Debug' => config('app.debug'),          // Target: true
//             'Environment' => config('app.env'),          // Target: production
//         ];

//         return response()->json($config, 200);

//     } catch (\Exception $e) {
//         // Kalau error, tampilkan detailnya biar kita tahu salahnya dimana
//         return response()->json([
//             'Status' => '❌ MASIH SAKIT (ERROR)',
//             'Pesan_Error' => $e->getMessage(),
//             'Analisa_Config' => [
//                 'Session_Driver' => config('session.driver'),
//                 'Cache_Driver' => config('cache.default'),
//             ]
//         ], 500);
//     }
// });
Route::get('/run-migrate', function () {
    try {
        // Menjalankan migrasi database dari dalam server Vercel
        Artisan::call('migrate', ['--force' => true]);
        
        return "✅ MIGRASI SUKSES!<br>" . nl2br(Artisan::output());
    } catch (\Exception $e) {
        return "❌ GAGAL: " . $e->getMessage();
    }
});