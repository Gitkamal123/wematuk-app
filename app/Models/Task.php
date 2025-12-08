<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 
use Carbon\Carbon;

class Task extends Model
{
    use HasFactory, SoftDeletes; // 2. TAMBAHKAN INI DI DALAM CLASS

    protected $table = 'tugas'; 

    protected $fillable = [
        'tugas', 
        'deskripsi',
        'deadline',
    ];

    // Relasi ke User
    public function users()
    {
        return $this->belongsToMany(User::class, 'task_user', 'task_id', 'user_id')
                    ->withPivot('is_completed', 'updated_at') 
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
    
    // Aksesor Progress
    public function getProgressAttribute()
    {
        if ($this->pivot && $this->pivot->is_completed) {
            return 100;
        }
        return 0;
    }
}