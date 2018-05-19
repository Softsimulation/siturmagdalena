<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Viaje $viaje
 * @property int $id
 * @property int $actividades_realizadas_id
 * @property int $atraccion_id
 * @property int $tipo_atraccion_id
 * @property int $viajes_id
 */
class Atraccion_Visitada_Interno extends Model
{
    
    protected $table = 'atracciones_visitadas_interno';
    public $timestamps = false;

 
    protected $fillable = ['actividades_realizadas_id', 'atraccion_id', 'tipo_atraccion_id', 'viajes_id'];

    /*
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function viaje()
    {
        return $this->belongsTo('App\Models\Viaje', 'viajes_id');
    }
}
