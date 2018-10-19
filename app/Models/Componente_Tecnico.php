<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property CasasSostenibilidad $casasSostenibilidad
 * @property int $casas_sostenibilidad_id
 * @property boolean $contribuira
 * @property string $aspectos_mejorar
 * @property boolean $es_fuente
 * @property boolean $impacto_economico
 */
class Componente_Tecnico extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'componente_tecnico';

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
    
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = ['contribuira', 'aspectos_mejorar', 'es_fuente', 'impacto_economico','casas_sostenibilidad_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function casasSostenibilidad()
    {
        return $this->belongsTo('App\CasasSostenibilidad');
    }
}
