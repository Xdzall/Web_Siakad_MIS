<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Matakuliah extends Model
{
    protected $fillable = [
        'kode',
        'nama',
        'dosen_id',
        'kelas_id', // Ubah dari 'kelas' ke 'kelas_id'
        'sks',
        'jadwal_id', // Ubah dari 'jadwal' ke 'jadwal_id'
        'ruang',
        'semester'
    ];

    public function dosen()
    {
        return $this->belongsTo(User::class, 'dosen_id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function jadwalKuliah()
    {
        return $this->belongsTo(JadwalKuliah::class, 'jadwal_id');
    }

    public function nilai()
    {
        return $this->hasMany(Nilai::class, 'mahasiswa_id');
    }
}
