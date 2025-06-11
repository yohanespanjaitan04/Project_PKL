<?php

namespace App\Http\Controllers;

// use App\Models\User_Manajemen;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class UserManajemenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Gunakan model User
        $users = User::latest()->paginate(10); 
        return view('admin.UserManajemen.index', compact('users'));
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
            'email' => 'required|email|unique:users,email',
            'role' => 'required|string|max:100',
            'department' => 'required|string|max:100',
            'password' => 'required|string|max:10',
        ]);

       $validatedData['password'] = Hash::make($validatedData['password']); // GANTI DISINI

        \App\Models\User::create($validatedData); // pastikan kamu pakai model yg benar

        return redirect()->route('admin.UserManajemen.index')->with('success', 'User berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // 2. Cari user menggunakan model `User` dan `findOrFail`
        // `findOrFail` akan otomatis menampilkan halaman 404 jika user tidak ditemukan
        $user = User::findOrFail($id);

        // 3. Kirim variabel tunggal `$user` ke view, bukan `$users`
        return view('admin.UserManajemen.show', compact('user')); 
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // 2. Cari user menggunakan model `User` dan `findOrFail`
        $user = User::findOrFail($id);

        // 3. Kirim variabel tunggal `$user` ke view, bukan `$users`
        return view('admin.UserManajemen.edit', compact('user'));
    }

 
    // Ganti signature method untuk menerima $id mentah, bukan model.
    // 2. UBAH TIPE PARAMETER DI METHOD UPDATE DAN LAINNYA
    public function update(Request $request, $id) 
    {
        // Cari user menggunakan model User
        $user = User::findOrFail($id);

        // ... sisa logika update Anda (yang sudah benar) tetap sama ...
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id, 
            'role' => 'required|string|max:100',
            'department' => 'required|string|max:100',
            'password' => 'nullable|string|max:10', 
        ]);

        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->role = $validatedData['role'];
        $user->department = $validatedData['department'];

        if ($request->filled('password')) {
            $user->password = Hash::make($validatedData['password']);
        }
        
        $user->save();
        
        return redirect()->route('admin.UserManajemen.index')->with('success', 'Data user berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('admin.UserManajemen.index')->with('success', 'User berhasil dihapus');
    }
}
