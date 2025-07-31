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
        Schema::table('cutis', function (Blueprint $table) {
            $table->string('atasan_jabatan')->nullable();
            $table->unsignedBigInteger('atasan_id')->nullable();
            $table->string('atasan_nip')->nullable();
            $table->string('atasan_nama')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cutis', function (Blueprint $table) {
            $table->dropColumn([
                'atasan_jabatan',
                'atasan_id',
                'atasan_nip',
                'atasan_nama',
            ]);
        });
    }
};
