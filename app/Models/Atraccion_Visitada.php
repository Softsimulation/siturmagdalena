<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Visitante $visitante
 * @property int $id
 * @property int $atraccion_id
 * @property int $tipo_atraccion_id
 * @property int $actividades_realizadas_id
 * @property int $visitante_id
 */
class Atraccion_Visitada extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'atracciones_visitadas';
    public $timestamps = false;
    /**
     * @var array
     */
    protected $fillable = ['atraccion_id', 'tipo_atraccion_id', 'actividades_realizadas_id', 'visitante_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function visitante()
    {
        return $this->belongsTo('App\Visitante');
    }
}
