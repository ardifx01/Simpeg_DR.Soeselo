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
        Schema::create('keterangans', function (Blueprint $table) {
            $table->id();
            $table->string('nomor')->nullable();
            $table->foreignId('pegawai_id')->constrained('pegawais')->onDelete('cascade');
            $table->text('keterangan');
            $table->string('tempat_ditetapkan')->default('Slawi');
            $table->date('tanggal_ditetapkan');
            $table->foreignId('penandatangan_id')->constrained('pegawais')->onDelete('cascade');
            $table->text('tembusan')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keterangans');
    }
};
