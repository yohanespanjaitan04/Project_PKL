{{-- Menggunakan layout admin yang sudah kita buat --}}
@extends('layouts.admin')

{{-- Mengisi judul halaman --}}
@section('title', 'User Manajemen')

{{-- Mengisi bagian konten utama --}}
@section('content')
    <div class="main-content">
        <div class="header">
            <h1>Daftar User</h1>
            <a href="{{ route('admin.users.create')}}" class="add-user-btn">
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
                                            data-update-url="{{ route('admin.users.update', $user->id) }}">
                                        Edit
                                    </button>
                                    {{-- TOMBOL HAPUS (WAJIB PAKAI FORM) - DIMODIFIKASI --}}
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" data-user-name="{{ $user->name }}">
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

        {{-- Menggunakan pagination bawaan Laravel --}}
        <div class="pagination">
            {{ $users->links() }}
        </div>

        {{-- Mengisi bagian modal --}}
        @section('modals')
            {{-- Modal untuk Edit User --}}
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

    {{-- Mengisi bagian script --}}
    @section('scripts')
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