<?php

use App\Http\Controllers\KasController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Mengalihkan halaman utama langsung ke login agar aman
Route::get('/', function () {
    return redirect()->route('login');
});

/**
 * Grup rute yang dilindungi oleh middleware 'auth'.
 * Hanya user yang sudah login yang bisa mengakses rute di dalam grup ini.
 */
Route::middleware('auth')->group(function () {

    // --- FITUR MONITORING KAS ---

    // Menampilkan halaman utama kas dan ringkasan saldo
    Route::get('/kas', [KasController::class, 'index'])->name('kas.index');

    // Memproses tambah data transaksi baru
    Route::post('/kas', [KasController::class, 'store'])->name('kas.store');

    // Memproses hapus data transaksi berdasarkan ID
    Route::delete('/kas/{id}', [KasController::class, 'destroy'])->name('kas.destroy');


    // --- FITUR PROFILE (BAWAAN BREEZE) ---

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Memuat rute autentikasi bawaan Laravel Breeze (Login, Register, dll)
require __DIR__ . '/auth.php';
