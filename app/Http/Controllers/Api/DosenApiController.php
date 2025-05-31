<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DosenApiController extends Controller
{
    public function kelas()
    {
        $user = Auth::user();
        
        // Get unique kelas from jadwal
        $kelasIds = $user->jadwalKuliah()->distinct('kelas_id')->pluck('kelas_id');
        
        $kelasList = Kelas::whereIn('id', $kelasIds)
            ->where('active', true)
            ->get()
            ->map(function($kelas) {
                return [
                    'id' => $kelas->id,
                    'nama' => $kelas->nama,
                    'program_studi' => $kelas->program_studi,
                    'semester' => $kelas->semester,
                    'tahun_ajaran' => $kelas->tahun_ajaran,
                    'total_mahasiswa' => $kelas->mahasiswa->count()
                ];
            });
            
        return response()->json([
            'kelas_list' => $kelasList
        ]);
    }
    
    public function profile()
    {
        $user = Auth::user();
        
        $dosenWali = $user->is_wali ? Kelas::where('dosen_id', $user->id)->where('active', true)->first() : null;

        
        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'nip' => $user->nip,
            'is_wali' => $user->is_wali,
            'kelas_wali' => $dosenWali
        ]);
    }
}