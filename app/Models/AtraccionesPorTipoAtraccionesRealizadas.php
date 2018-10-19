<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Atraccione $atraccione
 * @property int $atraccion_id
 * @property int $tipo_atraccion_id
 * @property int $actividades_realizadas_id
 * @property boolean $estado
 */
class AtraccionesPorTipoAtraccionesRealizadas extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'atracciones_por_tipo_actividades_realizadas';

    /**
     * @var array
     */
    protected $fillable = ['estado'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function atraccione()
    {
        return $this->belongsTo('App\Atraccione', 'atraccion_id');
    }
}
