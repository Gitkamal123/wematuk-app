<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon; // <--- JANGAN LUPA IMPORT INI

class Task extends Model
{
    use HasFactory;

    protected $table = 'tugas'; 

    protected $fillable = [
        'judul_tugas', 
        'deskripsi',
        'deadline',
    ];

    // Relasi ke User
    public function users()
    {
        return $this->belongsToMany(User::class, 'task_user', 'task_id', 'user_id')
                    ->withPivot('is_completed')
                    ->withTimestamps();
    }
    
    /**
     * Cek apakah deadline sudah dekat (kurang dari 3 hari)
     */
    public function isDeadlineNear()
    {
        if (!$this->deadline) return false;

        $deadlineDate = Carbon::parse($this->deadline);
        $today = Carbon::now();

        // Jika deadline sudah lewat atau kurang dari 3 hari dari sekarang
        return $deadlineDate->isPast() || $deadlineDate->diffInDays($today) <= 3;
    }
    
    // Aksesor untuk Progress (Opsional, agar tidak error jika kolom progress tidak ada)
    public function getProgressAttribute()
    {
        // Jika Anda belum punya kolom 'progress' di database, kita default ke 0
        // Atau logika: jika selesai = 100%, jika belum = 50%
        if ($this->pivot && $this->pivot->is_completed) {
            return 100;
        }
        return 0; // Default 0%
    }
}