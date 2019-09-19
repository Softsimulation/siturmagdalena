<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Encuesta $encuesta
 * @property int $id
 * @property int $encuestas_id
 * @property int $hombres
 * @property int $mujeres
 */
class Sexo_Empleado extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'sexos_empleados';
     public $timestamps = false;
     

    /**
     * @var array
     */
    protected $fillable = ['encuestas_id', 'hombres', 'mujeres'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function encuesta()
    {
        return $this->belongsTo('App\Models\Encuesta', 'encuestas_id');
    }
}
