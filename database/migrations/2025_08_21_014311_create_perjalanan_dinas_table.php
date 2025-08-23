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
        Schema::create('perjalanan_dinas', function (Blueprint $table) {
            $table->id();
            $table->string('lembar_ke')->nullable();
            $table->string('kode_no')->nullable();
            $table->string('nomor')->unique();
            $table->foreignId('kuasa_pengguna_anggaran_id')->constrained('pegawais')->onDelete('cascade');
            $table->foreignId('pegawai_id')->constrained('pegawais')->onDelete('cascade');
            $table->string('tingkat_biaya');
            $table->text('maksud_perjalanan');
            $table->string('alat_angkut');
            $table->string('tempat_berangkat');
            $table->string('tempat_tujuan');
            $table->integer('lama_perjalanan');
            $table->date('tanggal_berangkat');
            $table->date('tanggal_kembali');
            $table->json('pengikut')->nullable()->comment('Array of objects: [{nama, tgl_lahir, keterangan}]');
            $table->string('skpd_pembebanan');
            $table->string('kode_rekening_pembebanan');
            $table->text('keterangan_lain')->nullable();
            $table->date('tanggal_dikeluarkan');

            // --- KOLOM BARU UNTUK RIWAYAT PERJALANAN ---
            $table->json('riwayat_perjalanan')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perjalanan_dinas');
    }
};
