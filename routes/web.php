<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\MahasiswaController;

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



Route::get('admin', function() {
    return '<h1>admin</h1>';
})->middleware(['auth', 'verified', 'role:admin']);

Route::get('mahasiswa', function() {
    return '<h1>mahasiswa</h1>';
})->middleware(['auth', 'verified', 'role:mahasiswa|admin']);

Route::get('matakuliah', function() {
    return view('matakuliah.matakuliah');
})->middleware(['auth', 'verified', 'role_or_permission:lihat-matakuliah|admin']);


require __DIR__.'/auth.php';
