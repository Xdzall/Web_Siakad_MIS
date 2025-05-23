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
        'semester',
        'tipe_semester',
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
        return $this->hasMany(Matakuliah::class);
    }
    public function mahasiswa()
    {
        return $this->hasMany(User::class, 'kelas_id');
    }
    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function scopeByTipeSemester($query, $type)
    {
        return $query->where('tipe_semester', $type);
    }

    // Helper method to get only odd semester classes
    public function scopeGanjil($query)
    {
        return $query->where('tipe_semester', 'ganjil');
    }

    // Helper method to get only even semester classes
    public function scopeGenap($query)
    {
        return $query->where('tipe_semester', 'genap');
    }

    public function scopeHasDosenWali($query, $dosenId)
    {
        return $query->where('dosen_id', $dosenId)
            ->where('active', true);
    }

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    public function updateStatus()
    {
        $this->active = !is_null($this->dosen_id);
        $this->save();
    }
}
