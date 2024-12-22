<?php

namespace Database\Seeders;

use App\Models\Matkul;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MatkulSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['kode' => '5SLAM', 'nama' => 'Prak. Aplikasi Mobile'],
            ['kode' => '3TLPW', 'nama' => 'Praktikum Pemrograman Web Native'],
            ['kode' => '3TLPO', 'nama' => 'Praktikum Pemrograman Objek'],
            ['kode' => '3TLSM', 'nama' => 'Praktikum Sistem Mikrokontroller'],
            ['kode' => '1TLAL', 'nama' => 'Praktikum Algoritma dan Pemrograman'],
            ['kode' => '1SLAP', 'nama' => 'Prak. Algoritma dan Pemrograman'],
            ['kode' => '3SLPW', 'nama' => 'Praktikum Pemrograman Web Native'],
            ['kode' => '3RFEN', 'nama' => 'Front-End Mobile Development'],
            ['kode' => '3SDSN', 'nama' => 'Data Sains'],
            ['kode' => '5SPWF', 'nama' => 'Pemrograman Web Berbasis FrameWork'],
            ['kode' => '3SAPS', 'nama' => 'Analisis dan Desain Sistem (UML)'],
            ['kode' => '1BABN', 'nama' => 'Akuntansi Bisnis'],
            ['kode' => '1RLAL', 'nama' => 'Prak. Algoritma Dan Pemrograman'],
            ['kode' => '1KAKB', 'nama' => 'Akuntansi Bisnis'],
            ['kode' => '1BKAP', 'nama' => 'Ilmu Komputer dan Algoritma Pemrograman'],
            ['kode' => '1DALP', 'nama' => 'ALGORITMA DAN PEMROGRAMAN'],
            ['kode' => '3DPWB', 'nama' => 'PEMROGRAMAN WEB'],
            ['kode' => '1RPTI', 'nama' => 'PTI dan PLA'],
            ['kode' => '3DJRK', 'nama' => 'JARINGAN KOMPUTER'],
            ['kode' => '3RDUI', 'nama' => 'Desain Ui/Ux'],
            ['kode' => '3KDGM', 'nama' => 'Desain Grafis dan Multimedia'],
            ['kode' => '5RSMG-A', 'nama' => 'Smart Game 1'],
            ['kode' => '3RMRY', 'nama' => 'Mixed Reality'],
            ['kode' => '1TLEA', 'nama' => 'Praktikum Elektronika Analog'],
        ];

        foreach ($data as $item) {
            Matkul::create([
                'kode' => $item['kode'],
                'nama' => $item['nama'],
            ]);
        }
    }
}
