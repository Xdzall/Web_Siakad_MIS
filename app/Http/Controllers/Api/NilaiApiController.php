<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Nilai;
use App\Models\JadwalKuliah;
use App\Models\Matakuliah;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class NilaiApiController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get all jadwal for this dosen
        $jadwalList = JadwalKuliah::where('dosen_id', $user->id)
            ->with(['matakuliah', 'kelas'])
            ->get()
            ->map(function($jadwal) {
                return [
                    'id' => $jadwal->id,
                    'matakuliah_id' => $jadwal->matakuliah_id,
                    'kelas_id' => $jadwal->kelas_id,
                    'nama_matakuliah' => $jadwal->matakuliah->nama,
                    'kode' => $jadwal->matakuliah->kode,
                    'sks' => $jadwal->matakuliah->sks,
                    'kelas' => $jadwal->kelas->nama,
                    'hari' => $jadwal->hari,
                    'waktu' => $jadwal->waktu
                ];
            });
            
        return response()->json([
            'jadwal_list' => $jadwalList
        ]);
    }
    
    public function getMahasiswa(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'matakuliah_id' => 'required|exists:matakuliahs,id'
        ]);
        
        // Get all mahasiswa in this kelas
        $mahasiswaList = User::whereHas('roles', function($q) {
                $q->where('name', 'mahasiswa');
            })
            ->where('kelas_id', $request->kelas_id)
            ->get()
            ->map(function($mhs) use ($request) {
                // Get nilai if exists
                $nilai = Nilai::where('mahasiswa_id', $mhs->id)
                    ->where('matakuliah_id', $request->matakuliah_id)
                    ->first();
                    
                return [
                    'id' => $mhs->id,
                    'name' => $mhs->name,
                    'nrp' => $mhs->nrp,
                    'nilai_angka' => $nilai ? $nilai->nilai_angka : null,
                    'nilai_huruf' => $nilai ? $nilai->nilai_huruf : null
                ];
            });
            
        return response()->json([
            'mahasiswa_list' => $mahasiswaList
        ]);
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'mahasiswa_id' => 'required|exists:users,id',
            'matakuliah_id' => 'required|exists:matakuliahs,id',
            'nilai_angka' => 'required|integer|min:0|max:100'
        ]);
        
        // Konversi nilai angka ke huruf
        $nilai_huruf = Nilai::konversiNilai($request->nilai_angka);
        
        // Update atau buat nilai baru
        $nilai = Nilai::updateOrCreate(
            [
                'mahasiswa_id' => $request->mahasiswa_id,
                'matakuliah_id' => $request->matakuliah_id
            ],
            [
                'dosen_id' => Auth::id(),
                'nilai_angka' => $request->nilai_angka,
                'nilai_huruf' => $nilai_huruf
            ]
        );
        
        return response()->json([
            'message' => 'Nilai berhasil disimpan',
            'nilai' => [
                'mahasiswa_id' => $nilai->mahasiswa_id,
                'matakuliah_id' => $nilai->matakuliah_id,
                'nilai_angka' => $nilai->nilai_angka,
                'nilai_huruf' => $nilai->nilai_huruf
            ]
        ]);
    }
    
    public function mahasiswaNilai()
    {
        $user = Auth::user();
        
        // Get all nilai for this mahasiswa
        $nilaiList = Nilai::where('mahasiswa_id', $user->id)
            ->with(['matakuliah', 'dosen'])
            ->get()
            ->map(function($nilai) {
                return [
                    'id' => $nilai->id,
                    'matakuliah_id' => $nilai->matakuliah_id,
                    'nama_matakuliah' => $nilai->matakuliah->nama,
                    'kode' => $nilai->matakuliah->kode,
                    'sks' => $nilai->matakuliah->sks,
                    'nilai_angka' => $nilai->nilai_angka,
                    'nilai_huruf' => $nilai->nilai_huruf,
                    'dosen' => $nilai->dosen->name
                ];
            });
            
        // Calculate IP
        $totalSks = 0;
        $totalNilai = 0;
        
        foreach ($nilaiList as $nilai) {
            $bobot = 0;
            switch ($nilai['nilai_huruf']) {
                case 'A': $bobot = 4; break;
                case 'AB': $bobot = 3.5; break;
                case 'B': $bobot = 3; break;
                case 'BC': $bobot = 2.5; break;
                case 'C': $bobot = 2; break;
                case 'D': $bobot = 1; break;
                case 'E': $bobot = 0; break;
            }
            
            $totalSks += $nilai['sks'];
            $totalNilai += ($nilai['sks'] * $bobot);
        }
        
        $ip = $totalSks > 0 ? round($totalNilai / $totalSks, 2) : 0;
            
        return response()->json([
            'nilai_list' => $nilaiList,
            'ip' => $ip,
            'total_sks' => $totalSks
        ]);
    }
}