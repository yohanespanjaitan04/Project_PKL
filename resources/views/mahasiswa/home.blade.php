@extends('layouts.layout')

@section('content')
<div style="padding: 24px;">
    <h2>Daftar Jurnal</h2>
    <hr>

    <!-- Filter Section -->
    <div style="background: #f8f9fa; padding: 20px; border-radius: 8px; margin-bottom: 20px;">
        <form method="GET" action="{{ route('home') }}" style="display: grid; grid-template-columns: 1fr 1fr 1fr auto auto; gap: 16px; align-items: end;">
            
            <div>
                <label for="departemen" style="display: block; margin-bottom: 5px; font-weight: bold;">Departemen</label>
                <select name="departemen" id="departemen" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                    <option value="">-- Semua Departemen --</option>
                    <option value="Informatika" {{ request('departemen') == 'Informatika' ? 'selected' : '' }}>Informatika</option>
                    <option value="Elektro" {{ request('departemen') == 'Elektro' ? 'selected' : '' }}>Elektro</option>
                    <option value="Sipil" {{ request('departemen') == 'Sipil' ? 'selected' : '' }}>Sipil</option>
                    <option value="Ekonomi" {{ request('departemen') == 'Ekonomi' ? 'selected' : '' }}>Ekonomi</option>
                </select>
            </div>

            <div>
                <label for="program_studi" style="display: block; margin-bottom: 5px; font-weight: bold;">Program Studi</label>
                <select name="program_studi" id="program_studi" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                    <option value="">-- Semua Program Studi --</option>
                    <option value="Teknik Informatika" {{ request('program_studi') == 'Teknik Informatika' ? 'selected' : '' }}>Teknik Informatika</option>
                    <option value="Sistem Informasi" {{ request('program_studi') == 'Sistem Informasi' ? 'selected' : '' }}>Sistem Informasi</option>
                    <option value="Teknik Komputer" {{ request('program_studi') == 'Teknik Komputer' ? 'selected' : '' }}>Teknik Komputer</option>
                    <option value="Teknik Elektro" {{ request('program_studi') == 'Teknik Elektro' ? 'selected' : '' }}>Teknik Elektro</option>
                    <option value="Teknik Sipil" {{ request('program_studi') == 'Teknik Sipil' ? 'selected' : '' }}>Teknik Sipil</option>
                </select>
            </div>

            <div>
                <label for="kata_kunci" style="display: block; margin-bottom: 5px; font-weight: bold;">Kata Kunci (Opsional)</label>
                <input type="text" name="kata_kunci" id="kata_kunci" placeholder="Masukkan kata kunci..." value="{{ request('kata_kunci') }}" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
            </div>

            <button type="submit" style="padding: 8px 20px; background: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer;">Cari</button>
            
            <a href="{{ route('home') }}" style="padding: 8px 20px; background: #6c757d; color: white; text-decoration: none; border-radius: 4px; text-align: center;">Reset</a>
        </form>
    </div>

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

    <!-- Table -->
    <div style="background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f8f9fa;">
                    <th style="padding: 12px; text-align: left; border-bottom: 2px solid #dee2e6; font-weight: bold;">NO</th>
                    <th style="padding: 12px; text-align: left; border-bottom: 2px solid #dee2e6; font-weight: bold;">Judul</th>
                    <th style="padding: 12px; text-align: left; border-bottom: 2px solid #dee2e6; font-weight: bold;">Penulis</th>
                    <th style="padding: 12px; text-align: left; border-bottom: 2px solid #dee2e6; font-weight: bold;">Tahun</th>
                    <th style="padding: 12px; text-align: left; border-bottom: 2px solid #dee2e6; font-weight: bold;">Kategori</th>
                    <th style="padding: 12px; text-align: left; border-bottom: 2px solid #dee2e6; font-weight: bold;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jurnals ?? [] as $index => $jurnal)
                <tr style="border-bottom: 1px solid #dee2e6;">
                    <td style="padding: 12px;">{{ ($jurnals->currentPage() - 1) * $jurnals->perPage() + $index + 1 }}</td>
                    <td style="padding: 12px;">{{ $jurnal->judul ?? 'Tidak ada judul' }}</td>
                    <td style="padding: 12px;">{{ $jurnal->pengarang ?? 'Tidak diketahui' }}</td>
                    <td style="padding: 12px;">{{ $jurnal->tahun_publikasi ?? '-' }}</td>
                    <td style="padding: 12px;">
                        <span style="background: #007bff; color: white; padding: 4px 8px; border-radius: 12px; font-size: 12px;">
                            {{ $jurnal->tipe_referensi ?? 'Jurnal' }}
                        </span>
                    </td>
                    <td style="padding: 12px;">
                        <a href="{{ route('jurnal.show', $jurnal->id) }}" style="background: #007bff; color: white; padding: 6px 12px; text-decoration: none; border-radius: 4px; font-size: 14px;">Lihat</a>
                        @if($jurnal->file_path)
                            <a href="{{ route('jurnal.download', $jurnal->id) }}" style="background: #17a2b8; color: white; padding: 6px 12px; text-decoration: none; border-radius: 4px; font-size: 14px; margin-left: 5px;">Download</a>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="padding: 40px; text-align: center; color: #6c757d;">
                        <div style="font-size: 18px; margin-bottom: 8px;">📚</div>
                        <div>Belum ada jurnal yang tersedia</div>
                        @if(request()->hasAny(['departemen', 'program_studi', 'kata_kunci']))
                            <div style="font-size: 14px; margin-top: 8px;">
                                <a href="{{ route('home') }}" style="color: #007bff; text-decoration: none;">Lihat semua jurnal</a>
                            </div>
                        @endif
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if(isset($jurnals) && method_exists($jurnals, 'links'))
    <div style="margin-top: 20px; display: flex; justify-content: center;">
        {{ $jurnals->appends(request()->query())->links() }}
    </div>
    @endif

    <!-- Statistik -->
    <div style="margin-top: 20px; padding: 16px; background: #e9ecef; border-radius: 8px;">
        <p style="margin: 0; color: #6c757d; text-align: center;">
            @if(isset($jurnals) && $jurnals->count() > 0)
                Menampilkan <strong>{{ $jurnals->count() }}</strong> dari <strong>{{ $jurnals->total() }}</strong> jurnal
                @if(request()->hasAny(['departemen', 'program_studi', 'kata_kunci']))
                    (difilter)
                @endif
            @else
                Total jurnal di database: <strong>{{ $total_jurnal ?? 0 }}</strong>
            @endif
        </p>
    </div>
</div>
@endsection