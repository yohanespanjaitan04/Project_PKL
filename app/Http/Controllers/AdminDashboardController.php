<?php

// [DIUBAH] Namespace disesuaikan dengan lokasi file
// karena tidak ada di dalam subfolder 'Admin'
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Jurnal;

class AdminDashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard khusus untuk Admin.
     */
    public function index()
    {
        // Menghitung jumlah total pengguna
        $userCount = User::count();

        // Menghitung jumlah total jurnal
        $journalCount = Jurnal::count();

        // Mengirim data ke view
        return view('admin.dashboard', compact('userCount', 'journalCount'));
    }
}