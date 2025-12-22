<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ModelLaporanHarian;

class LaporanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed data for LaporanSeeder
        ModelLaporanHarian::create([
            'judul_laporan' => 'Penanaman Melon',
            'tanggal_laporan' => now(),
            'aktivitas' => 'Penanaman',
            'nama_petugas' => 'Budi Santoso',
            'gambar_laporan' => 'penanaman_melon.jpg',
            'catatan' => 'Penanaman berjalan lancar tanpa kendala.',
            'id_greenhouse' => 'GH0001',
        ]);

    }
}
