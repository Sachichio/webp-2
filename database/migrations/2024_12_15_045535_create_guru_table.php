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
        Schema::create('guru', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Relasi dengan user
            $table->string('nip')->unique(); // NIP (untuk username)
            $table->string('nama');
            $table->date('tanggal_lahir')->nullable(); // Mengubah kolom ini menjadi nullable
            $table->string('jenis_kelamin');
            $table->string('hp', 13); // Nomor HP
            $table->text('alamat');  // Alamat
            $table->timestamps();
        
            $table->foreign('user_id')->references('id')->on('user')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guru');
    }
};
