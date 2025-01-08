<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengumpulanTugas extends Model
{
    use HasFactory;

    protected $table = 'pengumpulan_tugas';

    protected $fillable = ['tugas_id', 'siswa_id', 'waktu_pengumpulan', 'file_tugas', 'status'];

    protected $casts = [
        'waktu_pengumpulan' => 'datetime',
        'status' => 'boolean',
    ];

    public function tugas()
    {
        return $this->belongsTo(Tugas::class, 'tugas_id');
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }
}
