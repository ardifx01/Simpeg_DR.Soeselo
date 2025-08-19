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
        Schema::create('disposisis', function (Blueprint $table) {
            $table->id();
            $table->string('surat_dari')->nullable();
            $table->string('no_surat')->nullable();
            $table->date('tgl_surat')->nullable();
            $table->date('tgl_diterima')->nullable();
            $table->string('no_agenda')->nullable();
            $table->enum('sifat', ['sangat_segera', 'segera', 'rahasia'])->nullable();
            $table->string('hal')->nullable();

            $table->json('diteruskan_kepada')->nullable();

            $table->json('harap')->nullable();

            $table->text('catatan')->nullable();

            $table->unsignedBigInteger('penandatangan_id')->nullable();
            $table->foreign('penandatangan_id')->references('id')->on('users')->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disposisis');
    }
};
