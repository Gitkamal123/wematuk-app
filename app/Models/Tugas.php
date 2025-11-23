<?php

namespace App\Models;

// 👇 1. TAMBAHKAN 'SoftDeletes' DI BARIS 'USE' INI 👇
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tugas extends Model
{
    // 👇 2. TAMBAHKAN 'SoftDeletes' DI DALAM 'USE' INI 👇
    // Ini akan mengaktifkan 'onlyTrashed()', 'restore()', 'forceDelete()', dll.
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'judul',
        'deskripsi',
        'deadline',
        'file_path',
        // 'status' sudah kita hapus, jadi ini sudah benar
    ];
}