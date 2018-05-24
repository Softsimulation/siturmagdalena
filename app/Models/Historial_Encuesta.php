<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Digitadore $digitadore
 * @property EstadosEncuestum $estadosEncuestum
 * @property Visitante $visitante
 * @property int $id
 * @property int $usuario_id
 * @property int $estado_id
 * @property int $visitante_id
 * @property string $fecha_cambio
 * @property string $mensaje
 */
class Historial_Encuesta extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'historial_encuesta';
    public $timestamps = false;
    /**
     * @var array
     */
    protected $fillable = ['usuario_id', 'estado_id', 'visitante_id', 'fecha_cambio', 'mensaje'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function digitadore()
    {
        return $this->belongsTo('App\Models\Digitador', 'usuario_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function estadosEncuesta()
    {
        return $this->belongsTo('App\Models\Estados_Encuesta', 'estado_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function visitante()
    {
        return $this->belongsTo('App\Models\Visitante');
    }
}
