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
        Schema::create('stok', function (Blueprint $table) {
            $table->string('nama_barang');
            $table->integer('jumlah_barang');

            // foreign key id panen ama pesanan
            $table->string('id_panen', 10);
            $table->foreign('id_panen')->references('id_panen')->on('panen')->onDelete('cascade');

            $table->string('id_pesanan', 10);
            $table->foreign('id_pesanan')->references('id_pesanan')->on('pesanan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stok');
    }
};
