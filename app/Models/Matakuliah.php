<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\JadwalKuliah;
use App\Models\Kelas;
use App\Models\Nilai;

class Matakuliah extends Model
{
    protected $fillable = [
        'kode',
        'nama',
        'semester',
        'sks'
    ];

    public function jadwalKuliah()
    {
        return $this->hasOne(JadwalKuliah::class);
    }

    public function dosen(){
        return $this->hasOneThrough(
            User::class,
            JadwalKuliah::class,
            'matakuliah_id',
            'id',
            'id',
            'dosen_id'
        );
    }

    public function kelas(){
        return $this->hasOneThrough(
            Kelas::class,
            JadwalKuliah::class,
            'matakuliah_id',
            'id',
            'id',
            'kelas_id'
        );
    }

    public function nilai()
    {
        return $this->hasMany(Nilai::class, 'matakuliah_id');
    }
}
