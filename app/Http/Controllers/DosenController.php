<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JadwalKuliah;
use App\Models\Matakuliah;
use App\Models\Kelas;
use App\Models\FrsSubmission;

class DosenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function dashboard()
    {
        return view('dosen.dashboard');
    }

    public function frs()
    {
        // Check if user is dosen wali
        if (!auth()->user()->is_wali) {
            return redirect()->route('dosen.dashboard')
                ->with('error', 'Hanya dosen wali yang dapat mengakses halaman FRS');
        }

        // Get kelas where current dosen is wali with relationships
        $kelas = Kelas::where('dosen_id', auth()->id())
            ->where('active', true)
            ->with(['mahasiswa', 'matakuliah.jadwalKuliah'])
            ->first();

        if (!$kelas) {
            return redirect()->route('dosen.dashboard')
                ->with('error', 'Anda belum ditugaskan sebagai dosen wali');
        }

        // Get all FRS submissions for this kelas
        $frsSubmissions = FrsSubmission::where('kelas_id', $kelas->id)
            ->with(['mahasiswa', 'matakuliah'])
            ->get()
            ->groupBy('matakuliah_id');

        return view('dosen.frs', compact('kelas', 'frsSubmissions'));
    }

    public function validateFrs(Request $request)
    {
        $request->validate([
            'frs_id' => 'required|exists:frs_submissions,id',
            'status' => 'required|in:approved,rejected',
            'reason' => 'required_if:status,rejected'
        ]);

        $frs = FrsSubmission::findOrFail($request->frs_id);

        // Verify this dosen is the wali for this kelas
        if ($frs->kelas->dosen_id !== auth()->id()) {
            return back()->with('error', 'Unauthorized action');
        }

        $frs->update([
            'status' => $request->status,
            'rejection_reason' => $request->reason,
            'validated_at' => now(),
            'validated_by' => auth()->id()
        ]);

        return back()->with('success', 'FRS berhasil divalidasi');
    }


    public function nilai()
    {
        return view('dosen.nilai');
    }

    public function jadwal()
    {
        // Get logged in dosen's matakuliah
        $matakuliah = Matakuliah::with('jadwalKuliah')
            ->where('dosen_id', auth()->id())
            ->get();

        // Group jadwal by hari
        $grouped = collect();
        foreach ($matakuliah as $mk) {
            $grouped->push([
                'hari' => $mk->jadwalKuliah->hari,
                'mata_kuliah' => $mk->nama,
                'waktu' => $mk->jadwalKuliah->waktu,
                'ruang' => $mk->ruang,
                'kelas' => $mk->kelas->nama
            ]);
        }

        $grouped = $grouped->groupBy('hari');

        return view('dosen.jadwal', compact('grouped'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
