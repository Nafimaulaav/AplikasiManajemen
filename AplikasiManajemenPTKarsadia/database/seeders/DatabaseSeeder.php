<?php

namespace Database\Seeders;

use App\Models\ModelUser;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    // use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // ni buat seeder user admin
        // ModelUser::create([
        //     'id_user' => 'U0001',
        //     'username' => 'admin',
        //     'password' => Hash::make('admin123'),
        //     'role' => 'admin',
        // ]);

        // ni buat seeder gh
        $this->call([
            GreenhouserSeeder::class,
        ]);

        // ni buat seeder qc
        $this->call([
            QCSeeder::class,
        ]);
    }
}
