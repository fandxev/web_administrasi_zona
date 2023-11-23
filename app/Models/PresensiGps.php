<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PresensiGps extends Model
{


   
   protected $table = 'presensi_with_gps';
   protected $fillable = [
    'user_id', 'jam_masuk_kantor', 'waktu_awal_presensi', 'waktu_akhir_presensi',
        'foto_awal_presensi', 'foto_akhir_presensi', 'status', 'lokasi_terakhir',
        'waktu_ping_terakhir','latitude_terakhir','longitude_terakhir','total_jarak_perpindahan',
   ];
}
