@extends('v_guru.kelas_menu.layout_kelas.kelas_master')

@section('kelas-content')
    
<!-- Block 1: Table Absensi -->
<div class="table-container mb-5">
    <h4>Table Absensi</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Tanggal</th>
                <th>Pelajaran</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <!-- Kosongkan untuk pengujian -->
            <tr>
                <td colspan="5" class="text-center">Data absensi belum tersedia.</td>
            </tr>
        </tbody>
    </table>
</div>

<!-- Block 2: Table Rekap Absensi -->
<div class="table-container">
    <h4>Table Rekap Absensi</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Kelas</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <!-- Kosongkan untuk pengujian -->
            <tr>
                <td colspan="4" class="text-center">Data rekap absensi belum tersedia.</td>
            </tr>
        </tbody>
    </table>
</div>

@endsection
