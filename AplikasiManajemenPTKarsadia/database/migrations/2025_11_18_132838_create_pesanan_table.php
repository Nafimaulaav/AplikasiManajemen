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
            $table->string('id_pesanan', 10)->primary();
            $table->string('nama_pelanggan');
            $table->string('alamat');
            $table->date('tanggal_pesan')->default(now()); // ni biar defaultnya sekarang
            $table->date('tanggal_kirim')->nullable(); // biar bisa null dulu
            $table->bigInteger('total_harga');
            $table->enum('status_pesanan', ['Dikemas', 'Dikirim', 'Diterima'])->default('Dikemas');
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
