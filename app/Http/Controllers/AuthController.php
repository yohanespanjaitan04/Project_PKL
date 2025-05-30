<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login.index');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,dosen,mahasiswa',
            'nim' => 'nullable|string|unique:users,nim',
            'nip' => 'nullable|string|unique:users,nip',
            'prodi' => 'nullable|string|max:255',
        ]);

        // Validasi tambahan berdasarkan role
        if ($request->role === 'mahasiswa') {
            $request->validate([
                'nim' => 'required|string|unique:users,nim',
                'prodi' => 'required|string|max:255',
            ]);
        } elseif ($request->role === 'dosen') {
            $request->validate([
                'nip' => 'required|string|unique:users,nip',
                'prodi' => 'required|string|max:255',
            ]);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'nim' => $request->nim,
            'nip' => $request->nip,
            'prodi' => $request->prodi,
        ]);

        Auth::login($user);

        return $this->redirectBasedOnRole();
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();
            return $this->redirectBasedOnRole();
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function profile()
    {
        return view('profil.index');
    }

    private function redirectBasedOnRole()
    {
        $user = Auth::user();
        
        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'dosen':
                return redirect()->route('dosen.dashboard');
            case 'mahasiswa':
                return redirect()->route('mahasiswa.dashboard');
            default:
                return redirect()->route('dashboard');
        }
    }
}