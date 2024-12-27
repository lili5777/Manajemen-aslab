<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_periode',
        'hari',
        'pukul',
        'ruang',
        'kode_kelas',
        'prodi',
        'semester',
        'nama_matkul',
        'nama_dosen',
        'asdos1',
        'asdos2',
    ];
}
