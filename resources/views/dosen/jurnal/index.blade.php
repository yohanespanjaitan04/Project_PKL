@extends('layouts.layout')

@section('content')
<div class="page-title">Daftar Jurnal</div>


<div class="search-container">
    <input type="text" placeholder="Cari jurnal...">
    <button class="search-button">Cari</button>
</div>

<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>NO</th><th>Judul</th><th>Penulis</th><th>Tahun</th><th>Kategori</th><th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($jurnals as $j)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $j->judul }}</td>
                <td>{{ $j->pengarang }}</td>
                <td>{{ $j->tahun_publikasi }}</td>
                <td>{{ $j->tipe_referensi }}</td>
                <td>
                    <a href="{{ route('jurnal.show', $j->id) }}" class="btn btn-primary">Lihat</a>
                    <a href="{{ route('jurnal.edit', $j->id) }}" class="btn btn-success">Edit</a>
                    <form action="{{ route('jurnal.destroy', $j->id) }}" method="POST" style="display:inline" 
                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus jurnal ini?')">
                        @csrf 
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                    @if($j->file_path)
                        <a href="{{ route('jurnal.download', $j->id) }}" class="btn btn-info">Download</a>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">Tidak ada data jurnal</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    <!-- Pagination Links -->
    <div class="pagination-container">
        {{ $jurnals->links() }}
    </div>
</div>

<style>
.alert {
    padding: 15px;
    margin-bottom: 20px;
    border: 1px solid transparent;
    border-radius: 4px;
}

.alert-success {
    color: #3c763d;
    background-color: #dff0d8;
    border-color: #d6e9c6;
}

.alert-danger {
    color: #a94442;
    background-color: #f2dede;
    border-color: #ebccd1;
}

.btn {
    padding: 5px 10px;
    margin: 2px;
    text-decoration: none;
    border: none;
    border-radius: 3px;
    cursor: pointer;
    font-size: 12px;
}

.btn-primary { background-color: #007bff; color: white; }
.btn-success { background-color: #28a745; color: white; }
.btn-danger { background-color: #dc3545; color: white; }
.btn-info { background-color: #17a2b8; color: white; }

.btn:hover {
    opacity: 0.8;
}
</style>
@endsection