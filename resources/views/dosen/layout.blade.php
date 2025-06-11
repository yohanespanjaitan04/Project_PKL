<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dosen - UPT PERPUS - Universitas Diponegoro</title>
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
                    <div class="app-name">UPT PERPUS - DOSEN</div>
                </div>
            </div>
        </div>
        <div class="user-info">
            <svg class="user-icon" xmlns="http://www.w3.org/2000/svg" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            <div>{{ auth()->user()->nama ?? 'Dosen' }}</div>
        </div>
        
        <ul class="nav-menu">
            <li class="{{ request()->routeIs('dosen.dashboard') ? 'active' : '' }}">
                <a href="{{ route('dosen.dashboard') }}">Dashboard</a>
            </li>
            <li class="{{ request()->routeIs('dosen.jurnal.index') ? 'active' : '' }}">
                <a href="{{ route('dosen.jurnal.index') }}">Jurnal Saya</a>
            </li>
            <li class="{{ request()->routeIs('dosen.jurnal.create') ? 'active' : '' }}">
                <a href="{{ route('dosen.jurnal.create') }}">Jurnal Baru</a>
            </li>
            <li class="{{ request()->routeIs('dosen.home') ? 'active' : '' }}">
                <a href="{{ route('dosen.home') }}">Home</a>
            </li>
            <li class="{{ request()->routeIs('profil.*') ? 'active' : '' }}">
                <a href="{{ route('profil.edit') }}">Profil</a>
            </li>
            <li>
                <form action="{{ route('logout') }}" method="POST" style="margin: 0; padding: 0;">
                    @csrf
                    <button type="submit" style="background: none; border: none; color: inherit; padding: 12px 15px; width: 100%; text-align: left; cursor: pointer; border-radius: 5px; transition: background 0.3s;">
                        Logout
                    </button>
                </form>
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