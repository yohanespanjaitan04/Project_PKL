@extends('layouts.layout')

@section('content')
<div style="padding: 24px;">
    <h2>Tambah Referensi Baru</h2>
    <hr>

    <form action="{{ route('jurnal.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">

            {{-- Baris 1 --}}
            <div>
                <label for="tipe_referensi">Tipe Referensi</label>
                <select name="tipe_referensi" id="tipe_referensi" style="width: 100%; padding: 8px;" required>
                    <option value="">-- Pilih Tipe --</option>
                    <option value="Jurnal">Jurnal</option>
                    <option value="Artikel">Artikel</option>
                    <option value="Buku">Buku</option>
                </select>
            </div>

            <div>
                <label for="departemen">Departemen</label>
                <select name="departemen" id="departemen" style="width: 100%; padding: 8px;" required>
                    <option value="">-- Pilih Departemen --</option>
                    <option value="Fakultas Sains dan Matematika">Fakultas Sains dan Matematika</option>
                    <option value="Fakultas Teknik">Fakultas Teknik</option>
                    <option value="Fakultas Ekonomi dan Bisnis">Fakultas Ekonomi dan Bisnis</option>
                </select>
            </div>

            {{-- Baris 2 - Dropdown Cascading --}}
            <div>
                <label for="prodi">Program Studi</label>
                <select name="prodi" id="prodi" style="width: 100%; padding: 8px;" required disabled>
                    <option value="">-- Pilih Prodi --</option>
                </select>
            </div>

            <div>
                <label for="semester">Semester</label>
                <select name="semester" id="semester" style="width: 100%; padding: 8px;" required disabled>
                    <option value="">-- Pilih Semester --</option>
                </select>
            </div>

            {{-- Baris 3 --}}
            <div style="grid-column: span 2;">
                <label for="mata_kuliah">Mata Kuliah</label>
                <select name="mata_kuliah" id="mata_kuliah" style="width: 100%; padding: 8px;" required disabled>
                    <option value="">-- Pilih Mata Kuliah --</option>
                </select>
            </div>

            {{-- Baris 4 --}}
            <div style="grid-column: span 2;">
                <label for="judul">Judul</label>
                <input type="text" name="judul" id="judul" style="width: 100%; padding: 8px;" required>
            </div>

            {{-- Baris 5 --}}
            <div>
                <label for="pengarang">Pengarang</label>
                <input type="text" name="pengarang" id="pengarang" style="width: 100%; padding: 8px;" required>
            </div>
            <div>
                <label for="tahun">Tahun Publikasi</label>
                <input type="number" name="tahun" id="tahun" style="width: 100%; padding: 8px;" required>
            </div>

            {{-- Baris 6 --}}
            <div>
                <label for="issue">Issue</label>
                <input type="text" name="issue" id="issue" style="width: 100%; padding: 8px;">
            </div>
            <div>
                <label for="halaman">Banyak Halaman</label>
                <input type="number" name="halaman" id="halaman" style="width: 100%; padding: 8px;">
            </div>

            {{-- Baris 7 --}}
            <div style="grid-column: span 2;">
                <label for="abstrak">Abstrak/deskripsi</label>
                <textarea name="abstrak" id="abstrak" rows="4" style="width: 100%; padding: 8px;" required></textarea>
            </div>

            {{-- Baris 8 --}}
            <div>
                <label for="url">DOI/URL</label>
                <input type="url" name="url" id="url" style="width: 100%; padding: 8px;">
            </div>
            <div>
                <label for="file_pdf">Upload PDF (optional)</label>
                <input type="file" name="file_pdf" id="file_pdf" accept=".pdf" style="width: 100%;">
            </div>

        </div>

        <br>
        <button type="submit" style="padding: 8px 20px;">Simpan</button>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const departemenSelect = document.getElementById('departemen');
    const prodiSelect = document.getElementById('prodi');
    const semesterSelect = document.getElementById('semester');
    const mataKuliahSelect = document.getElementById('mata_kuliah');

    // Reset function untuk dropdown
    function resetDropdown(selectElement, defaultText) {
        selectElement.innerHTML = `<option value="">${defaultText}</option>`;
        selectElement.disabled = true;
    }

    // Event listener untuk departemen
    departemenSelect.addEventListener('change', function() {
        const departemen = this.value;
        
        // Reset dropdown yang tergantung
        resetDropdown(prodiSelect, '-- Pilih Prodi --');
        resetDropdown(semesterSelect, '-- Pilih Semester --');
        resetDropdown(mataKuliahSelect, '-- Pilih Mata Kuliah --');

        if (departemen) {
            // AJAX request untuk mengambil data prodi
            fetch(`/getProdi?departemen=${departemen}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Prodi data:', data); // Debug log
                    prodiSelect.disabled = false;
                    data.forEach(prodi => {
                        const option = document.createElement('option');
                        option.value = prodi;
                        option.textContent = prodi;
                        prodiSelect.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Gagal memuat data prodi: ' + error.message);
                });
        }
    });

    // Event listener untuk prodi
    prodiSelect.addEventListener('change', function() {
        const prodi = this.value;
        
        // Reset dropdown yang tergantung
        resetDropdown(semesterSelect, '-- Pilih Semester --');
        resetDropdown(mataKuliahSelect, '-- Pilih Mata Kuliah --');

        if (prodi) {
            // AJAX request untuk mengambil data semester
            fetch(`/getSemester?prodi=${prodi}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Semester data:', data); // Debug log
                    semesterSelect.disabled = false;
                    data.forEach(semester => {
                        const option = document.createElement('option');
                        option.value = semester;
                        option.textContent = `Semester ${semester}`;
                        semesterSelect.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Gagal memuat data semester: ' + error.message);
                });
        }
    });

    // Event listener untuk semester
    semesterSelect.addEventListener('change', function() {
        const semester = this.value;
        const prodi = prodiSelect.value;
        
        // Reset dropdown mata kuliah
        resetDropdown(mataKuliahSelect, '-- Pilih Mata Kuliah --');

        if (semester && prodi) {
            // AJAX request untuk mengambil data mata kuliah
            fetch(`/getMataKuliah?prodi=${prodi}&semester=${semester}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Mata Kuliah data:', data); // Debug log
                    mataKuliahSelect.disabled = false;
                    data.forEach(mataKuliah => {
                        const option = document.createElement('option');
                        option.value = mataKuliah;
                        option.textContent = mataKuliah;
                        mataKuliahSelect.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Gagal memuat data mata kuliah: ' + error.message);
                });
        }
    });
});
</script>
@endsection