<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property CasasSostenibilidad $casasSostenibilidad
 * @property EstadosEncuestum $estadosEncuestum
 * @property int $id
 * @property int $casas_sostenibilidad_id
 * @property int $estado_encuesta_id
 * @property string $observacion
 * @property string $fecha_cambio
 * @property string $created_at
 * @property string $updated_at
 * @property boolean $estado
 * @property string $user_create
 * @property string $user_update
 */
class Historial_Encuesta_Hogar_Sostenibilidad extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'historial_encuesta_hogares_sostenibilidad';

    /**
     * @var array
     */
    protected $fillable = ['casas_sostenibilidad_id', 'estado_encuesta_id', 'observacion', 'fecha_cambio', 'created_at', 'updated_at', 'estado', 'user_create', 'user_update'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function casasSostenibilidad()
    {
        return $this->belongsTo('App\CasasSostenibilidad');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function estadosEncuestum()
    {
        return $this->belongsTo('App\EstadosEncuestum', 'estado_encuesta_id');
    }
}
