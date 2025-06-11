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
                    <div style="font-weight: 600;">Adi</div>
                    <div style="font-size: 12px; opacity: 0.8;">Admin</div>
                </div>
            </div>
        </div>

        <nav class="nav-menu">
            <div class="nav-item" onclick="showDashboard()">
                <div class="nav-icon">📊</div>
                Dashboard
            </div>
            <div class="nav-item active" onclick="showUserManagement()">
                <div class="nav-icon">👥</div>
                User Manajemen
            </div>
            <div class="nav-item active" onclick="showTambahJurnal()">
                <div class="nav-icon">👥</div>
                Tambah Jurnal
            </div>
            <div class="nav-item" onclick="showProfile()">
                <div class="nav-icon">👤</div>
                Profil
            </div>
        </nav>
    </div>

    <div class="main-content">
        <div class="header">
            <h1>Daftar User</h1>
            <a href="{{ route('admin.UserManajemen.create')}}" class="add-user-btn">
                <span>👤</span>
                Tambah User Baru
            </a>
        </div>

        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>User</th>
                        <th>Role</th>
                        <th>Department</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <<tbody>
                    {{-- Gunakan @forelse untuk handle jika data kosong --}}
                    @forelse ($users as $key => $user)
                        <tr>
                            {{-- Penomoran yang benar untuk pagination --}}
                            <td>{{ $users->firstItem() + $key }}</td>
                            <td>
                                <strong>{{ $user->name }}</strong><br>
                                <small>{{ $user->email }}</small>
                            </td>
                            <td>{{ $user->role }}</td>
                            <td>{{ $user->department }}</td>
                            <td class="kolom-aksi">
                                <div class="aksi-buttons">
                                    {{-- TOMBOL EDIT (MEMBUKA MODAL) --}}
                                    <button type="button" 
                                            class="btn-aksi btn-edit js-edit-btn"
                                            data-id="{{ $user->id }}"
                                            data-name="{{ $user->name }}"
                                            data-email="{{ $user->email }}"
                                            data-role="{{ $user->role }}"
                                            data-department="{{ $user->department }}"
                                            data-update-url="{{ route('admin.UserManajemen.update', $user->id) }}">
                                        Edit
                                    </button>
                                    {{-- TOMBOL HAPUS (WAJIB PAKAI FORM) - DIMODIFIKASI --}}
                                    <form action="{{ route('admin.UserManajemen.destroy', $user->id) }}" method="POST" data-user-name="{{ $user->name }}">
                                        @csrf
                                        @method('DELETE')
                                        {{-- Tombol ini sekarang memicu modal, bukan submit langsung --}}
                                        <button type="button" class="btn-aksi btn-hapus btn-hapus-modal">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        {{-- Tampilan jika tidak ada data user sama sekali --}}
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 20px;">
                                Tidak ada data user.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination">
            <button class="pagination-btn" disabled>‹</button>
            <button class="pagination-btn active">1</button>
            <button class="pagination-btn">2</button>
            <button class="pagination-btn">3</button>
            <button class="pagination-btn">›</button>
        </div>
        <div id="editModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full flex items-center justify-center" style="display: none; z-index: 2000;">
        <div class="relative mx-auto p-5 border w-full max-w-md shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-blue-100">
                     <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                </div>
                <h3 class="text-lg leading-6 font-medium text-gray-900 text-center mt-4">Edit User</h3>
                
                <form id="editUserForm" method="POST" action="" class="mt-4 px-2">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="editName" class="form-label">Nama</label>
                        <input type="text" id="editName" name="name" class="form-input" required>
                    </div>

                    <div class="form-group">
                        <label for="editEmail" class="form-label">Email</label>
                        <input type="email" id="editEmail" name="email" class="form-input" required>
                    </div>

                    <div class="form-group">
                        <label for="editRole" class="form-label">Role</label>
                        <select id="editRole" name="role" class="form-select" required>
                            <option value="Dosen">Dosen</option>
                            <option value="Mahasiswa">Mahasiswa</option>
                            <option value="Admin">Admin</option>    
                            {{-- Tambahkan role lain jika ada --}}
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="editDepartment" class="form-label">Department</label>
                        <input type="text" id="editDepartment" name="department" class="form-input" required>
                    </div>

                    <div class="form-group">
                        <label for="editPassword" class="form-label">Password (Opsional)</label>
                        <input type="password" id="editPassword" name="password" class="form-input" placeholder="Isi hanya jika ingin mengubah password">
                    </div>

                    <div class="items-center px-4 py-3 flex justify-center gap-4">
                        <button id="cancelEditModalBtn" type="button" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 focus:outline-none">
                            Batal
                        </button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {

        // --- Logika untuk Modal Edit User ---
        const editModal = document.getElementById('editModal');
        const cancelEditBtn = document.getElementById('cancelEditModalBtn');
        const editUserForm = document.getElementById('editUserForm');
        const editButtons = document.querySelectorAll('.js-edit-btn');
        
        // Fungsi untuk membuka modal edit
        const openEditModal = (button) => {
            const updateUrl = button.dataset.updateUrl;
            
            // Set action form
            editUserForm.action = updateUrl;
            
            // Isi field form dengan data dari tombol
            document.getElementById('editName').value = button.dataset.name;
            document.getElementById('editEmail').value = button.dataset.email;
            document.getElementById('editRole').value = button.dataset.role;
            document.getElementById('editDepartment').value = button.dataset.department;
            document.getElementById('editPassword').value = ''; // Kosongkan password
            
            editModal.style.display = 'flex';
        };

        // Fungsi untuk menutup modal edit
        const closeEditModal = () => {
            editModal.style.display = 'none';
        };

        // Tambahkan event listener untuk semua tombol "Edit"
        editButtons.forEach(button => {
            button.addEventListener('click', () => openEditModal(button));
        });

        // Event listener untuk tombol "Batal" di modal edit
        cancelEditBtn.addEventListener('click', closeEditModal);

        // Tutup modal jika user mengklik di luar area konten modal
        editModal.addEventListener('click', (event) => {
            if (event.target === editModal) {
                closeEditModal();
            }
        });


        // --- Logika untuk Modal Konfirmasi Hapus ---
        const deleteModal = document.getElementById('deleteModal');
        const cancelDeleteBtn = document.getElementById('cancelModalBtn');
        const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
        const modalUserName = document.getElementById('modalUserName');
        const deleteButtons = document.querySelectorAll('.btn-hapus-modal');

        let formToSubmit = null;

        const openDeleteModal = (form) => {
            formToSubmit = form;
            const userName = form.dataset.userName;
            modalUserName.textContent = userName;
            deleteModal.style.display = 'flex';
        };

        const closeDeleteModal = () => {
            formToSubmit = null;
            deleteModal.style.display = 'none';
        };

        deleteButtons.forEach(button => {
            button.addEventListener('click', (event) => {
                const form = event.target.closest('form');
                openDeleteModal(form);
            });
        });

        cancelDeleteBtn.addEventListener('click', closeDeleteModal);

        confirmDeleteBtn.addEventListener('click', () => {
            if (formToSubmit) {
                formToSubmit.submit();
            }
        });
        
        deleteModal.addEventListener('click', (event) => {
            if (event.target === deleteModal) {
                closeDeleteModal();
            }
        });


        // --- Logika Umum (misal: tombol Escape) ---
        window.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                if (deleteModal.style.display === 'flex') {
                    closeDeleteModal();
                }
                if (editModal.style.display === 'flex') {
                    closeEditModal();
                }
            }
        });
    });
    </script>
    
    <div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full flex items-center justify-center" style="display: none; z-index: 2000;">
        <div class="relative mx-auto p-5 border w-full max-w-md shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                    <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <h3 class="text-lg leading-6 font-medium text-gray-900 mt-4">Konfirmasi Hapus User</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500">
                        Apakah Anda yakin ingin menghapus user <strong id="modalUserName" class="font-bold"></strong>? Tindakan ini tidak dapat dibatalkan.
                    </p>
                </div>
                <div class="items-center px-4 py-3 flex justify-center gap-4">
                    <button id="cancelModalBtn" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        Batal
                    </button>
                    <button id="confirmDeleteBtn" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        Ya, Hapus
                    </button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>