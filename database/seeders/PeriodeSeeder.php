<?php

namespace Database\Seeders;

use App\Models\Periode;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PeriodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Periode::create([
            'tahun' => '2024/2025',
            'semester' => 'ganjil',
            'status' => 'nonaktif',
        ]);
        Periode::create([
            'tahun' => '2024/2025',
            'semester' => 'genap',
            'status' => 'nonaktif',
        ]);
    }
}
