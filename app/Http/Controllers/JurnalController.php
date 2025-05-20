<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jurnal;

class JurnalController extends Controller
{
    public function index()
    {
        $jurnals = Jurnal::paginate(10); // Menggunakan pagination
        return view('jurnal.index', compact('jurnals'));
    }

    public function create()
    {
        return view('jurnal.create');
    }

    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'judul' => 'required|max:255',
            'penulis' => 'required|max:255',
            'tahun' => 'required|numeric',
            'kategori' => 'required|max:255',
            'isi' => 'required',
        ]);
        
        // Simpan jurnal
        Jurnal::create($validated);
        
        return redirect()->route('jurnal.index')
            ->with('success', 'Jurnal berhasil ditambahkan!');
    }
}