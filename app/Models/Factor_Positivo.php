<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property CasasSostenibilidad $casasSostenibilidad
 * @property FactoresCalidad $factoresCalidad
 * @property int $id
 * @property int $casas_sostenibilidad_id
 * @property int $factores_calidad_id
 * @property boolean $calificacion
 * @property boolean $otro
 */
class Factor_Positivo extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'factores_positivos';
    public $timestamps = false;
    /**
     * @var array
     */
    protected $fillable = ['casas_sostenibilidad_id', 'factores_calidad_id', 'calificacion', 'otro'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function casasSostenibilidad()
    {
        return $this->belongsTo('App\Models\Casa_Sostenibilidad');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function factoresCalidad()
    {
        return $this->belongsTo('App\Models\Factor_Calidad');
    }
}
