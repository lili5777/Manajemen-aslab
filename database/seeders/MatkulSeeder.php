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
            ['kode' => '6SSIG', 'nama' => 'Analisis Data Spasial'],
            ['kode' => '4TSDA', 'nama' => 'Analisis Data Spasial'],
            ['kode' => '4RBEM', 'nama' => 'Back-End Mobile Development'],
            ['kode' => '4RBEW', 'nama' => 'Back-End Web Development'],
            ['kode' => '6RDOE', 'nama' => 'DevOps Engineering'],
            ['kode' => '4BPDM', 'nama' => 'Pemasaran Digital Platform Digital Dan Medsos'],
            ['kode' => '2DPBO', 'nama' => 'Pemrograman Berorientasi Objek (Python)'],
            ['kode' => '4RPGM', 'nama' => 'Pemrograman Game'],
            ['kode' => '4DPAM', 'nama' => 'Pemrograman Mobile'],
            ['kode' => '6SPML', 'nama' => 'Pemrograman Mobile Lintas Platform'],
            ['kode' => '4RAMI', 'nama' => 'Pengembangan Aplikasi Media Interaktif'],
            ['kode' => '2RLPB', 'nama' => 'Prak.Pemrograman Berorientasi Objek'],
            ['kode' => '4SLBO', 'nama' => 'Prak.Pemrograman Berorientasi Objek'],
            ['kode' => '2KLAK', 'nama' => 'Pratikum Aplikasi Komputer'],
            ['kode' => '2SLBD', 'nama' => 'Pratikum Basis Data'],
            ['kode' => '2TLED', 'nama' => 'Pratikum Elektronika Digital'],
            ['kode' => '4TLMN', 'nama' => 'Pratikum Pemrograman Aplikasi Mobile Native'],
            ['kode' => '2TLBD', 'nama' => 'Pratikum Basis Data'],
            ['kode' => '2TLSD', 'nama' => 'Pratikum Stuktur Data (Python)'],
            ['kode' => '2SLSD', 'nama' => 'Pratikum Stuktur Data-Python'],
            ['kode' => '2BSBD', 'nama' => 'Sistem Basis Data'],
            ['kode' => '2DSBD', 'nama' => 'Sistem Basis Data'],
            ['kode' => '2RSBD', 'nama' => 'Sistem Basis Data'],
            ['kode' => '2DSTA', 'nama' => 'Statistik'],
            ['kode' => '4TSPB', 'nama' => 'Statistik dan Probabilitas'],
            ['kode' => '2RSDT', 'nama' => 'Struktur Data'],

        ];

        foreach ($data as $item) {
            Matkul::create([
                'kode' => $item['kode'],
                'nama' => $item['nama'],
            ]);
        }
    }
}
