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
        Schema::create('edarans', function (Blueprint $table) {
            $table->id();
            $table->string('nomor')->nullable();
            $table->year('tahun');
            $table->string('tentang');
            $table->text('isi_edaran');
            $table->string('tempat_ditetapkan')->default('Slawi');
            $table->date('tanggal_ditetapkan');
            $table->foreignId('penandatangan_id')->constrained('pegawais')->onDelete('cascade');
            $table->json('tujuan');
            $table->text('tembusan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('edarans');
    }
};
