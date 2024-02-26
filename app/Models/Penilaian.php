<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_alternatif',
        'id_jenisVariabel',
        'rk',
        'penghasilan',
        'tanggungan',
        'jaminan',
        'slip_gaji',
        'merk_kendaraan',
        'jenis_kendaraan',
        'tahun_kendaraan',
    ];
}
