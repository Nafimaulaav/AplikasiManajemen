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
        Schema::create('greenhouse', function (Blueprint $table) {
            $table->string('id_greenhouse', 10)->primary(); 
            $table->string('nama_greenhouse', 50); 
            $table->string('alamat_greenhouse', 100); 
            $table->string('gambar_greenhouse')->nullable();
            $table->enum('status_greenhouse', ['Aktif', 'Tidak Aktif', 'Perbaikan']); 
            $table->float('suhu_greenhouse')->nullable(); 
            $table->float('kelembaban_greenhouse')->nullable(); 
            $table->float('intensitas_cahaya_greenhouse')->nullable(); 
            $table->float('volume_air_greenhouse')->nullable(); 
            $table->float('luas_greenhouse')->nullable(); 
            $table->float('tinggi_greenhouse')->nullable(); 
            $table->string('sistem_dipakai_greenhouse', 50)->nullable();
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
