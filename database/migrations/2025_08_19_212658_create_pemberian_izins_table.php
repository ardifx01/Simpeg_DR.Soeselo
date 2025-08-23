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
        Schema::create('pemberian_izins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pegawai_id')->constrained('pegawais')->onDelete('cascade');
            $table->foreignId('pemberi_izin_id')->constrained('pegawais')->onDelete('cascade');

            // Detail Surat Izin
            $table->string('nomor_surat')->unique();
            $table->string('tentang');
            $table->text('dasar_hukum')->nullable();
            $table->text('tujuan_izin');
            $table->string('ditetapkan_di');
            $table->date('tanggal_penetapan');
            $table->text('tembusan')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemberian_izins');
    }
};
