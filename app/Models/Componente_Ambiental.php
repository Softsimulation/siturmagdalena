<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property CasasSostenibilidad $casasSostenibilidad
 * @property CasasSostenibilidad $casasSostenibilidad
 * @property int $casas_sostenibilidad_id
 * @property int $criterios_calificacion_id
 * @property string $areas_protegidas
 * @property boolean $existe_guia
 * @property boolean $efecto_turismo
 * @property boolean $estado
 * @property string $user_create
 * @property string $created_at
 * @property string $updated_at
 * @property string $user_update
 */
class Componente_Ambiental extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'componentes_ambientales';

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
    protected $fillable = ['criterios_calificacion_id', 'areas_protegidas', 'efecto_turismo', 'estado', 'user_create', 'created_at', 'updated_at', 'user_update'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function criterioCalificacion()
    {
        return $this->belongsTo('App\Models\Criterio_Calificacion', 'criterios_calificacion_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function casasSostenibilidad()
    {
        return $this->belongsTo('App\CasasSostenibilidad');
    }
}
