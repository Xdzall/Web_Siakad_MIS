<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Kelas;
use App\Models\JadwalKuliah;
use Illuminate\Http\Request;
use App\Models\Matakuliah;

class MatakuliahController extends Controller
{
    public function matakuliah(Request $request)
    {
        $query = Matakuliah::with(['dosen', 'kelas', 'jadwalKuliah']);

        // Filter berdasarkan kelas
        if ($request->filled('kelas')) {
            $query->where('kelas_id', $request->kelas);
        }

        // Filter berdasarkan semester
        if ($request->filled('semester')) {
            $query->where('semester', $request->semester);
        }

        $matakuliah = $query->get();
        $kelas = Kelas::where('active', true)->get();

        return view('admin.matakuliah.index', compact('matakuliah', 'kelas'));
    }

    public function createMatakuliah()
    {
        $dosen = User::role('dosen')->get();
        $kelas = Kelas::where('active', true)->get();
        $jadwal = JadwalKuliah::all();

        return view('admin.matakuliah.create', compact('dosen', 'kelas', 'jadwal'));
    }

    public function storeMatakuliah(Request $request)
    {
        $request->validate([
            'kode' => 'required|unique:matakuliahs,kode',
            'nama' => 'required',
            'dosen_id' => 'required|exists:users,id',
            'kelas_id' => 'required|exists:kelas,id',
            'semester' => 'required|integer|between:1,8',
            'sks' => 'required|integer|min:1',
            'jadwal_id' => 'required|exists:jadwal_kuliahs,id',
            'ruang' => 'required'
        ]);

        // Check if kelas is active
        $kelas = Kelas::find($request->kelas_id);
        if (!$kelas->active) {
            return back()->with('error', 'Tidak dapat menambahkan matakuliah ke kelas yang tidak aktif');
        }

        // Cek apakah jadwal bentrok untuk kelas yang sama
        $jadwalBentrok = Matakuliah::where('kelas_id', $request->kelas_id)
            ->where('jadwal_id', $request->jadwal_id)
            ->exists();

        if ($jadwalBentrok) {
            return back()->with('error', 'Jadwal bentrok dengan mata kuliah lain di kelas yang sama');
        }

        Matakuliah::create($request->all());

        return redirect()->route('admin.matakuliah.index')
            ->with('success', 'Matakuliah berhasil ditambahkan');
    }

    public function editMatakuliah($id)
    {
        $matakuliah = Matakuliah::findOrFail($id);
        $dosen = User::role('dosen')->get();
        $kelas = Kelas::where('active', true)->get();
        $jadwal = JadwalKuliah::all();

        return view('admin.matakuliah.edit', compact('matakuliah', 'dosen', 'kelas', 'jadwal'));
    }
    public function updateMatakuliah(Request $request, $id)
    {
        $request->validate([
            'kode' => 'required|unique:matakuliahs,kode,' . $id,
            'nama' => 'required',
            'dosen_id' => 'required|exists:users,id',
            'kelas_id' => 'required|exists:kelas,id',
            'semester' => 'required|integer|between:1,8',
            'sks' => 'required|integer|min:1',
            'jadwal_id' => 'required|exists:jadwal_kuliahs,id',
            'ruang' => 'required'
        ]);

        // Check if kelas is active
        $kelas = Kelas::find($request->kelas_id);
        if (!$kelas->active) {
            return back()->with('error', 'Tidak dapat menambahkan matakuliah ke kelas yang tidak aktif');
        }

        // Cek apakah jadwal bentrok untuk kelas yang sama
        $jadwalBentrok = Matakuliah::where('kelas_id', $request->kelas_id)
            ->where('jadwal_id', $request->jadwal_id)
            ->where('id', '<>', $id)
            ->exists();

        if ($jadwalBentrok) {
            return back()->with('error', 'Jadwal bentrok dengan mata kuliah lain di kelas yang sama');
        }

        $matakuliah = Matakuliah::findOrFail($id);
        $matakuliah->update($request->all());

        return redirect()->route('admin.matakuliah.index')
            ->with('success', 'Matakuliah berhasil diperbarui');
    }
    public function destroyMatakuliah($id)
    {
        $matakuliah = Matakuliah::findOrFail($id);
        $matakuliah->delete();

        return redirect()->route('admin.matakuliah.index')
            ->with('success', 'Matakuliah berhasil dihapus');
    }
}
