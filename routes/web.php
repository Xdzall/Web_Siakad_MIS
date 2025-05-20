<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\JadwalKuliahController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dosen', [DosenController::class, 'dashboard'])->name('dosen.dashboard')->middleware(['auth', 'verified', 'role:dosen']);
Route::get('/dosen/jadwal', [DosenController::class, 'jadwal'])->name('dosen.jadwal')->middleware(['auth', 'verified', 'role:dosen']);
Route::middleware(['auth', 'verified', 'role:dosen', 'dosen.wali'])->group(function () {
    Route::get('/dosen/frs', [DosenController::class, 'frs'])->name('dosen.frs')->middleware(['auth', 'verified', 'role:dosen']);
    Route::post('/dosen/frs/{id}/acc', [DosenController::class, 'accFrs'])->name('dosen.frs.acc')->middleware(['auth', 'verified', 'role:dosen']);
});
Route::get('/dosen/nilai', [DosenController::class, 'nilai'])->name('dosen.nilai')->middleware(['auth', 'verified', 'role:dosen']);


Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard')->middleware(['auth', 'verified', 'role:admin']);
Route::post('/admin/dosen', [AdminController::class, 'storeDosen'])->name('admin.dosen.store')->middleware(['auth', 'verified', 'role:admin']);
Route::post('/admin/mahasiswa', [AdminController::class, 'storeMahasiswa'])->name('admin.mahasiswa.store')->middleware(['auth', 'verified', 'role:admin']);
Route::get('/admin/matakuliah', [AdminController::class, 'matakuliah'])->name('admin.matakuliah')->middleware(['auth', 'verified', 'role:admin']);
Route::get('/admin/frs', [AdminController::class, 'frs'])->name('admin.frs')->middleware(['auth', 'verified', 'role:admin']);
Route::get('/admin/dosen/create', [AdminController::class, 'create'])->name('admin.dosen.create')->middleware(['auth', 'verified', 'role:admin']);
Route::get('/admin/dosen', [AdminController::class, 'dosenIndex'])->name('admin.dosen.index')->middleware(['auth', 'verified', 'role:admin']);
Route::get('/admin/mahasiswa', [AdminController::class, 'mahasiswaIndex'])->name('admin.mahasiswa.index')->middleware(['auth', 'verified', 'role:admin']);
Route::get('/admin/mahaiswa/create', [AdminController::class, 'createMahasiswa'])->name('admin.mahasiswa.create')->middleware(['auth', 'verified', 'role:admin']);

Route::get('/admin/matakuliah', [AdminController::class, 'matakuliah'])->name('admin.matakuliah.index')->middleware(['auth', 'verified', 'role:admin']);
Route::post('/admin/matakuliah', [AdminController::class, 'storeMatakuliah'])->name('admin.matakuliah.store')->middleware(['auth', 'verified', 'role:admin']);
Route::get('/admin/matakuliah/create', [AdminController::class, 'createMatakuliah'])->name('admin.matakuliah.create')->middleware(['auth', 'verified', 'role:admin']);
Route::get('/admin/matakuliah/{id}/edit', [AdminController::class, 'editMatakuliah'])->name('admin.matakuliah.edit')->middleware(['auth', 'verified', 'role:admin']);
Route::put('/admin/matakuliah/{id}', [AdminController::class, 'updateMatakuliah'])->name('admin.matakuliah.update')->middleware(['auth', 'verified', 'role:admin']);
Route::delete('/admin/matakuliah/{id}', [AdminController::class, 'destroyMatakuliah'])->name('admin.matakuliah.destroy')->middleware(['auth', 'verified', 'role:admin']);

Route::get('/admin/dosen/{id}/edit', [AdminController::class, 'editDosen'])->name('admin.dosen.edit')->middleware(['auth', 'verified', 'role:admin']);
Route::put('/admin/dosen/{id}', [AdminController::class, 'updateDosen'])->name('admin.dosen.update')->middleware(['auth', 'verified', 'role:admin']);
Route::delete('/admin/dosen/{id}', [AdminController::class, 'destroyDosen'])->name('admin.dosen.destroy')->middleware(['auth', 'verified', 'role:admin']);

Route::get('/admin/kelas', [KelasController::class, 'index'])->name('admin.kelas.index')->middleware(['auth', 'verified', 'role:admin']);
Route::get('/admin/kelas/create', [KelasController::class, 'create'])->name('admin.kelas.create')->middleware(['auth', 'verified', 'role:admin']);
Route::post('/admin/kelas', [KelasController::class, 'store'])->name('admin.kelas.store')->middleware(['auth', 'verified', 'role:admin']);
Route::get('/admin/kelas/{id}/edit', [KelasController::class, 'edit'])->name('admin.kelas.edit')->middleware(['auth', 'verified', 'role:admin']);
Route::put('/admin/kelas/{id}', [KelasController::class, 'update'])->name('admin.kelas.update')->middleware(['auth', 'verified', 'role:admin']);
Route::delete('/admin/kelas/{id}', [KelasController::class, 'destroy'])->name('admin.kelas.destroy')->middleware(['auth', 'verified', 'role:admin']);
Route::get('/admin/kelas/{id}/show', [KelasController::class, 'show'])->name('admin.kelas.show')->middleware(['auth', 'verified', 'role:admin']);

Route::get('/admin/mahasiswa/{id}/edit', [AdminController::class, 'editMahasiswa'])->name('admin.mahasiswa.edit')->middleware(['auth', 'verified', 'role:admin']);
Route::put('/admin/mahasiswa/{id}', [AdminController::class, 'updateMahasiswa'])->name('admin.mahasiswa.update')->middleware(['auth', 'verified', 'role:admin']);
Route::delete('/admin/mahasiswa/{id}', [AdminController::class, 'destroyMahasiswa'])->name('admin.mahasiswa.destroy')->middleware(['auth', 'verified', 'role:admin']);

Route::get('/mahasiswa', [MahasiswaController::class, 'dashboard'])->name('mahasiswa.dashboard')->middleware(['auth', 'verified', 'role:mahasiswa']);
Route::get('/mahasiswa/jadwal', [MahasiswaController::class, 'jadwal'])->name('mahasiswa.jadwal')->middleware(['auth', 'verified', 'role:mahasiswa']);
Route::get('/mahasiswa/frs', [MahasiswaController::class, 'frs'])->name('mahasiswa.frs')->middleware(['auth', 'verified', 'role:mahasiswa']);
Route::get('/mahasiswa/nilai', [MahasiswaController::class, 'nilai'])->name('mahasiswa.nilai')->middleware(['auth', 'verified', 'role:mahasiswa']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// // Admin Routes - Grouped with prefix and name
// Route::prefix('admin')->name('admin.')->group(function () {
//     // Index
//     Route::get('/index', function () {
//         return view('admin.index');
//     })->name('index');

//     // Mahasiswa routes
//     Route::get('/mahasiswa', function () {
//         return view('admin.mahasiswa.index');
//     })->name('mahasiswa');

//     // Dosen routes
//     Route::get('/dosen', function () {
//         return view('admin.dosen.index');
//     })->name('dosen');

//     // Matakuliah routes
//     Route::get('/matakuliah', function () {
//         return view('admin.matakuliah.index');
//     })->name('matakuliah');

//     // FRS routes
//     Route::get('/frs', function () {
//         return view('admin.frs.index');
//     })->name('frs');

//     // Nanti tambahkan route untuk logout
//     // Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
// });


// //punya ghazali
// Route::get('admin', function() {
//     return view('admin.dashboard');
// })->middleware(['auth', 'verified', 'role:admin']);

// Route::get('mahasiswa', function() {
//     return view('mahasiswa.dashboard');
// })->middleware(['auth', 'verified', 'role:mahasiswa|admin']);

// Route::get('dosen', function() {
//     return view(view: 'dosen.dashboard');
// })->middleware(['auth', 'verified', 'role:dosen|admin']);

// Route::get('frs', function() {
//     return view('matakuliah.matakuliah');
// })->middleware(['auth', 'verified', 'role_or_permission:lihat-matakuliah|admin']);


require __DIR__ . '/auth.php';
