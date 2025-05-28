<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validasi email dan password
        $credentials = $request->only('email', 'password');

        // Cek apakah email dan password sesuai dengan yang ada di database
        if (Auth::attempt($credentials)) {
            // Cek apakah user adalah admin
            if (Auth::user()->email === 'adi@admin.com') {
                // Redirect ke dashboard admin jika login berhasil
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('home'); // Bisa sesuaikan dengan route lain jika bukan admin
            }
        }

        return redirect()->route('login')->with('error', 'Email atau password salah');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }
}
