<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jurnal;
use Illuminate\Support\Facades\Storage;

class JurnalController extends Controller
{
    public function index()
    {
        $jurnals = Jurnal::paginate(10);
        return view('dosen.jurnal.index', compact('jurnals'));
    }

    public function create()
    {
        return view('dosen.jurnal.create');
    }

    public function store(Request $request)
    {
        // Validasi input sesuai dengan form
        $validated = $request->validate([
            'tipe_referensi' => 'required|max:255',
            'departemen' => 'required|max:255',
            'prodi' => 'required|max:255',
            'semester' => 'required|max:255',
            'mata_kuliah' => 'required|max:255',
            'judul' => 'required|max:255',
            'pengarang' => 'required|max:255',
            'tahun' => 'required|numeric',
            'issue' => 'nullable|max:255',
            'halaman' => 'nullable|numeric',
            'abstrak' => 'required',
            'url' => 'nullable|url',
            'file_pdf' => 'nullable|file|mimes:pdf|max:10240',
        ]);
        
        // Mapping nama field ke kolom database
        $dataToSave = [
            'tipe_referensi' => $validated['tipe_referensi'],
            'departemen' => $validated['departemen'],
            'prodi' => $validated['prodi'],
            'semester' => $validated['semester'],
            'mata_kuliah' => $validated['mata_kuliah'],
            'judul' => $validated['judul'],
            'pengarang' => $validated['pengarang'],
            'tahun_publikasi' => $validated['tahun'], // mapping ke kolom tahun_publikasi
            'issue' => $validated['issue'],
            'banyak_halaman' => $validated['halaman'], // mapping ke kolom banyak_halaman
            'abstrak' => $validated['abstrak'],
            'doi' => $validated['url'], // mapping ke kolom doi
        ];
        
        // Handle file upload jika ada
        if ($request->hasFile('file_pdf')) {
            $fileName = time() . '_' . $request->file('file_pdf')->getClientOriginalName();
            $filePath = $request->file('file_pdf')->storeAs('pdfs', $fileName, 'public');
            $dataToSave['file_path'] = $filePath; // mapping ke kolom file_path
        }
        
        // Simpan jurnal
        Jurnal::create($dataToSave);
        
        return redirect()->route('jurnal.index')
            ->with('success', 'Jurnal berhasil ditambahkan!');
    }

    // Method untuk menampilkan detail jurnal
    public function show(Jurnal $jurnal)
    {
        return view('dosen.jurnal.show', compact('jurnal'));
    }

    // Method untuk menampilkan form edit
    public function edit(Jurnal $jurnal)
    {
        return view('jurnal.edit', compact('jurnal'));
    }

    // Method untuk update jurnal
    public function update(Request $request, Jurnal $jurnal)
    {
        // Validasi input
        $validated = $request->validate([
            'tipe_referensi' => 'required|max:255',
            'departemen' => 'required|max:255',
            'prodi' => 'required|max:255',
            'semester' => 'required|max:255',
            'mata_kuliah' => 'required|max:255',
            'judul' => 'required|max:255',
            'pengarang' => 'required|max:255',
            'tahun' => 'required|numeric',
            'issue' => 'nullable|max:255',
            'halaman' => 'nullable|numeric',
            'abstrak' => 'required',
            'url' => 'nullable|url',
            'file_pdf' => 'nullable|file|mimes:pdf|max:10240',
        ]);
        
        // Mapping nama field ke kolom database
        $dataToUpdate = [
            'tipe_referensi' => $validated['tipe_referensi'],
            'departemen' => $validated['departemen'],
            'prodi' => $validated['prodi'],
            'semester' => $validated['semester'],
            'mata_kuliah' => $validated['mata_kuliah'],
            'judul' => $validated['judul'],
            'pengarang' => $validated['pengarang'],
            'tahun_publikasi' => $validated['tahun'],
            'issue' => $validated['issue'],
            'banyak_halaman' => $validated['halaman'],
            'abstrak' => $validated['abstrak'],
            'doi' => $validated['url'],
        ];
        
        // Handle file upload jika ada file baru
        if ($request->hasFile('file_pdf')) {
            // Hapus file lama jika ada
            if ($jurnal->file_path && Storage::disk('public')->exists($jurnal->file_path)) {
                Storage::disk('public')->delete($jurnal->file_path);
            }
            
            // Upload file baru
            $fileName = time() . '_' . $request->file('file_pdf')->getClientOriginalName();
            $filePath = $request->file('file_pdf')->storeAs('pdfs', $fileName, 'public');
            $dataToUpdate['file_path'] = $filePath;
        }
        
        // Update jurnal
        $jurnal->update($dataToUpdate);
        
        return redirect()->route('jurnal.index')
            ->with('success', 'Jurnal berhasil diupdate!');
    }

    // Method untuk hapus jurnal
    public function destroy(Jurnal $jurnal)
    {
        // Hapus file jika ada
        if ($jurnal->file_path && Storage::disk('public')->exists($jurnal->file_path)) {
            Storage::disk('public')->delete($jurnal->file_path);
        }
        
        // Hapus data jurnal
        $jurnal->delete();
        
        return redirect()->route('jurnal.index')
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