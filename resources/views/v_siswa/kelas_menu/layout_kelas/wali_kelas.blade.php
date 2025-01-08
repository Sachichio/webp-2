@extends('v_guru.layouts.guru_master')

@section('content')
<div class="container my-4">
    <h2 class="mb-3">Daftar Siswa - Kelas {{ $kelas->nama_kelas }}</h2>
    <p>Jenjang: {{ $kelas->jenjang }}</p>

    <!-- Fitur Pencarian -->
    <div class="mb-4">
        <form action="{{ route('guru.kelas.wali', $kelas->id) }}" method="GET">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Cari siswa..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary">Cari</button>
            </div>
        </form>
    </div>

    <!-- Daftar Siswa -->
    <div class="card shadow-sm">
        <div class="card-body">
            @if($siswa->count() > 0)
                <ul class="list-group">
                    @foreach($siswa as $item)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>{{ $item->nama }} ({{ $item->nis }})</span>
                        <span>{{ $item->jenis_kelamin }}</span>
                    </li>
                    @endforeach
                </ul>
            @else
                <div class="alert alert-warning" role="alert">
                    Tidak ada siswa yang terdaftar di kelas ini.
                </div>
            @endif
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('[id^="search-"]').forEach(input => {
        const id = input.id.split('-')[1];
        input.addEventListener('input', function() {
            const filter = this.value.toLowerCase();
            const students = document.querySelectorAll(`#student-list-${id} li`);
            students.forEach(student => {
                const text = student.textContent.toLowerCase();
                student.style.display = text.includes(filter) ? '' : 'none';
            });
        });
    });
</script>

@endsection

