<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Encuesta $encuesta
 * @property TematicasCapacitacione[] $tematicasCapacitaciones
 * @property LineasTematica[] $lineasTematicas
 * @property MediosCapacitacionesEncuesta[] $mediosCapacitacionesEncuestas
 * @property ProgramasCapaciacione[] $programasCapaciaciones
 * @property int $encuesta_id
 * @property boolean $realiza_proceso
 */
class Capacitacion_Empleo extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'capacitaciones_empleo';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'encuesta_id';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = ['realiza_proceso'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function encuesta()
    {
        return $this->belongsTo('App\Models\Encuesta');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tematicasCapacitaciones()
    {
        return $this->hasMany('App\Models\Tematica_Capacitacion', 'encuesta_id', 'encuesta_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function lineasTematicas()
    {
        return $this->belongsToMany('App\Models\Linea_Tematica', 'tematicas_aplicadas_encuestas', 'encuesta_id', 'linea_tematica_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mediosCapacitacionesEncuestas()
    {
        return $this->hasMany('App\Models\Medio_Capacitacion_Encuesta', 'encuesta_id', 'encuesta_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
  
    
    
    public function mediosCapacitacion()
    {
        return $this->belongsToMany('App\Models\Medio_Capacitacion', 'medios_capacitaciones_encuestas','encuesta_id','medio_capacitacion_id')->withPivot('otro');
    }


    public function programasCapaciacion()
    {
        return $this->belongsToMany('App\Models\Tipo_Programa_Capacitacion', 'programas_capaciaciones', 'encuesta_id','tipo_programa_capacitacion_id')->withPivot('otro');
    }
    
    
    
}
