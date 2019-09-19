<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Encuesta $encuesta
 * @property int $id
 * @property int $encuestas_id
 * @property int $docea18
 * @property int $diecinuevea25
 * @property int $ventiseisa40
 * @property int $cuarentayunoa64
 * @property int $mas65
 */
class Edad_Empleado extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'edad_empleados';
 public $timestamps = false;
     
    /**
     * @var array
     */
    protected $fillable = ['encuestas_id', 'docea18', 'diecinuevea25', 'ventiseisa40', 'cuarentayunoa64', 'mas65'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function encuesta()
    {
        return $this->belongsTo('App\Models\Encuesta', 'encuestas_id');
    }
}
