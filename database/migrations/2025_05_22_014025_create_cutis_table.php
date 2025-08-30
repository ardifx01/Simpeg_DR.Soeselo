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
        Schema::create('cutis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pegawai_id')->constrained()->onDelete('cascade');
            $table->string('nip')->nullable();
            $table->string('nama_jabatan')->nullable();
            $table->string('unit_kerja')->nullable();
            $table->string('jenis_cuti');
            $table->string('alasan')->nullable();
            $table->string('alasan_lainnya')->nullable();
            $table->integer('lama_hari')->nullable();
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->string('alamat_cuti')->nullable();
            $table->string('telepon')->nullable();
            $table->foreignId('atasan_id')->nullable()->constrained('pegawais')->onDelete('set null');
            $table->string('atasan_nama')->nullable();
            $table->string('atasan_nip')->nullable();
            $table->string('atasan_jabatan')->nullable();
            // $table->enum('status', ['diproses', 'disetujui', 'ditolak'])->default('diproses');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cutis');
    }
};
