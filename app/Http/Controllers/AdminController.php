<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function storeDosen(Request $request)
    {
        $request->validate([
            'nip' => 'required|unique:users',
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'nip' => $request->nip,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $user->assignRole('dosen');

        return redirect()->back()->with('success', 'Dosen berhasil ditambahkan');
    }

    public function storeMahasiswa(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $user->assignRole('mahasiswa');

        return redirect()->back()->with('success', 'Mahasiswa berhasil ditambahkan');
    }

    public function dosenIndex()
    {
        $dosen = User::role('dosen')->get(); // Mengambil semua user dengan role dosen
        return view('admin.dosen.index', compact('dosen'));
    }

    
    /**
     * Display a listing of the resource.
     */
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function mahasiswa()
    {
        return view('admin.mahasiswa');
    }

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
