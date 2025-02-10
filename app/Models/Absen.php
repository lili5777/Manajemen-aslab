<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absen extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_user',
        'id_jadwal',
        'ket',
        'tgl_verifikasi',
    ];
}
