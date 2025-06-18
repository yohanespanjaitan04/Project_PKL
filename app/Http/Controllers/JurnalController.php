<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jurnal;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class JurnalController extends Controller
{
    public function index(Request $request)
    {
        // Cek apakah URL yang sedang diakses diawali dengan 'admin/'
        if ($request->is('admin/*')) {
            // --- INI LOGIKA UNTUK ADMIN ---

            // Ambil semua data jurnal untuk ditampilkan ke admin
            $jurnals = Jurnal::latest()->paginate(10); 
            
            // Tampilkan view index milik admin
            // Pastikan file ini ada: resources/views/admin/TambahJurnal/index.blade.php
            return view('admin.TambahJurnal.index', compact('jurnals'));
        } 
        
        // Jika URL tidak diawali 'admin/', maka kita anggap itu untuk dosen atau role lain.
        else {
            // --- INI LOGIKA UNTUK DOSEN ---

            // Ambil hanya jurnal yang dibuat oleh dosen yang sedang login
            // Pastikan Anda memiliki kolom 'user_id' di tabel 'jurnals'
           $jurnals = Jurnal::where('user_id', Auth::id())->latest()->paginate(10);
            
            // Tampilkan view index milik dosen
            // Pastikan file ini ada: resources/views/dosen/jurnal/index.blade.php
            return view('dosen.jurnal.index', compact('jurnals'));
        }
    }


    public function create(Request $request) // Tambahkan Request $request
    {
        if ($request->is('admin/*')) {
            // Untuk admin, tampilkan view tambah jurnal di folder admin
            // Pastikan file ini ada: resources/views/admin/TambahJurnal/create.blade.php
            return view('admin.TambahJurnal.create'); 
        } else {
            // Untuk dosen, tampilkan view tambah jurnal di folder dosen
            return view('dosen.jurnal.create');
        }
    }


public function store(Request $request)
{
    // LANGKAH 1: Tentukan aturan validasi dasar yang berlaku untuk semua role
    $rules = [
        'tipe_referensi' => 'required|string|in:Jurnal,Artikel,Buku',
        'pengarang'      => 'required|string|max:255',
        'judul'          => 'required|string|max:255',
        'tahun'          => 'required|numeric|digits:4',
        'abstrak'        => 'required|string',
        'url'            => 'nullable|url',
        'issue'          => 'nullable|string|max:100',
        'halaman'        => 'nullable|numeric',
        'file_pdf'       => 'nullable|file|mimes:pdf|max:10240', // Untuk upload file (opsional)
    ];

    // LANGKAH 2: Sesuaikan aturan jika request BUKAN dari admin
    // Form untuk role selain admin (misal: dosen) akan memerlukan field tambahan ini.
    // Asumsinya, form untuk dosen memiliki field departemen, prodi, dll.
    if (!$request->is('admin/*')) {
        $rules['departemen']  = 'required|string|max:255';
        $rules['prodi']       = 'required|string|max:255';
        $rules['semester']    = 'required|string|max:255';
        $rules['mata_kuliah'] = 'required|string|max:255';
    }

    // LANGKAH 3: Jalankan validasi HANYA SATU KALI
    $validated = $request->validate($rules);

    // LANGKAH 4: Siapkan data untuk disimpan, sesuaikan nama field dengan kolom database
    $dataToSave = [
        'tipe_referensi'  => $validated['tipe_referensi'],
        'pengarang'       => $validated['pengarang'],
        'judul'           => $validated['judul'],
        'tahun_publikasi' => $validated['tahun'], // Sesuai mapping Anda
        'abstrak'         => $validated['abstrak'],
        'doi'             => $validated['url'] ?? null,     // Sesuai mapping Anda
        'issue'           => $validated['issue'] ?? null,
        'banyak_halaman'  => $validated['halaman'] ?? null, // Sesuai mapping Anda
        'user_id'         => Auth::id(), // Mengambil ID user yang sedang login
    ];

    // Tambahkan data departemen, prodi, dll. jika ada (untuk non-admin)
    if (isset($validated['departemen'])) {
        $dataToSave['departemen'] = $validated['departemen'];
        $dataToSave['prodi'] = $validated['prodi'];
        $dataToSave['semester'] = $validated['semester'];
        $dataToSave['mata_kuliah'] = $validated['mata_kuliah'];
    }

    // Handle file upload jika ada
    if ($request->hasFile('file_pdf')) {
        $fileName = time() . '_' . $request->file('file_pdf')->getClientOriginalName();
        $filePath = $request->file('file_pdf')->storeAs('pdfs', $fileName, 'public');
        $dataToSave['file_path'] = $filePath;
    }
    
    
    // LANGKAH 5: Simpan ke database
     Jurnal::create($dataToSave);

    // LANGKAH 6: Redirect ke halaman yang sesuai dengan pesan sukses
    $redirectRoute = $request->is('admin/*') ? 'admin.jurnal.index' : 'dosen.jurnal.index';
    
    return redirect()->route($redirectRoute)
                     ->with('success', 'Referensi berhasil ditambahkan!');
}
        

    // Method untuk menampilkan detail jurnal
    public function show(Jurnal $jurnal)
    {
        return view('dosen.jurnal.show', compact('jurnal'));
    }

    // Method untuk menampilkan form edit
    public function edit(Jurnal $jurnal)
    {
        return view('dosen.jurnal.edit', compact('jurnal'));
    }

    // Method untuk update jurnal
    public function update(Request $request, Jurnal $jurnal)
    {
        // [PERBAIKAN PENTING] Validasi ini disesuaikan HANYA untuk form modal admin.
        // Tidak ada lagi validasi untuk 'departemen', 'prodi', dll.
        $validatedData = $request->validate([
            'tipe_referensi'  => 'required|string|max:255',
            'pengarang'       => 'required|string|max:255',
            'judul'           => 'required|string|max:255',
            'tahun_publikasi' => 'required|numeric|digits:4',
            'doi'             => 'nullable|url',
            'issue'           => 'nullable|string|max:100',
            'banyak_halaman'  => 'nullable|numeric',
            'abstrak'         => 'required|string',
        ]);
        
        // [PERBAIKAN PENTING] Langsung update karena nama input sudah konsisten.
        $jurnal->update($validatedData);

        // [PERBAIKAN PENTING] Redirect ke rute admin secara eksplisit.
        return redirect()->route('admin.jurnal.index')
            ->with('success', 'Jurnal berhasil diupdate!');
            
    }

    /**
     * [PERBAIKAN TOTAL] Method untuk HAPUS jurnal.
     */
    public function destroy(Jurnal $jurnal)
    {
        // Hapus file dari storage jika ada
        if ($jurnal->file_path && Storage::disk('public')->exists($jurnal->file_path)) {
            Storage::disk('public')->delete($jurnal->file_path);
        }
        
        // Hapus data dari database
        $jurnal->delete();
        
        // [PERBAIKAN PENTING] Redirect ke rute admin secara eksplisit.
        return redirect()->route('admin.jurnal.index')
            ->with('success', 'Jurnal berhasil dihapus!');
    }

    // Method untuk download file PDF
    public function download(Jurnal $jurnal)
    {
        if (!$jurnal->file_path || !Storage::disk('public')->exists($jurnal->file_path)) {
            return redirect()->back()->with('error', 'File tidak ditemukan!');
        }
        
        return Storage::disk('public')->download(
            $jurnal->file_path, 
            'Jurnal_' . $jurnal->judul . '.pdf'
        );
    }

    // Method untuk AJAX dropdown (tetap sama)
    public function getProdi(Request $request)
    {
        try {
            $departemen = $request->get('departemen');
            
            $prodi_data = [
                'Fakultas Sains dan Matematika' => [
                    'Informatika',
                    'Fisika',
                    'Kimia',
                    'Biologi',
                    'Statistika'
                ],
                'Fakultas Teknik' => [
                    'Teknik Elektro',
                    'Teknik Sipil',
                    'Teknik Mesin',
                    'Teknik Arsitektur',
                    'Teknik Industri'
                ],
                'Fakultas Ekonomi dan Bisnis' => [
                    'Etika Bisnis',
                    'Manajemen Resiko',
                    'Manajemen Sumber Daya Manusia',
                    'Akuntansi Manajemen',
                    'Manajemen Pemasaran'
                ]
            ];
            
            $prodi = isset($prodi_data[$departemen]) ? $prodi_data[$departemen] : [];
            
            return response()->json($prodi);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getSemester(Request $request)
    {
        try {
            $prodi = $request->get('prodi');
            $semester = [1, 2, 3, 4, 5, 6, 7, 8];
            return response()->json($semester);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getMataKuliah(Request $request)
    {
        $prodi = $request->prodi;
        $semester = $request->semester;
        
        // Data mata kuliah (sama seperti sebelumnya)
        $mata_kuliah_data = [
            'Informatika' => [
                1 => ['Matematika Dasar', 'Dasar Sistem', 'Logika Informatika', 'Strukrut Diskrit'],
                2 => ['Statistika', 'Algoritma Pemograman', 'Organisasi Arsitektur Komputer', 'Aljabar Linear'],
                3 => ['Basis Data', 'Struktur Data', 'Sistem Operasi', 'Interaksi Manusia Komputer'],
                4 => ['Pemrograman Berorientasi Objek', 'Jaringan Komputer', 'Manajemen Basis Data', 'Rekayasa Perangkat Lunak'],
                5 => ['Analisis dan Strategi Algoritma', 'Pengembangan Berbasis Platform', 'Komputasi Tesebar Paralel', 'Sistem Cerdas'],
                6 => ['Sistem Informasi', 'Proyek Perangkat Lunak', 'Uji Perangkat Lunak', 'Masyarakat dan Etika Profesi'],
                7 => ['Metode Perangkat Lunak', 'Machine Learning'],
                8 => ['Metodologi dan Penulisan Ilmia', 'Tugas Akhir']
                // ... dst
            ],
            'Fisika' => [
                1 => ['Praktikum Fisika Dasar', 'Fisika Dasar I', 'Kalkulus dan Vektor', 'Metode Pengukuran Fisis'],
                2 => ['Termodinamika', 'Praktikum Fisika Dasar II', 'Gelombang', 'Fisika Dasar II'],
                3 => ['Elektronika Dasar', 'Elektromagnetika', 'Fisika Modern', 'Mekanika'],
                4 => ['Fisika Statistik', 'Fisika Matematika III', 'Instrumentasi', 'Optika Modern'],
                5 => ['Simulasi dan Pemodelan', 'Fisika Zat Padat', 'Fisika Nuklir', 'Standarisasi'],
                6 => ['Metode Pengolahan Data', 'Kewirausahaan'],
                7 => ['Kuliah Kerja Nyata'],
                8 => ['Skripsi']
            ],
            'Kimia' => [
                1 => ['Experimental in General Chemistry 1', 'General Chemistry 1', 'Chemistry of Elements', 'Management of Chemical Information'],
                2 => ['Experimental in General Chemistry 2', 'General Physics 1', 'Inorganic Chemistry 1', 'Basics of Biological Chemistry'],
                3 => ['Experimental in Analytical Chemistry', 'Chemical Structure and Bonding', 'General Mathematics 2	', 'Organic Chemistry 2'],
                4 => ['Organic Chemistry 3', 'Inorganic Chemistry 3', 'Instrumental Analytical Chemistry 1', '	Chemical Spectroscopy'],
                5 => ['Experimental in Biochemistry', 'Organic Analysis', 'Organic Synthesis', 'Chemistry 4'],
                6 => ['Advance Experimental in Chemistry 1', 'Reaction Dynamics', 'Research Design', 'Field Work Practice'],
                7 => ['Research Project 1: Chemical Experimentation', 'Real Work Lecture', 'Entrepreneurship'],
                8 => ['Research Project 2: Thesis']
            ]
            // ... data lainnya
        ];
        
        $mata_kuliah = [];
        if (isset($mata_kuliah_data[$prodi]) && isset($mata_kuliah_data[$prodi][$semester])) {
            $mata_kuliah = $mata_kuliah_data[$prodi][$semester];
        }
        
        return response()->json($mata_kuliah);
    }
}