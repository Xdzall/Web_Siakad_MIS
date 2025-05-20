<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\User;
use App\Models\Matakuliah;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    // Tampilkan daftar kelas
    public function index()
    {
        $kelas = Kelas::with(['dosen', 'mahasiswa'])->get();
        return view('admin.kelas.index', compact('kelas'));
    }

    // Form tambah kelas
    public function create()
    {
        $dosen = User::role('dosen')->get();
        $mahasiswa = User::role('mahasiswa')->get();
        return view('admin.kelas.create', compact('dosen', 'mahasiswa'));
    }

    // Simpan kelas baru
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'dosen_id' => 'required|exists:users,id',
            'mahasiswa' => 'array'
        ]);

        $kelas = Kelas::create([
            'nama' => $request->nama,
            'dosen_id' => $request->dosen_id,
        ]);

        // Attach mahasiswa ke kelas (many-to-many)
        if ($request->has('mahasiswa')) {
            $kelas->mahasiswa()->attach($request->mahasiswa);
        }

        return redirect()->route('admin.kelas.index')->with('success', 'Kelas berhasil ditambahkan');
    }

    // Form edit kelas
    public function edit($id)
    {
        $kelas = Kelas::with('mahasiswa')->findOrFail($id);
        $dosen = User::role('dosen')->get();
        $mahasiswa = User::role('mahasiswa')->get();
        return view('admin.kelas.edit', compact('kelas', 'dosen', 'matakuliah', 'mahasiswa'));
    }

    // Update kelas
    public function update(Request $request, $id)
    {
        $kelas = Kelas::findOrFail($id);

        $request->validate([
            'nama' => 'required',
            'dosen_id' => 'required|exists:users,id',
            'mahasiswa' => 'array'
        ]);

        $kelas->update([
            'nama' => $request->nama,
            'dosen_id' => $request->dosen_id,
        ]);

        // Sync mahasiswa ke kelas
        $kelas->mahasiswa()->sync($request->mahasiswa ?? []);

        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil diupdate');
    }

    // Hapus kelas
    public function destroy($id)
    {
        $kelas = Kelas::findOrFail($id);
        $kelas->mahasiswa()->detach();
        $kelas->delete();
        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil dihapus');
    }

    // (Opsional) Detail kelas
    public function show($id)
    {
        $kelas = Kelas::with(['dosen', 'mahasiswa'])->findOrFail($id);
        return view('admin.kelas.show', compact('kelas'));
    }
}
