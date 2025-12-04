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
        Schema::create('laporanharian', function (Blueprint $table) {
            $table->string('id_laporanharian', 10)->primary();
            $table->dateTime('tanggal_laporan')->useCurrent();
            $table->string('aktivitas', 255);
            $table->string('catatan', 255);
            $table->string('gambar');

            // foreign key id greenhouse
            $table->string('id_greenhouse', 10);
            $table->foreign('id_greenhouse')->references('id_greenhouse')->on('greenhouse')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporanharian');
    }
};


