<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

    public function frs()
    {
        // Hanya dosen wali yang bisa mengakses halaman FRS
        if (!auth()->user()->is_wali) {
            return redirect()->route('dosen.dashboard')
                ->with('error', 'Hanya dosen wali yang dapat mengakses halaman FRS');
        }

        // Tampilkan FRS untuk mahasiswa yang diampu
        return view('dosen.frs');
    }

    public function accFrs(Request $request, $id)
    {
        if (!auth()->user()->is_wali) {
            return redirect()->back()
                ->with('error', 'Anda tidak memiliki akses untuk menyetujui FRS');
        }

        // Proses persetujuan FRS
        // ...

        return redirect()->back()->with('success', 'FRS berhasil disetujui');
    }


    public function nilai()
    {
        return view('dosen.nilai');
    }

    public function jadwal()
    {
        $jadwal = JadwalKuliah::all(); // Mengambil semua data jadwal kuliah
        return view('dosen.jadwal', compact('jadwal'));
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
