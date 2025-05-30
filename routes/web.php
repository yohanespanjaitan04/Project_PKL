<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JurnalController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserManajemenController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Redirect root to login
Route::get('/', function () {
    return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Protected Routes - Authenticated Users Only
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    // General Dashboard (fallback)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Profile routes
    Route::get('/profil', [AuthController::class, 'profile'])->name('profil');
    Route::get('/profil/edit', [ProfilController::class, 'edit'])->name('profil.edit');
    Route::put('/profil', [ProfilController::class, 'update'])->name('profil.update');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', \App\Http\Middleware\RoleMiddleware::class.':admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/admin/user', [UserManajemenController::class, 'index'])->name('admin.user.index');
    Route::get('/users', [UserManajemenController::class, 'users'])->name('users');
    Route::get('/jurnals', [UserManajemenController::class, 'manageJurnals'])->name('jurnals');
    
    // Tambahkan route UserManajemen di sini
    Route::resource('UserManajemen', UserManajemenController::class);
    Route::post('/user-manajemen', [UserManajemenController::class, 'store'])->name('User_manajemen.store');
});

/*
|--------------------------------------------------------------------------
| Dosen Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', \App\Http\Middleware\RoleMiddleware::class.':dosen,admin'])->prefix('dosen')->name('dosen.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('jurnal', JurnalController::class);
});

/*
|--------------------------------------------------------------------------
| Mahasiswa Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', \App\Http\Middleware\RoleMiddleware::class.':mahasiswa,dosen,admin'])->prefix('mahasiswa')->name('mahasiswa.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/jurnal', [JurnalController::class, 'index'])->name('jurnal.index');
    Route::get('/jurnal/{id}', [JurnalController::class, 'show'])->name('jurnal.show');
});

/*
|--------------------------------------------------------------------------
| Jurnal Routes - Authenticated Users
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    // AJAX Routes untuk dropdown dinamis
    Route::get('/getProdi', [JurnalController::class, 'getProdi'])->name('getProdi');
    Route::get('/getSemester', [JurnalController::class, 'getSemester'])->name('getSemester');
    Route::get('/getMataKuliah', [JurnalController::class, 'getMataKuliah'])->name('getMataKuliah');
    
    // Personal jurnal routes
    Route::get('/jurnal-saya', [JurnalController::class, 'myJurnals'])->name('jurnal.my');
    Route::get('/jurnal-baru', [JurnalController::class, 'index'])->name('jurnal.new');
    
    // Main jurnal resource routes
    Route::get('/jurnal', [JurnalController::class, 'index'])->name('jurnal.index');
    Route::get('/jurnal/create', [JurnalController::class, 'create'])->name('jurnal.create');
    Route::post('/jurnal', [JurnalController::class, 'store'])->name('jurnal.store');
    Route::get('/jurnal/{jurnal}', [JurnalController::class, 'show'])->name('jurnal.show');
    Route::get('/jurnal/{jurnal}/edit', [JurnalController::class, 'edit'])->name('jurnal.edit');
    Route::put('/jurnal/{jurnal}', [JurnalController::class, 'update'])->name('jurnal.update');
    Route::delete('/jurnal/{jurnal}', [JurnalController::class, 'destroy'])->name('jurnal.destroy');
    Route::get('/jurnal/{jurnal}/download', [JurnalController::class, 'download'])->name('jurnal.download');
    
    // Home controller routes
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::post('/jurnal/bulk-edit', [HomeController::class, 'bulkEdit'])->name('jurnal.bulk-edit');
    Route::post('/jurnal/bulk-update', [HomeController::class, 'bulkUpdate'])->name('jurnal.bulk-update');
});