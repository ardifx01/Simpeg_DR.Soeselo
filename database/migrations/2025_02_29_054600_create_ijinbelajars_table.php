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
        Schema::create('ijinbelajars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pegawai_id')->constrained('pegawais')->onDelete('cascade');
            $table->string('tingkat_ijin');
            $table->string('jenis_ijin');
            $table->string('nama_ijin');
            $table->year('tahun_lulus_ijin');
            $table->string('no_ijazah_ijin');
            $table->date('tanggal_ijazah_ijin');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ijinbelajars');
    }
};
