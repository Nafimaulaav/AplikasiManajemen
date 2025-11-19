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
        Schema::create('pesanan', function (Blueprint $table) {
            $table->string('status_pesanan');
            $table->date('tanggal_kirim');
            $table->string('total_harga');
            $table->date('tanggal_pesan');
            $table->string('alamat');
            $table->string('nama_pelanggan');
            $table->string('id_pesanan')->primary();


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanan');
    }
};
