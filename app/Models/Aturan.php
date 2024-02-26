<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aturan extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_rk',
        'id_penghasilan',
        'id_tanggungan',
        'id_jaminan',
        'hasil',
    ];
}
