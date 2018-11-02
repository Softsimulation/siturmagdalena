<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Porcentajes_servicios_paquete_viaje extends Model
{
    protected $primaryKey = 'viaje_id';
    public $timestamps = false;
    
    protected $casts = [
        'dentro' => 'int',
        'fuera' => 'int',
    ];
    
}
