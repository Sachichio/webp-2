@extends('v_siswa.layouts.siswa_master')

@section('title', 'Dashboard Siswa')

@section('content')
<div class="container">
    <!-- Block 1: Title -->
    <div class="title-container">
        <h1 class="title">Selamat datang, {{ Auth::user()->siswa->nama }}</h1>
        <p>Anda adalah SISWA berikut ringkasan data anda</p>
    </div>

    <!-- Block 2: Statistics -->
    <div class="table-container">
        <div class="stats d-flex justify-content-between">
            <div class="card shadow-sm p-3">
                <h3>{{ $jumlahKelas }}</h3>
                <p>Kelas Anda</p>
            </div>
            <div class="card shadow-sm p-3">
                <h3>{{ $jumlahMapel }}</h3>
                <p>Jumlah Mata Pelajaran</p>
            </div>
            <div class="card shadow-sm p-3">
                <h3>{{ $jumlahSiswa }}</h3>
                <p>Jumlah Siswa di Kelas</p>
            </div>
        </div>
    </div>
</div>
    

<style>
    /* General Styles */
    body {
        font-family: Arial, sans-serif;
        background-color: #ffffff;
        margin: 0;
        padding: 0;
    }

    .container {
        max-width: 100%;
        width: 90%;
        margin: 0 auto; /* Center container */
        padding: 2%; /* Added padding for better layout */
    }

    .title-container,
    .table-container {
        background-color: #d4d4d4;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        padding: 2%;
        margin-bottom: 2%; /* Space between blocks */
    }

    .title {
        font-size: 24px;
        text-align: left;
    }

    .stats {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        gap: 1.5rem; /* Jarak antar card */
    }

    .card {
        flex: 1 1 200px; /* Fleksibilitas card */
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 2rem;
        text-align: center;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s, box-shadow 0.3s; /* Efek transisi saat hover */
        cursor: pointer;
    }

    .card:hover {
        transform: translateY(-5px); /* Efek naik saat hover */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Menambah bayangan saat hover */
    }

    .card h3 {
        margin: 0;
        font-size: 2rem;
        color: #007bff; /* Warna yang lebih menarik */
    }

    .card p {
        margin-top: 0.5rem;
        color: #888; /* Warna teks yang lebih lembut */
    }
</style>
@endsection