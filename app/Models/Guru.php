<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;

    protected $table = 'guru';

    protected $fillable = ['user_id', 'nip', 'nama', 'tanggal_lahir', 'jenis_kelamin', 'hp', 'alamat'];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function kelas()
    {
        return $this->belongsToMany(Kelas::class, 'kelas_guru', 'guru_id', 'kelas_id')->withTimestamps();
    }

    // Relasi dengan tabel pelajaran
    public function pelajaran()
    {
        return $this->belongsToMany(Pelajaran::class, 'pelajaran_guru', 'guru_id', 'pelajaran_id')->withTimestamps();
    }
    public function materi()
    {
        return $this->hasMany(Materi::class);
    }
    public function kelas_guru()
    {
        return $this->belongsToMany(Kelas::class, 'kelas_guru', 'guru_id', 'kelas_id')->withTimestamps();
    }

}
