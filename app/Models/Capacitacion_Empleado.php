<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Encuesta $encuesta
 * @property int $id
 * @property int $encuestas_id
 * @property string $temas
 * @property integer $realizoCapacitacion
 */
class Capacitacion_Empleado extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'capacitacion_empleados';

    /**
     * @var array
     */
    protected $fillable = ['encuestas_id', 'temas', 'realizoCapacitacion'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function encuesta()
    {
        return $this->belongsTo('App\Encuesta', 'encuestas_id');
    }
}
