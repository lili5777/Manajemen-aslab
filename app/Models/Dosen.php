<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_akun',
        'foto',
        'nama',
        'email',
        'nidn',
        'no_wa',
    ];
}
