<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property CasasSostenibilidad $casasSostenibilidad
 * @property CriteriosCalificacione $criteriosCalificacione
 * @property TiposRiesgo $tiposRiesgo
 * @property int $id
 * @property int $casas_sostenibilidad_id
 * @property int $criterios_calificacion_id
 * @property int $tipos_riesgo_id
 * @property string $otro
 */
class Riesgo_Turismo extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'riesgos_turismos';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = ['casas_sostenibilidad_id', 'criterios_calificacion_id', 'tipos_riesgo_id', 'otro'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function casasSostenibilidad()
    {
        return $this->belongsTo('App\Models\CasasSostenibilidad');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function criteriosCalificacione()
    {
        return $this->belongsTo('App\Models\CriteriosCalificacione', 'criterios_calificacion_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tiposRiesgo()
    {
        return $this->belongsTo('App\Models\Tipo_Riesgo');
    }
}
