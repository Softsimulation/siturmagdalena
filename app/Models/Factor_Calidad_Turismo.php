<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property CasasSostenibilidad $casasSostenibilidad
 * @property FactoresCalidad $factoresCalidad
 * @property CalificacionesFactore $calificacionesFactore
 * @property int $id
 * @property int $casas_sostenibilidad_id
 * @property int $factores_calidad_id
 * @property int $calificaciones_factor_id
 * @property string $otro
 */
class Factor_Calidad_Turismo extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'factores_calidad_turismo';
    public $timestamps  =false;
    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
   

    /**
     * @var array
     */
    protected $fillable = ['casas_sostenibilidad_id', 'factores_calidad_id', 'calificaciones_factor_id', 'otro'];

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
    public function factoresCalidad()
    {
        return $this->belongsTo('App\Models\FactoresCalidad');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function calificacionesFactore()
    {
        return $this->belongsTo('App\Models\CalificacionesFactore', 'calificaciones_factor_id');
    }
}
