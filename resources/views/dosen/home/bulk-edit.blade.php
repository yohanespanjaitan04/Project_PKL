@extends('layouts.layout')

@section('content')
<div style="padding: 24px;">
    <div style="display: flex; align-items: center; margin-bottom: 20px;">
        {{-- Kembali ke halaman index jurnal dosen --}}
        <a href="{{ route('jurnal.my') }}" style="background: #6c757d; color: white; padding: 8px 16px; text-decoration: none; border-radius: 4px; margin-right: 16px;">
            ← Kembali
        </a>
        <h2>Edit Jurnal Secara Massal</h2>
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

    {{-- FORM UTAMA UNTUK BULK EDIT --}}
    <form action="{{ route('jurnal.bulk-update') }}" method="POST">
        @csrf
        {{-- Method POST untuk bulk-update, karena data yang dikirim adalah array --}}

        @if ($jurnals->isEmpty())
            <p>Tidak ada jurnal yang dipilih untuk diedit.</p>
        @else
            @foreach ($jurnals as $jurnalItem) {{-- LOOP DI SINI, gunakan variabel baru seperti $jurnalItem --}}
                <div class="jurnal-item-edit" style="margin-bottom: 20px; border: 1px solid #dee2e6; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    <div class="card-body" style="padding: 20px;">
                        <h3>Edit Jurnal: {{ $jurnalItem->judul }}</h3> {{-- Gunakan $jurnalItem --}}
                        <input type="hidden" name="jurnals[{{ $jurnalItem->id }}][id]" value="{{ $jurnalItem->id }}">

                        {{-- Contoh field: Judul --}}
                        <div style="margin-bottom: 15px;">
                            <label style="display: block; margin-bottom: 5px; font-weight: bold;">Judul</label>
                            <input type="text" name="jurnals[{{ $jurnalItem->id }}][judul]" value="{{ old('jurnals.' . $jurnalItem->id . '.judul', $jurnalItem->judul) }}" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                            @error('jurnals.' . $jurnalItem->id . '.judul')
                                <div style="color: red; font-size: 0.85em; margin-top: 5px;">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Contoh: Penulis --}}
                        <div style="margin-bottom: 15px;">
                            <label style="display: block; margin-bottom: 5px; font-weight: bold;">Penulis</label>
                            <input type="text" name="jurnals[{{ $jurnalItem->id }}][pengarang]" value="{{ old('jurnals.' . $jurnalItem->id . '.pengarang', $jurnalItem->pengarang) }}" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                            @error('jurnals.' . $jurnalItem->id . '.pengarang')
                                <div style="color: red; font-size: 0.85em; margin-top: 5px;">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Contoh: Tipe Referensi --}}
                        <div style="margin-bottom: 15px;">
                            <label style="display: block; margin-bottom: 5px; font-weight: bold;">Tipe Referensi</label>
                            <select name="jurnals[{{ $jurnalItem->id }}][tipe_referensi]" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                                <option value="Jurnal" {{ old('jurnals.' . $jurnalItem->id . '.tipe_referensi', $jurnalItem->tipe_referensi) == 'Jurnal' ? 'selected' : '' }}>Jurnal</option>
                                <option value="Artikel" {{ old('jurnals.' . $jurnalItem->id . '.tipe_referensi', $jurnalItem->tipe_referensi) == 'Artikel' ? 'selected' : '' }}>Artikel</option>
                                <option value="Buku" {{ old('jurnals.' . $jurnalItem->id . '.tipe_referensi', $jurnalItem->tipe_referensi) == 'Buku' ? 'selected' : '' }}>Buku</option>
                            </select>
                            @error('jurnals.' . $jurnalItem->id . '.tipe_referensi')
                                <div style="color: red; font-size: 0.85em; margin-top: 5px;">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Contoh: Tahun Publikasi --}}
                        <div style="margin-bottom: 15px;">
                            <label style="display: block; margin-bottom: 5px; font-weight: bold;">Tahun Publikasi</label>
                            <input type="number" name="jurnals[{{ $jurnalItem->id }}][tahun_publikasi]" value="{{ old('jurnals.' . $jurnalItem->id . '.tahun_publikasi', $jurnalItem->tahun_publikasi) }}" min="1900" max="{{ date('Y') + 5 }}" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                            @error('jurnals.' . $jurnalItem->id . '.tahun_publikasi')
                                <div style="color: red; font-size: 0.85em; margin-top: 5px;">{{ $message }}</div>
                            @enderror
                        </div>

                         <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: bold;">Departemen</label>
                    <select name="jurnals[{{ $jurnalItem->id }}][departemen]" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                        <option value="">Pilih Departemen</option>
                        <option value="Fakultas Sains dan Matematika" {{ old('jurnals.' . $jurnalItem->id . '.departemen', $jurnalItem->departemen) == 'Fakultas Sains dan Matematika' ? 'selected' : '' }}>Fakultas Sains dan Matematika</option>
                        <option value="Fakultas Teknik" {{ old('jurnals.' . $jurnalItem->id . '.departemen', $jurnalItem->departemen) == 'Fakultas Teknik' ? 'selected' : '' }}>Fakultas Teknik</option>
                        <option value="Fakultas Ekonomi dan Bisnis" {{ old('jurnals.' . $jurnalItem->id . '.departemen', $jurnalItem->departemen) == 'Fakultas Ekonomi dan Bisnis' ? 'selected' : '' }}>Fakultas Ekonomi dan Bisnis</option>
                        {{-- Tambahkan departemen lain jika ada --}}
                    </select>
                    @error('jurnals.' . $jurnalItem->id . '.departemen')
                        <div style="color: red; font-size: 0.85em; margin-top: 5px;">{{ $message }}</div>
                    @enderror
                </div>
                
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: bold;">Program Studi</label>
                    <select name="jurnals[{{ $jurnalItem->id }}][prodi]" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                        <option value="">Pilih Program Studi</option>
                        <option value="Informatika" {{ old('jurnals.' . $jurnalItem->id . '.prodi', $jurnalItem->prodi) == 'Informatika' ? 'selected' : '' }}>Informatika</option>
                        <option value="Teknik Informatika" {{ old('jurnals.' . $jurnalItem->id . '.prodi', $jurnalItem->prodi) == 'Teknik Informatika' ? 'selected' : '' }}>Teknik Informatika</option>
                        <option value="Sistem Informasi" {{ old('jurnals.' . $jurnalItem->id . '.prodi', $jurnalItem->prodi) == 'Sistem Informasi' ? 'selected' : '' }}>Sistem Informasi</option>
                        <option value="Teknik Komputer" {{ old('jurnals.' . $jurnalItem->id . '.prodi', $jurnalItem->prodi) == 'Teknik Komputer' ? 'selected' : '' }}>Teknik Komputer</option>
                        <option value="Teknik Elektro" {{ old('jurnals.' . $jurnalItem->id . '.prodi', $jurnalItem->prodi) == 'Teknik Elektro' ? 'selected' : '' }}>Teknik Elektro</option>
                        <option value="Teknik Sipil" {{ old('jurnals.' . $jurnalItem->id . '.prodi', $jurnalItem->prodi) == 'Teknik Sipil' ? 'selected' : '' }}>Teknik Sipil</option>
                        {{-- Tambahkan prodi lain jika ada --}}
                    </select>
                    @error('jurnals.' . $jurnalItem->id . '.prodi')
                        <div style="color: red; font-size: 0.85em; margin-top: 5px;">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                 <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: bold;">Semester</label>
                    <select name="jurnals[{{ $jurnalItem->id }}][semester]" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                        @for ($i = 1; $i <= 8; $i++)
                            <option value="{{ $i }}" {{ old('jurnals.' . $jurnalItem->id . '.semester', $jurnalItem->semester) == $i ? 'selected' : '' }}>Semester {{ $i }}</option>
                        @endfor
                    </select>
                    @error('jurnals.' . $jurnalItem->id . '.semester')
                        <div style="color: red; font-size: 0.85em; margin-top: 5px;">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: bold;">Mata Kuliah</label>
                    <input type="text" name="jurnals[{{ $jurnalItem->id }}][mata_kuliah]" value="{{ old('jurnals.' . $jurnalItem->id . '.mata_kuliah', $jurnalItem->mata_kuliah) }}" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                    @error('jurnals.' . $jurnalItem->id . '.mata_kuliah')
                        <div style="color: red; font-size: 0.85em; margin-top: 5px;">{{ $message }}</div>
                    @enderror
                </div>
            </div>

                        {{-- Tambahkan field lain yang ingin di-edit secara massal di sini --}}
                        {{-- Anda mungkin ingin beberapa field saja yang bisa di bulk edit, tidak semua field --}}
                        {{-- Contoh: Abstrak (jika ingin di bulk edit) --}}
                        {{--
                        <div style="margin-bottom: 15px;">
                            <label style="display: block; margin-bottom: 5px; font-weight: bold;">Abstrak</label>
                            <textarea name="jurnals[{{ $jurnalItem->id }}][abstrak]" rows="4" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; resize: vertical;">{{ old('jurnals.' . $jurnalItem->id . '.abstrak', $jurnalItem->abstrak) }}</textarea>
                            @error('jurnals.' . $jurnalItem->id . '.abstrak')
                                <div style="color: red; font-size: 0.85em; margin-top: 5px;">{{ $message }}</div>
                            @enderror
                        </div>
                        --}}

                        {{-- Catatan: Mengelola upload file dalam bulk edit jauh lebih kompleks dan biasanya tidak disarankan. --}}
                        {{-- Jika Anda ingin mengizinkan update file PDF, itu mungkin harus dilakukan secara individual per jurnal. --}}
                    </div>
                </div>
            @endforeach

            <div style="text-align: center; margin-top: 20px;">
                <button type="submit" style="background: #28a745; color: white; padding: 12px 30px; border: none; border-radius: 4px; cursor: pointer; font-size: 16px;">
                    💾 Simpan Semua Perubahan
                </button>
            </div>
        @endif
    </form>
</div>
@endsection

<style>
/* Styling Anda */
.jurnal-item-edit {
    background: white;
    border: 1px solid #dee2e6;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.jurnal-item-edit:hover {
    box-shadow: 0 4px 8px rgba(0,0,0,0.15) !important;
}

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