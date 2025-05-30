<?php

namespace App\Http\Controllers;

use App\Models\User_Manajemen;
use Illuminate\Http\Request;

class UserManajemenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $User_Manajemen = []; // Mengambil semua data user dari database
        return view('admin.UserManajemen.index', compact('User_Manajemen')); // Menampilkan view dengan data users
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.UserManajemen.create'); // Menampilkan form tambah user
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        // Validasi data input
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:user_manajemen,email',
            'role' => 'required|string|max:100',
            'department' => 'required|string|max:100',
        ]);

        // Menyimpan data user
        User_Manajemen::create($validatedData);

        // Redirect ke halaman daftar user
        return redirect()->route('admin.UserManajemen.index')->with('success', 'User berhasil ditambahkan');

    }

    /**
     * Display the specified resource.
     */
    public function show(User_Manajemen $user_Manajemen)
    {
        //
        return view('admin.UserManajemen.show', compact('user_Manajemen')); // Menampilkan detail user
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User_Manajemen $user_Manajemen)
    {
        //
        return view('admin.UserManajemen.edit', compact('user_Manajemen'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User_Manajemen $user_Manajemen)
    {
        // Validasi data input
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:user_manajemen,email,' . $user_Manajemen->id,
            'role' => 'required|string|max:100',
            'department' => 'required|string|max:100',
        ]);

        // Menemukan user berdasarkan ID
        $user = UserManajemen::findOrFail($id);

        // Memperbarui data user
        $user->update($validatedData);

        // Redirect ke halaman daftar user
        return redirect()->route('admin.UseManajemen.index')->with('success', 'User berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User_Manajemen $user_Manajemen)
    {

        // Menghapus user
        $user->delete();

        // Redirect ke halaman daftar user
        return redirect()->route('admin.UserManajemen.index')->with('success', 'User berhasil diperbarui');
    }
}
