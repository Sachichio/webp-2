@extends('v_guru.layouts.guru_master')

@section('title', 'Profil Saya')

@section('content')

<div class="container">
    <div class="title-container">
        <h1 class="title">My Profile</h1>
    </div>
    <div class="table-container">
        <form action="{{ route('guru.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="profile-wrapper">
                <div class="profile-left">
                    <div class="foto-preview-container">
                        <!-- Menampilkan foto profil guru -->
                        <img src="{{ file_exists(public_path('uploads/profile/guru/' . Auth::user()->username . '/' . Auth::user()->foto)) 
                            ? asset('uploads/profile/guru/' . Auth::user()->username . '/' . Auth::user()->foto) . '?timestamp=' . time() 
                            : asset('uploads/profile/default.jpg') }}" 
                            alt="Guru Profile Picture" class="foto-preview">

                        <input type="file" name="foto" class="form-control @error('foto') is-invalid @enderror">
                        @error('foto')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <button type="submit" class="btn btn-primary">Update</button>

                        <!-- Tombol Hapus Foto Guru -->
                        @if ($user->foto != 'default.jpg')
                            <button type="button" class="btn btn-danger" onclick="deletePhoto()">Hapus Foto</button>
                        @endif
                    </div>
                </div>

                <div class="profile-right">
                    <!-- Form Input Data Guru -->
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" name="nama" value="{{ old('nama', $guru->nama) }}" class="form-control @error('nama') is-invalid @enderror">
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control @error('email') is-invalid @enderror">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="username" value="{{ old('username', $user->username) }}" class="form-control @error('username') is-invalid @enderror">
                        @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Password Baru</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>No. HP</label>
                        <input type="text" name="hp" value="{{ old('hp', $guru->hp) }}" class="form-control @error('hp') is-invalid @enderror">
                        @error('hp')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
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
        margin: 0 0 0 3%;
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
        margin-bottom: 2%;
    }

    .title {
        font-size: 24px;
        text-align: left;
    }

    .profile-wrapper {
        display: flex;
        flex-wrap: wrap;
    }

    /* Profile Left Section */
    .profile-left {
        flex: 1;
        padding: 20px;
        border-right: 1px solid #ffffff;
        text-align: left;
        align-items: left;
    }

    .foto-preview {
        width: 100%;
        max-width: 180px;
        height: 180px;
        object-fit: cover;
        margin-bottom: 10px;
    }

    .form-control {
        margin-top: 10px;
    }

    .btn {
        margin-top: 10px;
        width: 100%;
        font-size: 12px;
        border: none;
        cursor: pointer;
    }

    .btn-primary {
        padding: 7px;
        background-color: #305cde;
        color: white;
    }

    .btn-secondary {
        background-color: #6c757d;
        color: white;
        padding: 7px
    }

    .btn-secondary:hover {
        background-color: #5a6268;
    }

    .btn-danger {
        padding: 7px;
        background-color: #dc3545;
        color: white;
    }

    .btn-danger:hover {
        background-color: #c82333;
    }

    /* Profile Right Section */
    .profile-right {
        flex: 2;
        padding: 2%;
    }

    .form-group {
        margin-bottom: 1%;
    }

    label {
        font-size: 12px;
        margin-bottom: 5px;
    }

    input, select {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        box-sizing: border-box;
    }

    input:focus,
    select:focus {
        outline: none;
        border-color: #305cde;
    }

    .invalid-feedback {
        color: red;
        font-size: 12px;
        margin-top: 5px;
    }

    /* Responsiveness */
    @media (max-width: 768px) {
        .profile-wrapper {
            flex-direction: column;
        }

        .profile-left {
            border-right: none;
            border-bottom: 1px solid #ddd;
        }
    }

    @media (max-width: 480px) {
        .profile-title {
            font-size: 22px;
        }

        input, select {
            padding: 8px;
        }

        label {
            font-size: 14px;
        }
    }

</style>

<script>
    function deletePhoto() {
        if (confirm('Apakah Anda yakin ingin menghapus foto ini?')) {
            fetch("{{ route('guru.profile.destroyPhoto') }}", {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }).then(response => {
                if (response.ok) {
                    // Perbarui tampilan foto di profile menu
                    const fotoPreview = document.querySelector('.foto-preview');
                    const profilePic = document.querySelector('.profile-pic');
                    const defaultFotoPath = "{{ asset('uploads/profile/default.jpg') }}";

                    if (fotoPreview) {
                        fotoPreview.src = defaultFotoPath + "?timestamp=" + new Date().getTime(); // Bypass cache
                    }

                    if (profilePic) {
                        profilePic.src = defaultFotoPath + "?timestamp=" + new Date().getTime(); // Bypass cache
                    }

                    // Sembunyikan tombol Hapus Foto
                    const deleteButton = document.querySelector('#delete-photo');
                    if (deleteButton) {
                        deleteButton.style.display = 'none'; // Sembunyikan tombol
                    }

                    alert('Foto berhasil dihapus');
                } else {
                    alert('Gagal menghapus foto');
                }
            }).catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan. Silakan coba lagi.');
            });
        }
    }
</script>



@endsection

