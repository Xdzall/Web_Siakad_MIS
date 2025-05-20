<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Matakuliah extends Model
{
    protected $fillable = [
        'kode',
        'nama', 
        'dosen_id',
        'kelas',
        'sks',
        'jadwal',
        'ruang'
    ];

    public function dosen()
    {
        return $this->belongsTo(User::class, 'dosen_id');
    }

    public function kelasRelasi()
    {
        return $this->belongsTo(Kelas::class, 'kelas');
    }

    public function jadwalKuliah()
    {
        return $this->belongsTo(JadwalKuliah::class, 'jadwal');
    }
}