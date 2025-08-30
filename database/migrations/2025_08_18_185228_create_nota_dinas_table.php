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
        Schema::create('nota_dinas', function (Blueprint $table) {
            $table->id();
            $table->string('nomor')->unique();
            $table->date('tanggal');
            $table->string('sifat')->nullable();
            $table->string('lampiran')->nullable();
            $table->string('hal');
            $table->text('isi');
            $table->json('tembusan')->nullable();
            $table->foreignId('pemberi_id')->constrained('pegawais')->cascadeOnDelete();
            $table->foreignId('penerima_id')->constrained('pegawais')->cascadeOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nota_dinas');
    }
};
