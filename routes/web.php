<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\AdminController;
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
Route::get('/dosen/frs', [DosenController::class, 'frs'])->name('dosen.frs')->middleware(['auth', 'verified', 'role:dosen']);
Route::get('/dosen/nilai', [DosenController::class, 'nilai'])->name('dosen.nilai')->middleware(['auth', 'verified', 'role:dosen']);


Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard')->middleware(['auth', 'verified', 'role:admin']);
// Route::get('/admin/dosen', [AdminController::class, 'dosen'])->name('admin.dosen')->middleware(['auth', 'verified', 'role:admin']);
Route::post('/admin/dosen', [AdminController::class, 'storeDosen'])->name('admin.dosen.store')->middleware(['auth', 'verified', 'role:admin']);
Route::get('/admin/mahasiswa', [AdminController::class, 'mahasiswa'])->name('admin.mahasiswa')->middleware(['auth', 'verified', 'role:admin']);
Route::post('/admin/mahasiswa', [AdminController::class, 'storeMahasiswa'])->name('admin.mahasiswa.store')->middleware(['auth', 'verified', 'role:admin']);
Route::get('/admin/matakuliah', [AdminController::class, 'matakuliah'])->name('admin.matakuliah')->middleware(['auth', 'verified', 'role:admin']);
Route::get('/admin/frs', [AdminController::class, 'frs'])->name('admin.frs')->middleware(['auth', 'verified', 'role:admin']);
Route::get('/admin/dosen/create', [AdminController::class, 'create'])->name('admin.dosen.create')->middleware(['auth', 'verified', 'role:admin']);
Route::get('/admin/dosen', [AdminController::class, 'dosenIndex'])->name('admin.dosen.index')->middleware(['auth', 'verified', 'role:admin']);

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


require __DIR__.'/auth.php';
