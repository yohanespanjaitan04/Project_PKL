{{-- Menggunakan layout admin yang sudah kita pisahkan sebelumnya --}}
@extends('layouts.admin')

{{-- Mengisi judul halaman --}}
@section('title', 'Manajemen Jurnal')

{{-- Mengisi bagian konten utama --}}
@section('content')
    <div class="header">
        <h1>Daftar Jurnal</h1>
        {{-- Tombol ini mengarah ke halaman form untuk menambah data baru --}}
        <a href="{{ route('admin.jurnal.create') }}" class="add-user-btn" style="gap: 5px;">
            <span style="font-size: 24px; line-height: 1;">+</span>
            Tambah Jurnal Baru
        </a>
    </div>

    {{-- Menampilkan pesan notifikasi jika ada (misal: setelah berhasil menyimpan data) --}}
    @if(session('success'))
        <div class="alert-success" style="background-color: #d1e7dd; color: #0f5132; border-color: #badbcc; padding: 1rem; border-radius: 8px; margin-bottom: 20px; border: 1px solid transparent;">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-container">
        <table class="table">
            {{-- Bagian Header Tabel --}}
            <thead>
                <tr>
                    <th>NO</th>
                    <th>Judul</th>
                    <th>Penulis</th>
                    <th>Tahun</th>
                    <th>Kategori</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            {{-- Bagian Isi Tabel --}}
            <tbody>
                {{-- Loop data $jurnals yang dikirim dari Controller --}}
                @forelse ($jurnals as $key => $jurnal)
                    <tr>
                        {{-- Kolom NO, nomornya akan menyesuaikan dengan pagination --}}
                        <td>{{ $jurnals->firstItem() + $key }}</td>

                        {{-- Kolom Judul --}}
                        <td style="max-width: 300px;">
                            <strong title="{{ $jurnal->judul }}">
                                {{-- Judul akan dipotong jika terlalu panjang agar layout tidak rusak --}}
                                {{ Str::limit($jurnal->judul, 50) }}
                            </strong>
                        </td>

                        {{-- Kolom Penulis --}}
                        <td>{{ $jurnal->penulis }}</td>

                        {{-- Kolom Tahun --}}
                        <td>{{ $jurnal->tahun_publikasi }}</td>

                        {{-- Kolom Kategori, menggunakan class .role-badge dari UI Anda --}}
                        <td>
                            <span class="role-badge">{{ $jurnal->kategori->nama_kategori ?? 'Tanpa Kategori' }}</span>
                        </td>

                        {{-- Kolom Aksi, berisi tombol Edit dan Hapus --}}
                        <td>
                            <div class="aksi-buttons">
                                {{-- Tombol EDIT: Mengarah ke halaman form edit --}}
                                <a href="{{ route('admin.jurnal.edit', $jurnal->id) }}" class="btn-aksi" style="background-color: #10b981;">Edit</a>
                                
                                {{-- Tombol HAPUS: Menggunakan form untuk keamanan (method DELETE) --}}
                                <form action="{{ route('admin.jurnal.destroy', $jurnal->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jurnal ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-aksi btn-hapus">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    {{-- Tampilan ini akan muncul jika tidak ada data jurnal di database --}}
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 20px;">
                            Belum ada data jurnal yang ditambahkan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Link untuk Pagination, akan muncul jika data lebih dari 10 (sesuai pengaturan di controller) --}}
    <div class="pagination">
       {{ $jurnals->links() }}
    </div>
@endsection