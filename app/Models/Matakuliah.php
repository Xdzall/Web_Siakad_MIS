<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matakuliah extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode',
        'nama',
        'dosen_id',
        'kelas',
        'sks',
        'jadwal',
        'ruang',
    ];

    // Relasi ke dosen (user)
    public function dosen()
    {
        return $this->belongsTo(User::class, 'dosen_id');
    }
}
