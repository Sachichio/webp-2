<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard - SMP Anak Bangsa')</title>
    <link rel="stylesheet" href="{{ asset('backend/css/admin/main.css') }}">
    
</head>
<body>
    <header>
        <div class="header-right">
            <a href="{{ route('admin.dashboard') }}" class="judul-link">
                <p class="judul">SMP Anak Bangsa</p>
            </a>
            <div class="profile-wrapper">
                <a href="{{ route('admin.profile') }}">
                    <img src="{{ file_exists(public_path('uploads/profile/admin/' . Auth::user()->username . '/' . Auth::user()->foto)) 
                        ? asset('uploads/profile/admin/' . Auth::user()->username . '/' . Auth::user()->foto) 
                        : asset('uploads/profile/default.jpg') }}" 
                        alt="Profile Picture" class="profile-pic">
                </a>
            </div>
        </div>
    </header>


    <button class="menu-toggle">&#9776;</button>
    <nav id="sidebar">
        <ul>
            <li>
                <a href="{{ route('admin.dashboard') }}">
                    <img src="{{ asset('backend/icons/dashboard.svg') }}" alt="Dashboard" class="nav-icon"> Dashboard
                </a>
            </li>
            <li>
                <a href="#" onclick="toggleDropdown(event)">
                    <img src="{{ asset('backend/icons/drop_down.svg') }}" alt="Manajemen User" class="nav-icon">
                    Manajemen User
                </a>
                <ul class="dropdown">
                    <li>
                        <a href="{{ route('admin.manajemenGuru') }}">
                            <img src="{{ asset('backend/icons/user.svg') }}" alt="Manajemen Guru" class="nav-icon">
                            Manajemen Guru
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.manajemenSiswa') }}">
                            <img src="{{ asset('backend/icons/user.svg') }}" alt="Manajemen Siswa" class="nav-icon">
                            Manajemen Siswa
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="{{ route('admin.manajemenPelajaran') }}">
                    <img src="{{ asset('backend/icons/matapelajaran.svg') }}" alt="Mata Pelajaran" class="nav-icon"> Mata Pelajaran
                </a>
            </li>
            <li>
                <a href="{{ route('admin.manajemenKelas') }}">
                    <img src="{{ asset('backend/icons/kelas.svg') }}" alt="Manajemen Kelas" class="nav-icon"> Manajemen Kelas
                </a>
            </li>

            <li>
                <a href="#">
                    <img src="{{ asset('backend/icons/ujian.svg') }}" alt="Manajemen Ujian" class="nav-icon"> Manajemen Ujian
                </a>
            </li>
            <li>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <img src="{{ asset('backend/icons/logout.svg') }}" alt="Logout" class="nav-icon"> Logout
                </a>
            </li>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </ul>
    </nav>


    <main id="content">
        @yield('content') <!-- Tempat untuk konten dinamis -->
    </main>
    <footer>
        &copy; {{ date('Y') }} SMP Anak Bangsa
    </footer>
    <script src="{{ asset('backend/js/admin/main.js') }}"></script>
</body>
</html>