<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JurnalController;
use App\Http\Controllers\ReferensiController;
use App\Http\Controllers\ProfilController;

Route::get('/', [DashboardController::class, 'index'])->name('home'); // ✅ route default

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/jurnal', [JurnalController::class, 'index'])->name('jurnal.index');
Route::get('/jurnal/create', [JurnalController::class, 'create'])->name('jurnal.create');
Route::get('/referensi/create', [ReferensiController::class, 'create'])->name('referensi.create');
Route::get('/profil', [ProfilController::class, 'edit'])->name('profil.edit');
