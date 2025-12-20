<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ModelGreenhouse;

class GreenhouserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ModelGreenhouse::create([
            'nama_greenhouse' => 'Greenhouse Melon A',
            'alamat_greenhouse' => 'Kopidia',
            'status_greenhouse' => 'Aktif',
            'waktu_monitoring' => now(),
            'suhu_greenhouse' => 28.5,
            'kelembaban_greenhouse' => 70,
            'intensitas_cahaya_greenhouse' => 1200,
            'volume_air_greenhouse' => 500,
            'luas_greenhouse' => 250,
            'tinggi_greenhouse' => 4.5,
            'sistem_dipakai_greenhouse' => 'Hidroponik',
        ]);

        ModelGreenhouse::create([
            'nama_greenhouse' => 'Greenhouse Melon A2',
            'alamat_greenhouse' => 'Kopidia',
            'status_greenhouse' => 'Aktif',
            'waktu_monitoring' => now(),
            'suhu_greenhouse' => 26.0,
            'kelembaban_greenhouse' => 65,
            'intensitas_cahaya_greenhouse' => 1500,
            'volume_air_greenhouse' => 600,
            'luas_greenhouse' => 300,
            'tinggi_greenhouse' => 5.0,
            'sistem_dipakai_greenhouse' => 'Hidroponik',
        ]);
    }
}
