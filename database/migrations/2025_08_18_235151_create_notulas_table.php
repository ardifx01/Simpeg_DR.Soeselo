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
        Schema::create('notulas', function (Blueprint $table) {
            $table->id();
            $table->string('sidang_rapat');
            $table->date('tanggal');
            $table->time('waktu');
            $table->string('surat_undangan')->nullable();
            $table->text('acara');
            $table->foreignId('ketua_id')->constrained('pegawais')->onDelete('cascade');
            $table->foreignId('sekretaris_id')->nullable()->constrained('pegawais')->onDelete('set null');
            $table->foreignId('pencatat_id')->constrained('pegawais')->onDelete('cascade');
            $table->json('peserta');
            $table->text('kegiatan_rapat');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notulas');
    }
};
