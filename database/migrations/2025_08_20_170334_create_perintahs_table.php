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
        Schema::create('perintahs', function (Blueprint $table) {
            $table->id();

            // Pejabat penandatangan
            $table->foreignId('pegawai_id')->constrained('pegawais')->cascadeOnDelete();

            // Detail surat
            $table->string('nomor_surat')->unique();
            $table->date('tanggal_perintah');
            $table->string('tempat_dikeluarkan');

            // Bagian list
            $table->text('menimbang');
            $table->text('dasar');
            $table->text('untuk');

            // Daftar penerima (banyak pegawai)
            $table->json('penerima');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perintahs');
    }
};
