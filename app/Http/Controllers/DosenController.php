<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Matakuliah;
use App\Models\Kelas;
use App\Models\FrsSubmission;
use App\Models\Nilai;
use App\Models\User;
use App\Models\JadwalKuliah;


class DosenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function dashboard()
    {
        return view('dosen.dashboard');
    }

    public function frs(){
        // Check if user is dosen wali
        if (!auth()->user()->is_wali) {
            return redirect()->route('dosen.dashboard')
                ->with('error', 'Hanya dosen wali yang dapat mengakses halaman FRS');
        }

        // Get kelas where current dosen is wali with relationships
        $kelas = Kelas::where('dosen_id', auth()->id())
            ->where('active', true)
            ->with(['mahasiswa', 'matakuliah'])
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

        foreach ($kelas->matakuliah as $mk) {
            if (!isset($frsSubmissions[$mk->id])) {
                $frsSubmissions[$mk->id] = collect();
            }
        }

        return view('dosen.frs', compact('kelas', 'frsSubmissions'));
    }

    public function validateFrs(Request $request)
    {
        // Validasi request
        $request->validate([
            'frs_id' => 'required|exists:frs_submissions,id',
            'status' => 'required|in:approved,rejected',
            'reason' => 'required_if:status,rejected'
        ]);

        // Ambil submission FRS berdasarkan ID
        $frs = FrsSubmission::findOrFail($request->frs_id);

        // Pastikan yang memvalidasi adalah dosen wali dari kelas tersebut
        $kelas = Kelas::find($frs->kelas_id);
        if ($kelas->dosen_id != auth()->id()) {
            return back()->with('error', 'Anda tidak berwenang memvalidasi FRS ini');
        }

        // Update status FRS
        $frs->status = $request->status;

        // Jika ditolak, tambahkan alasan
        if ($request->status === 'rejected') {
            $frs->rejection_reason = $request->reason;
        } else {
            $frs->rejection_reason = null;
        }

        $frs->validated_at = now();
        $frs->validated_by = auth()->id();
        $frs->save();

        return back()->with('success', 'FRS berhasil divalidasi dengan status: ' .
            ($request->status === 'approved' ? 'Disetujui' : 'Ditolak'));
    }

    public function nilai(Request $request){
            $kelasYangDiampu = JadwalKuliah::where('dosen_id', auth()->id())
                ->with('kelas')
                ->get()
                ->pluck('kelas')
                ->unique('id');

            $selectedKelas = null;
            $mahasiswa = collect();
            $selectedMatakuliah = null;
            $matakuliah = collect();

            if ($request->filled('kelas_id')) {
                $selectedKelas = Kelas::find($request->kelas_id);

                $matakuliah = JadwalKuliah::where('dosen_id', auth()->id())
                    ->where('kelas_id', $request->kelas_id)
                    ->with('matakuliah')
                    ->get()
                    ->pluck('matakuliah')
                    ->unique('id');

                if ($request->filled('matakuliah_id')) {
                    $selectedMatakuliah = Matakuliah::find($request->matakuliah_id);

                    $approvedMahasiswaIds = FrsSubmission::where('kelas_id', $request->kelas_id)
                        ->where('matakuliah_id', $request->matakuliah_id)
                        ->where('status', 'approved')
                        ->pluck('mahasiswa_id');

                    $mahasiswa = User::whereIn('id', $approvedMahasiswaIds)
                        ->with(['nilai' => function ($query) use ($request) {
                            $query->where('matakuliah_id', $request->matakuliah_id);
                        }])
                        ->get();
                }
            }

            return view('dosen.nilai', compact('kelasYangDiampu', 'selectedKelas', 'mahasiswa', 'matakuliah', 'selectedMatakuliah'));
        }

    public function storeNilai(Request $request)
    {
        $request->validate([
            'mahasiswa_id' => 'required|exists:users,id',
            'matakuliah_id' => 'required|exists:matakuliahs,id',
            'nilai_angka' => 'required|integer|min:0|max:100'
        ]);

        // Konversi nilai angka ke huruf
        $nilai_huruf = Nilai::konversiNilai($request->nilai_angka);

        // Update atau buat nilai baru
        Nilai::updateOrCreate(
            [
                'mahasiswa_id' => $request->mahasiswa_id,
                'matakuliah_id' => $request->matakuliah_id
            ],
            [
                'dosen_id' => auth()->id(),
                'nilai_angka' => $request->nilai_angka,
                'nilai_huruf' => $nilai_huruf
            ]
        );

        return response()->json([
            'success' => true,
            'nilai_huruf' => $nilai_huruf
        ]);
    }

    public function jadwal(){
        $user = auth()->user();
        $jadwal = JadwalKuliah::where('dosen_id', $user->id)
            ->with(['matakuliah', 'kelas'])
            ->get();

        // Group jadwal by hari
        $grouped = collect();
        foreach ($jadwal as $jdwl) {
            $grouped->push([
                'hari' => $jdwl->hari,
                'mata_kuliah' => $jdwl->matakuliah->nama,
                'waktu' => $jdwl->waktu,
                'ruang' => $jdwl->ruang,
                'kelas' => $jdwl->kelas->nama
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
