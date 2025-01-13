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
        Schema::create('tugas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kelas_id');
            $table->unsignedBigInteger('pelajaran_id');
            $table->string('judul'); // Judul tugas
            $table->text('deskripsi'); // Deskripsi tugas
            $table->datetime('batas_pengumpulan'); // Tanggal terakhir pengumpulan
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
        Schema::dropIfExists('tugas');
    }
};
