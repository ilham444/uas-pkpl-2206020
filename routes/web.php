<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;

// Auth & Profil
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KomentarController;

// Admin
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\ModulController as AdminModulController;
use App\Http\Controllers\Admin\MateriController as AdminMateriController;
use App\Http\Controllers\Admin\LatihanController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\QuizResultController;
// User
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\ModulController as UserModulController;
use App\Http\Controllers\User\MateriController as UserMateriController;

// Latihan & Quiz
use App\Http\Controllers\LatihanPenggunaController;
use App\Http\Controllers\QuizController;


// ==========================================================
// RUTE PUBLIK
// ==========================================================
Route::get('/', fn() => view('welcome'))->name('home');


// ==========================================================
// RUTE LOGIN - VERIFIKASI WAJIB LOGIN
// ==========================================================
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard Redirect Berdasarkan Role
    Route::get('/dashboard', function () {
        return redirect()->route(auth()->user()->role === 'admin' ? 'admin.dashboard' : 'user.dashboard');
    })->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Komentar
    Route::post('/komentar', [KomentarController::class, 'store'])->name('komentar.store');

    // ==========================================================
    // RUTE PENGERJAAN LATIHAN OLEH PENGGUNA
    // ==========================================================
    Route::get('/latihan/{latihan}', [LatihanPenggunaController::class, 'show'])->name('latihan.show');
    Route::post('/latihan/{latihan}/submit', [LatihanPenggunaController::class, 'submit'])->name('latihan.submit');

    // ==========================================================
    // RUTE QUIZ UMUM
    // ==========================================================
    Route::prefix('quiz')->name('quiz.')->group(function () {
        Route::get('/start', [QuizController::class, 'start'])->name('start');
        Route::post('/submit', [QuizController::class, 'submit'])->name('submit');
        Route::get('/result/{quizAttempt}', [QuizController::class, 'result'])->name('result');
    });
});


// ==========================================================
// RUTE ADMIN
// ==========================================================
Route::middleware(['auth', RoleMiddleware::class . ':admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::resource('kategori', KategoriController::class);
        Route::resource('modul', AdminModulController::class);
        Route::resource('modul.materi', AdminMateriController::class);
        Route::resource('latihan', LatihanController::class);
         Route::resource('questions', QuestionController::class); 
         Route::get('/quiz-results', [QuizResultController::class, 'index'])->name('quiz_results.index');
    });

    


// ==========================================================
// RUTE USER
// ==========================================================
Route::middleware(['auth', RoleMiddleware::class . ':user'])
    ->prefix('user')
    ->name('user.')
    ->group(function () {
        Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
        Route::get('/modul', [UserModulController::class, 'index'])->name('modul.index');
        Route::get('/modul/{modul}', [UserModulController::class, 'show'])->name('modul.show');
        Route::get('/modul/{modul}/materi/{materi}', [UserMateriController::class, 'show'])->name('modul.materi.show');
    });


// ==========================================================
// RUTE OTENTIKASI DEFAULT LARAVEL
// ==========================================================
require __DIR__ . '/auth.php';
