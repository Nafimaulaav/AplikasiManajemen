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
        Schema::create('transaksi_harian', function (Blueprint $table) {
            $table->string('id_transaksi')->primary();
            $table->dateTime('tanggal_waktu_transaksi');
            $table->bigInteger('total_transaksi_harian');
            $table->string('nama_petugas', 100);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_harian');
    }
};
