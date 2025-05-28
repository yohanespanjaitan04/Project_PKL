<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JurnalController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

Route::get('/', function () {
    return redirect()->route('login');  // Redirect langsung ke halaman login
});

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate']);

//Route::get('/', function () {
    //return redirect()->route('dashboard');
//});

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// AJAX Routes untuk dropdown dinamis - LETAKKAN DI ATAS SEBELUM RESOURCE ROUTES
Route::get('/getProdi', [JurnalController::class, 'getProdi'])->name('getProdi');
Route::get('/getSemester', [JurnalController::class, 'getSemester'])->name('getSemester');
Route::get('/getMataKuliah', [JurnalController::class, 'getMataKuliah'])->name('getMataKuliah');

// Jurnal Routes
Route::get('/jurnal', [JurnalController::class, 'index'])->name('jurnal.index');
Route::get('/jurnal/create', [JurnalController::class, 'create'])->name('jurnal.create');
Route::post('/jurnal', [JurnalController::class, 'store'])->name('jurnal.store');
Route::get('/jurnal/{jurnal}', [JurnalController::class, 'show'])->name('jurnal.show');
Route::get('/jurnal/{jurnal}/edit', [JurnalController::class, 'edit'])->name('jurnal.edit');
Route::put('/jurnal/{jurnal}', [JurnalController::class, 'update'])->name('jurnal.update');
Route::delete('/jurnal/{jurnal}', [JurnalController::class, 'destroy'])->name('jurnal.destroy');
Route::get('/jurnal/{jurnal}/download', [JurnalController::class, 'download'])->name('jurnal.download');

// Referensi - PERBAIKAN ROUTES
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::post('/jurnal/bulk-edit', [HomeController::class, 'bulkEdit'])->name('jurnal.bulk-edit');
Route::post('/jurnal/bulk-update', [HomeController::class, 'bulkUpdate'])->name('jurnal.bulk-update');

// Profil
Route::get('/profil', [ProfilController::class, 'index'])->name('profil.index');
Route::get('/profil/edit', [ProfilController::class, 'edit'])->name('profil.edit');
Route::put('/profil', [ProfilController::class, 'update'])->name('profil.update');