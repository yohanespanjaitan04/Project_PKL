<?php

// File: app/Http/Controllers/ReferensiController.php
namespace App\Http\Controllers;

class ReferensiController extends Controller
{
    public function create()
    {
        return view('referensi.create');
    }

    public function store(Request $request)
    {
        // logic menyimpan data referensi
    }
}
