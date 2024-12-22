<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftar extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_user',
        'nama',
        'stb',
        'alamat',
        'ttl',
        'tempat_lahir',
        'no_wa',
        'surat_pernyataan',
        'surat_rekomendasi',
        'foto',
        'transkip'
    ];
}
