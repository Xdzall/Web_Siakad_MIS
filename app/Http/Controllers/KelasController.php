<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\User;
use App\Models\Matakuliah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class KelasController extends Controller
{
    // Tampilkan daftar kelas
    public function index(Request $request)
    {
        $query = Kelas::with(['dosen', 'mahasiswa'])->withCount('mahasiswa');

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
    public function update(Request $request, $id){
        Log::info('Current mahasiswa: ', [
            'data' => $request->has('current_mahasiswa') ? $request->current_mahasiswa : 'none'
        ]);
        $kelas = Kelas::findOrFail($id);
        
        // Basic validation
        $request->validate([
            'nama' => 'required',
            'semester' => 'required|integer|between:1,8',
            'tipe_semester' => 'required|in:ganjil,genap',
        ]);
        
        // Update kelas details
        $kelas->update([
            'nama' => $request->nama,
            'semester' => $request->semester,
            'tipe_semester' => $request->tipe_semester,
            'dosen_id' => $request->dosen_id,
            'active' => (bool)$request->dosen_id
        ]);
        
        // If class is inactive, remove all students
        if (!$kelas->active) {
            User::where('kelas_id', $kelas->id)->update(['kelas_id' => null]);
            return redirect()->route('admin.kelas.index')
                ->with('warning', 'Kelas dinonaktifkan dan semua mahasiswa dipindahkan karena tidak ada dosen wali');
        }
        
        // Process student assignments if class is active and form was submitted
        if ($kelas->active && $request->has('students_processed')) {
            $currentStudentIds = User::where('kelas_id', $kelas->id)->pluck('id')->toArray();
            
            // Get submitted student IDs (could be empty array if all removed)
            $submittedStudentIds = $request->has('current_mahasiswa') ? 
                (is_array($request->current_mahasiswa) ? $request->current_mahasiswa : [$request->current_mahasiswa]) 
                : [];
            
            // Remove students no longer in the list
            User::whereIn('id', $currentStudentIds)
                ->whereNotIn('id', $submittedStudentIds)
                ->update(['kelas_id' => null]);
                
            // Add new students to the class
            if (!empty($submittedStudentIds)) {
                User::whereIn('id', $submittedStudentIds)
                    ->update(['kelas_id' => $kelas->id]);
            }
        }
        
        return redirect()->route('admin.kelas.index')
            ->with('success', 'Kelas berhasil diupdate');
    }

    // Hapus kelas
    public function destroy($id){
        $kelas = Kelas::findOrFail($id);
        User::where('kelas_id', $kelas->id)->update(['kelas_id' => null]);
        $kelas->delete();
        return redirect()->route('admin.kelas.index')->with('success', 'Kelas berhasil dihapus');
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
