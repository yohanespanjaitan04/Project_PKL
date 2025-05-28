<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jurnal;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        try {
            // Query dasar untuk jurnal
            $query = Jurnal::query();

            // Filter berdasarkan departemen - menggunakan nama kolom yang benar
            if ($request->filled('departemen')) {
                $query->where('departemen', $request->departemen);
            }

            // Filter berdasarkan program studi - menggunakan kolom prodi
            if ($request->filled('program_studi')) {
                $query->where('prodi', $request->program_studi);
            }

            // Filter berdasarkan kata kunci (pencarian di judul dan pengarang)
            if ($request->filled('kata_kunci')) {
                $kata_kunci = $request->kata_kunci;
                $query->where(function($q) use ($kata_kunci) {
                    $q->where('judul', 'like', '%' . $kata_kunci . '%')
                      ->orWhere('pengarang', 'like', '%' . $kata_kunci . '%')
                      ->orWhere('abstrak', 'like', '%' . $kata_kunci . '%');
                });
            }

            // Urutkan berdasarkan tahun terbaru - menggunakan kolom yang benar
            $query->orderBy('tahun_publikasi', 'desc')->orderBy('created_at', 'desc');

            // Pagination
            $jurnals = $query->paginate(10);

            // Statistik
            $total_jurnal = Jurnal::count();
            $jurnal_tahun_ini = Jurnal::whereYear('tahun_publikasi', date('Y'))->count();

            return view('home.home', compact('jurnals', 'total_jurnal', 'jurnal_tahun_ini'));

        } catch (\Exception $e) {
            // Log error untuk debugging
            \Log::error('Error in HomeController: ' . $e->getMessage());
            
            // Jika terjadi error, coba query sederhana
            try {
                $jurnals = Jurnal::orderBy('created_at', 'desc')->paginate(10);
                $total_jurnal = Jurnal::count();
                $jurnal_tahun_ini = 0;
                
                return view('home', compact('jurnals', 'total_jurnal', 'jurnal_tahun_ini'))
                    ->with('error', 'Terjadi kesalahan dalam memuat filter, menampilkan semua data.');
            } catch (\Exception $e2) {
                // Jika masih error, tampilkan halaman kosong
                $jurnals = collect()->paginate(10); // Empty pagination
                $total_jurnal = 0;
                $jurnal_tahun_ini = 0;

                return view('home', compact('jurnals', 'total_jurnal', 'jurnal_tahun_ini'))
                    ->with('error', 'Terjadi kesalahan dalam memuat data jurnal: ' . $e2->getMessage());
            }
        }
    }

    // Method baru untuk menangani bulk edit - PERBAIKAN DI SINI
    public function bulkEdit(Request $request)
    {
        try {
            // Validasi input - ubah dari selected_ids ke jurnal_ids
            $request->validate([
                'jurnal_ids' => 'required|string'
            ]);

            // Parse selected IDs - ubah dari selected_ids ke jurnal_ids
            $selectedIds = explode(',', $request->jurnal_ids);
            $selectedIds = array_filter($selectedIds); // Remove empty values
            
            if (empty($selectedIds)) {
                return redirect()->back()->with('error', 'Tidak ada jurnal yang dipilih.');
            }

            // Ambil data jurnal yang dipilih
            $selectedJurnals = Jurnal::whereIn('id', $selectedIds)->get();

            if ($selectedJurnals->isEmpty()) {
                return redirect()->back()->with('error', 'Jurnal yang dipilih tidak ditemukan.');
            }

            // Redirect ke halaman bulk edit dengan data yang dipilih
            return view('home.bulk-edit', compact('selectedJurnals'));

        } catch (\Exception $e) {
            \Log::error('Error in bulk edit: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // Method untuk memproses update bulk edit
    public function bulkUpdate(Request $request)
    {
        try {
            // Validasi basic - PERBAIKAN: ubah validasi untuk menerima format yang benar
            $request->validate([
                'jurnal_ids' => 'required|array',
                'jurnal_ids.*' => 'exists:jurnals,id'
            ]);

            $updatedCount = 0;
            $errors = [];

            foreach ($request->jurnal_ids as $index => $jurnalId) {
                try {
                    $jurnal = Jurnal::find($jurnalId);
                    if (!$jurnal) {
                        continue;
                    }

                    // Update data untuk setiap jurnal
                    $updateData = [];
                    
                    if (isset($request->judul[$index])) {
                        $updateData['judul'] = $request->judul[$index];
                    }
                    
                    if (isset($request->pengarang[$index])) {
                        $updateData['pengarang'] = $request->pengarang[$index];
                    }
                    
                    if (isset($request->tahun_publikasi[$index])) {
                        $updateData['tahun_publikasi'] = $request->tahun_publikasi[$index];
                    }
                    
                    if (isset($request->departemen[$index])) {
                        $updateData['departemen'] = $request->departemen[$index];
                    }
                    
                    if (isset($request->prodi[$index])) {
                        $updateData['prodi'] = $request->prodi[$index];
                    }

                    if (isset($request->abstrak[$index])) {
                        $updateData['abstrak'] = $request->abstrak[$index];
                    }

                    if (isset($request->tipe_referensi[$index])) {
                        $updateData['tipe_referensi'] = $request->tipe_referensi[$index];
                    }

                    if (isset($request->penerbit[$index])) {
                        $updateData['penerbit'] = $request->penerbit[$index];
                    }

                    if (isset($request->volume[$index])) {
                        $updateData['volume'] = $request->volume[$index];
                    }

                    if (!empty($updateData)) {
                        $jurnal->update($updateData);
                        $updatedCount++;
                    }

                } catch (\Exception $e) {
                    $errors[] = "Error updating jurnal ID {$jurnalId}: " . $e->getMessage();
                }
            }

            if ($updatedCount > 0) {
                $message = "Berhasil memperbarui {$updatedCount} jurnal.";
                if (!empty($errors)) {
                    $message .= " Terdapat " . count($errors) . " error.";
                }
                return redirect()->route('home')->with('success', $message);
            } else {
                return redirect()->back()->with('error', 'Tidak ada data yang diperbarui. ' . implode(' ', $errors));
            }

        } catch (\Exception $e) {
            \Log::error('Error in bulk update: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // Method untuk mendapatkan data statistik
    public function getStatistik()
    {
        try {
            $statistik = [
                'total_jurnal' => Jurnal::count(),
                'jurnal_bulan_ini' => Jurnal::whereMonth('created_at', date('m'))
                                           ->whereYear('created_at', date('Y'))
                                           ->count(),
                'departemen_terbanyak' => Jurnal::select('departemen')
                                               ->groupBy('departemen')
                                               ->orderByRaw('COUNT(*) DESC')
                                               ->first()->departemen ?? 'Tidak ada',
                'tahun_terbaru' => Jurnal::max('tahun_publikasi') ?? date('Y')
            ];

            return response()->json($statistik);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal memuat statistik'], 500);
        }
    }
}