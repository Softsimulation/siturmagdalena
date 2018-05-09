<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Encuesta $encuesta
 * @property int $id
 * @property int $encuestas_id
 * @property int $numero_vehiculos
 * @property int $vehiculos_alquilados_total
 * @property int $vehiculos_alquilados_dia
 * @property float $tarifa_promedio
 */
class Alquiler_Vehiculo extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'alquiler_vehiculos';

    /**
     * @var array
     */
    protected $fillable = ['encuestas_id', 'numero_vehiculos', 'vehiculos_alquilados_total', 'vehiculos_alquilados_dia', 'tarifa_promedio'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function encuesta()
    {
        return $this->belongsTo('App\Encuesta', 'encuestas_id');
    }
}
