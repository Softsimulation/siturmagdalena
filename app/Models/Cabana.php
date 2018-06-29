<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cabana extends Model
{
    protected $table = 'cabañas';

    public $timestamps = false;
    
    protected $casts = [
        'tarifa' => 'float',
        'habitaciones' => 'int',
    ];
    
}
