@extends('layouts.layout')

@section('content')
<div style="padding: 24px;">
    <div style="display: flex; align-items: center; margin-bottom: 20px;">
        {{-- Kembali ke halaman index jurnal dosen --}}
        <a href="{{ route('jurnal.index') }}" style="background: #6c757d; color: white; padding: 8px 16px; text-decoration: none; border-radius: 4px; margin-right: 16px;">
            ← Kembali
        </a>
        {{-- Menampilkan judul dari satu jurnal yang dikirim --}}
        <h2> Edit Jurnal: {{ $jurnal->judul }} </h2>
    </div>
    <hr>

    @if(session('success'))
        <div style="background: #d4edda; color: #155724; padding: 12px; border-radius: 4px; margin-bottom: 16px; border: 1px solid #c3e6cb;">
            {{ session('success') }}
        </div>
    @endif
    @if ($errors->any())
        <div style="background: #f8d7da; color: #721c24; padding: 12px; border-radius: 4px; margin-bottom: 16px; border: 1px solid #f5c6cb;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- DIUBAH: Form action mengarah ke route update untuk satu jurnal --}}
    <form action="{{ route('jurnal.update', $jurnal->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT') {{-- PENTING: Method untuk update adalah PUT/PATCH --}}
        
        <div class="jurnal-card" style="background: white; border: 1px solid #dee2e6; border-radius: 8px; margin-bottom: 16px; overflow: hidden; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            
            <div class="card-body" style="padding: 20px;">
                
                {{-- DIHAPUS: @foreach dan input untuk jurnal_ids tidak diperlukan lagi --}}

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: bold;">Judul</label>
                        {{-- DIUBAH: name menjadi "judul", bukan "judul[]" --}}
                        <input type="text" name="judul" value="{{ old('judul', $jurnal->judul) }}" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                    </div>
                    
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: bold;">Penulis</label>
                        {{-- DIUBAH: name menjadi "pengarang" --}}
                        <input type="text" name="pengarang" value="{{ old('pengarang', $jurnal->pengarang) }}" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px; margin-bottom: 20px;">
    <div>
        <label style="display: block; margin-bottom: 5px; font-weight: bold;">Tipe Referensi</label>
        <select name="tipe_referensi" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
            <option value="Jurnal" {{ old('tipe_referensi', $jurnal->tipe_referensi) == 'Jurnal' ? 'selected' : '' }}>Jurnal</option>
            <option value="Artikel" {{ old('tipe_referensi', $jurnal->tipe_referensi) == 'Artikel' ? 'selected' : '' }}>Artikel</option>
            <option value="Buku" {{ old('tipe_referensi', $jurnal->tipe_referensi) == 'Buku' ? 'selected' : '' }}>Buku</option>
        </select>
    </div>

    <div>
        <label style="display: block; margin-bottom: 5px; font-weight: bold;">Semester</label>
        <select name="semester" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
            @for ($i = 1; $i <= 8; $i++)
                <option value="{{ $i }}" {{ old('semester', $jurnal->semester) == $i ? 'selected' : '' }}>Semester {{ $i }}</option>
            @endfor
        </select>
    </div>

    <div>
        <label style="display: block; margin-bottom: 5px; font-weight: bold;">Mata Kuliah</label>
        {{-- Untuk sementara kita gunakan input text. Jika ingin dropdown dinamis, perlu Javascript tambahan. --}}
        <input type="text" name="mata_kuliah" value="{{ old('mata_kuliah', $jurnal->mata_kuliah) }}" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
    </div>
</div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: bold;">Tahun Publikasi</label>
                        {{-- DIUBAH: name menjadi "tahun", sesuaikan dengan validasi di controller --}}
                        <input type="number" name="tahun" value="{{ old('tahun', $jurnal->tahun_publikasi) }}" min="1900" max="{{ date('Y') + 5 }}" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                    </div>
                    
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: bold;">Departemen</label>
                        {{-- DIUBAH: name menjadi "departemen" --}}
                        <select name="departemen" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                            <option value="">Pilih Departemen</option>
                            {{-- DIUBAH: $jurnal->departemen --}}
                            <option value="Fakultas Sains dan Matematika" {{ old('departemen', $jurnal->departemen) == 'Fakultas Sains dan Matematika' ? 'selected' : '' }}>Fakultas Sains dan Matematika</option>
                            <option value="Fakultas Teknik" {{ old('departemen', $jurnal->departemen) == 'Fakultas Teknik' ? 'selected' : '' }}>Fakultas Teknik</option>
                            <option value="Fakultas Ekonomi dan Bisnis" {{ old('departemen', $jurnal->departemen) == 'Fakultas Ekonomi dan Bisnis' ? 'selected' : '' }}>Fakultas Ekonomi dan Bisnis</option>
                        </select>
                    </div>
                    
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: bold;">Program Studi</label>
                         {{-- DIUBAH: name menjadi "prodi" --}}
                        <select name="prodi" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                            <option value="">Pilih Program Studi</option>
                            {{-- DIUBAH: $jurnal->prodi --}}
                            <option value="Informatika" {{ old('prodi', $jurnal->prodi) == 'Informatika' ? 'selected' : '' }}>Informatika</option>
                            {{-- Tambahkan prodi lain jika perlu --}}
                        </select>
                    </div>
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; font-weight: bold;">Abstrak</label>
                    {{-- DIUBAH: name menjadi "abstrak" --}}
                    <textarea name="abstrak" rows="4" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; resize: vertical;" placeholder="Masukkan abstrak jurnal...">{{ old('abstrak', $jurnal->abstrak) }}</textarea>
                </div>
                
                 <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; font-weight: bold;">URL (DOI)</label>
                    {{-- DIUBAH: name menjadi "url", value dari kolom "doi" --}}
                    <input type="url" name="url" value="{{ old('url', $jurnal->doi) }}" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                </div>

                 <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; font-weight: bold;">Ganti File PDF (Opsional)</label>
                    <input type="file" name="file_pdf" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                     @if($jurnal->file_path)
                        <small>File saat ini: {{ basename($jurnal->file_path) }}. Biarkan kosong jika tidak ingin mengubah.</small>
                    @endif
                </div>

            </div>
        </div>

        <div style="text-align: center; margin-top: 20px;">
            <button type="submit" style="background: #28a745; color: white; padding: 12px 30px; border: none; border-radius: 4px; cursor: pointer; font-size: 16px;">
                💾 Simpan Perubahan
            </button>
        </div>
    </form>
</div>


<style>
/* Additional styling for better UX */
.jurnal-card {
    transition: all 0.3s ease;
}

.jurnal-card:hover {
    box-shadow: 0 4px 8px rgba(0,0,0,0.15) !important;
}

.card-header {
    transition: background-color 0.2s ease;
}

.card-header:hover {
    background: #e9ecef !important;
}

.toggle-icon {
    transition: transform 0.2s ease;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .card-body > div[style*="grid-template-columns"] {
        grid-template-columns: 1fr !important;
    }
    
    .control-buttons {
        flex-direction: column;
        gap: 10px;
    }
}

/* Loading state */
.loading {
    opacity: 0.6;
    pointer-events: none;
}

/* Success animation */
@keyframes fadeInSuccess {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

.success-message {
    animation: fadeInSuccess 0.5s ease;
}
</style>
@endsection