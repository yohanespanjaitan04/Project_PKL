@extends('layout')

@section('content')
<div class="page-title">Profil</div>

<div class="form-container">
    <form action="{{ route('profil.update') }}" method="POST">
        @csrf @method('PUT')
        <div class="form-group">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" name="nama" value="{{ $user['nama'] }}" class="form-control" required>
        </div>
        <div class="form-row">
            <div class="form-column">
                <label class="form-label">Email</label>
                <input type="email" name="email" value="{{ $user['email'] }}" class="form-control" required>
            </div>
            <div class="form-column">
                <label class="form-label">No. Telepon</label>
                <input type="tel" name="telepon" value="{{ $user['telepon'] }}" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <label class="form-label">Departemen</label>
            <select name="departemen" class="form-control" required>
                <option value="teknik"   {{ $user['departemen']=='teknik'   ? 'selected':'' }}>Teknik</option>
                <option value="ekonomi"   {{ $user['departemen']=='ekonomi'   ? 'selected':'' }}>Ekonomi</option>
                <option value="kesehatan" {{ $user['departemen']=='kesehatan' ? 'selected':'' }}>Kesehatan</option>
                <option value="hukum"     {{ $user['departemen']=='hukum'     ? 'selected':'' }}>Hukum</option>
            </select>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection
