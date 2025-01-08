<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('materi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kelas_id'); // Relasi dengan tabel kelas
            $table->unsignedBigInteger('pelajaran_id'); // Relasi dengan tabel pelajaran
            $table->unsignedBigInteger('guru_id'); // Relasi dengan tabel guru
            $table->string('judul'); // Judul materi
            $table->text('deskripsi')->nullable(); // Deskripsi materi (opsional)
            $table->string('file_path'); // Lokasi file materi
            $table->timestamps();
        
            $table->foreign('kelas_id')->references('id')->on('kelas')->onDelete('cascade');
            $table->foreign('pelajaran_id')->references('id')->on('pelajaran')->onDelete('cascade');
            $table->foreign('guru_id')->references('id')->on('guru')->onDelete('cascade');
        });
        
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materi');
    }
};
