<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Otro_Acompaniante_Viaje extends Model
{
    public $timestamps = false;
    
    protected $table = 'otros_acompañantes_viaje';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;
    
    protected $fillable = ['visitante_id', 'nombre'];
    
}
