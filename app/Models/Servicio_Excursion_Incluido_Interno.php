<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property ServiciosPaqueteInterno $serviciosPaqueteInterno
 * @property ViajeExcursion $viajeExcursion
 * @property int $viajes_id
 * @property int $servicios_paquete_id
 */
class Servicio_Excursion_Incluido_Interno extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'servicios_excursion_incluidos_interno';

    /**
     * @var array
     */
    protected $fillable = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function serviciosPaqueteInterno()
    {
        return $this->belongsTo('App\ServiciosPaqueteInterno', 'servicios_paquete_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function viajeExcursion()
    {
        return $this->belongsTo('App\ViajeExcursion', 'viajes_id', 'viajes_id');
    }
}
