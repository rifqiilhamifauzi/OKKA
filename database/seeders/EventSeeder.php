<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Event::create([
            'name' => 'OKKA 2026',
            'slug' => 'okka-2026',
            'description' => 'Orientasi Kepramukaan dan Kepemimpinan Mahasiswa Tahun 2026',
            'start_date' => '2026-09-01',
            'end_date' => '2026-09-03',
            'registration_fee' => 150000, // Rp 150.000
            'status' => 'active',
        ]);
    }
}
