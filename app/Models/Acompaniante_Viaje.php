<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Acompaniante_Viaje extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'acompañantes_viajes';

    /**
     * @var array

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function viajes()
    {
        return $this->hasMany('App\Models\Viaje', 'acompañantes_viajes_id');
    }
}
