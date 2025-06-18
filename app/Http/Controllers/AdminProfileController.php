<?php

// Lokasi file: app/Http/Controllers/AdminProfileController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// [DIUBAH] Nama class controller disesuaikan
class AdminProfileController extends Controller
{
    /**
     * Menampilkan halaman profil pengguna yang sedang login.
     * Logika ini berlaku untuk semua role yang login, termasuk admin.
     */
    public function show()
    {
        // Mengambil seluruh data dari pengguna yang sedang terautentikasi
        $user = Auth::user();

        // Mengirim data pengguna ke view 'profil.show'
        return view('profil.show', compact('user'));
    }

    // Nanti Anda bisa menambahkan method untuk proses update di sini
    // public function update(Request $request) { ... }
}
