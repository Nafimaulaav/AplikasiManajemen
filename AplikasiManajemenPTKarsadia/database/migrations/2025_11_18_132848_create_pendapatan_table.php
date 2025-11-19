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
        Schema::create('pendapatan', function (Blueprint $table) {
            $table->string('id_pendapatan')->primary();
            $table->string('keterangan', 255);
            $table->date('tanggal_transaksi');
            $table->integer('jumlah_pendapatan', 15);

            //foreign key id_pesanan
            $table->string('id_pesanan', 10);
            $table->foreign('id_pesanan')->references('id_pesanan')->on('pesanan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendapatan');
    }
};
