<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\User;
use App\Models\Matakuliah;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    // Tampilkan daftar kelas
    public function index(Request $request)
    {
        $query = Kelas::with(['dosen', 'mahasiswa']);

        // Filter by semester if selected
        if ($request->filled('semester')) {
            $query->where('semester', $request->semester);
        }

        // Get filtered results
        $kelas = $query->get();

        return view('admin.kelas.index', compact('kelas'));
    }

    // Form tambah kelas
    public function create()
    {
        // Get IDs of dosen that are already wali kelas
        $assignedDosenIds = Kelas::where('active', true)
            ->pluck('dosen_id')
            ->toArray();

        // Get only available dosen wali
        $dosen = User::role('dosen')
            ->where('is_wali', true)
            ->whereNotIn('id', $assignedDosenIds)
            ->get();

        return view('admin.kelas.create', compact('dosen'));
    }

    // Simpan kelas baru
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'semester' => 'required|integer|between:1,8',
            'tipe_semester' => 'required|in:ganjil,genap',
        ]);

        // Check if dosen_id exists and is valid
        if ($request->filled('dosen_id')) {
            $dosen = User::findOrFail($request->dosen_id);
            if (!$dosen->is_wali) {
                return back()
                    ->withInput()
                    ->with('error', 'Hanya dosen wali yang dapat menjadi pengampu kelas');
            }
        }

        $kelas = Kelas::create([
            'nama' => $request->nama,
            'semester' => $request->semester,
            'tipe_semester' => $request->tipe_semester,
            'dosen_id' => $request->dosen_id,
            'active' => (bool)$request->dosen_id
        ]);

        return redirect()->route('admin.kelas.index')
            ->with('success', 'Kelas berhasil ditambahkan' .
                (!$kelas->active ? ' (Kelas tidak aktif karena tidak ada dosen wali)' : ''));
    }

    // Form edit kelas
    public function edit($id)
    {
        $kelas = Kelas::with('mahasiswa')->findOrFail($id);

        // Get dosen wali yang available
        $assignedDosenIds = Kelas::where('active', true)
            ->where('id', '!=', $id)
            ->pluck('dosen_id')
            ->toArray();

        $dosen = User::role('dosen')
            ->where('is_wali', true)
            ->where(function ($query) use ($assignedDosenIds, $kelas) {
                $query->whereNotIn('id', $assignedDosenIds)
                    ->orWhere('id', $kelas->dosen_id);
            })
            ->get();
        // Get mahasiswa yang belum masuk kelas manapun atau sudah di kelas ini
        $availableMahasiswa = User::role('mahasiswa')
            ->where(function ($query) use ($kelas) {
                $query->whereNull('kelas_id')
                    ->orWhere('kelas_id', $kelas->id);
            })
            ->get();

        return view('admin.kelas.edit', compact('kelas', 'dosen', 'availableMahasiswa'));
    }
    // Update kelas
    public function update(Request $request, $id)
    {
        $kelas = Kelas::findOrFail($id);

        $request->validate([
            'nama' => 'required',
            'semester' => 'required|integer|between:1,8',
            'tipe_semester' => 'required|in:ganjil,genap',
        ]);

        // Check if dosen_id exists and is valid
        if ($request->filled('dosen_id')) {
            $dosen = User::findOrFail($request->dosen_id);
            if (!$dosen->is_wali) {
                return back()
                    ->withInput()
                    ->with('error', 'Hanya dosen wali yang dapat menjadi pengampu kelas');
            }
        }

        // Update kelas
        $kelas->update([
            'nama' => $request->nama,
            'semester' => $request->semester,
            'tipe_semester' => $request->tipe_semester,
            'dosen_id' => $request->dosen_id,
            'active' => (bool)$request->dosen_id
        ]);

        // If class becomes inactive, remove all students
        if (!$kelas->active) {
            User::where('kelas_id', $kelas->id)->update(['kelas_id' => null]);
            return redirect()->route('admin.kelas.index')
                ->with('warning', 'Kelas dinonaktifkan dan semua mahasiswa dipindahkan karena tidak ada dosen wali');
        }

        // Update mahasiswa only if class is active and current_mahasiswa array exists
        if ($kelas->active) {
            // First, remove all current students from this class
            User::where('kelas_id', $kelas->id)->update(['kelas_id' => null]);

            // Then, assign selected students to this class
            if ($request->has('current_mahasiswa') && is_array($request->current_mahasiswa)) {
                User::whereIn('id', $request->current_mahasiswa)
                    ->update(['kelas_id' => $kelas->id]);
            }
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
