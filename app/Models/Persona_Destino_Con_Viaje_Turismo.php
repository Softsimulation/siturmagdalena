<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property OpcionesPersonasDestino $opcionesPersonasDestino
 * @property ViajesTurismo $viajesTurismo
 * @property int $opciones_personas_destino_id
 * @property int $viajes_turismos_id
 * @property float $internacional
 * @property float $nacional
 * @property float $numerototal
 */
class Persona_Destino_Con_Viaje_Turismo extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'personas_destino_con_viajes_turismos';

    /**
     * @var array
     */
    protected $fillable = ['internacional', 'nacional', 'numerototal'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function opcionesPersonasDestino()
    {
        return $this->belongsTo('App\OpcionesPersonasDestino');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function viajesTurismo()
    {
        return $this->belongsTo('App\ViajesTurismo', 'viajes_turismos_id');
    }
}
