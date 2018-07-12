<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property CasasSostenibilidad $casasSostenibilidad
 * @property CriteriosCalificacione $criteriosCalificacione
 * @property ViviendasTuristicasSostenible $viviendasTuristicasSostenible
 * @property int $casas_sostenibilidad_id
 * @property int $criterios_calificacion_id
 * @property boolean $es_agradable
 * @property int $calificacion
 * @property boolean $ofrece_informacion
 * @property boolean $pertenece_gremio
 * @property int $nivel_sastifacion
 * @property boolean $cambian_turistas
 * @property boolean $conservacion_patrimonio_id
 * @property boolean $viviendas_turisticas
 * @property boolean $efecto_turismo
 * @property string $positivo
 * @property string $negativo
 * @property boolean $estado
 * @property string $updated_at
 * @property string $created_at
 * @property string $user_create
 * @property string $user_update
 */
class Componente_Social extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'componentes_sociales';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'casas_sostenibilidad_id';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['criterios_calificacion_id', 'es_agradable', 'calificacion', 'ofrece_informacion', 'pertenece_gremio', 'nivel_sastifacion', 'cambian_turistas', 'conservacion_patrimonio_id', 'viviendas_turisticas', 'efecto_turismo', 'positivo', 'negativo', 'estado', 'updated_at', 'created_at', 'user_create', 'user_update'];

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
    public function criteriosCalificacione()
    {
        return $this->belongsTo('App\CriteriosCalificacione', 'criterios_calificacion_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function viviendasTuristicasSostenible()
    {
        return $this->hasOne('App\ViviendasTuristicasSostenible', 'casas_sostenibilidad_id', 'casas_sostenibilidad_id');
    }
}
