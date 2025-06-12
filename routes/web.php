<?php

// routes/web.php
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

// Dashboard berdasarkan role
Route::get('/dashboard', function () {
    if(auth()->user()->role === 'admin') {
        return view('admin.dashboard');
    }
    return view('siswa.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Admin routes
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});

// Siswa routes
Route::prefix('siswa')->middleware(['auth', 'siswa'])->group(function () {
    Route::get('/dashboard', function () {
        return view('siswa.dashboard');
    })->name('siswa.dashboard');
    
    // Jurnal routes (yang sudah ada)
    Route::get('/buat-jurnal', function () {
        return view('siswa.addJurnal');
    })->name('siswa.jurnal.create');
    
    Route::get('/riwayat-jurnal', function () {
        return view('siswa.historyJurnal');
    })->name('siswa.riwayat');
    
    // Tambahan route baru untuk fitur jurnal
    Route::post('/simpan-jurnal', function () {
        // Logika simpan jurnal
    })->name('siswa.jurnal.store');
    
    Route::get('/detail-jurnal/{id}', function ($id) {
        return view('siswa.viewJurnal', ['id' => $id]);
    })->name('siswa.jurnal.view');
    
    Route::get('/edit-jurnal/{id}', function ($id) {
        return view('siswa.editJurnal', ['id' => $id]);
    })->name('siswa.jurnal.edit');
    
    Route::put('/update-jurnal/{id}', function ($id) {
        // Logika update jurnal
    })->name('siswa.jurnal.update');
    
    Route::delete('/hapus-jurnal/{id}', function ($id) {
        // Logika hapus jurnal
    })->name('siswa.jurnal.delete');
    
    Route::get('/cetak-jurnal/{id}', function ($id) {
        // Logika cetak jurnal
    })->name('siswa.jurnal.print');

    // Route lainnya yang sudah ada
    Route::get('/statistik', function () {
        return view('siswa.statistik');
    })->name('siswa.statistik');

    Route::get('/absen', function () {
        return view('siswa.absensi');
    })->name('siswa.absensi');
});

// Auth routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';