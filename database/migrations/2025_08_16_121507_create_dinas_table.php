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
        Schema::create('dinas', function (Blueprint $table) {
            $table->id();
            $table->string('nomor')->unique();
            $table->string('sifat');
            $table->string('lampiran');
            $table->string('hal');
            $table->date('tanggal_surat');
            $table->string('tempat');
            
            // Kolom untuk penerima surat
            $table->string('kepada_yth');
            $table->string('alamat_tujuan');

            // Relasi ke pegawai yang menandatangani surat
            $table->foreignId('penandatangan_id')->constrained('pegawais')->onDelete('cascade');

            $table->text('tembusan')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dinas');
    }
};
