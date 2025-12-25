<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ModelQC;

class QCSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ModelQC::create([
            'id_greenhouse' => 'GH0001',
            'tanggal_qc' => now(),
            'nama_petugas' => 'Andi Saputra',
            'gambar_qc' => [
                'images/foto-qc1.png',
                'images/foto-qc2.png',
                'images/foto-qc3.png',
            ],
            'varietas_melon' => 'Melon Honeydew',
            'status_tumbuh' => 'Vegetatif',
            'total_tanaman' => 100,
            'jumlah_tanaman_tumbuh' => 95,
            'jumlah_tanaman_sehat' => 90,
            'jumlah_tanaman_sakit' => 3,
            'jumlah_tanaman_mati' => 2,
        ]);
    }
}
