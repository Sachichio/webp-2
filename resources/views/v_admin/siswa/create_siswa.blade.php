@extends('v_admin.layouts.admin_master')

@section('content')

<div class="container">
    <!-- Block 1: Title -->
    <div class="title-container">
        <h1 class="title">Tambah Siswa</h1>
    </div>

    <!-- Block 2: Form -->
    <div class="table-container">
        <form action="{{ route('admin.storeSiswa') }}" method="POST">
            @csrf

            <!-- NIS -->
            <div class="form-group">
                <label for="nis" class="form-label">NIS:</label>
                <input type="text" name="nis" id="nis" class="form-input" value="{{ old('nis') }}" required>
                @error('nis')
                    <small class="alert alert-custom-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Nama -->
            <div class="form-group">
                <label for="nama" class="form-label">Nama:</label>
                <input type="text" name="nama" id="nama" class="form-input" value="{{ old('nama') }}" required>
                @error('nama')
                    <small class="alert alert-custom-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Jenis Kelamin -->
            <div class="form-group">
                <label for="gender" class="form-label">Jenis Kelamin:</label>
                <select name="gender" id="gender" class="form-select" required>
                    <option value="" disabled selected>Pilih Jenis Kelamin</option>
                    <option value="Laki-laki" {{ old('gender') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="Perempuan" {{ old('gender') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                </select>
                @error('gender')
                    <small class="alert alert-custom-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Tanggal Lahir -->
            <div class="form-group">
                <label for="tanggal_lahir" class="form-label">Tanggal Lahir:</label>
                <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-input" value="{{ old('tanggal_lahir') }}">
                @error('tanggal_lahir')
                    <small class="alert alert-custom-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Email -->
            <div class="form-group">
                <label for="email" class="form-label">Email:</label>
                <input type="email" name="email" id="email" class="form-input" value="{{ old('email') }}" required>
                @error('email')
                    <small class="alert alert-custom-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Nomor HP -->
            <div class="form-group">
                <label for="hp" class="form-label">Nomor HP:</label>
                <input type="text" name="hp" id="hp" class="form-input" value="{{ old('hp') }}" required>
                @error('hp')
                    <small class="alert alert-custom-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password" class="form-label">Password:</label>
                <input type="password" name="password" id="password" class="form-input" required>
                @error('password')
                    <small class="alert alert-custom-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Alamat -->
            <div class="form-group">
                <label for="alamat" class="form-label">Alamat:</label>
                <textarea name="alamat" id="alamat" class="form-input" rows="3" required>{{ old('alamat') }}</textarea>
                @error('alamat')
                    <small class="alert alert-custom-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Status -->
            <div class="form-group">
                <label for="status" class="form-label">Status:</label>
                <select name="status" id="status" class="form-select" required>
                    <option value="" disabled selected>Pilih Status</option>
                    <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Nonaktif</option>
                </select>
                @error('status')
                    <small class="alert alert-custom-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="btn-group">
                <button type="submit" class="btn btn-primary">Simpan</button>
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
        margin-bottom: 1%;
    }

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
        margin-top: 2%;
        display: flex;
        gap: 5px;
    }
</style>
@endsection
