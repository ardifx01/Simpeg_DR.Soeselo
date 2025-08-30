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
            $table->foreignId('pegawai_id')->constrained('pegawais')->cascadeOnDelete();
            $table->string('nomor_surat')->unique();
            $table->date('tanggal_perintah');
            $table->string('tempat_dikeluarkan');
            $table->text('menimbang');
            $table->text('dasar');
            $table->text('untuk');
            $table->json('penerima');
            $table->softDeletes();
            $table->timestamps();
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
