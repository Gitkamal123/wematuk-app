<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Tabel Users
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            
            // UBAH DISINI: Jangan pakai ->unique() dulu
            $table->string('nrp'); 
            
            $table->string('password');
            $table->string('role')->default('user');
            $table->rememberToken();
            $table->timestamps();

            // DEFINISIKAN UNIQUE SECARA TERPISAH DI BAWAH
            // Ini lebih aman untuk mencegah error duplikasi constraint
            $table->unique('nrp', 'users_nrp_unique'); 
        });

        // 2. Tabel Password Reset (Pakai NRP)
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('nrp'); // Buat kolom dulu
            $table->primary('nrp'); // Baru jadikan primary
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        // 3. Tabel Sessions
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }
    // public function up(): void
    // {
    //     Schema::create('users', function (Blueprint $table) {
    //         $table->id();
    //         $table->string('name');
            
    //         // LOGIN PAKAI NRP (Unik)
    //         $table->string('nrp')->unique();
            
    //         $table->string('password');
            
    //         // [PENTING] Kolom Role untuk membedakan Admin/User
    //         $table->string('role')->default('user'); 
            
    //         $table->rememberToken();
    //         $table->timestamps();
    //     });

    //     // Schema::create('password_reset_tokens', function (Blueprint $table) {
    //     //     // Sesuaikan dengan NRP
    //     //     $table->string('nrp')->primary();
    //     //     $table->string('token');
    //     //     $table->timestamp('created_at')->nullable();
    //     // });

    //     Schema::create('sessions', function (Blueprint $table) {
    //         $table->string('id')->primary();
    //         $table->foreignId('user_id')->nullable()->index();
    //         $table->string('ip_address', 45)->nullable();
    //         $table->text('user_agent')->nullable();
    //         $table->longText('payload');
    //         $table->integer('last_activity')->index();
    //     });
    // }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};