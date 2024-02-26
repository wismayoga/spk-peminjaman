<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Himpunan extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_variabel',
        'id_kurva',
        'nama',
        'a',
        'b',
        'c',
        'd',
    ];
}
