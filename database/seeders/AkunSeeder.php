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
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'stb' => '111',
            'password' => Hash::make('111'),
            'role' => 'admin',
        ]);

        // Dosen
        User::create([
            'name' => 'Dosen',
            'email' => 'dosen@gmail.com',
            'stb' => '222',
            'password' => Hash::make('222'),
            'role' => 'dosen',
        ]);

        // Mahasiswa
        User::create([
            'name' => 'Mahasiswa',
            'email' => 'mahasiswa@gmail.com',
            'stb' => '333',
            'password' => Hash::make('333'),
            'role' => 'mahasiswa',
        ]);
    }
}
