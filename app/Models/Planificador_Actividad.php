<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Actividade $actividade
 * @property Planificador $planificador
 * @property int $id
 * @property int $actividades_id
 * @property int $planificador_id
 * @property int $dia
 * @property int $orden_dia
 */
class Planificador_Actividad extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'planificador_actividades';
    
    public $timestamps = false;
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['actividades_id', 'planificador_id', 'dia', 'orden_dia'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function actividade()
    {
        return $this->belongsTo('App\Actividade', 'actividades_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function planificador()
    {
        return $this->belongsTo('App\Planificador');
    }
}
