<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property CasasSostenibilidad $casasSostenibilidad
 * @property CalificacionesFactore $calificacionesFactore
 * @property Beneficio $beneficio
 * @property int $id
 * @property int $casas_sostenibilidad_id
 * @property int $calificacion_factores_id
 * @property int $beneficio_id
 * @property string $otro
 */
class Beneficio_Sociocultural extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'beneficios_socioculturales';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $timestamps  =false;

    /**
     * @var array
     */
    protected $fillable = ['casas_sostenibilidad_id', 'calificacion_factores_id', 'beneficio_id', 'otro'];

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
    public function calificacionesFactore()
    {
        return $this->belongsTo('App\CalificacionesFactore', 'calificacion_factores_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function beneficio()
    {
        return $this->belongsTo('App\Beneficio');
    }
}
