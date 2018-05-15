<?php

namespace App\Models;

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
     * 
     * @var string
     */
    protected $table = 'actividades_realizadas_viajero';
    public $timestamps = false;
    public $incrementing = false;
    /**
     * @var array
     */
   protected $fillable = ['actividad_id', 'actividades_realizadas_id', 'viajes_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function viaje()
    {
        return $this->belongsTo('App\Models\Viaje', 'viajes_id');
    }
}
