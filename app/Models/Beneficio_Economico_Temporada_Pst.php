<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property EncuestasPstSostenibilidad $encuestasPstSostenibilidad
 * @property Beneficio $beneficio
 * @property CalificacionesFactore $calificacionesFactore
 * @property int $id
 * @property int $encuestas_pst_sostenibilidad_id
 * @property int $beneficio_id
 * @property int $calificacion_factores_id
 * @property string $otro
 */
class Beneficio_Economico_Temporada_Pst extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'beneficios_economicos_temporada_pst';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $timestamps = false;
    /**
     * @var array
     */
    protected $fillable = ['encuestas_pst_sostenibilidad_id', 'beneficio_id', 'calificacion_factores_id', 'otro'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function encuestasPstSostenibilidad()
    {
        return $this->belongsTo('App\EncuestasPstSostenibilidad');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function beneficio()
    {
        return $this->belongsTo('App\Beneficio');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function calificacionesFactore()
    {
        return $this->belongsTo('App\CalificacionesFactore', 'calificacion_factores_id');
    }
}
