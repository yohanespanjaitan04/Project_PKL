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
        return view('jurnal.index', compact('jurnals'));
    }

    public function create()
    {
        return view('jurnal.create');
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
        return view('jurnal.show', compact('jurnal'));
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
                'Informatika' => [
                    'Teknik Informatika',
                    'Sistem Informasi',
                    'Teknik Komputer'
                ],
                'Elektro' => [
                    'Teknik Elektro',
                    'Teknik Telekomunikasi',
                    'Teknik Elektronika'
                ],
                'Sipil' => [
                    'Teknik Sipil',
                    'Teknik Lingkungan',
                    'Teknik Arsitektur'
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
            'Teknik Informatika' => [
                1 => ['Matematika Dasar', 'Algoritma Pemrograman', 'Pengantar TI'],
                2 => ['Struktur Data', 'Basis Data', 'Pemrograman Web'],
                // ... dst
            ],
            // ... data lainnya
        ];
        
        $mata_kuliah = [];
        if (isset($mata_kuliah_data[$prodi]) && isset($mata_kuliah_data[$prodi][$semester])) {
            $mata_kuliah = $mata_kuliah_data[$prodi][$semester];
        }
        
        return response()->json($mata_kuliah);
    }
}