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
        Schema::create('undangans', function (Blueprint $table) {
            $table->id();
            $table->string('tempat_surat');
            $table->date('tanggal_surat');
            $table->string('nomor')->unique();
            $table->string('sifat')->nullable();
            $table->string('lampiran')->nullable();
            $table->string('hal');
            $table->string('yth');
            $table->string('alamat')->nullable();
            $table->string('pembuka_surat')->nullable();
            $table->date('tanggal_acara');
            $table->string('hari')->nullable();
            $table->string('waktu');
            $table->string('tempat');
            $table->string('acara');
            $table->string('penutup_surat')->nullable();
            $table->foreignId('penandatangan_id')->constrained('pegawais')->onDelete('cascade');
            $table->json('tembusan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('undangans');
    }
};
