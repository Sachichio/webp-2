<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KelasPelajaran extends Model
{
    use HasFactory;

    protected $table = 'kelas_pelajaran';

    protected $fillable = [
        'kelas_id',
        'pelajaran_id',
        'hari',
        'jam_mulai',
        'jam_selesai',
        'status',
    ];

    // Relasi ke model Kelas
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    // Relasi ke model Pelajaran
    public function pelajaran()
    {
        return $this->belongsTo(Pelajaran::class, 'pelajaran_id');
    }
}
