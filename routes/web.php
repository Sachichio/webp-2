<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\SiswaController;
use Illuminate\Support\Facades\Route;


// ROUTE HALAMAN LOGIN & LOGOUT
Route::get('/', [LoginController::class, 'showLoginForm'])->name('home');
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ROUTE ADMIN DASHBOARD
Route::middleware(['auth'])->group(function () {
    Route::get('admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
});

// ROUTE ADMIN PROFILE PICTURE
Route::middleware(['auth'])->group(function () {
    Route::get('admin/profile', [AdminController::class, 'profile'])->name('admin.profile');
    Route::put('admin/profile/update', [AdminController::class, 'updateProfile'])->name('admin.profile.update');
    Route::delete('admin/profile/destroyPhoto', [AdminController::class, 'destroyPhoto'])->name('admin.profile.destroyPhoto');
});

// ROUTE ADMIN (GURU)
Route::get('admin/guru', [AdminController::class, 'manajemenGuru'])->name('admin.manajemenGuru');
Route::get('admin/guru/create', [AdminController::class, 'createGuru'])->name('admin.createGuru');
Route::post('admin/guru', [AdminController::class, 'storeGuru'])->name('admin.storeGuru');
Route::get('admin/guru/{id}/edit', [AdminController::class, 'editGuru'])->name('admin.editGuru');
Route::put('admin/guru/{id}', [AdminController::class, 'updateGuru'])->name('admin.updateGuru');
Route::delete('/guru/{id}', [AdminController::class, 'deleteGuru'])->name('admin.deleteGuru');

// ROUTE ADMIN (SISWA)
Route::get('admin/siswa', [AdminController::class, 'manajemenSiswa'])->name('admin.manajemenSiswa');
Route::get('admin/siswa/create', [AdminController::class, 'createSiswa'])->name('admin.createSiswa');
Route::post('admin/siswa', [AdminController::class, 'storeSiswa'])->name('admin.storeSiswa');
Route::get('admin/siswa/{id}/edit', [AdminController::class, 'editSiswa'])->name('admin.editSiswa');
Route::put('/admin/siswa/{id}', [AdminController::class, 'updateSiswa'])->name('admin.updateSiswa');
Route::delete('/siswa/{id}', [AdminController::class, 'deleteSiswa'])->name('admin.deleteSiswa');

// ROUTE ADMIN (MATA PELAJARAN)
Route::get('admin/pelajaran', [AdminController::class, 'manajemenPelajaran'])->name('admin.manajemenPelajaran');
Route::get('admin/pelajaran/create', [AdminController::class, 'createPelajaran'])->name('admin.createPelajaran');
Route::post('admin/pelajaran', [AdminController::class, 'storePelajaran'])->name('admin.storePelajaran');
Route::get('admin/pelajaran/{id}/edit', [AdminController::class, 'editPelajaran'])->name('admin.editPelajaran');
Route::put('admin/pelajaran/{id}', [AdminController::class, 'updatePelajaran'])->name('admin.updatePelajaran');
Route::delete('admin/pelajaran/{id}', [AdminController::class, 'deletePelajaran'])->name('admin.deletePelajaran');

// ROUTE ADMIN (MANAJEMEN KELAS)
Route::get('admin/kelas', [AdminController::class, 'manajemenKelas'])->name('admin.manajemenKelas');
Route::get('admin/kelas/create', [AdminController::class, 'createKelas'])->name('admin.createKelas');
Route::post('admin/kelas', [AdminController::class, 'storeKelas'])->name('admin.storeKelas');
Route::get('admin/kelas/{id}/edit', [AdminController::class, 'editKelas'])->name('admin.editKelas');
Route::put('admin/kelas/{id}', [AdminController::class, 'updateKelas'])->name('admin.updateKelas');
Route::delete('admin/kelas/{id}', [AdminController::class, 'deleteKelas'])->name('admin.deleteKelas');

// ROUTE GURU DASHBOARD
Route::middleware(['auth'])->group(function () {
    Route::get('guru/dashboard', [GuruController::class, 'dashboard'])->name('guru.dashboard');
});

// ROUTE GURU PROFILE PICTURE
Route::middleware(['auth'])->group(function () {
    Route::get('guru/profile', [GuruController::class, 'profile'])->name('guru.profile');
    Route::put('guru/profile/update', [GuruController::class, 'updateProfile'])->name('guru.profile.update');
    Route::delete('guru/profile/destroyPhoto', [GuruController::class, 'destroyPhoto'])->name('guru.profile.destroyPhoto');
});

// ROUTE GURU (KELAS TERDAFTAR)
Route::get('/guru/kelas-terdaftar', [GuruController::class, 'kelasList'])->name('guru.kelas_terdaftar');
Route::get('/guru/kelas/{kelasPelajaranId}/master', [GuruController::class, 'kelasMaster'])->name('guru.kelas.master');
Route::get('/guru/kelas/{kelas_id}/siswa', [GuruController::class, 'kelasSiswa'])->name('guru.kelas.siswa');
Route::get('/guru/kelas/{kelas_id}/absen', [GuruController::class, 'kelasAbsen'])->name('guru.kelas.absen');
Route::get('/guru/kelas/{kelas_id}/tugas', [GuruController::class, 'kelasTugas'])->name('guru.kelas.tugas');
Route::get('/guru/kelas/{kelas_id}/wali', [GuruController::class, 'waliKelas'])->name('guru.kelas.wali');

















//ROUTE SISWA DASHBOARD
Route::middleware(['auth'])->group(function () {
    Route::get('siswa/dashboard', [SiswaController::class, 'dashboard'])->name('siswa.dashboard');
});

// ROUTE SISWA PROFILE PICTURE
Route::middleware(['auth'])->group(function () {
    Route::get('siswa/profile', [SiswaController::class, 'profile'])->name('siswa.profile');
    Route::put('siswa/profile/update', [SiswaController::class, 'updateProfile'])->name('siswa.profile.update');
    Route::delete('siswa/profile/destroyPhoto', [SiswaController::class, 'destroyPhoto'])->name('siswa.profile.destroyPhoto');
});