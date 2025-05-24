<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Kelas;
use Illuminate\Support\Facades\Log;
use App\Models\Matakuliah;
use App\Models\FrsSubmission;
use Spatie\Permission\Models\Role;


class AdminController extends Controller
{
    // Tampilkan daftar dosen
    public function dosenIndex()
    {
        $dosen = User::role('dosen')->get();
        return view('admin.dosen.index', compact('dosen'));
    }

    // Tampilkan daftar mahasiswa
    public function mahasiswaIndex(Request $request)
    {
        // Start with base query
        $query = User::role('mahasiswa');

        // Apply kelas filter
        if ($request->filled('kelas')) {
            $query->where('kelas_id', $request->kelas);
        }

        // Apply semester filter
        if ($request->filled('semester')) {
            $query->where('semester', $request->semester);
        }

        // Get filtered results
        $mahasiswa = $query->get();

        // Get kelas for filter dropdown
        $kelas = Kelas::where('active', true)->get();

        return view('admin.mahasiswa.index', compact('mahasiswa', 'kelas'));
    }

    // Form tambah dosen
    public function create()
    {
        return view('admin.dosen.create');
    }

    // Form tambah mahasiswa
    public function createMahasiswa()
    {

        $kelas = Kelas::where('active', true)->get();
        return view('admin.mahasiswa.create', compact('kelas'));
    }

    // Simpan dosen baru
    public function storeDosen(Request $request)
    {
        $request->validate([
            'nip' => 'required|unique:users,nip',
            'name' => 'required',
            'email_prefix' => 'required|alpha_dash|unique:users,email',
            'password' => 'required|min:6',
        ]);

        $email = strtolower($request->email_prefix) . '@it.lecturer.pens.ac.id';

        $user = User::create([
            'nip' => $request->nip,
            'name' => $request->name,
            'email' => $email,
            'password' => Hash::make($request->password),
            'is_wali' => $request->has('is_wali') ? true : false,
        ]);
        $user->assignRole('dosen');

        return redirect()->route('admin.dosen.index')->with('success', 'Dosen berhasil ditambahkan');
    }

    // Simpan mahasiswa baru
    public function storeMahasiswa(Request $request)
    {
        $request->validate([
            'nrp' => 'required|unique:users,nrp',
            'name' => 'required',
            'email_prefix' => 'required|alpha_dash|unique:users,email',
            'password' => 'required|min:6',
            'semester' => 'required|integer|min:1|max:8',
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        $email = strtolower($request->email_prefix) . '@it.student.pens.ac.id';

        $user = User::create([
            'nrp' => $request->nrp,
            'name' => $request->name,
            'email' => $email,
            'password' => Hash::make($request->password),
            'semester' => $request->semester,
            'kelas_id' => $request->kelas_id,
        ]);
        $user->assignRole('mahasiswa');

        return redirect()->route('admin.mahasiswa.index')->with('success', 'Mahasiswa berhasil ditambahkan');
    }

    // Edit dosen
    public function editDosen($id)
    {
        $dosen = User::findOrFail($id);
        return view('admin.dosen.edit', compact('dosen'));
    }

    // Update dosen
    public function updateDosen(Request $request, $id)
    {
        $dosen = User::findOrFail($id);

        $request->validate([
            'nip' => 'required|unique:users,nip,' . $dosen->id,
            'name' => 'required',
            'email_prefix' => 'required|alpha_dash|unique:users,email,' . $dosen->id,
        ]);

        $email = strtolower($request->email_prefix) . '@it.lecturer.pens.ac.id';

        // Debug untuk melihat nilai yang diterima
        Log::info('Update Dosen Request:', [
            'is_wali_request' => $request->has('is_wali'),
            'all_data' => $request->all()
        ]);

        $data = [
            'nip' => $request->nip,
            'name' => $request->name,
            'email' => $email,
            'is_wali' => $request->has('is_wali') ? true : false  // Pastikan konversi ke boolean
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // Debug sebelum update
        Log::info('Data yang akan diupdate:', $data);

        $updated = $dosen->update($data);

        // Debug setelah update
        Log::info('Status update:', [
            'success' => $updated,
            'new_is_wali_status' => $dosen->fresh()->is_wali
        ]);

        return redirect()->route('admin.dosen.index')
            ->with('success', 'Data dosen berhasil diupdate');
    }

    // Hapus dosen
    public function destroyDosen($id)
    {
        $dosen = User::findOrFail($id);
        $dosen->delete();
        return redirect()->route('admin.dosen.index')->with('success', 'Dosen berhasil dihapus');
    }

    // Edit mahasiswa
    public function editMahasiswa($id)
    {
        $mahasiswa = User::findOrFail($id);
        return view('admin.mahasiswa.edit', compact('mahasiswa'));
    }

    // Update mahasiswa
    public function updateMahasiswa(Request $request, $id)
    {
        $mahasiswa = User::findOrFail($id);

        $request->validate([
            'nrp' => 'required|unique:users,nrp,' . $mahasiswa->id,
            'name' => 'required',
            'email_prefix' => 'required|alpha_dash|unique:users,email,' . $mahasiswa->id,
        ]);

        $email = strtolower($request->email_prefix) . '@it.student.pens.ac.id';

        $data = [
            'nrp' => $request->nrp,
            'name' => $request->name,
            'email' => $email,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $mahasiswa->update($data);

        return redirect()->route('admin.mahasiswa.index')->with('success', 'Mahasiswa berhasil diupdate');
    }

    // Hapus mahasiswa
    public function destroyMahasiswa($id)
    {
        $mahasiswa = User::findOrFail($id);
        $mahasiswa->delete();
        return redirect()->route('admin.mahasiswa.index')->with('success', 'Mahasiswa berhasil dihapus');
    }

    // Dashboard
    public function dashboard()
    {
        $totalMahasiswa = user::role('mahasiswa')->count();
        $totalDosen = user::role('dosen')->count();

        $userData = [
            'labels' => ['Mahasiswa', 'Dosen'],
            'counts' => [$totalMahasiswa, $totalDosen]
        ];

        $totalMatakuliah = Matakuliah::count();
        $totalFrs = FrsSubmission::count();

        return view('admin.dashboard', compact(
            'totalMahasiswa',
            'totalDosen',
            'totalMatakuliah',
            'totalFrs',
            'userData'
        ));
    }
}
