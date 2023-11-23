<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'jam',
        'jam_masuk_besok',
        'jam_kerja',
        'foto',
        'device',
        'maps',
        'latitude',
        'longitude',
        'status',
        'presensi_status',
        'tipe'
    ];
}