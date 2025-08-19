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
        Schema::create('berita_acaras', function (Blueprint $table) {
            $table->id();
            $table->string('nomor')->unique();
            $table->string('hari');
            $table->date('tanggal');
            $table->string('tempat');
            $table->foreignId('pihak_pertama_id')->constrained('pegawais')->onDelete('cascade');
            $table->foreignId('pihak_kedua_id')->nullable()->constrained('pegawais')->onDelete('cascade');
            $table->foreignId('atasan_id')->nullable()->constrained('pegawais')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('berita_acaras');
    }
};
