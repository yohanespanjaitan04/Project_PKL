<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Jurnal;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        try {
            // Get statistics
            $totalUsers = User::count();
            $totalMahasiswa = User::where('role', 'mahasiswa')->count();
            $totalDosen = User::where('role', 'dosen')->count();
            $totalJurnal = Jurnal::count();
            $totalBuku = Jurnal::where('tipe_referensi', 'buku')->count();
            $totalArtikel = Jurnal::where('tipe_referensi', 'artikel')->count();
            
            // Recent users
            $recentUsers = User::orderBy('created_at', 'desc')->take(5)->get();
            
            // Recent journals
            $recentJurnals = Jurnal::orderBy('created_at', 'desc')->take(5)->get();

            return view('admin.dashboard', compact(
                'totalUsers',
                'totalMahasiswa', 
                'totalDosen',
                'totalJurnal',
                'totalBuku',
                'totalArtikel',
                'recentUsers',
                'recentJurnals'
            ));
            
        } catch (\Exception $e) {
            return view('admin.dashboard')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function users()
    {
        $users = User::paginate(15);
        return view('admin.users', compact('users'));
    }

    public function manageJurnals()
    {
        $jurnals = Jurnal::with('user')->paginate(15);
        return view('admin.jurnals', compact('jurnals'));
    }
}