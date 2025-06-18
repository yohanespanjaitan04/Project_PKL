<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jurnal;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

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

            // Cek role user untuk menentukan view yang akan digunakan
            $user = Auth::user();
            
            if ($user->role === 'mahasiswa') {
                // Untuk mahasiswa, gunakan view tanpa fitur edit
                return view('mahasiswa.home', compact('jurnals', 'total_jurnal', 'jurnal_tahun_ini'));
            } else {
                // Untuk dosen dan admin, gunakan view dengan fitur edit
                return view('dosen.home.home', compact('jurnals', 'total_jurnal', 'jurnal_tahun_ini'));
            }

        } catch (\Exception $e) {
            // Log error untuk debugging
            \Log::error('Error in HomeController: ' . $e->getMessage());
            
            // Jika terjadi error, coba query sederhana
            try {
                $jurnals = Jurnal::orderBy('created_at', 'desc')->paginate(10);
                $total_jurnal = Jurnal::count();
                $jurnal_tahun_ini = 0;
                
                $user = Auth::user();
                $viewName = ($user->role === 'mahasiswa') ? 'mahasiswa.home' : 'dosen.home.home';
                
                return view($viewName, compact('jurnals', 'total_jurnal', 'jurnal_tahun_ini'))
                    ->with('error', 'Terjadi kesalahan dalam memuat filter, menampilkan semua data.');
            } catch (\Exception $e2) {
                // Jika masih error, tampilkan halaman kosong
                $jurnals = collect()->paginate(10); // Empty pagination
                $total_jurnal = 0;
                $jurnal_tahun_ini = 0;

                $user = Auth::user();
                $viewName = ($user->role === 'mahasiswa') ? 'mahasiswa.home' : 'dosen.home.home';

                return view($viewName, compact('jurnals', 'total_jurnal', 'jurnal_tahun_ini'))
                    ->with('error', 'Terjadi kesalahan dalam memuat data jurnal: ' . $e2->getMessage());
            }
        }
    }

    // Method khusus untuk mahasiswa (view only)
    public function mahasiswaHome(Request $request)
    {
        try {
            // Query dasar untuk jurnal
            $query = Jurnal::query();

            // Filter berdasarkan departemen
            if ($request->filled('departemen')) {
                $query->where('departemen', $request->departemen);
            }

            // Filter berdasarkan program studi
            if ($request->filled('program_studi')) {
                $query->where('prodi', $request->program_studi);
            }

            // Filter berdasarkan kata kunci
            if ($request->filled('kata_kunci')) {
                $kata_kunci = $request->kata_kunci;
                $query->where(function($q) use ($kata_kunci) {
                    $q->where('judul', 'like', '%' . $kata_kunci . '%')
                      ->orWhere('pengarang', 'like', '%' . $kata_kunci . '%')
                      ->orWhere('abstrak', 'like', '%' . $kata_kunci . '%');
                });
            }

            $query->orderBy('tahun_publikasi', 'desc')->orderBy('created_at', 'desc');
            $jurnals = $query->paginate(10);
            $total_jurnal = Jurnal::count();
            $jurnal_tahun_ini = Jurnal::whereYear('tahun_publikasi', date('Y'))->count();

            return view('mahasiswa.home', compact('jurnals', 'total_jurnal', 'jurnal_tahun_ini'));

        } catch (\Exception $e) {
            \Log::error('Error in mahasiswa home: ' . $e->getMessage());
            $jurnals = collect()->paginate(10);
            $total_jurnal = 0;
            $jurnal_tahun_ini = 0;

            return view('mahasiswa.home', compact('jurnals', 'total_jurnal', 'jurnal_tahun_ini'))
                ->with('error', 'Terjadi kesalahan dalam memuat data jurnal.');
        }
    }

    // Method khusus untuk dosen (dengan fitur edit)
    public function dosenHome(Request $request)
    {
        try {
            // Query dasar untuk jurnal
            $query = Jurnal::query();

            // Filter berdasarkan departemen
            if ($request->filled('departemen')) {
                $query->where('departemen', $request->departemen);
            }

            // Filter berdasarkan program studi
            if ($request->filled('program_studi')) {
                $query->where('prodi', $request->program_studi);
            }

            // Filter berdasarkan kata kunci
            if ($request->filled('kata_kunci')) {
                $kata_kunci = $request->kata_kunci;
                $query->where(function($q) use ($kata_kunci) {
                    $q->where('judul', 'like', '%' . $kata_kunci . '%')
                      ->orWhere('pengarang', 'like', '%' . $kata_kunci . '%')
                      ->orWhere('abstrak', 'like', '%' . $kata_kunci . '%');
                });
            }

            $query->orderBy('tahun_publikasi', 'desc')->orderBy('created_at', 'desc');
            $jurnals = $query->paginate(10);
            $total_jurnal = Jurnal::count();
            $jurnal_tahun_ini = Jurnal::whereYear('tahun_publikasi', date('Y'))->count();

            return view('dosen.home.home', compact('jurnals', 'total_jurnal', 'jurnal_tahun_ini'));

        } catch (\Exception $e) {
            \Log::error('Error in dosen home: ' . $e->getMessage());
            $jurnals = collect()->paginate(10);
            $total_jurnal = 0;
            $jurnal_tahun_ini = 0;

            return view('dosen.home.home', compact('jurnals', 'total_jurnal', 'jurnal_tahun_ini'))
                ->with('error', 'Terjadi kesalahan dalam memuat data jurnal.');
        }
    }

    // Method baru untuk menangani bulk edit - HANYA UNTUK DOSEN DAN ADMIN
    public function bulkEdit(Request $request)
    {
        // Cek authorization
        $user = Auth::user();
        if ($user->role === 'mahasiswa') {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk mengedit jurnal.');
        }

       try {
            // Validasi input: Harapkan 'selected_jurnal_ids' sebagai array
            $request->validate([
                'selected_jurnal_ids' => 'required|array', // <--- PENTING: Harapkan ARRAY
                'selected_jurnal_ids.*' => 'exists:jurnals,id' // Setiap ID harus ada
            ]);

            // Ambil ID dari request dengan nama yang benar
            $selectedIds = $request->input('selected_jurnal_ids'); // <--- PENTING: Nama ini harus sesuai dengan nama checkbox di form

            if (empty($selectedIds)) {
                return redirect()->back()->with('error', 'Tidak ada jurnal yang dipilih.');
            }

            // Ambil data jurnal yang dipilih
            $jurnals = Jurnal::whereIn('id', $selectedIds)->get(); // Variabel yang diteruskan ke view adalah $jurnals (plural)

            if ($jurnals->isEmpty()) {
                return redirect()->back()->with('error', 'Jurnal yang dipilih tidak ditemukan.');
            }

            // Teruskan koleksi jurnal ke view
            return view('dosen.home.bulk-edit', compact('jurnals')); // <--- PENTING: Meneruskan $jurnals (plural)
        } catch (\Exception $e) {
            \Log::error('Error in bulk edit: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // Method untuk memproses update bulk edit - HANYA UNTUK DOSEN DAN ADMIN
     public function bulkUpdate(Request $request)
    {
        // Cek authorization
        $user = Auth::user();
        if ($user->role === 'mahasiswa') {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk mengedit jurnal.');
        }

        try {
            // PERBAIKAN DI SINI: Ubah 'jurnal_ids' menjadi 'selected_jurnal_ids'
            $request->validate([
                'jurnals' => 'required|array', // Ini validasi untuk array utama dari form bulk-edit
                'jurnals.*.id' => 'required|exists:jurnals,id', // Validasi untuk ID setiap jurnal
                'jurnals.*.judul' => 'required|string|max:255',
                'jurnals.*.pengarang' => 'required|string|max:255',
                'jurnals.*.tipe_referensi' => 'required|string|in:Jurnal,Artikel,Buku',
                'jurnals.*.tahun_publikasi' => 'required|integer|min:1900|max:' . (date('Y') + 5),
                // Tambahkan validasi untuk bidang lain yang Anda sertakan di bulk-edit.blade.php
                'jurnals.*.departemen' => 'nullable|string|max:255', // Sesuaikan jika required
                'jurnals.*.prodi' => 'nullable|string|max:255', // Sesuaikan jika required
                'jurnals.*.semester' => 'nullable|integer|min:1|max:8', // Sesuaikan jika required
                'jurnals.*.mata_kuliah' => 'nullable|string|max:255', // Sesuaikan jika required
                'jurnals.*.abstrak' => 'nullable|string',
                'jurnals.*.doi' => 'nullable|url|max:255', // Sesuaikan nama jika di DB 'url'
                // 'jurnals.*.issue' => 'nullable|string|max:255', // Jika ada di form
                // 'jurnals.*.halaman' => 'nullable|integer', // Jika ada di form
            ]);

            $updatedCount = 0;
            $errors = [];

            // Loop melalui data 'jurnals' yang dikirim dari form
            foreach ($request->input('jurnals') as $jurnalData) {
                try {
                    $jurnal = Jurnal::find($jurnalData['id']);
                    if (!$jurnal) {
                        $errors[] = "Jurnal dengan ID {$jurnalData['id']} tidak ditemukan.";
                        continue;
                    }

                    // Update data untuk setiap jurnal
                    $jurnal->update([
                        'judul' => $jurnalData['judul'],
                        'pengarang' => $jurnalData['pengarang'],
                        'tipe_referensi' => $jurnalData['tipe_referensi'],
                        'tahun_publikasi' => $jurnalData['tahun_publikasi'],
                        'departemen' => $jurnalData['departemen'] ?? null, // Gunakan null coalescing jika opsional
                        'prodi' => $jurnalData['prodi'] ?? null,
                        'semester' => $jurnalData['semester'] ?? null,
                        'mata_kuliah' => $jurnalData['mata_kuliah'] ?? null,
                        'abstrak' => $jurnalData['abstrak'] ?? null,
                        'doi' => $jurnalData['doi'] ?? null, // Pastikan ini sesuai dengan nama kolom di DB
                        // 'issue' => $jurnalData['issue'] ?? null,
                        // 'banyak_halaman' => $jurnalData['halaman'] ?? null,
                         'user_id' => Auth::id(),
                    ]);

                    $updatedCount++;

                } catch (\Exception $e) {
                    $errors[] = "Error updating jurnal ID {$jurnalData['id']}: " . $e->getMessage();
                }
            }

            if ($updatedCount > 0) {
                $message = "Berhasil memperbarui {$updatedCount} jurnal.";
                if (!empty($errors)) {
                    $message .= " Terdapat " . count($errors) . " error: " . implode(' ', $errors);
                }
                return redirect()->route('jurnal.my')->with('success', $message); // Redirect ke halaman jurnal saya
            } else {
                return redirect()->back()->with('error', 'Tidak ada data yang diperbarui. ' . implode(' ', $errors));
            }

        } catch (ValidationException $e) { // Tangani khusus ValidationException
            // Ini akan memastikan pesan error validasi kembali ke form
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            \Log::error('Error in bulk update (outer catch): ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan umum saat pembaruan massal: ' . $e->getMessage());
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