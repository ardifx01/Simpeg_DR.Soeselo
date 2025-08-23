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
        Schema::create('telaahans', function (Blueprint $table) {
            $table->id();

            $table->foreignId('yth_id')->constrained('pegawais')->onDelete('cascade');
            $table->foreignId('dari_id')->constrained('pegawais')->onDelete('cascade');
            $table->string('nomor')->unique();
            $table->date('tanggal');
            $table->string('lampiran')->nullable();
            $table->string('hal');

            $table->text('persoalan')->nullable();
            $table->text('praanggapan')->nullable();
            $table->text('fakta')->nullable();
            $table->text('analisis')->nullable();
            $table->text('kesimpulan')->nullable();
            $table->text('saran')->nullable();

            $table->foreignId('penandatangan_id')->constrained('pegawais')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('telaahans');
    }
};
