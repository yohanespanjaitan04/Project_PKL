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
            @foreach($jurnals as $j)
            <tr>
                <td>{{ $j['id'] }}</td>
                <td>{{ $j['judul'] }}</td>
                <td>{{ $j['penulis'] }}</td>
                <td>{{ $j['tahun'] }}</td>
                <td>{{ $j['kategori'] }}</td>
                <td>
                    <a href="#" class="btn btn-primary">Lihat</a>
                    <a href="#" class="btn btn-success">Edit</a>
                    <form action="#" method="POST" style="display:inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
