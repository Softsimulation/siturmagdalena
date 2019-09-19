<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Acompaniante_Viaje_Hogar extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'acompañantes_viajes_hogar';
    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey = 'viajes_id';
    /**
     * @var array

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function viaje()
    {
        return $this->hasOne('App\Models\Viaje', 'acompañantes_viajes_hogar_id');
    }
}