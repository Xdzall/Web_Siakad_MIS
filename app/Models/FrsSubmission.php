<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FrsSubmission extends Model
{
    protected $fillable = [
        'mahasiswa_id',
        'matakuliah_id',
        'kelas_id',
        'status',
        'rejection_reason',
        'validated_at',
        'validated_by'
    ];

    protected $casts = [
        'validated_at' => 'datetime'
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(User::class, 'mahasiswa_id');
    }

    public function matakuliah()
    {
        return $this->belongsTo(Matakuliah::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function validator()
    {
        return $this->belongsTo(User::class, 'validated_by');
    }
}