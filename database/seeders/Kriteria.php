<?php

namespace Database\Seeders;

use App\Models\Kriteria as ModelsKriteria;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Kriteria extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        ModelsKriteria::create([
            'bobot' => 0.4,
            'nama_kriteria' => 'ipk',
        ]);
        ModelsKriteria::create([
            'bobot' => 0.3,
            'nama_kriteria' => 'nilai_matkul',
        ]);
        ModelsKriteria::create([
            'bobot' => 0.2,
            'nama_kriteria' => 'rekomendasi',
        ]);
        ModelsKriteria::create([
            'bobot' => 0.1,
            'nama_kriteria' => 'pernyataan',
        ]);
    }
}
