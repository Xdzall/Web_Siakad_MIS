<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'dosen_id',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean'
    ];
    public function dosen()
    {
        return $this->belongsTo(User::class, 'dosen_id');
    }
    public function matakuliah()
    {
        return $this->belongsTo(Matakuliah::class, 'matakuliah_id');
    }
    public function mahasiswa()
    {
        return $this->belongsToMany(User::class, 'kelas_mahasiswa', 'kelas_id', 'mahasiswa_id');
    }
    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }
}
