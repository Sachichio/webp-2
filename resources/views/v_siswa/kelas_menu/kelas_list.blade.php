@extends('v_siswa.layouts.siswa_master')

@section('title', 'Kelas Terdaftar - SMP Anak Bangsa')

@section('content')
<div class="container">
    <div class="title-container">
        <h1 class="title">Kelas Terdaftar</h1>
        <p>Berikut, Mata Pelajaran Anda</p>
    </div>

    <div class="table-container">
        <div class="class-grid">
            @forelse ($kelasSiswa as $kelas)
                <div class="class-card">
                    <h5 class="class-title">Kelas {{ $kelas->nama_kelas }} (Jenjang {{ $kelas->jenjang }})</h5>
                    
                    <div class="subjects-grid">
                        @foreach ($kelas->kelasPelajaran as $kelasPelajaran)
                            <div class="subject-card">
                                <h6 class="subject-name">{{ $kelasPelajaran->pelajaran->nama_pelajaran }}</h6>
                                <div class="schedule-info">
                                    <span class="schedule-day">{{ $kelasPelajaran->hari }}</span>
                                    <span class="schedule-time">{{ $kelasPelajaran->jam_mulai }} - {{ $kelasPelajaran->jam_selesai }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <div class="alert alert-warning" role="alert">
                        Anda belum terdaftar di kelas manapun.
                    </div>
                </div>
            @endforelse
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
        max-width: 1200px;
        width: 90%;
        margin: 0 auto;
        padding: 20px;
    }

    /* Title and Section Styling - Maintained from original */
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

    /* New Card Layout Styling */
    .class-grid {
        display: grid;
        gap: 25px;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    }

    .class-card {
        background-color: #f8f9fa;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .class-title {
        font-size: 18px;
        color: #305cde;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 1px solid #dee2e6;
    }

    .subjects-grid {
        display: grid;
        gap: 15px;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    }

    .subject-card {
        background-color: #ffffff;
        border-radius: 8px;
        padding: 15px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        cursor: pointer;
        border: 1px solid #dee2e6;
    }

    .subject-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        background-color: #f8f9fa;
    }

    .subject-name {
        font-size: 16px;
        color: #305cde;
        margin-bottom: 10px;
        font-weight: 600;
    }

    .schedule-info {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .schedule-day {
        color: #666;
        font-size: 14px;
        font-weight: 500;
    }

    .schedule-time {
        color: #888;
        font-size: 13px;
    }

    .empty-state {
        grid-column: 1 / -1;
    }

    /* Alert Styling - Maintained from original */
    .alert-warning {
        background-color: #fce4e4;
        color: #e60000;
        font-weight: bold;
        text-align: center;
        padding: 15px;
        border-radius: 5px;
        border: 1px solid #e60000;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .class-grid {
            grid-template-columns: 1fr;
        }
        
        .subjects-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection