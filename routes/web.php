<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JurnalController;
use App\Http\Controllers\ReferensiController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LoginController;


//Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
//Route::post('login', [AuthController::class, 'login']);
//Route::get('admin/dashboard', function () {
//    return view('admin.dashboard'); // Halaman dashboard admin
//})->middleware('auth')->name('admin.dashboard');

//Route::get('/', function () {
//    return view('login.index', ['title' => 'Login']);
//})->name('login');

Route::get('/', function () {
    return redirect()->route('login');  // Redirect langsung ke halaman login
});

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate']);

//Route::get('/', function () {
//    return redirect()->route('login');
//});

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


// Jurnal
Route::get('/jurnal', [JurnalController::class, 'index'])->name('jurnal.index');
Route::get('/jurnal/create', [JurnalController::class, 'create'])->name('jurnal.create');
Route::post('/jurnal', [JurnalController::class, 'store'])->name('jurnal.store');
Route::get('/jurnal/{jurnal}', [JurnalController::class, 'show'])->name('jurnal.show');
Route::get('/jurnal/{jurnal}/edit', [JurnalController::class, 'edit'])->name('jurnal.edit');
Route::put('/jurnal/{jurnal}', [JurnalController::class, 'update'])->name('jurnal.update');
Route::delete('/jurnal/{jurnal}', [JurnalController::class, 'destroy'])->name('jurnal.destroy');

// Referensi
Route::get('/referensi', [ReferensiController::class, 'index'])->name('referensi.index');
Route::get('/referensi/create', [ReferensiController::class, 'create'])->name('referensi.create');
Route::post('/referensi', [ReferensiController::class, 'store'])->name('referensi.store');
Route::get('/referensi/{referensi}', [ReferensiController::class, 'show'])->name('referensi.show');
Route::get('/referensi/{referensi}/edit', [ReferensiController::class, 'edit'])->name('referensi.edit');
Route::put('/referensi/{referensi}', [ReferensiController::class, 'update'])->name('referensi.update');
Route::delete('/referensi/{referensi}', [ReferensiController::class, 'destroy'])->name('referensi.destroy');

// Profil
Route::get('/profil', [ProfilController::class, 'index'])->name('profil.index');
Route::get('/profil/edit', [ProfilController::class, 'edit'])->name('profil.edit');
Route::put('/profil', [ProfilController::class, 'update'])->name('profil.update');