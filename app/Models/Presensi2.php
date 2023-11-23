<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presensi2 extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'jam_masuk',
        'jam_masuk_selanjutnya',
        'foto',
        'ssid',
        'status',
        'presensi_status',
    ];
}