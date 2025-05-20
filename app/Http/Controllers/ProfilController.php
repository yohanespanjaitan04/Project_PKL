<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfilController extends Controller
{
    // Tampilkan form edit profil
    public function edit()
    {
        // data dummy
        $user = [
            'nama' => 'Rayvis Budi',
            'email'=> 'rayvis.budi@undip.ac.id',
            'telepon'=>'081234567890',
            'departemen'=>'teknik'
        ];
        return view('profil', compact('user'));
    }

    // Update profil (dummy)
    public function update(Request $request)
    {
        // nanti update ke DB
        return back()->with('success', 'Profil berhasil diperbarui!');
    }
}
