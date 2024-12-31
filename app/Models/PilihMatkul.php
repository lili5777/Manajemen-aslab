<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PilihMatkul extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_pendaftar',
        'matkul',
    ];
}
