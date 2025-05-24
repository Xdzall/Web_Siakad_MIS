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
        'matakuliah_id',
        'dosen_id',
        'kelas_id',
        'ruang'
    ];
    
    public function matakuliah()
    {
        return $this->belongsTo(Matakuliah::class);
    }
    
    public function dosen()
    {
        return $this->belongsTo(User::class, 'dosen_id');
    }
    
    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }
}
