<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\Siswa\AttendanceController;
use App\Http\Controllers\siswa\AssessmentController;
use App\Http\Controllers\siswa\StatisticsController;
use App\Http\Controllers\siswa\JournalController;
use App\Http\Controllers\siswa\DashboardController;
use App\Http\Controllers\siswa\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\loginController;

Route::get('/', [loginController::class, 'create'])->middleware('guest')->name('login');

Route::post('/', [loginController::class, 'store'])->middleware('guest')->name('login.post');


Route::prefix('instructor')->middleware(['auth', 'instructor'])->group(function () {
    Route::get('/dashboard', function () {
        return view('instructor.dashboard');
    })->name('instructor.dashboard');
});

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

    Route::get('/jurnal', function () {
        return view('admin.jurnal-guru');
    })->name('admin.jurnal');

    Route::get('/jurnal/detail', function () {
        return view('admin.detail-jurnal-guru');
    })->name('admin.jurnal.detail');
    
    Route::post('/jurnal/detail/approve', function () {
    })->name('admin.jurnal.approve');
    
    Route::get('/assesment', [AssessmentController::class, 'index'])
        ->name('admin.assesment');
    
    Route::get('/assesment/{id}', [AssessmentController::class, 'show'])
        ->name('admin.assesment.detail');
});

// Siswa routes
Route::prefix('siswa')->middleware(['auth', 'siswa'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('siswa.dashboard');;
    
    // Jurnal routes
    Route::get('/buat-jurnal', function () {
        return view('siswa.addJurnal');
    })->name('siswa.jurnal.create');
    
    // Perbaikan rute riwayat jurnal
    Route::get('/riwayat-jurnal', [JournalController::class, 'index'])
        ->name('siswa.riwayat');
    
    Route::post('/simpan-jurnal', [JournalController::class, 'store'])
    ->name('siswa.jurnal.store');
    
    Route::get('/detail-jurnal/{id}', function ($id) {
        return view('siswa.viewJurnal', ['id' => $id]);
    })->name('siswa.jurnal.view');

    // Tambah rute untuk edit, update, dan delete
    Route::get('/edit-jurnal/{id}', [JournalController::class, 'edit'])
        ->name('siswa.jurnal.edit');
    
    Route::put('/update-jurnal/{id}', [JournalController::class, 'update'])
        ->name('siswa.jurnal.update');
    
    Route::delete('/hapus-jurnal/{id}', [JournalController::class, 'destroy'])
        ->name('siswa.jurnal.delete');
    
    // Rute untuk menghapus gambar
    Route::delete('/jurnal/hapus-gambar/{imageId}', [JournalController::class, 'deleteImage'])
        ->name('siswa.jurnal.hapus-gambar');
    
    Route::get('/cetak-jurnal/{id}', function ($id) {
        // Logika cetak jurnal
    })->name('siswa.jurnal.print');
    
    // Statistik route
    Route::get('/statistik', [StatisticsController::class, 'index'])
        ->name('siswa.statistik');
        
    Route::get('/statistik/chart', [StatisticsController::class, 'chartData'])
        ->name('siswa.statistik.chart');

    // Absensi route
    Route::get('/absen', [AttendanceController::class, 'index'])
        ->name('siswa.absensi');
    
    Route::post('/absen', [AttendanceController::class, 'store'])
        ->name('siswa.absensi.store');

    // Assessment routes
    Route::get('/asesmen', [AssessmentController::class, 'index'])->name('siswa.assesmen');
    
    // Monthly Assessment 1
    Route::get('/asesmen/bulanan-1/{id}', [AssessmentController::class, 'showMonthly1'])
        ->name('siswa.assesmen.monthly1.show');
    Route::post('/bulanan-1/{id}', [AssessmentController::class, 'storeMonthly1'])
        ->name('siswa.assesment.storeMonthly1');
    
    // Monthly Assessment 2
    Route::get('/asesmen/bulanan-2/{id}', [AssessmentController::class, 'showMonthly2'])
        ->name('siswa.assesmen.monthly2.show');
    Route::post('/asesmen/bulanan-2/{id}', [AssessmentController::class, 'storeMonthly2'])
        ->name('siswa.assesmen.monthly2.store');
    
    // Monthly Assessment 3
    Route::get('/asesmen/bulanan-3/{id}', [AssessmentController::class, 'showMonthly3'])
        ->name('siswa.assesmen.monthly3.show');
    Route::post('/asesmen/bulanan-3/{id}', [AssessmentController::class, 'storeMonthly3'])
        ->name('siswa.assesmen.monthly3.store');

    Route::get('/profil', [ProfileController::class, 'index'])->name('siswa.profil');
    
    Route::put('/profil/update-password', [ProfileController::class, 'updatePassword'])->name('siswa.profil.update-password');
});

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');
