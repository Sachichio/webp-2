@extends('v_siswa.layouts.siswa_master')

@section('title', 'Dashboard Siswa')

@section('content')
    <h1>Welcome, {{ Auth::user()->siswa->nama }}</h1>
    <p>Halaman Dashboard Siswa</p>
@endsection