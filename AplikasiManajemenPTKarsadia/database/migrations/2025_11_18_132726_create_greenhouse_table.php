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
            $table->string('id_greenhouse', 10);
            $table->date('tanggal_panen');
            $table->integer('jumlah_panen');
            $table->enum('kualitas', ['Baik', 'Sedang', 'Buruk']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('greenhouse');
    }
};
