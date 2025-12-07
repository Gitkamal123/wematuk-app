<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    
    // PENTING: Kasih tau Laravel nama tabelnya 'tugas'
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
}