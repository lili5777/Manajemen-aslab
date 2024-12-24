<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InputNilai extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_pendaftar',
        'kode',
        'nama_matkul',
        'sks',
        'nilai'
    ];
}
