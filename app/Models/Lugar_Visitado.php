<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property TipoAtraccione $tipoAtraccione
 * @property Visitante $visitante
 * @property int $actividad_realizada_id
 * @property int $tipo_atraccion_id
 * @property int $visitante_id
 * @property boolean $estado
 */
class Lugar_Visitado extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'lugares_visitados';
    public $timestamps = false;
    public $incrementing = false;
    /**
     * @var array
     */
    protected $fillable = ['estado','actividad_realizada_id','tipo_atraccion_id','visitante_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tipoAtraccione()
    {
        return $this->belongsTo('App\Models\TipoAtraccione', 'tipo_atraccion_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function visitante()
    {
        return $this->belongsTo('App\Models\Visitante');
    }
}
