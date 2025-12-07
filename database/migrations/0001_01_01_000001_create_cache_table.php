<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('task_user', function (Blueprint $table) {
            $table->id();

            // FIX: PostgreSQL tidak mendukung unsigned
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('task_id');

            $table->boolean('is_completed')->default(false);
            $table->timestamps();

            // Foreign keys
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('task_id')->references('id')->on('tugas')->onDelete('cascade');

            // Unique constraint
            $table->unique(['user_id', 'task_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('task_user');
    }
};  