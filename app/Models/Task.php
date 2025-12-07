<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * (Daftar kolom yang boleh diisi saat create/update)
     */
    protected $fillable = [
        'judul_tugas',  // Pastikan nama ini sama dengan di Migration & Form
        'deskripsi',
        'deadline',
    ];

    /**
     * Relasi Many-to-Many ke User (Mahasiswa)
     * Satu tugas bisa diambil oleh banyak mahasiswa
     */
    public function users()
    {
        // Parameter kedua 'task_user' adalah nama tabel pivot
        return $this->belongsToMany(User::class, 'task_user')
                    ->withPivot('is_completed') // Agar kita bisa akses status selesai/belum
                    ->withTimestamps();
    }
}