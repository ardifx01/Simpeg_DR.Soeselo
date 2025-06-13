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
        Schema::create('arsips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pegawai_id')->constrained('pegawais')->onDelete('cascade');
            $table->enum('jenis', [
                'SK CPNS', 
                'Surat Tugas', 
                'Surat Menghadapkan', 
                'Ijazah Pendidikan', 
                'Surat Nikah', 
                'KTP', 
                'NPWP', 
                'Kartu Keluarga', 
                'Akta Lahir Keluarga', 
                'Pas Photo', 
                'FIP', 
                'Konversi NIP', 
                'SK PNS', 
                'SK Kenaikan Pangkat', 
                'KPE', 
                'Karpeg', 
                'Taspen', 
                'Karis / Karsu', 
                'SK Mutasi BKN / Gubernur', 
                'ASKES / BPJS', 
                'STTPL', 
                'Sumpah Jabatan PNS', 
                'KGB', 
                'Rekomendasi Ijin Belajar', 
                'Ijin Belajar', 
                'Penggunaan Gelar', 
                'Ujian Dinas', 
                'Penyesuaian Ijazah']);
            $table->string('file')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('arsips');
    }
};
