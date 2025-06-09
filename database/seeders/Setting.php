<?php

namespace Database\Seeders;

use App\Models\Setting as ModelsSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Setting extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        ModelsSetting::create([
            'batasan_asdos' => 3,
            'minimal_sertifikat' => 7,
        ]);
    }
}
