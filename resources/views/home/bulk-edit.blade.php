@extends('layouts.layout')

@section('content')
<div style="padding: 24px;">
    <div style="display: flex; align-items: center; margin-bottom: 20px;">
        <a href="{{ route('home') }}" style="background: #6c757d; color: white; padding: 8px 16px; text-decoration: none; border-radius: 4px; margin-right: 16px;">
            ← Kembali
        </a>
        <h2 style="margin: 0;">Edit Multiple Jurnal ({{ $selectedJurnals->count() }} item)</h2>
    </div>
    <hr>

    <!-- Messages -->
    @if(session('success'))
        <div style="background: #d4edda; color: #155724; padding: 12px; border-radius: 4px; margin-bottom: 16px; border: 1px solid #c3e6cb;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="background: #f8d7da; color: #721c24; padding: 12px; border-radius: 4px; margin-bottom: 16px; border: 1px solid #f5c6cb;">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div style="background: #f8d7da; color: #721c24; padding: 12px; border-radius: 4px; margin-bottom: 16px; border: 1px solid #f5c6cb;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('jurnal.bulk-update') }}" method="POST">
        @csrf
        
        <!-- Control Buttons -->
        <div style="background: #f8f9fa; padding: 16px; border-radius: 8px; margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center;">
            <div>
                <button type="button" id="expandAllBtn" style="background: #17a2b8; color: white; padding: 8px 16px; border: none; border-radius: 4px; cursor: pointer; margin-right: 8px;">
                    Expand All
                </button>
                <button type="button" id="collapseAllBtn" style="background: #6c757d; color: white; padding: 8px 16px; border: none; border-radius: 4px; cursor: pointer;">
                    Collapse All
                </button>
            </div>
            <div>
                <button type="submit" style="background: #28a745; color: white; padding: 10px 24px; border: none; border-radius: 4px; cursor: pointer; font-size: 16px;">
                    Simpan Semua Perubahan
                </button>
            </div>
        </div>

        <!-- Jurnal Cards -->
        @foreach($selectedJurnals as $index => $jurnal)
        <div class="jurnal-card" style="background: white; border: 1px solid #dee2e6; border-radius: 8px; margin-bottom: 16px; overflow: hidden; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            
            <!-- Card Header -->
            <div class="card-header" style="background: #f8f9fa; padding: 16px; border-bottom: 1px solid #dee2e6; cursor: pointer; display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <h5 style="margin: 0; color: #495057;">
                        {{ $index + 1 }}. {{ $jurnal->judul ?? 'Tidak ada judul' }}
                    </h5>
                    <small style="color: #6c757d;">
                        {{ $jurnal->pengarang ?? 'Tidak diketahui' }} | {{ $jurnal->tahun_publikasi ?? '-' }}
                    </small>
                </div>
                <div class="toggle-icon" style="font-size: 18px; color: #6c757d;">▼</div>
            </div>

                        <!-- Card Body (Collapsible) - Bagian yang perlu diperbaiki -->
            <div class="card-body" style="padding: 20px; display: none;">
                <!-- Ubah dari jurnal_ids[] menjadi jurnal_ids[index] -->
                <input type="hidden" name="jurnal_ids[{{ $index }}]" value="{{ $jurnal->id }}">
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: bold;">Judul</label>
                        <input type="text" name="judul[{{ $index }}]" value="{{ $jurnal->judul }}" 
                            style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                    </div>
                    
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: bold;">Penulis</label>
                        <input type="text" name="pengarang[{{ $index }}]" value="{{ $jurnal->pengarang }}" 
                            style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: bold;">Tahun Publikasi</label>
                        <input type="number" name="tahun_publikasi[{{ $index }}]" value="{{ $jurnal->tahun_publikasi }}" 
                               min="1900" max="{{ date('Y') + 5 }}"
                               style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                    </div>
                    
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: bold;">Departemen</label>
                        <select name="departemen[{{ $index }}]" 
                                style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                            <option value="">Pilih Departemen</option>
                            <option value="Informatika" {{ $jurnal->departemen == 'Informatika' ? 'selected' : '' }}>Informatika</option>
                            <option value="Elektro" {{ $jurnal->departemen == 'Elektro' ? 'selected' : '' }}>Elektro</option>
                            <option value="Sipil" {{ $jurnal->departemen == 'Sipil' ? 'selected' : '' }}>Sipil</option>
                            <option value="Ekonomi" {{ $jurnal->departemen == 'Ekonomi' ? 'selected' : '' }}>Ekonomi</option>
                            <option value="Teknik Mesin" {{ $jurnal->departemen == 'Teknik Mesin' ? 'selected' : '' }}>Teknik Mesin</option>
                            <option value="Manajemen" {{ $jurnal->departemen == 'Manajemen' ? 'selected' : '' }}>Manajemen</option>
                        </select>
                    </div>
                    
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: bold;">Program Studi</label>
                        <select name="prodi[{{ $index }}]" 
                                style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                            <option value="">Pilih Program Studi</option>
                            <option value="Teknik Informatika" {{ $jurnal->prodi == 'Teknik Informatika' ? 'selected' : '' }}>Teknik Informatika</option>
                            <option value="Sistem Informasi" {{ $jurnal->prodi == 'Sistem Informasi' ? 'selected' : '' }}>Sistem Informasi</option>
                            <option value="Teknik Komputer" {{ $jurnal->prodi == 'Teknik Komputer' ? 'selected' : '' }}>Teknik Komputer</option>
                            <option value="Teknik Elektro" {{ $jurnal->prodi == 'Teknik Elektro' ? 'selected' : '' }}>Teknik Elektro</option>
                            <option value="Teknik Sipil" {{ $jurnal->prodi == 'Teknik Sipil' ? 'selected' : '' }}>Teknik Sipil</option>
                            <option value="Manajemen" {{ $jurnal->prodi == 'Manajemen' ? 'selected' : '' }}>Manajemen</option>
                            <option value="Akuntansi" {{ $jurnal->prodi == 'Akuntansi' ? 'selected' : '' }}>Akuntansi</option>
                            <option value="Teknik Mesin" {{ $jurnal->prodi == 'Teknik Mesin' ? 'selected' : '' }}>Teknik Mesin</option>
                        </select>
                    </div>
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; font-weight: bold;">Abstrak</label>
                    <textarea name="abstrak[{{ $index }}]" rows="4" 
                              style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; resize: vertical;"
                              placeholder="Masukkan abstrak jurnal...">{{ $jurnal->abstrak }}</textarea>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: bold;">Tipe Referensi</label>
                        <select name="tipe_referensi[{{ $index }}]" 
                                style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                            <option value="Jurnal" {{ $jurnal->tipe_referensi == 'Jurnal' ? 'selected' : '' }}>Jurnal</option>
                            <option value="Konferensi" {{ $jurnal->tipe_referensi == 'Konferensi' ? 'selected' : '' }}>Konferensi</option>
                            <option value="Buku" {{ $jurnal->tipe_referensi == 'Buku' ? 'selected' : '' }}>Buku</option>
                            <option value="Thesis" {{ $jurnal->tipe_referensi == 'Thesis' ? 'selected' : '' }}>Thesis</option>
                            <option value="Disertasi" {{ $jurnal->tipe_referensi == 'Disertasi' ? 'selected' : '' }}>Disertasi</option>
                        </select>
                    </div>
                    
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: bold;">Penerbit</label>
                        <input type="text" name="penerbit[{{ $index }}]" value="{{ $jurnal->penerbit }}" 
                               style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;"
                               placeholder="Nama penerbit...">
                    </div>
                    
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: bold;">Volume/Issue</label>
                        <input type="text" name="volume[{{ $index }}]" value="{{ $jurnal->volume }}" 
                               style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;"
                               placeholder="Volume dan Issue...">
                    </div>
                </div>

                <!-- File Info (Read Only) -->
                @if($jurnal->file_path)
                <div style="margin-top: 20px; padding: 12px; background: #e9ecef; border-radius: 4px;">
                    <div style="display: flex; align-items: center; justify-content: space-between;">
                        <div>
                            <strong>File:</strong> {{ basename($jurnal->file_path) }}
                            <small style="color: #6c757d; margin-left: 8px;">
                                ({{ number_format(filesize(storage_path('app/' . $jurnal->file_path)) / 1024, 2) }} KB)
                            </small>
                        </div>
                        <a href="{{ route('jurnal.download', $jurnal->id) }}" 
                           style="background: #17a2b8; color: white; padding: 4px 8px; text-decoration: none; border-radius: 4px; font-size: 12px;">
                            Download
                        </a>
                    </div>
                </div>
                @endif
            </div>
        </div>
        @endforeach

        <!-- Submit Button (Fixed at bottom) -->
        <div style="position: sticky; bottom: 0; background: white; padding: 16px; border-top: 1px solid #dee2e6; text-align: center; margin-top: 20px;">
            <button type="submit" style="background: #28a745; color: white; padding: 12px 30px; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                💾 Simpan Semua Perubahan
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.jurnal-card');
    const expandAllBtn = document.getElementById('expandAllBtn');
    const collapseAllBtn = document.getElementById('collapseAllBtn');

    // Function to toggle card
    function toggleCard(card) {
        const cardBody = card.querySelector('.card-body');
        const toggleIcon = card.querySelector('.toggle-icon');
        
        if (cardBody.style.display === 'none' || !cardBody.style.display) {
            cardBody.style.display = 'block';
            toggleIcon.textContent = '▲';
            card.style.borderColor = '#007bff';
        } else {
            cardBody.style.display = 'none';
            toggleIcon.textContent = '▼';
            card.style.borderColor = '#dee2e6';
        }
    }

    // Add click event to each card header
    cards.forEach(card => {
        const cardHeader = card.querySelector('.card-header');
        cardHeader.addEventListener('click', function() {
            toggleCard(card);
        });
    });

    // Expand all cards
    expandAllBtn.addEventListener('click', function() {
        cards.forEach(card => {
            const cardBody = card.querySelector('.card-body');
            const toggleIcon = card.querySelector('.toggle-icon');
            cardBody.style.display = 'block';
            toggleIcon.textContent = '▲';
            card.style.borderColor = '#007bff';
        });
    });

    // Collapse all cards
    collapseAllBtn.addEventListener('click', function() {
        cards.forEach(card => {
            const cardBody = card.querySelector('.card-body');
            const toggleIcon = card.querySelector('.toggle-icon');
            cardBody.style.display = 'none';
            toggleIcon.textContent = '▼';
            card.style.borderColor = '#dee2e6';
        });
    });

    // Form validation before submit
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        let hasChanges = false;
        const inputs = form.querySelectorAll('input, select, textarea');
        
        // Check if any field has been modified (basic check)
        inputs.forEach(input => {
            if (input.name && input.value.trim() !== '') {
                hasChanges = true;
            }
        });

        if (!hasChanges) {
            e.preventDefault();
            alert('Tidak ada perubahan yang ditemukan. Silakan lakukan perubahan terlebih dahulu.');
            return false;
        }

        // Confirm before submit
        if (!confirm(`Anda akan menyimpan perubahan pada {{ $selectedJurnals->count() }} jurnal. Lanjutkan?`)) {
            e.preventDefault();
            return false;
        }
    });

    // Auto-save indicator (optional enhancement)
    let changesMade = false;
    const inputs = document.querySelectorAll('input, select, textarea');
    inputs.forEach(input => {
        input.addEventListener('change', function() {
            changesMade = true;
            if (!document.getElementById('unsavedChanges')) {
                const indicator = document.createElement('div');
                indicator.id = 'unsavedChanges';
                indicator.style.cssText = 'position: fixed; top: 10px; right: 10px; background: #ffc107; color: #856404; padding: 8px 12px; border-radius: 4px; font-size: 14px; z-index: 1000;';
                indicator.textContent = '⚠️ Perubahan belum disimpan';
                document.body.appendChild(indicator);
            }
        });
    });

    // Remove unsaved changes indicator on form submit
    form.addEventListener('submit', function() {
        const indicator = document.getElementById('unsavedChanges');
        if (indicator) {
            indicator.remove();
        }
    });
});
</script>

<style>
/* Additional styling for better UX */
.jurnal-card {
    transition: all 0.3s ease;
}

.jurnal-card:hover {
    box-shadow: 0 4px 8px rgba(0,0,0,0.15) !important;
}

.card-header {
    transition: background-color 0.2s ease;
}

.card-header:hover {
    background: #e9ecef !important;
}

.toggle-icon {
    transition: transform 0.2s ease;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .card-body > div[style*="grid-template-columns"] {
        grid-template-columns: 1fr !important;
    }
    
    .control-buttons {
        flex-direction: column;
        gap: 10px;
    }
}

/* Loading state */
.loading {
    opacity: 0.6;
    pointer-events: none;
}

/* Success animation */
@keyframes fadeInSuccess {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

.success-message {
    animation: fadeInSuccess 0.5s ease;
}
</style>
@endsection