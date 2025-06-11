<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Jurnal - UPT Perpus</title>
    {{-- Menggunakan style yang sama persis dengan halaman User Manajemen untuk konsistensi UI --}}
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 250px;
            background: linear-gradient(135deg, #4f46e5, #3b82f6);
            color: white;
            min-height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1000;
        }

        .logo-section {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .logo {
            width: 50px;
            height: 50px;
            background: white;
            border-radius: 50%;
            margin: 0 auto 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: #4f46e5;
            font-size: 18px;
        }

        .university-name {
            font-size: 12px;
            margin-bottom: 5px;
            opacity: 0.9;
        }

        .library-name {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
        }

        .user-avatar {
            width: 24px;
            height: 24px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .nav-menu {
            padding: 20px 0;
        }

        .nav-item {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
            cursor: pointer;
        }

        .nav-item:hover {
            background: rgba(255, 255, 255, 0.1);
            border-left-color: white;
        }

        .nav-item.active {
            background: rgba(255, 255, 255, 0.15);
            border-left-color: white;
        }

        .nav-icon {
            width: 20px;
            height: 20px;
            margin-right: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .main-content {
            margin-left: 250px;
            flex: 1;
            padding: 30px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .header h1 {
            font-size: 28px;
            color: #1f2937;
            font-weight: 600;
        }

        .add-item-btn {
            background: #3b82f6;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: background 0.2s ease;
            text-decoration: none;
        }

        .add-item-btn:hover {
            background: #2563eb;
        }

        .table-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            border: 1px solid #e5e7eb;
            overflow: hidden;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th {
            background: #f9fafb;
            padding: 16px;
            text-align: left;
            font-weight: 600;
            color: #374151;
            border-bottom: 1px solid #e5e7eb;
            font-size: 14px;
        }

        .table td {
            padding: 16px;
            border-bottom: 1px solid #f3f4f6;
            vertical-align: top;
        }

        .table tr:last-child td {
            border-bottom: none;
        }

        .table tr:hover {
            background: #f9fafb;
        }

        .item-title {
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 4px;
        }

        .item-author {
            color: #6b7280;
            font-size: 13px;
        }

        .item-category {
            background: #f3f4f6;
            color: #374151;
            padding: 4px 12px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 500;
            display: inline-block;
        }

        .aksi-buttons {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .aksi-buttons form {
            margin: 0;
        }

        .btn-aksi {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 5px;
            text-decoration: none;
            color: white;
            font-size: 13px;
            font-weight: 500;
            border: none;
            cursor: pointer;
            text-align: center;
            transition: all 0.2s ease-in-out;
        }

        .btn-edit { background-color: #f39c12; }
        .btn-hapus { background-color: #e74c3c; }

        .btn-aksi:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 5px rgba(0,0,0,0.15);
        }

        .btn-edit:hover { background-color: #d35400; }
        .btn-hapus:hover { background-color: #c0392b; }

        .pagination-container {
            margin-top: 20px;
        }

    </style>
</head>
<body>
    <div class="sidebar">
        <div class="logo-section">
            <div class="logo">UD</div>
            <div class="university-name">UNIVERSITAS DIPONEGORO</div>
            <div class="library-name">UPT PERPUS</div>
            <div class="user-info">
                <div class="user-avatar">👤</div>
                <div>
                    {{-- Menampilkan data user yang sedang login --}}
                    <div style="font-weight: 600;">{{ Auth::user()->name ?? 'Nama Dosen' }}</div>
                    <div style="font-size: 12px; opacity: 0.8;">{{ Auth::user()->role ?? 'Dosen' }}</div>
                </div>
            </div>
        </div>

        <nav class="nav-menu">
            <a href="#" class="nav-item">
                <div class="nav-icon">📊</div>
                Dashboard
            </a>
            {{-- Link ke daftar jurnal, diberi kelas 'active' jika route saat ini adalah 'jurnal.index' --}}
            <a href="{{ route('jurnal.index') }}" class="nav-item {{ request()->routeIs('jurnal.index') ? 'active' : '' }}">
                <div class="nav-icon">📚</div>
                Daftar Jurnal
            </a>
            {{-- Link ke form tambah jurnal, diberi kelas 'active' jika route saat ini adalah 'jurnal.create' --}}
            <a href="{{ route('jurnal.create') }}" class="nav-item {{ request()->routeIs('jurnal.create') ? 'active' : '' }}">
                <div class="nav-icon">➕</div>
                Tambah Jurnal
            </a>
            <a href="#" class="nav-item">
                <div class="nav-icon">👤</div>
                Profil
            </a>
        </nav>
    </div>

    <div class="main-content">
        <div class="header">
            <h1>Daftar Jurnal</h1>
            <a href="{{ route('jurnal.create') }}" class="add-item-btn">
                <span>➕</span>
                Tambah Jurnal
            </a>
        </div>

        {{-- Menampilkan notifikasi sukses --}}
        @if (session('success'))
            <div style="background-color: #d4edda; color: #155724; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                {{ session('success') }}
            </div>
        @endif

        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Penulis</th>
                        <th>Tahun</th>
                        <th>Kategori</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($jurnals as $jurnal)
                        <tr>
                            <td>
                                <div class="item-title">{{ $jurnal->judul }}</div>
                                <div class="item-author">{{ $jurnal->pengarang }}</div>
                            </td>
                            <td>{{ $jurnal->penulis ?? $jurnal->pengarang }}</td>
                            <td>{{ $jurnal->tahun_publikasi }}</td>
                            <td>
                                <span class="item-category">{{ $jurnal->tipe_referensi }}</span>
                            </td>
                            <td>
                                <div class="aksi-buttons">
                                    {{-- Tombol Edit mengarah ke route 'jurnal.edit' dengan parameter id jurnal --}}
                                    <a href="{{ route('jurnal.edit', $jurnal->id) }}" class="btn-aksi btn-edit">Edit</a>
                                    
                                    {{-- Tombol Hapus menggunakan form dengan method DELETE --}}
                                    <form action="{{ route('jurnal.destroy', $jurnal->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-aksi btn-hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus jurnal ini?')">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        {{-- Pesan yang ditampilkan jika tidak ada data jurnal --}}
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 20px;">
                                Tidak ada data jurnal. Silakan tambahkan jurnal baru.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Menampilkan link pagination --}}
        <div class="pagination-container">
            {{ $jurnals->links() }}
        </div>
    </div>
</body>
</html>
