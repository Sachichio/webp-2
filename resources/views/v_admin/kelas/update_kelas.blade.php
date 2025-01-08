@extends('v_admin.layouts.admin_master')

@section('content')

<div class="container">
    <!-- Title -->
    <div class="title-container">
        <h1 class="title">Edit Kelas</h1>
    </div>

    <!-- Form -->
    <div class="table-container">
        <form action="{{ route('admin.updateKelas', $kelas->id) }}" method="POST" class="form-container">
            @csrf
            @method('PUT')

            <!-- Nama Kelas -->
            <div class="form-group">
                <label for="nama_kelas" class="form-label">Nama Kelas:</label>
                <input type="text" id="nama_kelas" readonly name="nama_kelas" class="form-input" value="{{ $kelas->nama_kelas }}" required>
            </div>

            <!-- Jenjang -->
            <div class="form-group">
                <label for="jenjang" class="form-label">Jenjang:</label>
                <input type="text" id="jenjang" readonly name="jenjang" class="form-input" value="{{ $kelas->jenjang }}" required>
            </div>

            <!-- Siswa -->
            <div class="form-group">
                <label for="siswa" class="form-label">Siswa:</label>
                <select id="siswa" name="siswa[]" class="form-select" multiple>
                    @foreach ($siswaList as $siswa)
                        <option value="{{ $siswa->id }}" {{ $kelas->siswa->pluck('id')->contains($siswa->id) ? 'selected' : '' }}>
                            {{ $siswa->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Wali Kelas -->
            <div class="form-group">
                <label for="wali_kelas" class="form-label">Wali Kelas:</label>
                <select id="wali_kelas" name="wali_kelas" class="form-select">
                    <option value="">Pilih Wali Kelas</option>
                    @foreach ($guruList as $guru)
                        <option value="{{ $guru->id }}" {{ optional($kelas->guru->first())->id == $guru->id ? 'selected' : '' }}>
                            {{ $guru->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Jadwal Pelajaran -->
            <div class="form-group">
                <label for="jadwal" class="form-label">Jadwal Pelajaran:</label>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Pilih</th>
                            <th>Mata Pelajaran</th>
                            <th>Hari</th>
                            <th>Jam Mulai</th>
                            <th>Jam Selesai</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($jadwalList as $jadwal)
                            @php
                                $errorKey = "jadwal.{$jadwal['pelajaran_id']}";
                            @endphp
                            <tr>
                                <!-- Checkbox -->
                                <td>
                                    <input type="hidden" name="jadwal[{{ $jadwal['pelajaran_id'] }}][selected]" value="0">
                                    <input type="checkbox" name="jadwal[{{ $jadwal['pelajaran_id'] }}][selected]" value="1" {{ !empty($jadwal['hari']) ? 'checked' : '' }}>
                                </td>

                                <!-- Nama Pelajaran -->
                                <td>{{ $jadwal['nama_pelajaran'] }}</td>

                                <!-- Hari -->
                                <td>
                                    <select name="jadwal[{{ $jadwal['pelajaran_id'] }}][hari]" class="form-control">
                                        <option value="">Pilih Hari</option>
                                        <option value="Senin" {{ $jadwal['hari'] === 'Senin' ? 'selected' : '' }}>Senin</option>
                                        <option value="Selasa" {{ $jadwal['hari'] === 'Selasa' ? 'selected' : '' }}>Selasa</option>
                                        <option value="Rabu" {{ $jadwal['hari'] === 'Rabu' ? 'selected' : '' }}>Rabu</option>
                                        <option value="Kamis" {{ $jadwal['hari'] === 'Kamis' ? 'selected' : '' }}>Kamis</option>
                                        <option value="Jumat" {{ $jadwal['hari'] === 'Jumat' ? 'selected' : '' }}>Jumat</option>
                                    </select>
                                </td>

                                <!-- Jam Mulai -->
                                <td>
                                    <input type="time" name="jadwal[{{ $jadwal['pelajaran_id'] }}][jam_mulai]" value="{{ $jadwal['jam_mulai'] }}" class="form-control">
                                </td>

                                <!-- Jam Selesai -->
                                <td>
                                    <input type="time" name="jadwal[{{ $jadwal['pelajaran_id'] }}][jam_selesai]" value="{{ $jadwal['jam_selesai'] }}" class="form-control">
                                </td>
                            </tr>
                            @if ($errors->has($errorKey))
                                <tr>
                                    <td colspan="5">
                                        <div class="alert alert-danger">
                                            {{ $errors->first($errorKey) }}
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>



            <!-- Buttons -->
            <div class="form-group mt-4">
                <button type="submit" class="btn btn-primary">Update</button>
                <button type="button" class="btn btn-danger" onclick="window.history.back()">Batal</button>
            </div>
        </form>
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
        margin: 0 0 2% 3%;
        padding: 0;
    }

    .title-container,
    .table-container {
        display: inline-block;
        width: 100%;
        background-color: #d4d4d4;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        padding: 2%;
    }

    .table-container {
        margin-top: 2%;
        padding-top: 3%;
    }

    .title {
        font-size: 24px;
        text-align: left;
    }

    /* Form styling */
    .form-group {
        margin-bottom: 1%;    }

    .form-label {
        font-size: 12px;
        margin-bottom: 5px;
    }

    .form-input,
    .form-select {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        box-sizing: border-box;
    }

    .form-input:focus,
    .form-select:focus {
        outline: none;
        border-color: #305cde;
    }

    /* Button styling */
    .btn {
        font-size: 12px;
        border: none;
        cursor: pointer;
    }

    .btn-primary {
        padding: 10px 12px;
        background-color: #305cde;
        color: white;
    }

    .btn-primary:hover {
        background-color: #004b9f;
    }

    .btn-danger {
        padding: 10px 22px;
        background-color: #dc3545;
        color: white;
    }

    .btn-danger:hover {
        background-color: #c82333;
    }

    /* Button group styling */
    .btn-group {
        display: flex;
        gap: 5px;
        margin-top: 2%;
    }
    .alert-custom-danger {
        font-size: 8px; /* Ukuran font */
    }
    .table {
        width: 100%; /* Mengatur lebar tabel 100% dari kontainer */
        border-collapse: collapse; /* Menghilangkan jarak antara border sel */
        font-size: 12px; /* Mengatur ukuran font menjadi lebih kecil */
        margin-bottom: 2%;
    }

    .table th, .table td {
        border: 1px solid #ddd; /* Menambahkan border pada sel */
        padding: 8px; /* Menambahkan padding di dalam sel */
        text-align: left; /* Mengatur teks rata kiri */
    }

    .table th {
        background-color: #f2f2f2; /* Warna latar belakang untuk header */
        font-weight: bold; /* Membuat teks header menjadi tebal */
    }

    .table tr:nth-child(even) {
        background-color: #f9f9f9; /* Warna latar belakang untuk baris genap */
    }

    .table tr:hover {
        background-color: #f1f1f1; /* Warna latar belakang saat hover */
    }

    .form-control {
        font-size: 12px; /* Mengatur ukuran font untuk input dan select */
    }
</style>
@endsection
