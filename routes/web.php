<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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

// Admin Routes - Grouped with prefix and name
Route::prefix('admin')->name('admin.')->group(function () {
    // Index
    Route::get('/index', function () {
        return view('admin.index');
    })->name('index');
    
    // Mahasiswa routes
    Route::get('/mahasiswa', function () {
        return view('admin.mahasiswa.index');
    })->name('mahasiswa');
    
    // Dosen routes
    Route::get('/dosen', function () {
        return view('admin.dosen.index');
    })->name('dosen');
    
    // Matakuliah routes
    Route::get('/matakuliah', function () {
        return view('admin.matakuliah.index');
    })->name('matakuliah');
    
    // FRS routes
    Route::get('/frs', function () {
        return view('admin.frs.index');
    })->name('frs');
    
    // Nanti tambahkan route untuk logout
    // Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

require __DIR__.'/auth.php';
