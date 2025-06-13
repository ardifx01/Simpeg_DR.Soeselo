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
            $table->string('faktor_meringankan');
            $table->string('faktor_memberatkan');
            $table->string('dampak');
            $table->string('pwkt');
            $table->string('no');
            $table->string('tahun');
            $table->string('pasal');
            $table->string('tentang');
            $table->string('jenis_hukuman');
            $table->string('keterangan_hukuman');
            $table->string('peraturan');
            $table->string('hari');
            $table->date('tanggal');
            $table->string('jam');
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
