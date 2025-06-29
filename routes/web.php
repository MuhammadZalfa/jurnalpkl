<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\Siswa\AttendanceController;
use App\Http\Controllers\Instructor\AssessmentController as InstructorAssessmentController;
use App\Http\Controllers\Siswa\AssessmentController as SiswaAssessmentController;
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


// routes/web.php
Route::prefix('instructor')->middleware(['auth', 'instructor'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [\App\Http\Controllers\Instructor\DashboardController::class, 'index'])
        ->name('instructor.dashboard');

    Route::get('/students', [StudentController::class, 'index'])->name('instructor.students');
    Route::get('/students/{student}', [StudentController::class, 'show'])->name('instructor.students.show');
    
    // Journals
    Route::get('/journals', [\App\Http\Controllers\Instructor\JournalController::class, 'index'])
        ->name('instructor.journals');
    Route::get('/journals/{journal}', [\App\Http\Controllers\Instructor\JournalController::class, 'show'])
        ->name('instructor.journals.show');
    Route::get('/journals/student/{student}', [\App\Http\Controllers\Instructor\JournalController::class, 'studentJournals'])
        ->name('instructor.journals.student');
    
    // Attendances
    Route::get('/attendances', [\App\Http\Controllers\Instructor\AttendanceController::class, 'index'])
        ->name('instructor.attendances');
    Route::get('/attendances/student/{student}', [\App\Http\Controllers\Instructor\AttendanceController::class, 'show'])
        ->name('instructor.attendances.student');

    Route::get('/assessments', [InstructorAssessmentController::class, 'index'])
        ->name('instructor.assessments.index');

    Route::get('/monthly1/{assessment}', [InstructorAssessmentController::class, 'showMonthly1'])
        ->name('instructor.assessment1.show');
    Route::put('/monthly1/{assessment}', [InstructorAssessmentController::class, 'updateMonthly1'])
        ->name('instructor.assessment1.update');
            
    // Monthly 2
    Route::get('/monthly2/{assessment}', [InstructorAssessmentController::class, 'showMonthly2'])
        ->name('instructor.assessment2.show');
    Route::put('/monthly2/{assessment}', [InstructorAssessmentController::class, 'updateMonthly2'])
        ->name('instructor.assessment2.update');
            
    // Monthly 3
    Route::get('/monthly3/{assessment}', [InstructorAssessmentController::class, 'showMonthly3'])
        ->name('instructor.assessment3.show');
    Route::put('/monthly3/{assessment}', [InstructorAssessmentController::class, 'updateMonthly3'])
        ->name('instructor.assessment3.update');
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

    Route::post('/admin/assessment/{assessment}/comment/{type}', [\App\Http\Controllers\Admin\AssessmentController::class, 'addComment'])
    ->name('admin.assessment.comment');
    
    Route::get('/admin/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])
        ->name('admin.dashboard');

    Route::get('/jurnal', [\App\Http\Controllers\Admin\JournalController::class, 'index'])
        ->name('admin.jurnal');
    
    Route::get('/jurnal/detail/{id}', [\App\Http\Controllers\Admin\JournalController::class, 'show'])
        ->name('admin.jurnal.detail');

    Route::get('/admin/jurnal/siswa/{student}', [\App\Http\Controllers\Admin\JournalController::class, 'studentJournals'])
    ->name('admin.jurnal.student');
    
    Route::post('/jurnal/detail/approve/{id}', [\App\Http\Controllers\Admin\JournalController::class, 'approve'])
        ->name('admin.jurnal.approve');
    
    Route::get('/assesment', [\App\Http\Controllers\Admin\AssessmentController::class, 'index'])
        ->name('admin.assesment');
    
    Route::get('/assesment/{id}', [\App\Http\Controllers\Admin\AssessmentController::class, 'show'])
        ->name('admin.assesment.detail');

    Route::get('/statistik', [\App\Http\Controllers\Admin\StatisticsController::class, 'index'])
        ->name('admin.statistik');

    Route::get('/pengaturan', [\App\Http\Controllers\Admin\SettingController::class, 'index'])
        ->name('admin.settings');
    
    Route::put('/pengaturan/update-password', [\App\Http\Controllers\Admin\SettingController::class, 'updatePassword'])
        ->name('admin.setting.update-password');

    Route::get('/user-upload', [AdminController::class, 'showUploadForm'])->name('admin.user-upload');

    Route::post('/verify-access', [AdminController::class, 'verifyAccess'])->name('admin.verify-access');

    Route::post('/upload-users', [AdminController::class, 'uploadUsers'])->name('admin.upload-users');

    Route::post('/upload-users-ajax', [AdminController::class, 'uploadUsersAjax'])->name('admin.upload-users-ajax');
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
    Route::get('/asesmen', [SiswaAssessmentController::class, 'index'])->name('siswa.assesmen');
    
    // Monthly Assessment 1
    Route::get('/asesmen/bulanan-1/{id}', [SiswaAssessmentController::class, 'showMonthly1'])
        ->name('siswa.assesmen.monthly1.show');
    Route::post('/bulanan-1/{id}', [SiswaAssessmentController::class, 'storeMonthly1'])
        ->name('siswa.assesment.storeMonthly1');
    
    // Monthly Assessment 2
    Route::get('/asesmen/bulanan-2/{id}', [SiswaAssessmentController::class, 'showMonthly2'])
        ->name('siswa.assesmen.monthly2.show');
    Route::post('/asesmen/bulanan-2/{id}', [SiswaAssessmentController::class, 'storeMonthly2'])
        ->name('siswa.assesmen.monthly2.store');
    
    // Monthly Assessment 3
    Route::get('/asesmen/bulanan-3/{id}', [SiswaAssessmentController::class, 'showMonthly3'])
        ->name('siswa.assesmen.monthly3.show');
    Route::post('/asesmen/bulanan-3/{id}', [SiswaAssessmentController::class, 'storeMonthly3'])
        ->name('siswa.assesmen.monthly3.store');

    Route::get('/profil', [ProfileController::class, 'index'])->name('siswa.profil');
    
    Route::put('/profil/update-password', [ProfileController::class, 'updatePassword'])->name('siswa.profil.update-password');
});

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');
