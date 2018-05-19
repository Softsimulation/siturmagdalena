<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property TipoAtraccione $tipoAtraccione
 * @property Viaje $viaje
 * @property int $actividad_realizadas_id
 * @property int $tipo_atraccion_id
 * @property int $viajes_id
 * @property boolean $estado
 */
class Lugar_Visitado_Interno extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'lugares_visitados_interno';
    public $timestamps = false;
    public $incrementing = false;

    /**
     * @var array
     */
       protected $fillable = ['estado','actividad_realizadas_id','tipo_atraccion_id','viajes_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tipoAtraccione()
    {
        return $this->belongsTo('App\Models\Tipo_Atraccione', 'tipo_atraccion_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function viaje()
    {
        return $this->belongsTo('App\Models\Viaje', 'viajes_id');
    }
}
