<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property CriteriosCalificacione $criteriosCalificacione
 * @property EncuestasPstSostenibilidad $encuestasPstSostenibilidad
 * @property TiposRiesgo $tiposRiesgo
 * @property int $id
 * @property int $criterios_calificacion_id
 * @property int $encuesta_pst_sostenibilidad_id
 * @property int $tipo_riesgo_id
 * @property string $otro
 */
class Riesgo_Encuesta_Pst_Sostenibilidad extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'riesgos_encuestas_pst_sostenibilidad';
    
    public $timestamps = false;
    /**
     * @var array
     */
    protected $fillable = ['criterios_calificacion_id', 'encuesta_pst_sostenibilidad_id', 'tipo_riesgo_id', 'otro'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function criteriosCalificacione()
    {
        return $this->belongsTo('App\CriteriosCalificacione', 'criterios_calificacion_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function encuestasPstSostenibilidad()
    {
        return $this->belongsTo('App\EncuestasPstSostenibilidad', 'encuesta_pst_sostenibilidad_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tiposRiesgo()
    {
        return $this->belongsTo('App\TiposRiesgo', 'tipo_riesgo_id');
    }
}
