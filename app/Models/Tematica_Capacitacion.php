<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property CapacitacionesEmpleo $capacitacionesEmpleo
 * @property int $id
 * @property int $encuesta_id
 * @property string $nombre
 * @property boolean $realizada_empresa
 */
class Tematica_Capacitacion extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'tematicas_capacitaciones';

    /**
     * @var array
     */
    protected $fillable = ['encuesta_id', 'nombre', 'realizada_empresa'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
     
     public $timestamps = false;
    public function capacitacionesEmpleo()
    {
        return $this->belongsTo('App\Models\Capacitacion_Empleo', 'encuesta_id', 'encuesta_id');
    }
}
