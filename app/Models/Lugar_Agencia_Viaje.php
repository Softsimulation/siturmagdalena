<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property UbicacionAgenciaViaje $ubicacionAgenciaViaje
 * @property ViajeExcursion $viajeExcursion
 * @property int $ubicacion_agencia_viajes_id
 * @property int $viaje_excursion_id
 */
class Lugar_Agencia_Viaje extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'lugar_agencia_viaje';


    /**
     * @var array
     */
    protected $fillable = [ "viaje_excursion_id", "ubicacion_agencia_viajes_id"];

    public $timestamps = false;
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ubicacionAgenciaViaje()
    {
        return $this->belongsTo('App\UbicacionAgenciaViaje', 'ubicacion_agencia_viajes_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function viajeExcursion()
    {
        return $this->belongsTo('App\ViajeExcursion', null, 'viajes_id');
    }
}
