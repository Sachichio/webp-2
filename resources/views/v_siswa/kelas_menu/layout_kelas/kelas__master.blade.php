@extends('v_guru.layouts.guru_master')

@section('content')
<div class="container my-4">
    <h2>Kelas {{ $kelas->nama_kelas }} - Jenjang {{ $kelas->jenjang }}</h2>

    <!-- Navigasi -->
    <ul class="nav nav-tabs mb-4">
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('guru.kelas.siswa') ? 'active' : '' }}" 
            href="{{ route('guru.kelas.siswa', $kelas->id) }}">
                List Siswa
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('guru.kelas.absen') ? 'active' : '' }}" 
            href="{{ route('guru.kelas.absen', $kelas->id) }}">
                Absen
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('guru.kelas.tugas') ? 'active' : '' }}" 
            href="{{ route('guru.kelas.tugas', $kelas->id) }}">
                Tugas
            </a>
        </li>
    </ul>


    <!-- Konten Dinamis -->
    <main id="content">
        @yield('kelas-content') <!-- Konten spesifik untuk setiap tab -->
    </main>
</div>

<style>
    .card {
    border: none;
    transition: transform 0.2s;
    }

    .card:hover {
        transform: scale(1.05);
    }

    .list-group-item {
        font-size: 16px;
    }

</style>

<script>
    document.getElementById('search').addEventListener('input', function() {
        let filter = this.value.toLowerCase();
        let students = document.querySelectorAll('#student-list li');
        students.forEach(function(student) {
            let text = student.textContent.toLowerCase();
            student.style.display = text.includes(filter) ? '' : 'none';
        });
    });
</script>
@endsection

