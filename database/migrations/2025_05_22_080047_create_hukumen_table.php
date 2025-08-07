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
        Schema::create('hukumen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pegawai_id')->constrained()->onDelete('cascade');
            $table->string('bentuk_pelanggaran');
            $table->string('waktu');
            $table->string('tempat');
            $table->text('faktor_meringankan');
            $table->text('faktor_memberatkan');
            $table->text('dampak');
            $table->string('pwkt');
            $table->string('no');
            $table->year('tahun');
            $table->string('pasal');
            $table->text('tentang');
            $table->string('jenis_hukuman');
            $table->text('keterangan_hukuman');
            $table->text('peraturan');
            $table->string('hari');
            $table->date('tanggal');
            $table->time('jam');
            $table->foreignId('atasan_id')->nullable()->constrained('pegawais')->onDelete('set null');
            $table->string('atasan_nama')->nullable();
            $table->string('atasan_jabatan')->nullable();
            $table->string('atasan_nip')->nullable();
            $table->string('atasan_pangkat')->nullable();
            $table->string('atasan_golongan_ruang')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hukumen');
    }
};
