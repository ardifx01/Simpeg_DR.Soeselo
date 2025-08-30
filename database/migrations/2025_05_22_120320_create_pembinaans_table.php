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
        Schema::create('pembinaans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pegawai_id')->constrained()->onDelete('cascade');
            $table->string('nama_pasangan');
            $table->string('pekerjaan');
            $table->string('agama');
            $table->string('alamat');
            $table->string('hubungan');
            $table->string('status_perceraian')->nullable();
            $table->foreignId('atasan_id')->nullable()->constrained('pegawais')->onDelete('set null');
            $table->string('atasan_nama')->nullable();
            $table->string('atasan_nip')->nullable();
            $table->string('atasan_jabatan')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembinaans');
    }
};
