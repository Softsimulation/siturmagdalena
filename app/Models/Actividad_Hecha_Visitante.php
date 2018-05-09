<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Visitante $visitante
 * @property int $id
 * @property int $actividad_id
 * @property int $acitvidades_realizadas_id
 * @property int $visitante_id
 */
class Actividad_Hecha_Visitante extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'actividades_hechas_visitante';
    public $timestamps = false;
    /**
     * @var array
     */
    protected $fillable = ['actividad_id', 'acitvidades_realizadas_id', 'visitante_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function visitante()
    {
        return $this->belongsTo('App\Visitante');
    }
}
