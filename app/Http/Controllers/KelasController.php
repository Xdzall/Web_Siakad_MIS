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
        $dosen = User::role('dosen')->where('is_wali', true)->get();
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

        // Check if selected dosen is wali
        $dosen = User::findOrFail($request->dosen_id);
        if (!$dosen->is_wali) {
            return back()->with('error', 'Hanya dosen wali yang dapat menjadi pengampu kelas.');
        }

        $kelas = Kelas::create([
            'nama' => $request->nama,
            'dosen_id' => $request->dosen_id,
            'active' => true
        ]);

        // Check if mahasiswa already has a class
        if ($request->has('mahasiswa')) {
            foreach ($request->mahasiswa as $mahasiswaId) {
                $mahasiswa = User::find($mahasiswaId);
                if ($mahasiswa->kelas_id) {
                    return back()->with('error', "Mahasiswa {$mahasiswa->name} sudah terdaftar di kelas lain.");
                }
            }

            // Update mahasiswa kelas_id
            User::whereIn('id', $request->mahasiswa)->update(['kelas_id' => $kelas->id]);
        }

        return redirect()->route('admin.kelas.index')
            ->with('success', 'Kelas berhasil ditambahkan');
    }

    // Form edit kelas
    public function edit($id)
    {
        $kelas = Kelas::with('mahasiswa')->findOrFail($id);
        $dosen = User::role('dosen')->get();
        $mahasiswa = User::role('mahasiswa')->get();
        return view('admin.kelas.edit', compact('kelas', 'dosen', 'mahasiswa'));
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

        // Check if selected dosen is wali
        $dosen = User::findOrFail($request->dosen_id);
        if (!$dosen->is_wali) {
            return back()->with('error', 'Hanya dosen wali yang dapat menjadi pengampu kelas.');
        }

        $kelas->update([
            'nama' => $request->nama,
            'dosen_id' => $request->dosen_id,
            'active' => true
        ]);

        // Reset kelas_id for removed students
        User::where('kelas_id', $kelas->id)
            ->whereNotIn('id', $request->mahasiswa ?? [])
            ->update(['kelas_id' => null]);

        // Update kelas_id for new students
        if ($request->has('mahasiswa')) {
            foreach ($request->mahasiswa as $mahasiswaId) {
                $mahasiswa = User::find($mahasiswaId);
                if ($mahasiswa->kelas_id && $mahasiswa->kelas_id != $kelas->id) {
                    return back()->with('error', "Mahasiswa {$mahasiswa->name} sudah terdaftar di kelas lain.");
                }
            }

            User::whereIn('id', $request->mahasiswa)->update(['kelas_id' => $kelas->id]);
        }

        return redirect()->route('admin.kelas.index')
            ->with('success', 'Kelas berhasil diupdate');
    }

    // Hapus kelas
    public function destroy($id)
    {
        $kelas = Kelas::findOrFail($id);
        $kelas->mahasiswa()->detach();
        $kelas->delete();
        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil dihapus');
    }

    public function observeDosenWali($kelas)
    {
        $dosen = User::find($kelas->dosen_id);
        if (!$dosen || !$dosen->is_wali) {
            $kelas->update(['active' => false]);
        }
    }

    // (Opsional) Detail kelas
    public function show($id)
    {
        $kelas = Kelas::with(['dosen', 'mahasiswa'])->findOrFail($id);
        return view('admin.kelas.show', compact('kelas'));
    }
}
