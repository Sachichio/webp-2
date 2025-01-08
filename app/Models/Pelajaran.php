<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelajaran extends Model
{
    use HasFactory;

    protected $table = 'pelajaran';

    protected $fillable = ['nama_pelajaran', 'jenjang'];

    public function pelajaran()
    {
        return $this->belongsToMany(Pelajaran::class, 'kelas_pelajaran', 'kelas_id', 'pelajaran_id')
            ->withPivot('hari', 'jam_mulai', 'jam_selesai')
            ->withTimestamps();
    }

    public function kelas()
    {
        return $this->belongsToMany(Kelas::class, 'kelas_pelajaran', 'pelajaran_id', 'kelas_id')
            ->withPivot('hari', 'jam_mulai', 'jam_selesai')
            ->withTimestamps();
    }


    public function guru()
    {
        return $this->belongsToMany(Guru::class, 'pelajaran_guru', 'pelajaran_id', 'guru_id')->withTimestamps();
    }
}
