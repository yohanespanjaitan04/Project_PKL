@extends('layouts.layout')

@section('content')

<div style="padding: 24px;">
    <h2>Profil Pengguna</h2> {{-- Mengubah judul agar lebih jelas --}}
    <hr>

    {{-- Pesan sukses atau error (tetap ditampilkan jika ada, meskipun tombol simpan dihapus) --}}
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

    {{-- Form ini hanya untuk tampilan, tidak perlu method/action lagi karena tidak ada tombol submit --}}
    {{-- Kita bisa biarkan sebagai form untuk konsistensi layout, tapi atribut action/method tidak dipakai --}}
    <form> {{-- Hapus action="{{ route('profil.update') }}" method="POST" dan @method('PUT') --}}
        @csrf {{-- Tetap biarkan CSRF token untuk mencegah error Blade parsing, meski tidak disubmit --}}

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: bold;">Nama Lengkap</label>
                {{-- Hanya menampilkan teks, tidak ada input field --}}
                <p style="margin: 0; padding: 8px 0; font-weight: normal; color: #333;">{{ $user->name }}</p>
            </div>
            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: bold;">Peran (Role)</label>
                {{-- Hanya menampilkan teks --}}
                <p style="margin: 0; padding: 8px 0; font-weight: normal; color: #333;">{{ ucfirst($user->role) }}</p>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: bold;">Email</label>
                {{-- Hanya menampilkan teks --}}
                <p style="margin: 0; padding: 8px 0; font-weight: normal; color: #333;">{{ $user->email }}</p>
            </div>
            <div>
                {{-- Logika dinamis untuk NIM / NIP / No. Telepon (hanya tampilan) --}}
                @if($user->role === 'mahasiswa')
                    <label style="display: block; margin-bottom: 5px; font-weight: bold;">NIM</label>
                    <p style="margin: 0; padding: 8px 0; font-weight: normal; color: #333;">{{ $user->nim ?? '-' }}</p>
                @elseif($user->role === 'dosen')
                    <label style="display: block; margin-bottom: 5px; font-weight: bold;">NIP</label>
                    <p style="margin: 0; padding: 8px 0; font-weight: normal; color: #333;">{{ $user->nip ?? '-' }}</p>
                @else {{-- Untuk admin atau role lain --}}
                    <label style="display: block; margin-bottom: 5px; font-weight: bold;">No. Telepon</label>
                    <p style="margin: 0; padding: 8px 0; font-weight: normal; color: #333;">{{ $user->telepon ?? '-' }}</p>
                @endif
            </div>
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 5px; font-weight: bold;">Departemen</label>
            <p style="margin: 0; padding: 8px 0; font-weight: normal; color: #333;">{{ $user->department ?? '-' }}</p>
        </div>

        {{-- Menghapus tombol "Simpan Perubahan" --}}
        {{-- <div style="text-align: right; margin-top: 20px;">
            <button type="submit" style="background: #007bff; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-size: 16px;">
                Simpan Perubahan
            </button>
        </div> --}}
    </form>
</div>

@endsection