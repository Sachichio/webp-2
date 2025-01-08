@extends('v_guru.layouts.guru_master')

@section('content')
<div class="container my-4">
    <!-- Bagian Wali Kelas -->
    <div class="section">
        <h2 class="mb-3">Wali Kelas</h2>
        <div class="row">
            @forelse ($waliKelas as $kelas)
                <div class="col-md-4">
                    <div class="card mb-3 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">{{ $kelas->nama_kelas }}</h5>
                            <p class="card-text">Jenjang: {{ $kelas->jenjang }}</p>
                            <a href="{{ route('guru.kelas.wali', $kelas->id) }}" class="btn btn-primary">
                                Masuk Kelas
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-warning" role="alert">
                        Tidak terdaftar sebagai wali kelas di kelas manapun.
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Bagian Mata Pelajaran yang Diajar -->
    <div class="section mt-5">
        <h2 class="mb-3">Mata Pelajaran yang Diajar</h2>
        <div class="row">
            @forelse ($mataPelajaran as $pelajaran)
                <div class="col-md-4">
                    <div class="card mb-3 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">{{ $pelajaran->nama_pelajaran }}</h5>
                            <p class="card-text">
                                Diajar di kelas:
                                <ul class="mb-0">
                                    @foreach ($pelajaran->kelas as $kelas)
                                        <li>
                                            <a href="{{ route('guru.kelas.master', $kelas->id) }}">
                                                {{ $kelas->nama_kelas }} ({{ $kelas->jenjang }})
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-warning" role="alert">
                        Tidak terdaftar di mata pelajaran manapun.
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>



<style>
    .section {
        margin-bottom: 30px;
    }

    .card {
        background-color: #f8f9fa;
        border-radius: 10px;
        border: 1px solid #ddd;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s ease-in-out;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
    }

    .card-title {
        font-size: 1.2rem;
        font-weight: 600;
    }

    .alert-warning {
        background-color: #fce4e4;
        color: #e60000;
        font-weight: bold;
        text-align: center;
        padding: 15px;
        border-radius: 5px;
        border: 1px solid #e60000;
    }

    .card-body {
        padding: 20px;
    }

    .card-text {
        font-size: 1rem;
        color: #555;
    }

    ul {
        list-style-type: none;
        padding-left: 0;
    }

    li {
        margin-bottom: 5px;
    }

    h1 {
        font-size: 2.5rem;
        color: #333;
        margin-bottom: 20px;
    }

    h2 {
        font-size: 1.8rem;
        margin-bottom: 15px;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
    }

    .row {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
    }

    .col-md-4 {
        width: 30%;
        margin-bottom: 20px;
    }

    .col-12 {
        width: 100%;
    }

</style>
@endsection

