<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalKuliah extends Model
{
    use HasFactory;

    protected $fillable = [
        'hari',
        'waktu',
    ];
    public function kelas()
    {
        return $this->hasMany(Kelas::class);
    }
    public function matakuliah()
    {
        return $this->hasMany(Matakuliah::class);
    }
    public function dosen()
    {
        return $this->hasMany(User::class);
    }
    public function mahasiswa()
    {
        return $this->hasMany(User::class);
    }
}
