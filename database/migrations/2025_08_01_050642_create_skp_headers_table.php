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
        Schema::create('skp_headers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pegawai_dinilai_id')->constrained('pegawais')->onDelete('cascade');
            $table->foreignId('pegawai_penilai_id')->constrained('pegawais')->onDelete('cascade');
            $table->foreignId('atasan_pegawai_penilai_id')->constrained('pegawais')->onDelete('cascade');
            $table->year('tahun');
            $table->float('nilai_capaian_skp')->nullable();
            $table->float('nilai_perilaku')->nullable();
            $table->float('nilai_akhir')->nullable();
            $table->string('kategori')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skp_headers');
    }
};
