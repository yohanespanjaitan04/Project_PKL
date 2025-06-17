{{-- Menggunakan layout admin yang sudah konsisten --}}
@extends('layouts.admin')

@section('title', 'Tambah Referensi Baru')

@section('content')
<div class="header">
    <h1>Tambah Referensi Baru (Admin)</h1>
</div>

{{-- Menggunakan .table-container sebagai wrapper agar visualnya sama dengan halaman lain --}}
<div class="table-container" style="padding: 30px;">
    
    {{-- Arahkan ke route yang sesuai untuk admin --}}
    <form action="{{ route('admin.referensi.store') }}" method="POST">
        @csrf {{-- Token Keamanan Wajib --}}

        {{-- Kita gunakan grid layout agar rapi, mirip form Dosen tapi dengan style Admin --}}
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">

            {{-- Baris 1 --}}
            <div class="form-group" style="margin-bottom: 0;">
                <label for="tipe_referensi" class="form-label">Tipe Referensi</label>
                <select name="tipe_referensi" id="tipe_referensi" class="form-select" required>
                    <option value="" disabled selected>-- Pilih Tipe --</option>
                    <option value="Jurnal" {{ old('tipe_referensi') == 'Jurnal' ? 'selected' : '' }}>Jurnal</option>
                    <option value="Artikel" {{ old('tipe_referensi') == 'Artikel' ? 'selected' : '' }}>Artikel</option>
                    <option value="Buku" {{ old('tipe_referensi') == 'Buku' ? 'selected' : '' }}>Buku</option>
                </select>
                @error('tipe_referensi') <span class="error-message">{{ $message }}</span> @enderror
            </div>
            
            <div class="form-group" style="margin-bottom: 0;">
                <label for="pengarang" class="form-label">Pengarang</label>
                <input type="text" name="pengarang" id="pengarang" class="form-input" value="{{ old('pengarang') }}" required>
                @error('pengarang') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            {{-- Baris 2 --}}
            <div class="form-group" style="grid-column: span 2; margin-bottom: 0;">
                <label for="judul" class="form-label">Judul</label>
                <input type="text" name="judul" id="judul" class="form-input" value="{{ old('judul') }}" required>
                @error('judul') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            {{-- Baris 3 --}}
            <div class="form-group" style="margin-bottom: 0;">
                <label for="tahun" class="form-label">Tahun Publikasi</label>
                <input type="number" name="tahun" id="tahun" class="form-input" value="{{ old('tahun') }}" placeholder="Contoh: 2024" required>
                @error('tahun') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            <div class="form-group" style="margin-bottom: 0;">
                <label for="url" class="form-label">DOI / URL (Opsional)</label>
                <input type="url" name="url" id="url" class="form-input" value="{{ old('url') }}" placeholder="https://example.com/jurnal.pdf">
                @error('url') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            {{-- Baris 4 --}}
            <div class="form-group" style="margin-bottom: 0;">
                <label for="issue" class="form-label">Issue (Opsional)</label>
                <input type="text" name="issue" id="issue" class="form-input" value="{{ old('issue') }}">
                @error('issue') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            <div class="form-group" style="margin-bottom: 0;">
                <label for="halaman" class="form-label">Banyak Halaman (Opsional)</label>
                <input type="number" name="halaman" id="halaman" class="form-input" value="{{ old('halaman') }}">
                @error('halaman') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            {{-- Baris 5 --}}
            <div class="form-group" style="grid-column: span 2; margin-bottom: 0;">
                <label for="abstrak" class="form-label">Abstrak / Deskripsi</label>
                <textarea name="abstrak" id="abstrak" rows="5" class="form-input" required>{{ old('abstrak') }}</textarea>
                @error('abstrak') <span class="error-message">{{ $message }}</span> @enderror
            </div>
        </div>

        {{-- Tombol Aksi --}}
        <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 30px;">
            <a href="{{ route('admin.referensi.index') }}" class="btn-aksi" style="background-color: #6c757d;">Batal</a>
            <button type="submit" class="btn-aksi" style="background-color: #3b82f6;">Simpan Referensi</button>
        </div>

    </form>
</div>

{{-- Menambahkan sedikit style untuk pesan error agar konsisten --}}
<style>
    .error-message {
        color: #ef4444; /* Merah */
        font-size: 12px;
        margin-top: 4px;
    }
</style>
@endsection