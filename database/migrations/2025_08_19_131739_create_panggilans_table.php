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
        Schema::create('panggilans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pegawai_id')->constrained('pegawai')->onDelete('cascade'); // Pegawai yang dipanggil
            $table->foreignId('penandatangan_id')->constrained('pegawai')->onDelete('cascade'); // Pejabat yang menandatangani

            // Detail surat
            $table->string('nomor_surat')->unique();
            $table->string('sifat')->default('Biasa');
            $table->string('lampiran')->nullable();
            $table->date('tanggal_surat');
            $table->text('perihal'); // menghadao untuk

            // Detail jadwal pertemuan
            $table->string('jadwal_hari');
            $table->date('jadwal_tanggal');
            $table->string('jadwal_pukul'); // Disimpan sebagai string untuk format bebas (misal: 09:00 WIB)
            $table->string('jadwal_tempat');
            $table->string('menghadap_kepada');
            $table->string('alamat_menghadap');
            $table->text('tembusan')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('panggilans');
    }
};
