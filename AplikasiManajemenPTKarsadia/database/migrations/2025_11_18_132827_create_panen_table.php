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
            $table->string('id_greenhouse', 10)->primary();
            $table->string('tanggal_panen', 2);
            $table->string('', 100);
            $table->enum('', ['Aktif', '']);
            $table->datetime('')->current();
            $table->integer('');
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
