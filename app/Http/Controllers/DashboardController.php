<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jurnal;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            // Get total counts from jurnals table based on tipe_referensi
            $totalJurnal = Jurnal::where('tipe_referensi', 'jurnal')->count();
            $totalBuku = Jurnal::where('tipe_referensi', 'buku')->count();
            $totalArtikel = Jurnal::where('tipe_referensi', 'artikel')->count();
            
            // Get recent journals for history
            $jurnalTerbaru = Jurnal::orderBy('created_at', 'desc')->take(5)->get();
            
            // Get statistics by department
            $statsByDepartment = Jurnal::select('departemen', DB::raw('count(*) as total'))
                ->groupBy('departemen')
                ->get();
            
            // Get statistics by type
            $statsByType = Jurnal::select('tipe_referensi', DB::raw('count(*) as total'))
                ->groupBy('tipe_referensi')
                ->get();
            
            // Get monthly statistics for the current year
            $monthlyStats = Jurnal::select(
                    DB::raw('MONTH(created_at) as month'),
                    DB::raw('COUNT(*) as total')
                )
                ->whereYear('created_at', date('Y'))
                ->groupBy(DB::raw('MONTH(created_at)'))
                ->orderBy('month')
                ->get();

            return view('dashboard', compact(
                'totalJurnal',
                'totalBuku',
                'totalArtikel',
                'jurnalTerbaru',
                'statsByDepartment',
                'statsByType',
                'monthlyStats'
            ));
            
        } catch (\Exception $e) {
            // If there's an error, return with default values
            return view('dashboard', [
                'totalJurnal' => 0,
                'totalBuku' => 0,
                'totalArtikel' => 0,
                'jurnalTerbaru' => collect(),
                'statsByDepartment' => collect(),
                'statsByType' => collect(),
                'monthlyStats' => collect()
            ])->with('error', 'Terjadi kesalahan saat memuat dashboard: ' . $e->getMessage());
        }
    }
}