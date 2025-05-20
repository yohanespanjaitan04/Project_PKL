@extends('layouts.layout')

@section('content')
<div style="padding: 24px;">
    <h2>Tambah Referensi Baru</h2>
    <hr>

    <form action="{{ route('referensi.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">

            {{-- Baris 1 --}}
            <div>
                <label for="tipe_referensi">Tipe Referensi</label>
                <select name="tipe_referensi" id="tipe_referensi" style="width: 100%; padding: 8px;">
                    <option value="">-- Pilih Tipe --</option>
                    <option value="Jurnal">Jurnal</option>
                    <option value="Artikel">Artikel</option>
                    <option value="Buku">Buku</option>
                </select>
            </div>

            <div>
                <label for="departemen">Departemen</label>
                <select name="departemen" id="departemen" style="width: 100%; padding: 8px;">
                    <option value="">-- Pilih Departemen --</option>
                    <option value="Informatika">Informatika</option>
                    <option value="Elektro">Elektro</option>
                    <option value="Sipil">Sipil</option>
                </select>
            </div>

            {{-- Baris 2 --}}
            <div style="grid-column: span 2;">
                <label for="judul">Judul</label>
                <input type="text" name="judul" id="judul" style="width: 100%; padding: 8px;">
            </div>

            {{-- Baris 3 --}}
            <div>
                <label for="pengarang">Pengarang</label>
                <input type="text" name="pengarang" id="pengarang" style="width: 100%; padding: 8px;">
            </div>
            <div>
                <label for="tahun">Tahun Publikasi</label>
                <input type="number" name="tahun" id="tahun" style="width: 100%; padding: 8px;">
            </div>

            {{-- Baris 4 --}}
            <div>
                <label for="issue">Issue</label>
                <input type="text" name="issue" id="issue" style="width: 100%; padding: 8px;">
            </div>
            <div>
                <label for="halaman">Banyak Halaman</label>
                <input type="number" name="halaman" id="halaman" style="width: 100%; padding: 8px;">
            </div>

            {{-- Baris 5 --}}
            <div style="grid-column: span 2;">
                <label for="abstrak">Abstrak/deskripsi</label>
                <textarea name="abstrak" id="abstrak" rows="4" style="width: 100%; padding: 8px;"></textarea>
            </div>

            {{-- Baris 6 --}}
            <div>
                <label for="url">DOI/URL</label>
                <input type="text" name="url" id="url" style="width: 100%; padding: 8px;">
            </div>
            <div>
                <label for="file_pdf">Upload PDF (optional)</label>
                <input type="file" name="file_pdf" id="file_pdf" accept=".pdf" style="width: 100%;">
            </div>

        </div>

        <br>
        <button type="submit" style="padding: 8px 20px;">Simpan</button>
    </form>
</div>
@endsection