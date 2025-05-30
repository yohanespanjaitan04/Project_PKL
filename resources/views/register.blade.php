@extends('layouts.layout')

@section('content')
<div class="container" style="max-width: 500px; margin: 50px auto; padding: 20px;">
    <div class="card" style="padding: 30px; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
        <h2 style="text-align: center; margin-bottom: 30px; color: #333;">Daftar Akun Baru</h2>

        @if ($errors->any())
            <div style="background-color: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; padding: 10px; border-radius: 4px; margin-bottom: 20px;">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf
            
            <div style="margin-bottom: 20px;">
                <label for="name" style="display: block; margin-bottom: 5px; font-weight: bold;">Nama Lengkap</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required 
                       style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box;">
            </div>

            <div style="margin-bottom: 20px;">
                <label for="email" style="display: block; margin-bottom: 5px; font-weight: bold;">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required 
                       style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box;">
            </div>

            <div style="margin-bottom: 20px;">
                <label for="role" style="display: block; margin-bottom: 5px; font-weight: bold;">Daftar Sebagai</label>
                <select id="role" name="role" required onchange="toggleFields()" 
                        style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box;">
                    <option value="">Pilih Role</option>
                    <option value="mahasiswa" {{ old('role') == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                    <option value="dosen" {{ old('role') == 'dosen' ? 'selected' : '' }}>Dosen</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>

            <!-- Fields for Mahasiswa -->
            <div id="mahasiswa-fields" style="display: none;">
                <div style="margin-bottom: 20px;">
                    <label for="nim" style="display: block; margin-bottom: 5px; font-weight: bold;">NIM</label>
                    <input type="text" id="nim" name="nim" value="{{ old('nim') }}" 
                           style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box;">
                </div>
            </div>

            <!-- Fields for Dosen -->
            <div id="dosen-fields" style="display: none;">
                <div style="margin-bottom: 20px;">
                    <label for="nip" style="display: block; margin-bottom: 5px; font-weight: bold;">NIP</label>
                    <input type="text" id="nip" name="nip" value="{{ old('nip') }}" 
                           style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box;">
                </div>
            </div>

            <!-- Program Studi (for both Mahasiswa and Dosen) -->
            <div id="prodi-field" style="display: none; margin-bottom: 20px;">
                <label for="prodi" style="display: block; margin-bottom: 5px; font-weight: bold;">Program Studi</label>
                <input type="text" id="prodi" name="prodi" value="{{ old('prodi') }}" 
                       style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box;">
            </div>

            <div style="margin-bottom: 20px;">
                <label for="password" style="display: block; margin-bottom: 5px; font-weight: bold;">Password</label>
                <input type="password" id="password" name="password" required 
                       style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box;">
            </div>

            <div style="margin-bottom: 30px;">
                <label for="password_confirmation" style="display: block; margin-bottom: 5px; font-weight: bold;">Konfirmasi Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required 
                       style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box;">
            </div>

            <button type="submit" 
                    style="width: 100%; padding: 12px; background-color: #007bff; color: white; border: none; border-radius: 4px; font-size: 16px; cursor: pointer;">
                Daftar
            </button>
        </form>

        <div style="text-align: center; margin-top: 20px;">
            <p>Sudah punya akun? <a href="{{ route('login') }}" style="color: #007bff; text-decoration: none;">Login di sini</a></p>
        </div>
    </div>
</div>

<script>
function toggleFields() {
    const role = document.getElementById('role').value;
    const mahasiswaFields = document.getElementById('mahasiswa-fields');
    const dosenFields = document.getElementById('dosen-fields');
    const prodiField = document.getElementById('prodi-field');

    // Hide all fields first
    mahasiswaFields.style.display = 'none';
    dosenFields.style.display = 'none';
    prodiField.style.display = 'none';

    // Show relevant fields based on role
    if (role === 'mahasiswa') {
        mahasiswaFields.style.display = 'block';
        prodiField.style.display = 'block';
    } else if (role === 'dosen') {
        dosenFields.style.display = 'block';
        prodiField.style.display = 'block';
    }
}

// Run on page load to show correct fields if there's old input
document.addEventListener('DOMContentLoaded', function() {
    toggleFields();
});
</script>
@endsection