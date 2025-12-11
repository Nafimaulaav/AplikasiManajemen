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
        Schema::create('log_quality_control', function (Blueprint $table) {
            $table->integer('id_log_qc')->id();
            $table->dateTime('tanggal_qc');
            $table->string('nama_petugas');
            $table->string('varietas_melon');
            $table->enum('status_tumbuh', ['Vegetatif', 'Generatif','Panen', 'Gegetatif']);
            $table->integer('total_tanaman');
            $table->integer('jumlah_tanaman_tumbuh');
            $table->integer('jumlah_tanaman_sehat');
            $table->integer('jumlah_tanaman_sakit');
            $table->integer('jumlah_tanaman_mati');

            // foreign key ke tabel greenhouse
            $table->string('id_greenhouse', 10);
            $table->foreign('id_greenhouse')->references('id_greenhouse')->on('greenhouse')->onDelete('cascade');
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_quality_control');
    }
};
