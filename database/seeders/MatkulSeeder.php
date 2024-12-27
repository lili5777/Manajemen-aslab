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
            ['kode' => 'P6021-S', 'kode_kelas' => '5SLAM', 'nama' => 'Prak. Aplikasi Mobile'],
            ['kode' => 'K3201-T', 'kode_kelas' => '3TLPW', 'nama' => 'Praktikum Pemrograman Web Native'],
            ['kode' => 'K4402-T', 'kode_kelas' => '3TLPO', 'nama' => 'Praktikum Pemrograman Objek'],
            ['kode' => 'K3261-T', 'kode_kelas' => '3TLSM', 'nama' => 'Praktikum Sistem Mikrokontroller'],
            ['kode' => 'P1042-T', 'kode_kelas' => '1TLAL', 'nama' => 'Praktikum Algoritma dan Pemrograman'],
            ['kode' => 'P1042-S', 'kode_kelas' => '1SLAP', 'nama' => 'Prak. Algoritma dan Pemrograman'],
            ['kode' => 'K3251-S', 'kode_kelas' => '3SLPW', 'nama' => 'Praktikum Pemrograman Web Native'],
            ['kode' => 'P3013-R', 'kode_kelas' => '3RFEN', 'nama' => 'Front-End Mobile Development'],
            ['kode' => 'K3243-S', 'kode_kelas' => '3SDSN', 'nama' => 'Data Sains'],
            ['kode' => 'K5223-S', 'kode_kelas' => '5SPWF', 'nama' => 'Pemrograman Web Berbasis FrameWork'],
            ['kode' => 'A5014-S', 'kode_kelas' => '3SAPS', 'nama' => 'Analisis dan Desain Sistem (UML)'],
            ['kode' => 'B1043-B', 'kode_kelas' => '1BABN', 'nama' => 'Akuntansi Bisnis'],
            ['kode' => 'P1032-R', 'kode_kelas' => '1RLAL', 'nama' => 'Prak. Algoritma Dan Pemrograman'],
            ['kode' => 'E1033-K', 'kode_kelas' => '1KAKB', 'nama' => 'Akuntansi Bisnis'],
            ['kode' => 'K1023-B', 'kode_kelas' => '1BKAP', 'nama' => 'Ilmu Komputer dan Algoritma Pemrograman'],
            ['kode' => 'K1054-D', 'kode_kelas' => '1DALP', 'nama' => 'ALGORITMA DAN PEMROGRAMAN'],
            ['kode' => 'K4254-D', 'kode_kelas' => '3DPWB', 'nama' => 'PEMROGRAMAN WEB'],
            ['kode' => 'K1073-R', 'kode_kelas' => '1RPTI', 'nama' => 'PTI dan PLA'],
            ['kode' => 'K5024-D', 'kode_kelas' => '3DJRK', 'nama' => 'JARINGAN KOMPUTER'],
            ['kode' => 'K2053-R', 'kode_kelas' => '3RDUI', 'nama' => 'Desain Ui/Ux'],
            ['kode' => 'K3013-K', 'kode_kelas' => '3KDGM', 'nama' => 'Desain Grafis dan Multimedia'],
            ['kode' => 'G5032-R', 'kode_kelas' => '5RSMG', 'nama' => 'Smart Game 1'],
            ['kode' => 'K1013-R', 'kode_kelas' => '3RMRY', 'nama' => 'Mixed Reality'],
            ['kode' => 'E2011-T', 'kode_kelas' => '1TLEA', 'nama' => 'Praktikum Elektronika Analog'],
            ['kode' => 'U6223-S', 'kode_kelas' => '6SSIG', 'nama' => 'Analisis Data Spasial'],
            ['kode' => 'K4253-T', 'kode_kelas' => '4TSDA', 'nama' => 'Analisis Data Spasial'],
            ['kode' => 'P4013-R', 'kode_kelas' => '4RBEM', 'nama' => 'Back-End Mobile Development'],
            ['kode' => 'P4023-R', 'kode_kelas' => '4RBEW', 'nama' => 'Back-End Web Development'],
            ['kode' => 'K6033-R', 'kode_kelas' => '6RDOE', 'nama' => 'DevOps Engineering'],
            ['kode' => 'B4022-B', 'kode_kelas' => '4BPDM', 'nama' => 'Pemasaran Digital Platform Digital Dan Medsos'],
            ['kode' => 'P5024-D', 'kode_kelas' => '2DPBO', 'nama' => 'Pemrograman Berorientasi Objek (Python)'],
            ['kode' => 'P5613-R', 'kode_kelas' => '4RPGM', 'nama' => 'Pemrograman Game'],
            ['kode' => 'P4014-D', 'kode_kelas' => '4DPAM', 'nama' => 'Pemrograman Mobile'],
            ['kode' => 'K6273-S', 'kode_kelas' => '6SPML', 'nama' => 'Pemrograman Mobile Lintas Platform'],
            ['kode' => 'P4043-R', 'kode_kelas' => '4RAMI', 'nama' => 'Pengembangan Aplikasi Media Interaktif'],
            ['kode' => 'P2022-R', 'kode_kelas' => '2RLPB', 'nama' => 'Prak.Pemrograman Berorientasi Objek'],
            ['kode' => 'P5032-S', 'kode_kelas' => '4SLBO', 'nama' => 'Prak.Pemrograman Berorientasi Objek'],
            ['kode' => 'K1012-K', 'kode_kelas' => '2KLAK', 'nama' => 'Pratikum Aplikasi Komputer'],
            ['kode' => 'P2051-S', 'kode_kelas' => '2SLBD', 'nama' => 'Pratikum Basis Data'],
            ['kode' => 'E3021-T', 'kode_kelas' => '2TLED', 'nama' => 'Pratikum Elektronika Digital'],
            ['kode' => 'K4221-T', 'kode_kelas' => '4TLMN', 'nama' => 'Pratikum Pemrograman Aplikasi Mobile Native'],
            ['kode' => 'K3051-T', 'kode_kelas' => '2TLBD', 'nama' => 'Pratikum Basis Data'],
            ['kode' => 'K2231-T', 'kode_kelas' => '2TLSD', 'nama' => 'Pratikum Stuktur Data (Python)'],
            ['kode' => 'P2221-S', 'kode_kelas' => '2SLSD', 'nama' => 'Pratikum Stuktur Data-Python'],
            ['kode' => 'K2023-B', 'kode_kelas' => '2BSBD', 'nama' => 'Sistem Basis Data'],
            ['kode' => 'K4434-D', 'kode_kelas' => '2DSBD', 'nama' => 'Sistem Basis Data'],
            ['kode' => 'K2073-R', 'kode_kelas' => '2RSBD', 'nama' => 'Sistem Basis Data'],
            ['kode' => 'A2044-D', 'kode_kelas' => '2DSTA', 'nama' => 'Statistik'],
            ['kode' => 'M4223-T', 'kode_kelas' => '4TSPB', 'nama' => 'Statistik dan Probabilitas'],
            ['kode' => 'K2103-R', 'kode_kelas' => '2RSDT', 'nama' => 'Struktur Data'],

        ];

        foreach ($data as $item) {
            Matkul::create([
                'kode' => $item['kode'],
                'kode_kelas' => $item['kode_kelas'],
                'nama' => $item['nama'],
            ]);
        }
    }
}
