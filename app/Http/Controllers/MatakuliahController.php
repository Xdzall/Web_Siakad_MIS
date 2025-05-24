<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Kelas;
use App\Models\JadwalKuliah;
use Illuminate\Http\Request;
use App\Models\Matakuliah;
use Illuminate\Support\Facades\Log;

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
        if ($request->filled('semester') && $request->semester) {
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
        try {
            $request->validate([
                'kode' => 'required|unique:matakuliahs,kode',
                'nama' => 'required',
                'semester' => 'required|integer|between:1,8',
                'sks' => 'required|integer|min:1',
            ]);

            // Hanya menyimpan data dasar mata kuliah
            Matakuliah::create([
                'kode' => $request->kode,
                'nama' => $request->nama,
                'semester' => $request->semester,
                'sks' => $request->sks,
            ]);

            return redirect()->route('admin.matakuliah.index')
                ->with('success', 'Matakuliah berhasil ditambahkan');
        } catch (\Exception $e) {
            Log::error('Error menambahkan matakuliah: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Matakuliah tidak dapat ditambahkan: ' . $e->getMessage());
        }
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
        try {
            $request->validate([
                'kode' => 'required|unique:matakuliahs,kode,' . $id,
                'nama' => 'required',
                'semester' => 'required|integer|between:1,8',
                'sks' => 'required|integer|min:1',
            ]);

            $matakuliah = Matakuliah::findOrFail($id);

            /// Hanya update informasi dasar matakuliah
            $matakuliah->update([
                'kode' => $request->kode,
                'nama' => $request->nama,
                'semester' => $request->semester,
                'sks' => $request->sks,
            ]);

            return redirect()->route('admin.matakuliah.index')
                ->with('success', 'Matakuliah berhasil diperbarui');
        } catch (\Exception $e) {
            Log::error('Error memperbarui matakuliah: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Matakuliah tidak dapat diperbarui: ' . $e->getMessage());
        }
    }
    
    public function destroyMatakuliah($id)
    {
        $matakuliah = Matakuliah::findOrFail($id);
        $matakuliah->delete();

        return redirect()->route('admin.matakuliah.index')
            ->with('success', 'Matakuliah berhasil dihapus');
    }
}
