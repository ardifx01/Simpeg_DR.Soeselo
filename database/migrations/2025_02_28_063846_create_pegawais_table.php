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
        Schema::create('pegawais', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable();
            $table->string('nip');
            $table->string('nip_lama')->nullable();
            $table->string('no_karpeg')->nullable();
            $table->string('no_kpe')->nullable();
            $table->string('no_ktp');
            $table->string('no_npwp')->nullable();
            $table->string('nama');
            $table->string('gelar_depan')->nullable();
            $table->string('gelar_belakang')->nullable();
            $table->string('tempat_lahir');
            $table->string('tanggal_lahir');
            $table->string('jenis_kelamin');
            $table->string('agama');
            $table->string('status_nikah');
            $table->text('alamat')->nullable();
            $table->string('rt')->nullable();
            $table->string('rw')->nullable();
            $table->string('desa')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('kabupaten')->nullable();
            $table->string('provinsi')->nullable();
            $table->string('pos')->nullable();
            $table->string('telepon');
            $table->string('golongan_ruang')->nullable();
            $table->string('tmt_golongan_ruang')->nullable();
            $table->string('golongan_ruang_cpns')->nullable();
            $table->string('tmt_golongan_ruang_cpns')->nullable();
            $table->string('tmt_pns')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawais');
    }
};
