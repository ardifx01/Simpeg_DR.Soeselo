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
        Schema::create('pernyataans', function (Blueprint $table) {
            $table->id();

            $table->string('nomor_surat')->unique();
            $table->date('tanggal_surat')->nullable();
            $table->string('tempat_surat')->nullable();

            $table->foreignId('pejabat_id')->nullable()->constrained('pegawais')->nullOnDelete();
            $table->foreignId('pegawai_id')->constrained('pegawais')->cascadeOnDelete();

            $table->string('peraturan_tugas')->nullable();
            $table->string('nomor_peraturan')->nullable();
            $table->Integer('tahun_peraturan')->nullable();
            $table->string('tentang_peraturan')->nullable();
            $table->date('tanggal_mulai_tugas')->nullable();
            $table->string('jabatan_tugas')->nullable();
            $table->string('lokasi_tugas')->nullable();

            $table->json('tembusan')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pernyataans');
    }
};
