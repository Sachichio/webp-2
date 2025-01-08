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
        Schema::create('kelas_pelajaran', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kelas_id'); // Relasi dengan tabel kelas
            $table->unsignedBigInteger('pelajaran_id'); // Relasi dengan tabel pelajaran
            $table->string('hari'); // Hari dalam jadwal (misal: Senin, Selasa, dst)
            $table->time('jam_mulai'); // Waktu mulai kelas
            $table->time('jam_selesai'); // Waktu selesai kelas
            $table->enum('status', ['buka', 'tutup'])->default('tutup');
            $table->timestamps();
        
            $table->foreign('kelas_id')->references('id')->on('kelas')->onDelete('cascade');
            $table->foreign('pelajaran_id')->references('id')->on('pelajaran')->onDelete('cascade');
        });
        
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelas_pelajaran');
    }
};
