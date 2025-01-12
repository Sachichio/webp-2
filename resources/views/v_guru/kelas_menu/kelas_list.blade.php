@extends('v_guru.layouts.guru_master')

@section('content')
<div class="container">
    <div class="title-container">
        <h1 class="title">Kelas Terdaftar</h1>
        <p>Berikut, Anda Terdaftar di Kelas</p>
    </div>

    <div class="table-container p-4">
        <div class="row">
            @forelse ($waliKelas as $kelas)
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm h-100">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">Wali Kelas: {{ $kelas->nama_kelas }}</h5>
                            <p class="small-text">Anda merupakan wali kelas dari kelas ini.</p>
                            <a href="{{ route('guru.kelas.wali', $kelas->id) }}" class="btn btn-primary mt-auto">
                                Lihat Kelas
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

            @forelse ($mataPelajaran as $pelajaran)
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm h-100">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $pelajaran->nama_pelajaran }}</h5>
                            <p class="card-text">
                                Diajar di kelas:
                                <ul class="mb-0 d-flex flex-wrap custom-list">
                                    @foreach ($pelajaran->kelas as $kelasMatapelajaran)
                                        @php
                                            $kelasPelajaran = \App\Models\KelasPelajaran::where('kelas_id', $kelasMatapelajaran->id)
                                                ->where('pelajaran_id', $pelajaran->id)
                                                ->first();
                                        @endphp
                                        <li class="me-3">
                                            @if ($kelasPelajaran)
                                                <a href="{{ route('guru.kelas.master', $kelasPelajaran->id) }}" class="btn-primary2">
                                                    {{ $kelasMatapelajaran->nama_kelas }} 
                                                    ({{ $kelasPelajaran->hari }} | Jam: {{ $kelasPelajaran->jam_mulai }} - {{ $kelasPelajaran->jam_selesai }})
                                                </a>
                                            @else
                                                <span>Kelas belum ditemukan.</span>
                                            @endif
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

@endsection
<style>
    /* General Styles */
    body {
        font-family: Arial, sans-serif;
        background-color: #ffffff;
        margin: 0;
        padding: 0;
    }

    .container {
        max-width: 1200px;
        width: 90%;
        margin: 0 auto;
        padding: 20px;
    }

    /* Title and Section Styling */
    .title-container,
    .table-container {
        background-color: #d4d4d4;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        padding: 20px;
        margin-bottom: 20px;
    }

    .title {
        font-size: 24px;
        text-align: left;
        color: #333;
    }

    /* Card Styling */
    .card {
        background-color: #f8f9fa;
        border-radius: 10px;
        border: 1px solid #ddd;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s, box-shadow 0.3s;
        cursor: pointer;
        height: 100%;
        max-width: 100%; /* Ensure card doesn’t grow too wide */
        margin: 0 auto; /* Center cards in columns */
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
    }

    .card-body {
        padding: 0 10%;
        display: flex;
        flex-direction: column;
    }

    .card-title {
        font-size: 1.1rem; /* Reduced size */
        font-weight: 600;
        color: #007bff;
    }

    .card-text {
        font-size: 1rem;
        margin-bottom: 8px;
        color: #555;
    }

    .small-text {
        font-size: 0.9rem;
        color: #888;
        margin-bottom: 10px;
    }

    /* Alert Styling */
    .alert-warning {
        background-color: #fce4e4;
        color: #e60000;
        font-weight: bold;
        text-align: center;
        padding: 15px;
        border-radius: 5px;
        border: 1px solid #e60000;
    }

    /* List Styling - Custom Class */
    .custom-list {
        list-style-type: none; /* Remove default list styling */
        padding-left: 0; /* Remove padding */
        display: flex; /* Use flexbox for horizontal layout */
        flex-wrap: wrap; /* Allow wrapping to the next line if needed */
        margin: 0; /* Remove default margin */
    }

    .custom-list li {
        margin-right: 15px; /* Add space between items */
        font-size: 0.9rem; /* Adjust font size */
        color: #555; /* Text color */
    }

    .custom-list li a {
        text-decoration: none; /* Remove underline from links */
        color: #007bff; /* Link color */
        transition: color 0.3s ease; /* Smooth transition for hover effect */
    }

    .custom-list li a:hover {
        color: #0056b3; /* Darker color on hover */
    }

    /* Grid Layout */
    .row {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
    }

    .col-md-4 {
        width: 32%; /* Adjusted width for better spacing */
        margin-bottom: 0;
    }

    .col-12 {
        width: 100%;
    }

    /* Button Styling */
    .btn-primary {
        background-color: #d4d4d4; /* Warna abu-abu utama */
        color: #305cde; /* Warna teks */
        border: none;
        font-size: 14px; /* Ukuran font */
        text-decoration: none;
        width: 80%;
        padding: 10px;
        transition: background-color 0.3s ease, transform 0.2s ease; /* Animasi hover */
    }

    .btn-primary:hover {
        background-color: grey; /* Warna abu-abu lebih gelap saat hover */
        transform: translateY(-2px); /* Efek naik saat hover */
        text-decoration: none; /* Hilangkan underline */
        color: white;
    }

    .btn-primary2 {
        background-color: #d4d4d4; /* Warna abu-abu utama */
        color: #305cde; /* Warna teks */
        border: none;
        font-size: 14px;
        text-decoration: none;
        width: 100%;
        padding: 10px;
        transition: background-color 0.3s ease, transform 0.2s ease;
        display: block; /* Elemen block-level */
    }

    .btn-primary2:hover {
        background-color: grey; /* Warna abu-abu lebih gelap saat hover */
        transform: translateY(-2px); /* Efek naik */
        text-decoration: none; /* Hilangkan underline */
        color: white !important; /* Warna teks putih */
    }

    /* List Item Styling */
    li.me-3 {
        display: flex; /* Pastikan elemen mengikuti model flexbox */
        flex-direction: column; /* Susun vertikal jika ada elemen dalam <li> */
        width: 100%; /* Buat <li> selebar container */
        margin-bottom: 3px; /* Jarak antar <li> */
    }


</style>




