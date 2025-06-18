<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProfilController extends Controller
{
    /**
     * Tampilkan form profil dengan data dari user yang sedang login (Hanya-Lihat).
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Anda harus login untuk mengakses halaman profil.');
        }

        return view('profil', compact('user'));
    }

    /**
     * Method ini tidak akan digunakan lagi karena form tidak memiliki tombol submit.
     * Jika diakses secara langsung (misal melalui Postman), akan me-redirect atau error.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    
}