@extends('layouts.admin')

@section('title', 'Manajemen Jurnal')

{{-- ======================================================================= --}}
{{-- KONTEN UTAMA (TABEL) --}}
{{-- ======================================================================= --}}
@section('content')
    <div class="header">
        <h1>Daftar Jurnal</h1>
        <a href="{{ route('admin.jurnal.create') }}" class="add-user-btn" style="gap: 5px;">
            <span style="font-size: 24px; line-height: 1;">+</span>
            Tambah Jurnal Baru
        </a>
    </div>

    @if(session('success'))
        <div class="alert-success" style="background-color: #d1e7dd; color: #0f5132; border-color: #badbcc; padding: 1rem; border-radius: 8px; margin-bottom: 20px; border: 1px solid transparent;">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>NO</th>
                    <th>Judul</th>
                    <th>Pengarang</th>
                    <th>Tahun</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($jurnals as $key => $jurnal)
                    <tr>
                        <td>{{ $jurnals->firstItem() + $key }}</td>
                        <td style="max-width: 300px;"><strong title="{{ $jurnal->judul }}">{{ Str::limit($jurnal->judul, 50) }}</strong></td>
                        <td>{{ $jurnal->pengarang }}</td>
                        <td>{{ $jurnal->tahun_publikasi }}</td>
                        <td>
                            <div class="aksi-buttons">
                                {{-- Tombol untuk membuka modal EDIT --}}
                                <button type="button" class="btn-aksi btn-edit-modal" style="background-color: #10b981;"
                                    data-jurnal='{!! $jurnal->toJson() !!}'
                                    data-update-url="{{ route('admin.jurnal.update', $jurnal->id) }}">
                                    Edit
                                </button>
                                
                                {{-- [MODIFIKASI] Form Hapus yang disembunyikan --}}
                                <form id="delete-form-{{ $jurnal->id }}" action="{{ route('admin.jurnal.destroy', $jurnal->id) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                {{-- [MODIFIKASI] Tombol untuk membuka modal HAPUS --}}
                                <button type="button" class="btn-aksi btn-hapus btn-delete-modal" data-form-id="delete-form-{{ $jurnal->id }}">
                                    Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 20px;">Belum ada data jurnal yang ditambahkan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination">{{ $jurnals->links() }}</div>
@endsection

{{-- ======================================================================= --}}
{{-- SEMUA MODAL DITEMPATKAN DI SINI --}}
{{-- ======================================================================= --}}
@section('modals')
    <div id="editJurnalModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full flex items-center justify-center" style="display: none; z-index: 9999;">
        <div class="relative mx-auto p-5 border w-full max-w-md shadow-lg rounded-md bg-white">
            <div class="flex justify-between items-center pb-3 border-b">
                <h3 class="text-xl font-medium text-gray-900">Edit Referensi</h3>
                <button id="closeEditModalBtn" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16"><path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/></svg>
                </button>
            </div>
            <form id="editJurnalForm" method="POST" action="">
                @csrf
                @method('PUT')
                <div class="py-4" style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
                    <div class="form-group"><label for="edit_tipe_referensi" class="form-label">Tipe Referensi</label><select name="tipe_referensi" id="edit_tipe_referensi" class="form-select" required><option value="" disabled>-- Pilih Tipe --</option><option value="Jurnal">Jurnal</option><option value="Artikel">Artikel</option><option value="Buku">Buku</option></select></div>
                    <div class="form-group"><label for="edit_pengarang" class="form-label">Pengarang</label><input type="text" name="pengarang" id="edit_pengarang" class="form-input" required></div>
                    <div class="form-group" style="grid-column: span 2;"><label for="edit_judul" class="form-label">Judul</label><input type="text" name="judul" id="edit_judul" class="form-input" required></div>
                    <div class="form-group"><label for="edit_tahun_publikasi" class="form-label">Tahun Publikasi</label><input type="number" name="tahun_publikasi" id="edit_tahun_publikasi" class="form-input" placeholder="Contoh: 2024" required></div>
                    <div class="form-group"><label for="edit_doi" class="form-label">DOI / URL (Opsional)</label><input type="url" name="doi" id="edit_doi" class="form-input" placeholder="https://example.com/jurnal.pdf"></div>
                    <div class="form-group"><label for="edit_issue" class="form-label">Issue (Opsional)</label><input type="text" name="issue" id="edit_issue" class="form-input"></div>
                    <div class="form-group"><label for="edit_banyak_halaman" class="form-label">Banyak Halaman (Opsional)</label><input type="number" name="banyak_halaman" id="edit_banyak_halaman" class="form-input"></div>
                    <div class="form-group" style="grid-column: span 2;"><label for="edit_abstrak" class="form-label">Abstrak / Deskripsi</label><textarea name="abstrak" id="edit_abstrak" rows="4" class="form-input" required></textarea></div>
                </div>
                <div class="flex items-center justify-end p-4 border-t gap-4">
                    <button id="cancelEditBtn" type="button" class="btn-aksi" style="background-color: #6c757d;">Batal</button>
                    <button type="submit" class="add-user-btn">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <div id="deleteConfirmModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full flex items-center justify-center" style="display: none; z-index: 10000;">
        <div class="relative mx-auto p-5 border w-full max-w-md shadow-lg rounded-md bg-white">
            <div class="text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                    <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                <h3 class="text-lg leading-6 font-medium text-gray-900 mt-3">Hapus Data Jurnal</h3>
                <div class="mt-2 px-7 py-3"><p class="text-sm text-gray-500">Apakah Anda benar-benar yakin ingin menghapus data ini? Proses ini tidak dapat dibatalkan.</p></div>
                <div class="items-center px-4 py-3 gap-4 flex justify-center">
                    <button id="cancelDeleteBtn" type="button" class="btn-aksi px-4 py-2 rounded-md w-24 text-center" style="background-color: #e5e7eb; color: #1f2937;">Batal</button>
                    <button id="confirmDeleteBtn" type="button" class="btn-aksi btn-hapus px-4 py-2 rounded-md w-24 text-center">Ya, Hapus</button>
                </div>
            </div>
        </div>
    </div>
@endsection


{{-- ======================================================================= --}}
{{-- SEMUA JAVASCRIPT DITEMPATKAN DI SINI --}}
{{-- ======================================================================= --}}
@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    
    // --- LOGIKA UNTUK MODAL EDIT ---
    const editModal = document.getElementById('editJurnalModal');
    if (editModal) {
        const closeEditModalBtn = document.getElementById('closeEditModalBtn');
        const cancelEditBtn = document.getElementById('cancelEditBtn');
        const editForm = document.getElementById('editJurnalForm');

        const showEditModal = () => { editModal.style.display = 'flex'; };
        const hideEditModal = () => { editModal.style.display = 'none'; };

        document.querySelectorAll('.btn-edit-modal').forEach(button => {
            button.addEventListener('click', function () {
                const jurnalData = JSON.parse(this.getAttribute('data-jurnal'));
                const updateUrl = this.getAttribute('data-update-url');
                editForm.setAttribute('action', updateUrl);

                document.getElementById('edit_tipe_referensi').value = jurnalData.tipe_referensi;
                document.getElementById('edit_pengarang').value = jurnalData.pengarang;
                document.getElementById('edit_judul').value = jurnalData.judul;
                document.getElementById('edit_abstrak').value = jurnalData.abstrak;
                document.getElementById('edit_issue').value = jurnalData.issue;
                document.getElementById('edit_tahun_publikasi').value = jurnalData.tahun_publikasi;
                document.getElementById('edit_banyak_halaman').value = jurnalData.banyak_halaman;
                document.getElementById('edit_doi').value = jurnalData.doi;

                showEditModal();
            });
        });

        closeEditModalBtn.addEventListener('click', hideEditModal);
        cancelEditBtn.addEventListener('click', hideEditModal);
        window.addEventListener('click', (event) => {
            if (event.target === editModal) {
                hideEditModal();
            }
        });
    }

    // --- LOGIKA UNTUK MODAL DELETE ---
    const deleteModal = document.getElementById('deleteConfirmModal');
    if (deleteModal) {
        const cancelDeleteBtn = document.getElementById('cancelDeleteBtn');
        const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
        let formIdToDelete = null;

        const showDeleteModal = () => { deleteModal.style.display = 'flex'; };
        const hideDeleteModal = () => {
            formIdToDelete = null;
            deleteModal.style.display = 'none';
        };

        document.querySelectorAll('.btn-delete-modal').forEach(button => {
            button.addEventListener('click', function () {
                formIdToDelete = this.getAttribute('data-form-id');
                showDeleteModal();
            });
        });

        confirmDeleteBtn.addEventListener('click', function () {
            if (formIdToDelete) {
                const formToSubmit = document.getElementById(formIdToDelete);
                if (formToSubmit) {
                    formToSubmit.submit();
                }
            }
            hideDeleteModal();
        });

        cancelDeleteBtn.addEventListener('click', hideDeleteModal);
        window.addEventListener('click', (event) => {
            if (event.target === deleteModal) {
                hideDeleteModal();
            }
        });
    }

});
</script>
@endsection