<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jurnal;

class JurnalController extends Controller
{
    public function index()
    {
        $jurnals = Jurnal::all(); // Ambil semua data
        return view('jurnal.index', compact('jurnals')); // Kirim ke view
    }

    public function create()
    {
        return view('jurnal.create');
    }

    public function store(Request $request)
    {
        // proses simpan
    }
}
