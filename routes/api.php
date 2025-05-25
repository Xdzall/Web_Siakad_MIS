<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MahasiswaApiController;
use App\Http\Controllers\Api\DosenApiController;
use App\Http\Controllers\Api\JadwalApiController;
use App\Http\Controllers\Api\FrsApiController;
use App\Http\Controllers\Api\NilaiApiController;

// Public routes
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
    
    // Mahasiswa routes
    Route::middleware(['ability:mahasiswa'])->prefix('mahasiswa')->group(function () {
        Route::get('/jadwal', [JadwalApiController::class, 'mahasiswaJadwal']);
        Route::get('/frs', [FrsApiController::class, 'index']);
        Route::post('/frs', [FrsApiController::class, 'store']);
        Route::delete('/frs/{id}', [FrsApiController::class, 'destroy']);
        Route::get('/nilai', [NilaiApiController::class, 'mahasiswaNilai']);
        Route::get('/profile', [MahasiswaApiController::class, 'profile']);
        Route::get('/dashboard', [MahasiswaApiController::class, 'dashboard']);
    });
    
    // Dosen routes
    Route::middleware(['ability:dosen'])->prefix('dosen')->group(function () {
        Route::get('/jadwal', [JadwalApiController::class, 'dosenJadwal']);
        Route::get('/kelas', [DosenApiController::class, 'kelas']);
        
        Route::get('/frs', [FrsApiController::class, 'dosenFrs']);
        Route::post('/frs/validate', [FrsApiController::class, 'validateFrs']);
        
        Route::get('/nilai', [NilaiApiController::class, 'index']);
        Route::post('/nilai', [NilaiApiController::class, 'store']);
        Route::post('/nilai/mahasiswa', [NilaiApiController::class, 'getMahasiswa']);
    });
});