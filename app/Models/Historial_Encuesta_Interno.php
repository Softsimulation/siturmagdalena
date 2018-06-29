<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Digitadore $digitadore
 * @property EstadosEncuestum $estadosEncuestum
 * @property Viaje $viaje
 * @property int $id
 * @property int $digitador_id
 * @property int $estado_id
 * @property int $viajes_id
 * @property string $fecha_cambio
 * @property string $mensaje
 */
class Historial_Encuesta_Interno extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'historial_encuesta_interno';
    public $timestamps=false;

    /**
     * @var array
     */
    protected $fillable = ['digitador_id', 'estado_id', 'viajes_id', 'fecha_cambio', 'mensaje'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function digitadore()
    {
        return $this->belongsTo('App\Digitadore', 'digitador_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function estadosEncuestum()
    {
        return $this->belongsTo('App\EstadosEncuestum', 'estado_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function viaje()
    {
        return $this->belongsTo('App\Viaje', 'viajes_id');
    }
}
