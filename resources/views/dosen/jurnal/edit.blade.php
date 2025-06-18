@extends('layouts.layout')

@section('content')
<div class="page-title">Edit Jurnal</div>

<div class="form-container">
    <form action="{{ route('jurnal.update', $jurnal->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="tipe_referensi">Tipe Referensi <span class="required">*</span></label>
            <select name="tipe_referensi" id="tipe_referensi" required>
                <option value="">Pilih Tipe Referensi</option>
                <option value="Jurnal" {{ old('tipe_referensi', $jurnal->tipe_referensi) == 'Jurnal' ? 'selected' : '' }}>Jurnal</option>
                <option value="Buku" {{ old('tipe_referensi', $jurnal->tipe_referensi) == 'Buku' ? 'selected' : '' }}>Buku</option>
                <option value="Artikel" {{ old('tipe_referensi', $jurnal->tipe_referensi) == 'Artikel' ? 'selected' : '' }}>Artikel</option>
                <option value="Thesis" {{ old('tipe_referensi', $jurnal->tipe_referensi) == 'Thesis' ? 'selected' : '' }}>Thesis</option>
            </select>
            @error('tipe_referensi')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="departemen">Departemen <span class="required">*</span></label>
            <select name="departemen" id="departemen" required>
                <option value="">Pilih Departemen</option>
                {{-- Opsi Departemen sesuai dengan logika controller --}}
                <option value="Fakultas Sains dan Matematika" {{ old('departemen', $jurnal->departemen) == 'Fakultas Sains dan Matematika' ? 'selected' : '' }}>Fakultas Sains dan Matematika</option>
                <option value="Fakultas Teknik" {{ old('departemen', $jurnal->departemen) == 'Fakultas Teknik' ? 'selected' : '' }}>Fakultas Teknik</option>
                <option value="Fakultas Ekonomi dan Bisnis" {{ old('departemen', $jurnal->departemen) == 'Fakultas Ekonomi dan Bisnis' ? 'selected' : '' }}>Fakultas Ekonomi dan Bisnis</option>
                {{-- Anda bisa menambahkan opsi lain jika diperlukan --}}
            </select>
            @error('departemen')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="prodi">Program Studi <span class="required">*</span></label>
            <select name="prodi" id="prodi" required disabled>
                <option value="">Pilih Program Studi</option>
                {{-- Opsi akan diisi oleh JavaScript --}}
            </select>
            @error('prodi')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="semester">Semester <span class="required">*</span></label>
            <select name="semester" id="semester" required disabled>
                <option value="">Pilih Semester</option>
                {{-- Opsi akan diisi oleh JavaScript --}}
            </select>
            @error('semester')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="mata_kuliah">Mata Kuliah <span class="required">*</span></label>
            <select name="mata_kuliah" id="mata_kuliah" required disabled>
                <option value="">Pilih Mata Kuliah</option>
                {{-- Opsi akan diisi oleh JavaScript --}}
            </select>
            @error('mata_kuliah')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="judul">Judul <span class="required">*</span></label>
            <input type="text" name="judul" id="judul" value="{{ old('judul', $jurnal->judul) }}" required>
            @error('judul')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="pengarang">Pengarang <span class="required">*</span></label>
            <input type="text" name="pengarang" id="pengarang" value="{{ old('pengarang', $jurnal->pengarang) }}" required>
            @error('pengarang')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="tahun">Tahun Publikasi <span class="required">*</span></label>
            <input type="number" name="tahun" id="tahun" value="{{ old('tahun', $jurnal->tahun_publikasi) }}" min="1900" max="{{ date('Y') }}" required>
            @error('tahun')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="issue">Issue</label>
            <input type="text" name="issue" id="issue" value="{{ old('issue', $jurnal->issue) }}">
            @error('issue')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="halaman">Jumlah Halaman</label>
            <input type="number" name="halaman" id="halaman" value="{{ old('halaman', $jurnal->banyak_halaman) }}" min="1">
            @error('halaman')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="abstrak">Abstrak <span class="required">*</span></label>
            <textarea name="abstrak" id="abstrak" rows="5" required>{{ old('abstrak', $jurnal->abstrak) }}</textarea>
            @error('abstrak')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="url">DOI/URL</label>
            <input type="url" name="url" id="url" value="{{ old('url', $jurnal->doi) }}">
            @error('url')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="file_pdf">File PDF</label>
            @if($jurnal->file_path)
                <p>File saat ini: 
                    <a href="{{ route('jurnal.download', $jurnal->id) }}" target="_blank">
                        Download file existing
                    </a>
                </p>
            @endif
            <input type="file" name="file_pdf" id="file_pdf" accept=".pdf">
            <small>Biarkan kosong jika tidak ingin mengubah file</small>
            @error('file_pdf')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-actions">
            <a href="{{ route('jurnal.index') }}" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">Update Jurnal</button>
        </div>
    </form>
</div>

<style>
/* CSS Anda yang sudah ada, tidak ada perubahan di sini */
.form-container {
    max-width: 600px;
    margin: 0 auto;
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.form-group {
    margin-bottom: 15px;
}

.form-group label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
    color: #333;
}

.required {
    color: red;
}

.form-group input,
.form-group select,
.form-group textarea {
    width: 100%;
    padding: 8px 12px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 14px;
}

.form-group textarea {
    resize: vertical;
}

.error {
    color: red;
    font-size: 12px;
    margin-top: 5px;
    display: block;
}

.form-actions {
    margin-top: 20px;
    text-align: center;
}

.btn {
    padding: 10px 20px;
    margin: 0 5px;
    text-decoration: none;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
}

.btn-primary { background-color: #007bff; color: white; }
.btn-secondary { background-color: #6c757d; color: white; }

.btn:hover {
    opacity: 0.8;
}

small {
    color: #666;
    font-size: 12px;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const departemenSelect = document.getElementById('departemen');
    const prodiSelect = document.getElementById('prodi');
    const semesterSelect = document.getElementById('semester');
    const mataKuliahSelect = document.getElementById('mata_kuliah');

    // Ambil nilai awal dari objek $jurnal untuk pre-seleksi
    const initialDepartemen = "{{ old('departemen', $jurnal->departemen ?? '') }}";
    const initialProdi = "{{ old('prodi', $jurnal->prodi ?? '') }}";
    const initialSemester = "{{ old('semester', $jurnal->semester ?? '') }}";
    const initialMataKuliah = "{{ old('mata_kuliah', $jurnal->mata_kuliah ?? '') }}";

    // Fungsi untuk mereset dropdown
    function resetDropdown(selectElement, defaultText) {
        selectElement.innerHTML = `<option value="">${defaultText}</option>`;
        selectElement.disabled = true;
    }

    // Fungsi untuk mengambil dan mengisi data program studi
    function fetchProdi(departemen, selectedProdi = null) {
        resetDropdown(prodiSelect, '-- Pilih Program Studi --');
        resetDropdown(semesterSelect, '-- Pilih Semester --');
        resetDropdown(mataKuliahSelect, '-- Pilih Mata Kuliah --');

        if (departemen) {
            fetch(`/getProdi?departemen=${encodeURIComponent(departemen)}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Data Prodi:', data); // Log untuk debugging
                    prodiSelect.disabled = false;
                    data.forEach(prodi => {
                        const option = document.createElement('option');
                        option.value = prodi;
                        option.textContent = prodi;
                        if (selectedProdi && prodi === selectedProdi) {
                            option.selected = true;
                        }
                        prodiSelect.appendChild(option);
                    });
                    // Setelah mengisi prodi, jika ada initial prodi, panggil fetchSemester
                    if (selectedProdi) {
                        fetchSemester(selectedProdi, initialSemester);
                    }
                })
                .catch(error => {
                    console.error('Error fetching prodi:', error);
                    alert('Gagal memuat data program studi: ' + error.message);
                });
        }
    }

    // Fungsi untuk mengambil dan mengisi data semester
    function fetchSemester(prodi, selectedSemester = null) {
        resetDropdown(semesterSelect, '-- Pilih Semester --');
        resetDropdown(mataKuliahSelect, '-- Pilih Mata Kuliah --');

        if (prodi) {
            fetch(`/getSemester?prodi=${encodeURIComponent(prodi)}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Data Semester:', data); // Log untuk debugging
                    semesterSelect.disabled = false;
                    data.forEach(semester => {
                        const option = document.createElement('option');
                        option.value = semester;
                        option.textContent = `Semester ${semester}`;
                        if (selectedSemester && parseInt(semester) === parseInt(selectedSemester)) {
                            option.selected = true;
                        }
                        semesterSelect.appendChild(option);
                    });
                    // Setelah mengisi semester, jika ada initial semester, panggil fetchMataKuliah
                    if (selectedSemester) {
                        fetchMataKuliah(prodi, selectedSemester, initialMataKuliah);
                    }
                })
                .catch(error => {
                    console.error('Error fetching semester:', error);
                    alert('Gagal memuat data semester: ' + error.message);
                });
        }
    }

    // Fungsi untuk mengambil dan mengisi data mata kuliah
    function fetchMataKuliah(prodi, semester, selectedMataKuliah = null) {
        resetDropdown(mataKuliahSelect, '-- Pilih Mata Kuliah --');

        if (semester && prodi) {
            fetch(`/getMataKuliah?prodi=${encodeURIComponent(prodi)}&semester=${encodeURIComponent(semester)}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Data Mata Kuliah:', data); // Log untuk debugging
                    mataKuliahSelect.disabled = false;
                    data.forEach(mataKuliah => {
                        const option = document.createElement('option');
                        option.value = mataKuliah;
                        option.textContent = mataKuliah;
                        if (selectedMataKuliah && mataKuliah === selectedMataKuliah) {
                            option.selected = true;
                        }
                        mataKuliahSelect.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Error fetching mata kuliah:', error);
                    alert('Gagal memuat data mata kuliah: ' + error.message);
                });
        }
    }

    // Event listener untuk perubahan Departemen
    departemenSelect.addEventListener('change', function() {
        fetchProdi(this.value);
    });

    // Event listener untuk perubahan Program Studi
    prodiSelect.addEventListener('change', function() {
        fetchSemester(this.value);
    });

    // Event listener untuk perubahan Semester
    semesterSelect.addEventListener('change', function() {
        const semester = this.value;
        const prodi = prodiSelect.value;
        fetchMataKuliah(prodi, semester);
    });

    // Panggil fungsi fetch saat halaman pertama kali dimuat jika departemen sudah ada
    // Ini akan memicu rantai pemanggilan fetchProdi -> fetchSemester -> fetchMataKuliah
    if (initialDepartemen) {
        fetchProdi(initialDepartemen, initialProdi);
    }
});
</script>
@endsection