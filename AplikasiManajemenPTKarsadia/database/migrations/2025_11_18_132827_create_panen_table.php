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
        Schema::create('panen', function (Blueprint $table) {
            $table->string('id_panen', 10)->primary();
            $table->date('tanggal_panen');
            $table->integer('jumlah_panen');
            $table->enum('kualitas', ['Baik', 'Sedang', 'Buruk']);

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
        Schema::dropIfExists('panen');
    }
};
