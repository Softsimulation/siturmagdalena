<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Evento $evento
 * @property Planificador $planificador
 * @property int $id
 * @property int $eventos_id
 * @property int $planificador_id
 * @property int $dia
 * @property int $orden_visita
 */
class Planificador_Evento extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'planificador_eventos';
    
    public $timestamps = false;
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['eventos_id', 'planificador_id', 'dia', 'orden_visita'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function evento()
    {
        return $this->belongsTo('App\Evento', 'eventos_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function planificador()
    {
        return $this->belongsTo('App\Planificador');
    }
}
