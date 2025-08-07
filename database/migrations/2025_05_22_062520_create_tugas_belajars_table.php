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
        Schema::create('tugas_belajars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pegawai_id')->constrained()->onDelete('cascade');
            $table->string('program');
            $table->string('lembaga');
            $table->string('fakultas');
            $table->string('program_studi');
            $table->foreignId('atasan_id')->nullable()->constrained('pegawais')->onDelete('set null');
            $table->string('atasan_nama')->nullable();
            $table->string('atasan_nip')->nullable();
            $table->string('atasan_pangkat')->nullable();
            $table->string('atasan_golongan_ruang')->nullable();
            $table->string('atasan_jabatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tugas_belajars');
    }
};
