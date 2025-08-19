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
        Schema::create('kuasas', function (Blueprint $table) {
            $table->id();
            // Metadata surat
            $table->string('nomor');
            $table->string('tempat')->nullable();
            $table->date('tanggal')->nullable();

            // Pemberi kuasa
            $table->foreignId('pemberi_id')->constrained('pegawais')->cascadeOnDelete();

            // Penerima kuasa
            $table->foreignId('penerima_id')->constrained('pegawais')->cascadeOnDelete();

            // Isi kuasa
            $table->text('keperluan');

            // Tembusan (simpan JSON biar fleksibel)
            $table->json('tembusan')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Unique composite biar nomor bisa dipakai lagi setelah di-soft delete
            $table->unique(['nomor', 'deleted_at'], 'kuasas_nomor_deleted_at_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kuasas');
    }
};
