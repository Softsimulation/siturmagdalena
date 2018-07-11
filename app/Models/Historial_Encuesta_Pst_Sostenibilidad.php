<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property EstadosEncuestum $estadosEncuestum
 * @property EncuestasPstSostenibilidad $encuestasPstSostenibilidad
 * @property int $id
 * @property int $estado_encuesta_id
 * @property int $encuesta_pst_sostenibilidad_id
 * @property string $observacion
 * @property string $fecha_cambio
 * @property string $created_at
 * @property string $updated_at
 * @property boolean $estado
 * @property string $user_create
 * @property string $user_update
 */
class Historial_Encuesta_Pst_Sostenibilidad extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'historial_encuestas_pst_sostenibilidad';

    /**
     * @var array
     */
    protected $fillable = ['estado_encuesta_id', 'encuesta_pst_sostenibilidad_id', 'observacion', 'fecha_cambio', 'created_at', 'updated_at', 'estado', 'user_create', 'user_update'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function estadosEncuestum()
    {
        return $this->belongsTo('App\EstadosEncuestum', 'estado_encuesta_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function encuestasPstSostenibilidad()
    {
        return $this->belongsTo('App\EncuestasPstSostenibilidad', 'encuesta_pst_sostenibilidad_id');
    }
}
