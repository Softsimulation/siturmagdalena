<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property ServiciosAgencia $serviciosAgencia
 * @property ViajesTurismo $viajesTurismo
 * @property int $servicios_agencias_id
 * @property int $viaje_turismo_id
 */
class Servicio_Agencia_Has_Viaje_Turismo extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'servicios_agencias_has_viaje_turismo';

    /**
     * @var array
     */
    protected $fillable = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function serviciosAgencia()
    {
        return $this->belongsTo('App\ServiciosAgencia', 'servicios_agencias_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function viajesTurismo()
    {
        return $this->belongsTo('App\ViajesTurismo', 'viaje_turismo_id');
    }
}
