@extends('layouts.admin')

@section('title', 'Profil Saya')

@section('content')
    <div class="header">
        <h1>Profil Saya</h1>
    </div>

    <div class="profile-card">
        <div class="profile-header">
            <div class="profile-avatar">
                {{-- Mengambil huruf pertama dari nama user --}}
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div>
                <div class="profile-name">{{ $user->name }}</div>
                <div class="profile-email">{{ $user->email }}</div>
            </div>
        </div>
        
        <div class="profile-details">
            <h3>Detail Akun</h3>
            <div class="detail-item">
                <div class="label">Nama Lengkap</div>
                <div class="value">{{ $user->name }}</div>
            </div>
            <div class="detail-item">
                <div class="label">Alamat Email</div>
                <div class="value">{{ $user->email }}</div>
            </div>
            <div class="detail-item">
                <div class="label">Role</div>
                <div class="value role-badge">{{ $user->role }}</div>
            </div>
            <div class="detail-item">
                <div class="label">Departemen</div>
                {{-- Menggunakan 'N/A' jika departmen kosong/null --}}
                <div class="value">{{ $user->department ?? '-' }}</div>
            </div>
        </div>
    </div>
@endsection