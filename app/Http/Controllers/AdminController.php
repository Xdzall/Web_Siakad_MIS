<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Dosen;
use App\Models\Mahasiswa;

class AdminController extends Controller
{

    public function storeDosen(Request $request)
    {
        $request->validate([
            'nip' => 'required|unique:dosens',
            'name' => 'required',
            'email_prefix' => 'required|alpha_dash|unique:dosens,email',
            'password' => 'required|min:6',
        ]);

        $email = strtolower($request->email_prefix) . '@it.lecturer.pens.ac.id';

        // Simpan ke tabel dosen
        $dosen = Dosen::create([
            'nip' => $request->nip,
            'name' => $request->name,
            'email' => $email,
            'password' => Hash::make($request->password),
        ]);
        $dosen->assignRole('dosen');

        return redirect()->back()->with('success', 'Dosen berhasil ditambahkan');
    }

    public function storeMahasiswa(Request $request)
    {
        $request->validate([
            'nrp' => 'required|unique:mahasiswas',
            'name' => 'required',
            'email' => 'required|email|unique:mahasiswas',
            'password' => 'required|min:6',
        ]);

        $mahasiswa = Mahasiswa::create([
            'nrp' => $request->nrp,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $mahasiswa->assignRole('mahasiswa');

        return redirect()->back()->with('success', 'Mahasiswa berhasil ditambahkan');
    }

    public function editDosen($id)
    {
        $dosen = Dosen::findOrFail($id);
        return view('admin.dosen.edit', compact('dosen'));
    }

    public function updateDosen(Request $request, $id)
    {
        $dosen = Dosen::findOrFail($id);

        $email = strtolower($request->email_prefix) . '@it.lecturer.pens.ac.id';

        $request->validate([
            'nip' => 'required|unique:dosens,nip,' . $dosen->id,
            'name' => 'required',
            'email_prefix' => 'required|alpha_dash|unique:dosens,email,' . $dosen->id,
        ]);

        $dosen->update([
            'nip' => $request->nip,
            'name' => $request->name,
            'email' => $email,
        ]);

        return redirect()->route('admin.dosen.index')->with('success', 'Dosen berhasil diupdate');
    }

    public function destroyDosen($id)
    {
        $dosen = Dosen::findOrFail($id);
        $dosen->delete();
        return redirect()->route('admin.dosen.index')->with('success', 'Dosen berhasil dihapus');
    }

    public function dosenIndex()
    {
        $dosen = Dosen::role('dosen')->get(); // Mengambil semua user dengan role dosen
        return view('admin.dosen.index', compact('dosen'));
    }

    public function mahasiswaIndex()
    {
        $mahasiswa = Mahasiswa::role('mahasiswa')->get(); // Mengambil semua user dengan role mahasiswa
        return view('admin.mahasiswa.index', compact('mahasiswa'));
    }


    /**
     * Display a listing of the resource.
     */
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    // public function mahasiswa()
    // {
    //     return view('admin.mahasiswa');
    // }

    public function matakuliah()
    {

        return view('admin.matakuliah');
    }

    public function frs()
    {

        return view('admin.frs');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.dosen.create');
    }

    public function createMahasiswa()
    {
        return view('admin.mahasiswa.create');
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
