@extends('v_admin.layouts.admin_master')

@section('content')

<div class="container">
    <!-- Block 1: Title -->
    <div class="title-container">
        <h1 class="title">Edit Mata Pelajaran</h1>
    </div>

    <!-- Block 2: Table -->
    <div class="table-container">
    <form action="{{ route('admin.updatePelajaran', $pelajaran->id) }}" method="POST" class="form-container">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label for="nama_pelajaran" class="form-label">Nama Mata Pelajaran:</label>
        <input type="text" name="nama_pelajaran" id="nama_pelajaran" class="form-input" value="{{ $pelajaran->nama_pelajaran }}" readonly>
    </div>
    
    <div class="form-group">
        <label for="jenjang" class="form-label">Jenjang:</label>
        <input type="text" name="nama_pelajaran" id="nama_pelajaran" class="form-input" value="{{ $pelajaran->jenjang }}" readonly>
    </div>

    <div class="form-group">
        <label for="guru" class="form-label">Guru Pengajar:</label><small class="form-text text-muted">(Satu mata pelajaran hanya untuk satu guru pada jenjang yang sama)</small>
        <select name="guru" id="guru" class="form-select">
            <option value="">Pilih Guru (Opsional)</option>
            @foreach ($gurus as $guru)
                <option value="{{ $guru->id }}"
                        {{ $pelajaran->guru->pluck('id')->first() == $guru->id ? 'selected' : '' }}
                        {{ $guru->is_disabled ? 'disabled' : '' }}>
                    {{ $guru->nama }} {{ $guru->is_disabled ? '(Tidak Tersedia)' : '' }}
                </option>
            @endforeach
        </select>


        @error('guru')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="btn-group">
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
        font-size: 12px; /* Ukuran font */
    }
</style>
@endsection
