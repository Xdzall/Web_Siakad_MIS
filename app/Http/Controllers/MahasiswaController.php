<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Matakuliah;
use App\Models\FrsSubmission;
use App\Models\Nilai;
use App\Models\JadwalKuliah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MahasiswaController extends Controller
{
    public function dashboard()
    {
        return view('mahasiswa.dashboard');
    }

    public function jadwal()
    {
        $user = Auth::user();
        $approvedMatakuliah = FrsSubmission::where('mahasiswa_id', $user->id)
            ->where('status', 'approved')
            ->with(['matakuliah.jadwalKuliah'])
            ->get()
            ->pluck('matakuliah');

        // Group by hari for display
        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
        $grouped = collect();

        foreach ($approvedMatakuliah as $mk) {
            if ($mk && $mk->jadwalKuliah) {
                $grouped->push([
                    'hari' => $mk->jadwalKuliah->hari,
                    'mata_kuliah' => $mk->nama,
                    'waktu' => $mk->jadwalKuliah->waktu,
                    'ruang' => $mk->ruang,
                    'dosen' => $mk->dosen->name
                ]);
            }
        }

        $grouped = $grouped->groupBy('hari');

        return view('mahasiswa.jadwal', compact('grouped'));
    }

    public function frs()
    {
        $user = Auth::user();
        $kelas = $user->kelas;

        if (!$kelas) {
            return back()->with('error', 'Anda belum terdaftar di kelas manapun.');
        }

        // Get matakuliah available for this kelas
        $matakuliahList = JadwalKuliah::with(['matakuliah', 'dosen', 'kelas'])
            ->whereHas('matakuliah', function($query) use ($kelas){
                $query->where('semester', $kelas->semester);
            })
            ->get();

        // Get user's FRS submissions
        $frsSubmissions = FrsSubmission::where('mahasiswa_id', $user->id)
            ->with('matakuliah')
            ->get()
            ->keyBy('matakuliah_id');

        return view('mahasiswa.frs', compact('user', 'kelas', 'matakuliahList', 'frsSubmissions'));
    }

    public function storeFrs(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'matakuliah_id' => 'required|exists:matakuliahs,id',
        ]);

        // Check if matakuliah belongs to user's kelas
        $matakuliah = Matakuliah::findOrFail($request->matakuliah_id);
        if ($matakuliah->kelas_id != $user->kelas_id) {
            return back()->with('error', 'Matakuliah tidak tersedia untuk kelas Anda.');
        }

        // Create FRS submission
        FrsSubmission::create([
            'mahasiswa_id' => $user->id,
            'matakuliah_id' => $request->matakuliah_id,
            'kelas_id' => $user->kelas_id,
            'status' => 'pending'
        ]);

        return back()->with('success', 'Matakuliah berhasil ditambahkan ke FRS Anda.');
    }

    public function destroyFrs(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'matakuliah_id' => 'required|exists:matakuliahs,id',
        ]);

        // Find and delete the FRS submission
        $frs = FrsSubmission::where('mahasiswa_id', $user->id)
            ->where('matakuliah_id', $request->matakuliah_id)
            ->first();

        if (!$frs) {
            return back()->with('error', 'Matakuliah tidak ditemukan pada FRS Anda.');
        }

        // Check if already approved - can't delete approved submissions
        if ($frs->status === 'approved') {
            return back()->with('error', 'Matakuliah yang sudah disetujui tidak dapat dihapus.');
        }

        $frs->delete();
        return back()->with('success', 'Matakuliah berhasil dihapus dari FRS Anda.');
    }

    public function nilai()
    {
        $user = Auth::user();
        $nilai = Nilai::where('mahasiswa_id', $user->id)
            ->with(['matakuliah', 'matakuliah.dosen'])
            ->get();

        // Calculate GPA (IPK)
        $totalSKS = 0;
        $totalBobot = 0;

        foreach ($nilai as $n) {
            $bobot = $this->getNilaiBobot($n->nilai_huruf);
            $totalSKS += $n->matakuliah->sks;
            $totalBobot += ($bobot * $n->matakuliah->sks);
        }

        $ipk = $totalSKS > 0 ? $totalBobot / $totalSKS : 0;

        return view('mahasiswa.nilai', compact('nilai', 'ipk'));
    }

    private function getNilaiBobot($huruf)
    {
        switch ($huruf) {
            case 'A':
                return 4;
            case 'B':
                return 3;
            case 'C':
                return 2;
            case 'D':
                return 1;
            default:
                return 0;
        }
    }
}
