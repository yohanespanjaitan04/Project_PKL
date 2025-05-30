<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UPT PERPUS - Universitas Diponegoro</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="icon" href="{{ asset('Undip_favicon.ico') }}" type="image/x-icon">


    
</head>
<body>
    <div class="sidebar">
        <div class="logo-container">    
            <div class="logo">
                  <img src="{{ asset('image/Undip.png') }}" alt="Gambar" class="logo">
                <div>
                    <div class="logo-text">UNIVERSITAS DIPONEGORO</div>
                    <div class="app-name">UPT PERPUS</div>
                </div>
            </div>
        </div>
        <div class="user-info">
            <svg class="user-icon" xmlns="http://www.w3.org/2000/svg" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            <div>{{ $user['nama'] ?? 'Rayyis Budi' }}</div>
        </div>
        <ul class="nav-menu">
            @if (auth()->user()->role == "mahasiswa")
            <li class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}">Dashboard</a>
            </li>
            @endif
            @if (auth()->user()->role == "admin, dosen")
            <li class="{{ request()->routeIs('jurnal.*') ? 'active' : '' }}">
                <a href="{{ route('jurnal.index') }}">Jurnal Saya</a>
            </li>
            @endif
             @if (auth()->user()->role == "admin, dosen")
            <li class="{{ request()->routeIs('jurnal.create') ? 'active' : '' }}">
                <a href="{{ route('jurnal.create') }}">Jurnal Baru</a>
            </li>
            @endif
            <li class="{{ request()->routeIs('home.*') ? 'active' : '' }}">
                <a href="{{ route('home') }}">Home</a>
            </li>
            <li class="{{ request()->routeIs('profil.*') ? 'active' : '' }}">
                <a href="{{ route('profil.edit') }}">Profil</a>
            </li>
        </ul>
    </div>

    <div class="main-content">
        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        @yield('content')
    </div>

    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>