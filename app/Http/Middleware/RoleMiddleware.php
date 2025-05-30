<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::user();
        
        // Check if user role is in allowed roles
        if (!in_array($user->role, $roles)) {
            // Redirect based on user role if unauthorized
            switch ($user->role) {
                case 'admin':
                    return redirect()->route('admin.dashboard')->with('error', 'Akses tidak diizinkan.');
                case 'dosen':
                    return redirect()->route('dosen.dashboard')->with('error', 'Akses tidak diizinkan.');
                case 'mahasiswa':
                    return redirect()->route('mahasiswa.dashboard')->with('error', 'Akses tidak diizinkan.');
                default:
                    return redirect()->route('dashboard')->with('error', 'Akses tidak diizinkan.');
            }
        }

        return $next($request);
    }
}