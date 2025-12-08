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
        'judul', 
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
     * Cek apakah deadline sudah dekat
     */
    public function getDeadlineStatusAttribute()
    {
        if (!$this->deadline) return null;

        $deadline = Carbon::parse($this->deadline);
        $now = Carbon::now();
        // Hitung selisih hari (false = hasil bisa negatif kalau lewat)
        $diff = $now->diffInDays($deadline, false); 

        // LOGIKA STATUS
        if ($diff < 0) {
            // Sudah Lewat
            return [
                'text' => 'Lewat Deadline',
                'color' => 'danger', // Merah
                'icon' => 'fa-exclamation-triangle',
                'border' => 'border-danger'
            ];
        } elseif ($diff <= 3) {
            // Kurang dari atau sama dengan 3 hari (Mendekati)
            return [
                'text' => 'Mendekati Deadline',
                'color' => 'warning', // Kuning
                'icon' => 'fa-hourglass-half',
                'border' => 'border-warning'
            ];
        } else {
            // Lebih dari 3 hari (Aktif/Aman)
            return [
                'text' => 'Aktif',
                'color' => 'success', // Hijau
                'icon' => 'fa-check-circle',
                'border' => 'border-success'
            ];
        }
    }
}