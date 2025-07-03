<?php

namespace Database\Seeders;

use App\Models\Dosen;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DosenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil semua user yang memiliki role 'dosen'
        $dosenUsers = User::where('role', 'dosen')->get();

        // Data tambahan untuk setiap dosen (bisa disesuaikan)
        $additionalDosenData = [
            ['foto' => 'bambang.jpg', 'no_wa' => '081234567890'],
            ['foto' => 'ani.jpg', 'no_wa' => '081234567891'],
            ['foto' => 'candra.jpg', 'no_wa' => '081234567892'],
            ['foto' => 'dian.jpg', 'no_wa' => '081234567893'],
            ['foto' => 'eko.jpg', 'no_wa' => '081234567894'],
            ['foto' => 'fitriani.jpg', 'no_wa' => '081234567895'],
            ['foto' => 'gunawan.jpg', 'no_wa' => '081234567896'],
            ['foto' => 'hesti.jpg', 'no_wa' => '081234567897'],
            ['foto' => 'indra.jpg', 'no_wa' => '081234567898'],
            ['foto' => 'joko.jpg', 'no_wa' => '081234567899'],
        ];

        // Loop melalui setiap user dosen dan buat data dosen
        foreach ($dosenUsers as $index => $user) {
            Dosen::create([
                'id_akun' => $user->id,
                'foto' => $additionalDosenData[$index]['foto'] ?? 'default_dosen.jpg',
                'nama' => $user->name,
                'email' => $user->email,
                'nidn' => $user->stb,
                'no_wa' => $additionalDosenData[$index]['no_wa'] ?? '081234567890',
            ]);
        }
    }
}
