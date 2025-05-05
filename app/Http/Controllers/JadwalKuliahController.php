<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JadwalKuliah; // Pastikan model JadwalKuliah sudah dibuat

class JadwalKuliahController extends Controller
{
    public function index()
    {
    $jadwal = JadwalKuliah::all(); // Mengambil semua data jadwal kuliah
    return view('dosen.jadwal', compact('jadwal'));
    }
}
