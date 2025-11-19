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
        Schema::create('tanaman', function (Blueprint $table) {
            $table->string('id_tanaman', 10)->primary();
            $table->string('varietas', 100);
            $table->date('tanggal_tanam');
            $table->integer('jumlah_tanaman');
            $table->enum('status_tumbuh', ['tumbuh', 'panen', 'mati']);
            $table->date('perkiraan_panen');

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
        Schema::dropIfExists('tanaman');
    }
};
