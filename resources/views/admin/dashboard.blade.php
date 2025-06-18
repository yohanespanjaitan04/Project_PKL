@extends('layouts.admin')

@section('content')
    <div class="header">
        <h1>Dashboard</h1>
    </div>

    {{-- Grid untuk menampilkan kartu statistik --}}
    <div class="stat-cards-grid">

        <!-- Kartu Statistik untuk Total Pengguna -->
        <div class="stat-card">
            <div class="icon-wrapper icon-users">
                <span>👥</span>
            </div>
            <div class="info">
                <div class="stat-number">{{ $userCount ?? 0 }}</div>
                <div class="stat-label">Total Pengguna</div>
            </div>
        </div>

        <!-- Kartu Statistik untuk Total Jurnal -->
        <div class="stat-card">
            <div class="icon-wrapper icon-journals">
                <span>📚</span>
            </div>
            <div class="info">
                <div class="stat-number">{{ $journalCount ?? 0 }}</div>
                <div class="stat-label">Total Jurnal</div>
            </div>
        </div>

    </div>

    <!-- [BARU] Kartu untuk Quick Actions -->
    <div class="quick-actions-card">
        <h3>Aksi Cepat</h3>
        <div class="quick-actions-buttons">
            {{-- Tombol untuk ke halaman Manajemen User --}}
            <a href="{{ route('admin.users.index') }}" class="action-link user-management">
                <span>👥</span>
                Manajemen User
            </a>

            {{-- Tombol untuk ke halaman Tambah Jurnal --}}
            <a href="{{ route('admin.jurnal.create') }}" class="action-link add-journal">
                <span>➕</span>
                Tambah Jurnal
            </a>
        </div>
    </div>
@endsection