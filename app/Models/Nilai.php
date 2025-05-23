<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    protected $table = 'nilai';
    
    protected $fillable = [
        'mahasiswa_id',
        'matakuliah_id',
        'dosen_id',
        'nilai_angka',
        'nilai_huruf'
    ];
    
    public function mahasiswa()
    {
        return $this->belongsTo(User::class, 'mahasiswa_id');
    }
    
    public function matakuliah()
    {
        return $this->belongsTo(Matakuliah::class);
    }
    
    public function dosen()
    {
        return $this->belongsTo(User::class, 'dosen_id');
    }
    
    // Konversi nilai angka ke huruf
    public static function konversiNilai($nilai_angka)
    {
        if ($nilai_angka >= 90) return 'A';
        if ($nilai_angka >= 80) return 'B';
        if ($nilai_angka >= 70) return 'C';
        if ($nilai_angka >= 60) return 'D';
        return 'E';
    }
}