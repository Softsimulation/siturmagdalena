<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property float $frecuencia
 * @property float $tasa
 * @property boolean $es_interno
 * @property int $tipo_viaje_id
 * @property int $tiempo_interno_id
 * @property int $sexo_id
 * @property int $estrato_id
 * @property int $nivel_educacion_id
 * @property int $rango_edad_id
 * @property int $motivo_viaje_id
 * @property int $municipio_magdalena_id
 * @property string $user_create
 * @property string $user_update
 * @property boolean $estado
 * @property string $created_at
 * @property string $updated_at
 */
class H_Total_Viaje_Interno_Emisor extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'h_total_viajes_interno_emisor';

    /**
     * @var array
     */
    protected $fillable = ['frecuencia', 'tasa', 'es_interno', 'tipo_viaje_id', 'tiempo_interno_id', 'sexo_id', 'estrato_id', 'nivel_educacion_id', 'rango_edad_id', 'motivo_viaje_id', 'municipio_magdalena_id', 'user_create', 'user_update', 'estado', 'created_at', 'updated_at'];

}
