@extends('v_guru.kelas_menu.layout_kelas.kelas_master')

@section('kelas-content')
<!-- Add Task Button -->
<div class="add-button">
    <button class="btn btn-primary" onclick="openModal()">+ Add</button>
</div>

<!-- Tambahkan ini untuk menampilkan error -->
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!-- List of Tasks -->
<div class="list-tugas">
    @if($tugas->isEmpty())
        <p>No tasks added yet.</p>
    @else
        <table class="task-list">
            <thead>
                <tr>
                    <th>Judul</th>
                    <th>Deskripsi</th>
                    <th>Batas Pengumpulan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tugas as $task)
                    <tr>
                        <td><strong>{{ $task->judul }}</strong></td>
                        <td>{{ $task->deskripsi }}</td>
                        <td>{{ $task->batas_pengumpulan }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>


<!-- Modal Window -->
<div id="addTaskModal" class="modal" style="display: none;">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h4>Add New Task</h4>
        <form method="POST" action="{{ route('guru.addTask') }}">
            @csrf
            <input type="hidden" name="kelas_id" value="{{ $kelas->id }}">
            <input type="hidden" name="pelajaran_id" value="{{ $kelasPelajaran->pelajaran_id }}">
            <div class="form-group">
                <label for="judul">Judul:</label>
                <input type="text" name="judul" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="deskripsi">Deskripsi:</label>
                <textarea name="deskripsi" class="form-control" required></textarea>
            </div>
            <div class="form-group">
                <label for="batas_pengumpulan">Batas Pengumpulan:</label>
                <input type="datetime-local" name="batas_pengumpulan" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success">Submit</button>
        </form>

    </div>
</div>
@endsection
<style>
    /* General Styles */
    body {
        font-family: Arial, sans-serif;
        background-color: #f8f9fa;
        margin: 0;
        padding: 20px;
    }

    /* Add Button */
    .add-button {
        margin-bottom: 20px;
    }

    .add-button .btn {
        background-color: #305cde; /* Warna latar belakang */
        color: white; /* Warna teks */
        border: none; /* Menghilangkan border */
        padding: 10px 15px; /* Padding */
        border-radius: 5px; /* Sudut melengkung */
        cursor: pointer; /* Pointer saat hover */
        transition: background-color 0.3s; /* Transisi warna */
    }

    .add-button .btn:hover {
        background-color: #004bb5; /* Warna saat hover */
    }

    /* List of Tasks */
    .list-tugas {
        margin-top: 20px;
    }

    .task-list {
        width: 100%; /* Ukuran tabel diubah menjadi 100% */
        border-collapse: collapse;
        margin: auto; /* Pusatkan tabel */
        font-size: 12px; /* Ukuran teks tabel */
    }

    .task-list th, .task-list td {
        border: 1px solid #ddd;
        padding: 8px;
    }

    .task-list th {
        background-color: white; /* Warna kepala kolom */
        color: black; /* Warna teks kepala kolom */
        text-align: left;
    }

    .task-list tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    .task-list tr:hover {
        background-color: #ddd;
    }

    /* Modal Styles */
    .modal {
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.5);
    }

    .modal-content {
        background-color: #fefefe;
        margin: 15% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        max-width: 500px;
        border-radius: 8px;
    }

    /* Form Styles */
    .form-group {
        margin-bottom: 15px;
    }

    .form-control {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }
</style>
<script>
    function openModal() {
        document.getElementById('addTaskModal').style.display = 'block';
    }

    function closeModal() {
        document.getElementById('addTaskModal').style.display = 'none';
    }
</script>
