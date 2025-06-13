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
            $table->date('tanggal_lahir');
            $table->string('jenis_kelamin');
            $table->string('agama');
            $table->string('status_nikah');
            $table->text('alamat');
            $table->string('telepon');
            $table->string('tingkat_pendidikan')->nullable();
            $table->string('nama_pendidikan')->nullable();
            $table->string('nama_sekolah')->nullable();
            $table->date('tahun_lulus')->nullable();
            $table->string('pangkat')->nullable();
            $table->string('golongan_ruang')->nullable();
            $table->date('tmt_golongan_ruang')->nullable();
            $table->date('golongan_ruang_cpns')->nullable();
            $table->date('tmt_golongan_ruang_cpns')->nullable();
            $table->date('tmt_pns')->nullable();
            $table->string('jenis_kepegawaian');
            $table->string('status_hukum')->nullable();
            $table->string('skpd')->nullable();
            $table->string('jenis_jabatan')->nullable();
            $table->string('jabatan_fungsional')->nullable();
            $table->date('tmt_jabatan')->nullable();
            $table->string('diklat_pimpinan')->nullable();
            $table->date('tahun_diklat_pimpinan')->nullable();
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
