<?php

namespace Database\Seeders;

use App\Models\ModelRiwayat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RiwayatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ModelRiwayat::create([
            'id_user' => 'U0001',
            'tipe_aksi' => 'Tambah',
            'menu_terkait' => 'Greenhouse',
            'deskripsi' => 'Pak Budi menambahkan Greenhouse baru',
        ]);
    }
}
