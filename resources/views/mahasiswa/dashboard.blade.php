@extends('layouts.layout')

@section('content')
<div class="container" style="padding: 20px;">
    <h2>Dashboard</h2>

    @if(session('error'))
        <div class="alert alert-danger" style="margin-bottom: 20px; padding: 10px; background-color: #f8d7da; border: 1px solid #f5c6cb; border-radius: 4px; color: #721c24;">
            {{ session('error') }}
        </div>
    @endif

    <div class="row" style="margin-top: 20px; display: flex; gap: 20px; flex-wrap: wrap;">
        <!-- Total Buku -->
        <div class="card" style="flex: 1; min-width: 250px; padding: 20px; border: 1px solid #999; border-radius: 8px; background-color: #f8f9fa;">
            <h4 style="margin-bottom: 10px; color: #333;">Total Buku</h4>
            <p style="font-size: 24px; font-weight: bold; color: #007bff; margin: 0;">{{ $totalBuku ?? 0 }}</p>
        </div>

        <!-- Total Jurnal -->
        <div class="card" style="flex: 1; min-width: 250px; padding: 20px; border: 1px solid #999; border-radius: 8px; background-color: #f8f9fa;">
            <h4 style="margin-bottom: 10px; color: #333;">Total Jurnal</h4>
            <p style="font-size: 24px; font-weight: bold; color: #28a745; margin: 0;">{{ $totalJurnal ?? 0 }}</p>
        </div>

        <!-- Total Artikel -->
        <div class="card" style="flex: 1; min-width: 250px; padding: 20px; border: 1px solid #999; border-radius: 8px; background-color: #f8f9fa;">
            <h4 style="margin-bottom: 10px; color: #333;">Total Artikel</h4>
            <p style="font-size: 24px; font-weight: bold; color: #ffc107; margin: 0;">{{ $totalArtikel ?? 0 }}</p>
        </div>
    </div>

    <!-- User Info -->
    <div class="user-info" style="margin-top: 30px; padding: 20px; border: 1px solid #999; border-radius: 8px; background-color: #f8f9fa;">
        <h4 style="margin-bottom: 15px; color: #333;">Informasi User</h4>
        <p><strong>Nama:</strong> {{ Auth::user()->name }}</p>
        <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
        <p><strong>Role:</strong> {{ ucfirst(Auth::user()->role) }}</p>
        @if(Auth::user()->role === 'mahasiswa' && Auth::user()->nim)
            <p><strong>NIM:</strong> {{ Auth::user()->nim }}</p>
        @endif
        @if(Auth::user()->role === 'dosen' && Auth::user()->nip)
            <p><strong>NIP:</strong> {{ Auth::user()->nip }}</p>
        @endif
        @if(Auth::user()->prodi)
            <p><strong>Program Studi:</strong> {{ Auth::user()->prodi }}</p>
        @endif
    </div>

    <!-- History -->
    <div class="history-card" style="margin-top: 30px; padding: 20px; border: 1px solid #999; border-radius: 8px; background-color: #f8f9fa;">
        <h4 style="margin-bottom: 15px; color: #333;">History</h4>
        @if(isset($jurnalTerbaru) && $jurnalTerbaru && $jurnalTerbaru->count() > 0)
            <ul style="list-style-type: none; padding: 0;">
                @foreach($jurnalTerbaru as $jurnal)
                    <li style="margin-bottom: 8px; padding: 8px; background-color: white; border-radius: 4px; border-left: 3px solid #007bff;">
                        <a href="{{ route('jurnal.show', $jurnal->id) }}" style="text-decoration: none; color: #007bff;">
                            {{ $jurnal->judul ?? 'Tanpa Judul' }}
                            @if($jurnal->penulis)
                                - {{ $jurnal->penulis }}
                            @endif
                            @if($jurnal->penerbit)
                                - {{ $jurnal->penerbit }}
                            @endif
                            @if($jurnal->tahun_terbit)
                                - {{ $jurnal->tahun_terbit }}
                            @endif
                        </a>
                        <small style="display: block; color: #666; margin-top: 4px;">
                            {{ $jurnal->created_at ? $jurnal->created_at->format('d M Y H:i') : '' }}
                        </small>
                    </li>
                @endforeach
            </ul>
        @else
            <p style="color: #666; font-style: italic;">Belum ada data jurnal.</p>
        @endif
    </div>

    <!-- Statistics (Optional) -->
    @if(isset($statsByType) && $statsByType && $statsByType->count() > 0)
    <div class="stats-card" style="margin-top: 30px; padding: 20px; border: 1px solid #999; border-radius: 8px; background-color: #f8f9fa;">
        <h4 style="margin-bottom: 15px; color: #333;">Statistik Berdasarkan Tipe</h4>
        <div style="display: flex; gap: 10px; flex-wrap: wrap;">
            @foreach($statsByType as $stat)
                <div style="padding: 10px 15px; background-color: white; border-radius: 4px; border: 1px solid #ddd;">
                    <strong>{{ ucfirst($stat->tipe_referensi ?? 'Tidak Diketahui') }}:</strong> {{ $stat->total }}
                </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Quick Actions -->
    <div class="quick-actions" style="margin-top: 30px; padding: 20px; border: 1px solid #999; border-radius: 8px; background-color: #f8f9fa;">
        <h4 style="margin-bottom: 15px; color: #333;">Quick Actions</h4>
        <div style="display: flex; gap: 10px; flex-wrap: wrap;">
            <a href="{{ route('jurnal.index') }}" style="padding: 10px 20px; background-color: #007bff; color: white; text-decoration: none; border-radius: 4px;">Lihat Jurnal</a>
            <a href="{{ route('jurnal.create') }}" style="padding: 10px 20px; background-color: #28a745; color: white; text-decoration: none; border-radius: 4px;">Tambah Jurnal</a>
            <a href="{{ route('profil') }}" style="padding: 10px 20px; background-color: #6c757d; color: white; text-decoration: none; border-radius: 4px;">Edit Profil</a>
        </div>
    </div>
</div>
@endsection