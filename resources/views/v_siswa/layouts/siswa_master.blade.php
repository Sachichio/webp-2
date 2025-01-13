<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Siswa Dashboard - SMP Anak Bangsa')</title>
    <link rel="stylesheet" href="{{ asset('backend/css/siswa/main.css') }}">
</head>
<body>
    <header>
        <div class="header-right">
            <a href="{{ route('siswa.dashboard') }}" class="judul-link">
                <p class="judul">SMP Anak Bangsa</p>
            </a>
            <div class="profile-wrapper">
                <a href="{{ route('siswa.profile') }}">
                    <img src="{{ file_exists(public_path('uploads/profile/siswa/' . Auth::user()->username . '/' . Auth::user()->foto)) 
                        ? asset('uploads/profile/siswa/' . Auth::user()->username . '/' . Auth::user()->foto) 
                        : asset('uploads/profile/default.jpg') }}" 
                        alt="Profile Picture" class="profile-pic">
                </a>
            </div>
        </div>
    </header>

    <button class="menu-toggle">&#9776;</button>
    <nav id="sidebar">
        <ul>
            <!-- Dashboard Menu -->
            <li>
                <a href="{{ route('siswa.dashboard') }}">
                    <img src="{{ asset('backend/icons/dashboard.svg') }}" alt="Dashboard" class="nav-icon"> Dashboard
                </a>
            </li>

            <!-- Kelas Terdaftar Menu -->
            <li>
                <a href="{{ route('siswa.kelas.terdaftar') }}">
                    <img src="{{ asset('backend/icons/kelas.svg') }}" alt="Kelas Terdaftar" class="nav-icon">
                    Kelas Terdaftar
                </a>
            </li>


            <!-- Materi Menu -->
            <li>
                <a href="#">
                    <img src="{{ asset('backend/icons/matapelajaran.svg') }}" alt="Materi" class="nav-icon"> Materi
                </a>
            </li>

            <!-- Ujian Menu -->
            <li>
                <a href="#">
                    <img src="{{ asset('backend/icons/ujian.svg') }}" alt="Ujian" class="nav-icon"> Ujian
                </a>
            </li>

            <!-- Logout Menu -->
            <li>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <img src="{{ asset('backend/icons/logout.svg') }}" alt="Logout" class="nav-icon"> Logout
                </a>
            </li>
        </ul>
    </nav>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <main id="content">
        @yield('content') <!-- Tempat untuk konten dinamis -->
    </main>

    <footer>
        &copy; {{ date('Y') }} SMP Anak Bangsa
    </footer>

    <script src="{{ asset('backend/js/siswa/main.js') }}"></script>
</body>
</html>
