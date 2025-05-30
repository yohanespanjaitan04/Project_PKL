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
                <option value="Informatika" {{ old('departemen', $jurnal->departemen) == 'Informatika' ? 'selected' : '' }}>Informatika</option>
                <option value="Elektro" {{ old('departemen', $jurnal->departemen) == 'Elektro' ? 'selected' : '' }}>Elektro</option>
                <option value="Sipil" {{ old('departemen', $jurnal->departemen) == 'Sipil' ? 'selected' : '' }}>Sipil</option>
            </select>
            @error('departemen')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="prodi">Program Studi <span class="required">*</span></label>
            <select name="prodi" id="prodi" required>
                <option value="">Pilih Program Studi</option>
                <option value="{{ $jurnal->prodi }}" selected>{{ $jurnal->prodi }}</option>
            </select>
            @error('prodi')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="semester">Semester <span class="required">*</span></label>
            <select name="semester" id="semester" required>
                <option value="">Pilih Semester</option>
                @for($i = 1; $i <= 8; $i++)
                    <option value="{{ $i }}" {{ old('semester', $jurnal->semester) == $i ? 'selected' : '' }}>
                        Semester {{ $i }}
                    </option>
                @endfor
            </select>
            @error('semester')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="mata_kuliah">Mata Kuliah <span class="required">*</span></label>
            <select name="mata_kuliah" id="mata_kuliah" required>
                <option value="">Pilih Mata Kuliah</option>
                <option value="{{ $jurnal->mata_kuliah }}" selected>{{ $jurnal->mata_kuliah }}</option>
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