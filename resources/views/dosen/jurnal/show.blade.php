@extends('layouts.layout')

@section('content')
<div class="page-title">Detail Jurnal</div>

<div class="form-container">
    <div class="form-group">
        <label><strong>Tipe Referensi:</strong></label>
        <p>{{ $jurnal->tipe_referensi }}</p>
    </div>

    <div class="form-group">
        <label><strong>Departemen:</strong></label>
        <p>{{ $jurnal->departemen }}</p>
    </div>

    <div class="form-group">
        <label><strong>Program Studi:</strong></label>
        <p>{{ $jurnal->prodi }}</p>
    </div>

    <div class="form-group">
        <label><strong>Semester:</strong></label>
        <p>{{ $jurnal->semester }}</p>
    </div>

    <div class="form-group">
        <label><strong>Mata Kuliah:</strong></label>
        <p>{{ $jurnal->mata_kuliah }}</p>
    </div>

    <div class="form-group">
        <label><strong>Judul:</strong></label>
        <p>{{ $jurnal->judul }}</p>
    </div>

    <div class="form-group">
        <label><strong>Pengarang:</strong></label>
        <p>{{ $jurnal->pengarang }}</p>
    </div>

    <div class="form-group">
        <label><strong>Tahun Publikasi:</strong></label>
        <p>{{ $jurnal->tahun_publikasi }}</p>
    </div>

    <div class="form-group">
        <label><strong>Issue:</strong></label>
        <p>{{ $jurnal->issue ?? '-' }}</p>
    </div>

    <div class="form-group">
        <label><strong>Jumlah Halaman:</strong></label>
        <p>{{ $jurnal->banyak_halaman ?? '-' }}</p>
    </div>

    <div class="form-group">
        <label><strong>Abstrak:</strong></label>
        <p>{{ $jurnal->abstrak }}</p>
    </div>

    <div class="form-group">
        <label><strong>DOI/URL:</strong></label>
        <p>{{ $jurnal->doi ?? '-' }}</p>
    </div>

    @if($jurnal->file_path)
    <div class="form-group">
        <label><strong>File PDF:</strong></label>
        <p>
            <a href="{{ route('jurnal.download', $jurnal->id) }}" class="btn btn-info">
                Download PDF
            </a>
        </p>
    </div>
    @endif

    <div class="form-group">
        <label><strong>Dibuat pada:</strong></label>
        <p>{{ $jurnal->created_at->format('d-m-Y H:i') }}</p>
    </div>

    <div class="form-group">
        <label><strong>Terakhir diupdate:</strong></label>
        <p>{{ $jurnal->updated_at->format('d-m-Y H:i') }}</p>
    </div>

    <div class="form-actions">
        <a href="{{ route('home') }}" class="btn btn-secondary">Kembali</a>
        <a href="{{ route('jurnal.edit', $jurnal->id) }}" class="btn btn-success">Edit</a>
        <form action="{{ route('jurnal.destroy', $jurnal->id) }}" method="POST" style="display:inline" 
              onsubmit="return confirm('Apakah Anda yakin ingin menghapus jurnal ini?')">
            @csrf 
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Hapus</button>
        </form>
    </div>
</div>

<style>
.form-container {
    max-width: 800px;
    margin: 0 auto;
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.form-group {
    margin-bottom: 15px;
    padding-bottom: 10px;
    border-bottom: 1px solid #eee;
}

.form-group:last-child {
    border-bottom: none;
}

.form-group label {
    display: block;
    font-weight: bold;
    color: #333;
    margin-bottom: 5px;
}

.form-group p {
    margin: 0;
    color: #666;
    line-height: 1.5;
}

.form-actions {
    margin-top: 20px;
    text-align: center;
}

.btn {
    padding: 8px 16px;
    margin: 0 5px;
    text-decoration: none;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
}

.btn-secondary { background-color: #6c757d; color: white; }
.btn-success { background-color: #28a745; color: white; }
.btn-danger { background-color: #dc3545; color: white; }
.btn-info { background-color: #17a2b8; color: white; }

.btn:hover {
    opacity: 0.8;
}
</style>
@endsection