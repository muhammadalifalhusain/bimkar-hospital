<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\ProfileController;
use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Controllers\Dokter\ObatController;
use App\Http\Controllers\Dokter\MemeriksaController;
use App\Http\Controllers\Pasien\JanjiPeriksaController;
use App\Http\Controllers\Dokter\JadwalPeriksaController;
use App\Http\Controllers\Pasien\RiwayatPeriksaController;


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

        Route::prefix('memeriksa')->group(function () { 
        Route::get('/', [MemeriksaController::class, 'index'])->name('dokter.memeriksa.index'); 
        Route::post('/{id}', [MemeriksaController::class, 'store'])->name('dokter.memeriksa.store'); 
        Route::get('/{id}/periksa', [MemeriksaController::class, 'periksa'])->name('dokter.memeriksa.periksa'); 
        Route::get('/{id}/edit', [MemeriksaController::class, 'edit'])->name('dokter.memeriksa.edit'); 
        Route::patch('/{id}', [MemeriksaController::class, 'update'])->name('dokter.memeriksa.update'); 
    });
    });

    Route::middleware('role:pasien')->prefix('pasien')->group(function () {
        Route::get('/dashboard', function () {
            return view('dashboard');
        })->name('pasien.dashboard');

        Route::prefix('janji-periksa')->group(function(){ 
            Route::get('/', [JanjiPeriksaController::class, 'index'])->name('pasien.janji-periksa.index'); 
            Route::post('/', [JanjiPeriksaController::class, 'store'])->name('pasien.janji-periksa.store'); 
        });

        Route::prefix('riwayat-periksa')->group(function(){ 
            Route::get('/', [RiwayatPeriksaController::class, 'index'])->name('pasien.riwayat-periksa.index'); 
            Route::get('/{id}/detail', [RiwayatPeriksaController::class, 'detail'])->name('pasien.riwayat-periksa.detail'); 
            Route::get('/{id}/riwayat', [RiwayatPeriksaController::class, 'riwayat'])->name('pasien.riwayat-periksa.riwayat'); 
            Route::get('/', [RiwayatPeriksaController::class, 'index'])->name('pasien.riwayat-periksa.index'); 
        });
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', function (Request $request) {
        $user = User::where('id', Auth::user()->id)->first();
        $user->update([
            'nama'  => $request->nama,
            'email' => $request->email
        ]);

        return Redirect::route('profile.edit');
    })->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';