<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Atraccione $atraccione
 * @property Planificador $planificador
 * @property int $id
 * @property int $atracciones_id
 * @property int $planificador_id
 * @property int $dia
 * @property int $orden_visita
 */
class Planificador_Atraccion extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'planificador_atracciones';
    
    public $timestamps = false;
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['atracciones_id', 'planificador_id', 'dia', 'orden_visita'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function atraccione()
    {
        return $this->belongsTo('App\Atraccione', 'atracciones_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function planificador()
    {
        return $this->belongsTo('App\Planificador');
    }
}
