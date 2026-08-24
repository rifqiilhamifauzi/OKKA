<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::updateOrCreate(
            ['email' => 'admin@okka.ac.id'], // Ganti dengan email asli admin nanti
            [
                'name' => 'Administrator OKKA',
                'google_id' => 'admin_dummy_id',
                'role' => 'admin',
                'password' => bcrypt('password'), // Optional jika mau login manual
            ]
        );
    }
}
