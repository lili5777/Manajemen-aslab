<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AkunSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin Utama',
            'email' => 'admin@gmail.com',
            'stb' => '111',
            'password' => Hash::make('111'),
            'role' => 'admin',
        ]);

        // Dosen (Lecturers)
        $dosenData = [
            ['name' => 'Prof. Dr. Bambang Sutrisno, M.Kom.', 'email' => 'bambang@univ.ac.id', 'stb' => 'D001'],
            ['name' => 'Dr. Ani Rahmawati, S.T., M.T.', 'email' => 'ani@univ.ac.id', 'stb' => 'D002'],
            ['name' => 'Drs. Candra Wijaya, M.Sc.', 'email' => 'candra@univ.ac.id', 'stb' => 'D003'],
            ['name' => 'Dian Puspitasari, S.Si., M.Cs.', 'email' => 'dian@univ.ac.id', 'stb' => 'D004'],
            ['name' => 'Eko Prasetyo, S.Kom., M.Kom.', 'email' => 'eko@univ.ac.id', 'stb' => 'D005'],
            ['name' => 'Fitriani, S.T., M.Eng.', 'email' => 'fitriani@univ.ac.id', 'stb' => 'D006'],
            ['name' => 'Dr. Gunawan Wibisono, M.Sc.', 'email' => 'gunawan@univ.ac.id', 'stb' => 'D007'],
            ['name' => 'Hesti Rahayu, S.Si., M.T.', 'email' => 'hesti@univ.ac.id', 'stb' => 'D008'],
            ['name' => 'Ir. Indra Kurniawan, M.T.', 'email' => 'indra@univ.ac.id', 'stb' => 'D009'],
            ['name' => 'Joko Susilo, S.Kom., M.Kom.', 'email' => 'joko@univ.ac.id', 'stb' => 'D010'],
        ];

        foreach ($dosenData as $dosen) {
            User::create([
                'name' => $dosen['name'],
                'email' => $dosen['email'],
                'stb' => $dosen['stb'],
                'password' => Hash::make('222'),
                'role' => 'dosen',
            ]);
        }

        // Mahasiswa (Students)
        $mahasiswaData = [
            ['name' => 'Ahmad Fauzi', 'email' => 'ahmad@student.univ.ac.id', 'stb' => 'M001'],
            ['name' => 'Budi Santoso', 'email' => 'budi@student.univ.ac.id', 'stb' => 'M002'],
            ['name' => 'Citra Dewi', 'email' => 'citra@student.univ.ac.id', 'stb' => 'M003'],
            ['name' => 'Dewi Lestari', 'email' => 'dewi@student.univ.ac.id', 'stb' => 'M004'],
            ['name' => 'Eka Putra', 'email' => 'eka@student.univ.ac.id', 'stb' => 'M005'],
            ['name' => 'Fajar Nugroho', 'email' => 'fajar@student.univ.ac.id', 'stb' => 'M006'],
            ['name' => 'Gita Maharani', 'email' => 'gita@student.univ.ac.id', 'stb' => 'M007'],
            ['name' => 'Hadi Pranoto', 'email' => 'hadi@student.univ.ac.id', 'stb' => 'M008'],
            ['name' => 'Indah Permata', 'email' => 'indah@student.univ.ac.id', 'stb' => 'M009'],
            ['name' => 'Joni Saputra', 'email' => 'joni@student.univ.ac.id', 'stb' => 'M010'],
        ];

        foreach ($mahasiswaData as $mahasiswa) {
            User::create([
                'name' => $mahasiswa['name'],
                'email' => $mahasiswa['email'],
                'stb' => $mahasiswa['stb'],
                'password' => Hash::make('333'),
                'role' => 'mahasiswa',
            ]);
        }
    }
}
