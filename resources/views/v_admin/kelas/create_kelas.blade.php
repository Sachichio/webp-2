@extends('v_admin.layouts.admin_master')

@section('content')

<div class="container">
    <!-- Block 1: Title -->
    <div class="title-container">
        <h1 class="title">Tambah Kelas</h1>
    </div>

    <!-- Block 2: Form -->
    <div class="table-container">
        <form action="{{ route('admin.storeKelas') }}" method="POST" class="form-container">
            @csrf
            <div class="form-group">
                <label for="nama_kelas" class="form-label">Nama Kelas:</label><small class="form-text text-muted">(7A, 8B, 9C, dst. (Angka 7, 8, atau 9 diikuti huruf A-Z)).</small>
                <input type="text" name="nama_kelas" id="nama_kelas" class="form-input" value="{{ old('nama_kelas') }}" required>
                @error('nama_kelas')
                    <div class="alert alert-custom-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="jenjang" class="form-label">Jenjang:</label>
                <select name="jenjang" id="jenjang" class="form-select" required>
                    <option value="1" {{ old('jenjang') == 1 ? 'selected' : '' }}>Jenjang 1 (Kelas 7)</option>
                    <option value="2" {{ old('jenjang') == 2 ? 'selected' : '' }}>Jenjang 2 (Kelas 8)</option>
                    <option value="3" {{ old('jenjang') == 3 ? 'selected' : '' }}>Jenjang 3 (Kelas 9)</option>
                </select>
                @error('jenjang')
                    <div class="alert alert-custom-danger">{{ $message }}</div>
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

    .alert-custom-danger {
        font-size: 12px; /* Ukuran font */
    }

</style>
@endsection
