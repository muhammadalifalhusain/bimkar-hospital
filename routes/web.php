<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Dokter\JadwalPeriksaController;
use App\Http\Controllers\Dokter\ObatController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {

    Route::middleware('role:dokter')->prefix('dokter')->group(function () {
        Route::get('/dashboard', function () {
            return view('dashboard');
        })->name('dokter.dashboard');

        Route::prefix('jadwal-periksa')->group(function () {
            Route::get('/', [JadwalPeriksaController::class, 'index'])->name('dokter.jadwal-periksa.index');
            Route::post('/', [JadwalPeriksaController::class, 'store'])->name('dokter.jadwal-periksa.store');
            Route::patch('/{id}', [JadwalPeriksaController::class, 'update'])->name('dokter.jadwal-periksa.update');
        });

        Route::group([
            'prefix' => '/obat',
            'as' => 'obat.'
        ], function () {
            Route::get('/', [ObatController::class, 'index'])->name('index');
            Route::post('/', [ObatController::class, 'store'])->name('store');
            Route::get('/{id?}', [ObatController::class, 'edit'])->name('edit');
            Route::patch('/{id}', [ObatController::class, 'update'])->name('update');
            Route::delete('/delete/{id?}', [ObatController::class, 'destroy'])->name('destroy');
        });
    });

    Route::middleware('role:pasien')->prefix('pasien')->group(function () {
        Route::get('/dashboard', function () {
            return view('dashboard');
        })->name('pasien.dashboard');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
