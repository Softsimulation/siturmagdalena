<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Encuesta $encuesta
 * @property int $id
 * @property int $encuestas_id
 * @property int $posgrado
 * @property int $universitario
 * @property int $tecnologo
 * @property int $bachiller
 */
class Educacion_Empleado extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'educacion_empleados';

    /**
     * @var array
     */
    protected $fillable = ['encuestas_id', 'posgrado', 'universitario', 'tecnologo', 'bachiller'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function encuesta()
    {
        return $this->belongsTo('App\Encuesta', 'encuestas_id');
    }
}
