<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JadwalKuliah;
use App\Models\Kelas; // Tambahkan import Kelas
use App\Models\Matakuliah; // Tambahkan import untuk dropdown matakuliah
use App\Models\User; // Tambahkan import untuk dropdown dosen

class JadwalKuliahController extends Controller
{
    public function index(Request $request)
    {
        $query = JadwalKuliah::with(['matakuliah', 'dosen', 'kelas']);
        
        // Filter berdasarkan kelas
        if ($request->has('kelas') && $request->kelas) {
            $query->where('kelas_id', $request->kelas);
        }
        
        // Filter berdasarkan hari
        if ($request->has('hari') && $request->hari) {
            $query->where('hari', $request->hari);
        }
        
        $jadwal = $query->get();
        $kelas = Kelas::all();
        
        return view('admin.jadwal.index', compact('jadwal', 'kelas'));
    }

    // Tambahkan method lain yang diperlukan
    public function create()
    {
        $matakuliah = Matakuliah::all();
        $dosen = User::role('dosen')->get();
        $kelas = Kelas::all();
        
        return view('admin.jadwal.create', compact('matakuliah', 'dosen', 'kelas'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'matakuliah_id' => 'required|exists:matakuliahs,id',
            'dosen_id' => 'required|exists:users,id',
            'kelas_id' => 'required|exists:kelas,id',
            'hari' => 'required|string',
            'waktu' => 'required|string',
            'ruang' => 'required|string',
        ]);
        
        JadwalKuliah::create($request->all());
        
        return redirect()->route('admin.jadwal.index')
            ->with('success', 'Jadwal kuliah berhasil ditambahkan');
    }
    
    public function edit($id)
    {
        $jadwal = JadwalKuliah::findOrFail($id);
        $matakuliah = Matakuliah::all();
        $dosen = User::role('dosen')->get();
        $kelas = Kelas::all();
        
        return view('admin.jadwal.edit', compact('jadwal', 'matakuliah', 'dosen', 'kelas'));
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'matakuliah_id' => 'required|exists:matakuliahs,id',
            'dosen_id' => 'required|exists:users,id',
            'kelas_id' => 'required|exists:kelas,id',
            'hari' => 'required|string',
            'waktu' => 'required|string',
            'ruang' => 'required|string',
        ]);
        
        $jadwal = JadwalKuliah::findOrFail($id);
        $jadwal->update($request->all());
        
        return redirect()->route('admin.jadwal.index')
            ->with('success', 'Jadwal kuliah berhasil diperbarui');
    }
    
    public function destroy($id)
    {
        $jadwal = JadwalKuliah::findOrFail($id);
        $jadwal->delete();
        
        return redirect()->route('admin.jadwal.index')
            ->with('success', 'Jadwal kuliah berhasil dihapus');
    }
}
