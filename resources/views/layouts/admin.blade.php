<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Manajemen - UPT Perpus</title>
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

        .add-user-btn {
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

        .add-user-btn:hover {
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

        .user-number {
            font-weight: 600;
            color: #1f2937;
            font-size: 16px;
        }

        .user-name {
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 4px;
        }

        .user-email {
            color: #6b7280;
            font-size: 13px;
        }

        .role-badge {
            background: #f3f4f6;
            color: #374151;
            padding: 4px 12px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 500;
        }

        .department {
            color: #374151;
            font-weight: 500;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
        }

        .action-btn {
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .btn-view {
            background: #3b82f6;
            color: white;
        }

        .btn-view:hover {
            background: #2563eb;
        }

        .btn-edit {
            background: #10b981;
            color: white;
        }

        .btn-edit:hover {
            background: #059669;
        }

        .btn-delete {
            background: #ef4444;
            color: white;
        }

        .btn-delete:hover {
            background: #dc2626;
        }

        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            margin-top: 20px;
        }

        .pagination-btn {
            width: 32px;
            height: 32px;
            border: 1px solid #d1d5db;
            background: white;
            color: #374151;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.2s ease;
        }

        .pagination-btn:hover {
            background: #f3f4f6;
            border-color: #9ca3af;
        }

        .pagination-btn.active {
            background: #3b82f6;
            color: white;
            border-color: #3b82f6;
        }

        .pagination-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

            .main-content {
                margin-left: 0;
                padding: 20px;
            }

            .header {
                flex-direction: column;
                gap: 15px;
                align-items: stretch;
            }

            .table-container {
                overflow-x: auto;
            }

            .table {
                min-width: 700px;
            }
        }
        /* Styling untuk kontainer tombol agar sejajar */
        .aksi-buttons {
            display: flex; /* Mengaktifkan Flexbox */
            align-items: center; /* Membuat semua item sejajar secara vertikal di tengah */
            gap: 6px; /* Memberi jarak antar tombol */
        }

        /* Menghilangkan margin default dari form di dalam flex container */
        .aksi-buttons form {
            margin: 0;
        }

        /* Style dasar untuk SEMUA tombol aksi (Detail, Edit, Hapus) */
        .btn-aksi {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 5px; /* Membuat sudut tombol sedikit melengkung */
            text-decoration: none; /* Menghilangkan garis bawah pada link */
            color: white; /* Warna teks putih */
            font-size: 13px;
            font-weight: 500;
            border: none; /* Menghilangkan border default pada tombol 'Hapus' */
            cursor: pointer;
            text-align: center;
            transition: all 0.2s ease-in-out; /* Animasi halus saat di-hover */
        }

        /* Warna spesifik untuk setiap tombol */
        .btn-edit   { background-color: #f39c12; } /* Oranye */
        .btn-hapus  { background-color: #e74c3c; } /* Merah */

        /* Efek hover untuk setiap tombol (sedikit lebih gelap) */
        .btn-aksi:hover {
            transform: translateY(-1px); /* Sedikit terangkat saat di-hover */
            box-shadow: 0 2px 5px rgba(0,0,0,0.15);
        }

        .btn-edit:hover   { background-color: #d35400; }
        .btn-hapus:hover  { background-color: #c0392b; }
        /* CSS untuk Modal Konfirmasi Hapus */
        .fixed { position: fixed; }
        .inset-0 { top: 0; right: 0; bottom: 0; left: 0; }
        .bg-gray-600 { background-color: #4a5568; } /* Ganti dengan warna yang sesuai jika perlu */
        .bg-opacity-50 { background-color: rgba(74, 85, 104, 0.5); }
        .overflow-y-auto { overflow-y: auto; }
        .h-full { height: 100%; }
        .w-full { width: 100%; }
        .flex { display: flex; }
        .items-center { align-items: center; }
        .justify-center { justify-content: center; }

        .relative { position: relative; }
        .mx-auto { margin-left: auto; margin-right: auto; }
        .p-5 { padding: 1.25rem; }
        .border { border-width: 1px; }
        .max-w-md { max-width: 28rem; }
        .shadow-lg { box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); }
        .rounded-md { border-radius: 0.375rem; }
        .bg-white { background-color: #ffffff; }

        .mt-3 { margin-top: 0.75rem; }
        .text-center { text-align: center; }
        .h-12 { height: 3rem; }
        .w-12 { width: 3rem; }
        .rounded-full { border-radius: 9999px; }
        .bg-red-100 { background-color: #fee2e2; }
        .text-red-600 { color: #dc2626; }

        .text-lg { font-size: 1.125rem; }
        .leading-6 { line-height: 1.5rem; }
        .font-medium { font-weight: 500; }
        .text-gray-900 { color: #111827; }
        .mt-4 { margin-top: 1rem; }

        .mt-2 { margin-top: 0.5rem; }
        .px-7 { padding-left: 1.75rem; padding-right: 1.75rem; }
        .py-3 { padding-top: 0.75rem; padding-bottom: 0.75rem; }
        .text-sm { font-size: 0.875rem; }
        .text-gray-500 { color: #6b7280; }
        .font-bold { font-weight: 700; }

        .px-4 { padding-left: 1rem; padding-right: 1rem; }
        .py-2 { padding-top: 0.5rem; padding-bottom: 0.5rem; }
        .gap-4 { gap: 1rem; }
        .bg-gray-200 { background-color: #e5e7eb; }
        .text-gray-800 { color: #1f2937; }
        .hover\:bg-gray-300:hover { background-color: #d1d5db; }
        .bg-red-600 { background-color: #dc2626; }
        .hover\:bg-red-700:hover { background-color: #b91c1c; }
        .text-white { color: #ffffff; }
        .focus\:outline-none:focus { outline: 2px solid transparent; outline-offset: 2px; }

        /* Menyesuaikan Tombol Hapus Asli */
        .btn-hapus-modal {
            background-color: #e74c3c; /* Merah */
        }
        .btn-hapus-modal:hover {
            background-color: #c0392b;
        }
        /* [BARU] CSS Tambahan untuk Form di Modal Edit */
        .form-group {
            margin-bottom: 1rem;
            text-align: left;
        }
        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #374151;
            font-size: 14px;
        }
        .form-input, .form-select {
            width: 100%;
            padding: 0.65rem 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 14px;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .form-input:focus, .form-select:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.3);
        }
        .bg-blue-100 { background-color: #dbeafe; }
        .text-blue-600 { color: #2563eb; }
        .bg-blue-600 { background-color: #2563eb; }
        .hover\:bg-blue-700:hover { background-color: #1d4ed8; }
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
                    <div style="font-weight: 600;">{{ Auth::user()->name ?? 'nama' }}</div>
                    <div style="font-size: 12px; opacity: 0.8;">{{ Auth::user()->role ?? 'role' }}</div>
                </div>
            </div>
        </div>

        <nav class="nav-menu">
            {{-- Link ke Dashboard --}}
            <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <div class="nav-icon">📊</div>
                Dashboard
            </a>

            {{-- Link ke User Manajemen --}}
            <a href="{{ route('admin.users.index') }}" class="nav-item {{ request()->routeIs('admin.UserManajemen.*') ? 'active' : '' }}">
                <div class="nav-icon">👥</div>
                User Manajemen
            </a>
            
            {{-- Link ke Daftar Jurnal (Admin) --}}
            <a href="{{ route('admin.jurnal.index') }}" class="nav-item {{ request()->routeIs('admin.jurnal.*') ? 'active' : '' }}">
                <div class="nav-icon">📚</div>
                Tambah Jurnal
            </a>
            
            {{-- Link ke Profil --}}
            <a href="{{ route('profil') }}" class="nav-item {{ request()->routeIs('profil*') ? 'active' : '' }}">
                <div class="nav-icon">👤</div>
                Profil
            </a>

            {{-- Form untuk Logout --}}
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a href="{{ route('logout') }}" 
                class="nav-item" 
                onclick="event.preventDefault(); this.closest('form').submit();">
                <div class="nav-icon" style="transform: rotate(180deg);">↪️</div>
                    Logout
                </a>
            </form>
        </nav>
    </div>
    {{-- Wrapper untuk Konten Utama --}}
    <div class="main-content">
        {{-- Di sinilah konten spesifik dari setiap halaman akan ditampilkan --}}
        @yield('content')
    </div>

    {{-- Placeholder untuk modal (jika ada) --}}
    @yield('modals')

    {{-- Placeholder untuk script (jika ada) --}}
    @yield('scripts')

</body>
</html>