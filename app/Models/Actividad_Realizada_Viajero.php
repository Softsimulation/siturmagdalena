<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Viaje $viaje
 * @property int $viajes_id
 * @property int $actividad_id
 * @property int $actividades_realizadas_id
 * @property boolean $estado
 */
class Actividad_Realizada_Viajero extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'actividades_realizadas_viajero';

    /**
     * @var array
     */
    protected $fillable = ['estado'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function viaje()
    {
        return $this->belongsTo('App\Viaje', 'viajes_id');
    }
}
