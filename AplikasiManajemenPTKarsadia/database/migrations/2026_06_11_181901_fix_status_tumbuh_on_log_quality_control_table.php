<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Jalankan perubahan.
     */
    public function up(): void
    {
        // Perbaiki data lama jika masih memakai typo.
        DB::table('log_quality_control')
            ->where('status_tumbuh', 'Gegetatif')
            ->update([
                'status_tumbuh' => 'Vegetatif',
            ]);

        DB::statement("
            ALTER TABLE log_quality_control
            MODIFY status_tumbuh
            ENUM('Vegetatif', 'Generatif', 'Panen')
            NOT NULL
        ");
    }

    /**
     * Batalkan perubahan jika diperlukan.
     */
    public function down(): void
    {
        DB::statement("
            ALTER TABLE log_quality_control
            MODIFY status_tumbuh
            ENUM('Vegetatif', 'Generatif', 'Panen', 'Gegetatif')
            NOT NULL
        ");
    }
};