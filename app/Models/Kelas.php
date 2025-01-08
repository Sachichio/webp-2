<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $table = 'kelas';

    protected $fillable = ['nama_kelas', 'jenjang'];

    public function siswa()
    {
        return $this->belongsToMany(Siswa::class, 'kelas_siswa', 'kelas_id', 'siswa_id')->withTimestamps();
    }

    public function guru()
    {
        return $this->belongsToMany(Guru::class, 'kelas_guru', 'kelas_id', 'guru_id')->withTimestamps();
    }

    public function pelajaran()
    {
        return $this->belongsToMany(Pelajaran::class, 'kelas_pelajaran', 'kelas_id', 'pelajaran_id')
            ->withPivot('hari', 'jam_mulai', 'jam_selesai')
            ->withTimestamps();
    }

    public function absensi()
    {
        return $this->hasMany(Absen::class, 'kelas_id');
    }

    public function tugas()
    {
        return $this->hasMany(Tugas::class, 'kelas_id');
    }
    public function kelasPelajaran()
    {
        return $this->hasMany(KelasPelajaran::class, 'kelas_id', 'id');
    }
}
