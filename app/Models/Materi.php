<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materi extends Model
{
    use HasFactory;

    protected $fillable = ['kelas_id', 'pelajaran_id', 'guru_id', 'judul', 'deskripsi', 'file_path'];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function pelajaran()
    {
        return $this->belongsTo(Pelajaran::class);
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }
}
