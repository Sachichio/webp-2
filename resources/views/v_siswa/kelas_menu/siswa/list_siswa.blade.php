@extends('v_guru.kelas_menu.layout_kelas.kelas__master')

@section('kelas-content')
    <h3>List Siswa</h3>
    <ul>
        @forelse ($kelas->siswa as $siswa)
            <li>{{ $siswa->nama }}</li>
        @empty
            <li>Tidak ada siswa di kelas ini.</li>
        @endforelse
    </ul>
@endsection
