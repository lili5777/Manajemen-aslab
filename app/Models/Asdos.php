<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asdos extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_user',
        'id_pendaftar',
        'nama',
        'stb',
        'jurusan',
        'no_wa',
        'foto',
        'skor',
        'rank',
        'periode'
    ];
}
