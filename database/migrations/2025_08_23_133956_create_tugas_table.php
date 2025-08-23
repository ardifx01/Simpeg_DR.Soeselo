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
        Schema::create('tugas', function (Blueprint $table) {
            $table->id();

            $table->string('nomor')->unique();
            $table->string('tempat_dikeluarkan');
            $table->date('tanggal_dikeluarkan');

            $table->text('dasar');
            $table->text('untuk');

            $table->foreignId('penandatangan_id')->constrained('pegawais')->onDelete('cascade');

            $table->json('pegawai');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tugas');
    }
};
