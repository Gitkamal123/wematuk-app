<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tugas extends Model
{
    //1. Model softdeletes (tugas yg dihapus masuk keranjang sampah dulu), akan mengaktifkan 'onlyTrashed()', 'restore()', 'forceDelete()', dll.
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
    ];
}