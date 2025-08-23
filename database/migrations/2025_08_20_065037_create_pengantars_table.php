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
        Schema::create('pengantars', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat')->unique();
            $table->date('tanggal_surat')->nullable();
            $table->string('tujuan')->nullable();   // Yth ...
            $table->string('alamat_tujuan')->nullable();

            // Isi tabel daftar barang/naskah
            $table->json('daftar_item')->nullable();
            // Data penerima
            $table->foreignId('penerima_id')->constrained('pegawais')->onDelete('cascade');
            // Data pengirim
            $table->foreignId('pengirim_id')->constrained('pegawais')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengantars');
    }
};
