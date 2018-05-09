<?php

namespace App;

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

    /**
     * @var array
     */
    protected $fillable = ['estado'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tipoAtraccione()
    {
        return $this->belongsTo('App\TipoAtraccione', 'tipo_atraccion_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function viaje()
    {
        return $this->belongsTo('App\Viaje', 'viajes_id');
    }
}
