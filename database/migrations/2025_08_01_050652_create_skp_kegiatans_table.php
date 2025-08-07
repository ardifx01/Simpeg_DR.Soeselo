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
        Schema::create('skp_kegiatans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('skp_header_id')->constrained('skp_headers')->onDelete('cascade');
            $table->string('jenis_kegiatan');
            $table->string('nama_kegiatan');
            $table->string('ak')->nullable();
            
            // Target dan Realisasi
            $table->string('target_kuantitatif_output');
            $table->string('realisasi_kuantitatif_output')->nullable();
            $table->float('target_kualitatif_mutu');
            $table->float('realisasi_kualitatif_mutu')->nullable();
            $table->integer('target_waktu_bulan');
            $table->integer('realisasi_waktu_bulan')->nullable();
            $table->decimal('target_biaya', 15, 2)->nullable();
            $table->decimal('realisasi_biaya', 15, 2)->nullable();

            $table->float('nilai_kegiatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skp_kegiatans');
    }
};
