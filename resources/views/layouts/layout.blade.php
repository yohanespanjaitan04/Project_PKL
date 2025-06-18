<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UPT PERPUS - Universitas Diponegoro</title>

    {{-- Link CDN Bootstrap CSS --}}
    {{-- Ini PENTING untuk styling pagination dan komponen Bootstrap lainnya --}}
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    {{-- CSS kustom Anda --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    
    <link rel="icon" href="{{ asset('Undip_favicon.ico') }}" type="image/x-icon">

    {{-- Jika Anda menggunakan Font Awesome, ini juga bisa di sini --}}
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> --}}

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
            {{-- Pastikan variabel $user tersedia dari view composer atau controller --}}
            <div>{{ $user['nama'] ?? Auth::user()->name ?? 'Rayyis Budi' }}</div>
        </div>
        <ul class="nav-menu">
            {{-- Dashboard untuk semua --}}
            <li class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}">Dashboard</a>
            </li>

            {{-- Jurnal hanya untuk dosen dan admin --}}
            @if (auth()->check() && (auth()->user()->role == 'dosen' || auth()->user()->role == 'admin'))
                <li class="{{ request()->routeIs('jurnal.my') ? 'active' : '' }}">
                    <a href="{{ route('jurnal.my') }}">Jurnal Saya</a>
                </li>
                <li class="{{ request()->routeIs('jurnal.new') ? 'active' : '' }}">
                    <a href="{{ route('jurnal.new') }}">Jurnal Baru</a>
                </li>
            @endif

            {{-- Home untuk semua --}}
            <li class="{{ request()->routeIs('home') ? 'active' : '' }}">
                <a href="{{ route('home') }}">Home</a>
            </li>

            {{-- Profil untuk semua --}}
            <li class="{{ request()->routeIs('profil.*') ? 'active' : '' }}">
                <a href="{{ route('profil.edit') }}">Profil</a>
            </li>
            {{-- Logout untuk semua --}}
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

    {{-- Link CDN Bootstrap JavaScript, jQuery, dan Popper.js --}}
    {{-- Ini PENTING untuk fitur interaktif Bootstrap seperti dropdown, modal, dll. --}}
    {{-- Pastikan jQuery di-load sebelum Popper dan Bootstrap JS --}}
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    {{-- Script kustom Anda (script.js) --}}
    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>