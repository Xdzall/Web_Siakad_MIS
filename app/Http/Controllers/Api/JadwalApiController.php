<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JadwalKuliah;
use App\Models\FrsSubmission;
use Illuminate\Support\Facades\Auth;

class JadwalApiController extends Controller
{
    public function mahasiswaJadwal()
    {
        $user = Auth::user();
        $approvedMatakuliah = FrsSubmission::where('mahasiswa_id', $user->id)
            ->where('status', 'approved')
            ->with(['matakuliah.jadwalKuliah.dosen'])
            ->get()
            ->pluck('matakuliah');

        $jadwal = [];
        foreach ($approvedMatakuliah as $mk) {
            if ($mk && $mk->jadwalKuliah && $mk->jadwalKuliah->count() > 0) {
                $jadwalEntry = $mk->jadwalKuliah->first();
                $jadwal[] = [
                    'hari' => $jadwalEntry->hari,
                    'mata_kuliah' => $mk->nama,
                    'kode' => $mk->kode,
                    'sks' => $mk->sks,
                    'waktu' => $jadwalEntry->waktu,
                    'ruang' => $jadwalEntry->ruang,
                    'dosen' => $jadwalEntry->dosen->name ?? 'Belum ditentukan'
                ];
            }
        }

        return response()->json([
            'jadwal' => collect($jadwal)->groupBy('hari')
        ]);
    }

    public function dosenJadwal()
    {
        $user = Auth::user();
        $jadwal = JadwalKuliah::where('dosen_id', $user->id)
            ->with(['matakuliah', 'kelas'])
            ->get()
            ->map(function($item) {
                return [
                    'id' => $item->id,
                    'hari' => $item->hari,
                    'mata_kuliah' => $item->matakuliah->nama,
                    'kode' => $item->matakuliah->kode,
                    'sks' => $item->matakuliah->sks,
                    'waktu' => $item->waktu,
                    'ruang' => $item->ruang,
                    'kelas' => $item->kelas->nama,
                    'matakuliah_id' => $item->matakuliah_id,
                    'kelas_id' => $item->kelas_id
                ];
            });

        return response()->json([
            'jadwal' => $jadwal->groupBy('hari')
        ]);
    }
}