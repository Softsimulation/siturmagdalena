<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property ActividadesRealizada $actividadesRealizada
 * @property Visitante $visitante
 * @property int $visitante_id
 * @property int $actividades_realizadas_id
 * @property boolean $estado
 */
class Actividad_Realizada_Por_Visitante extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'actividades_realizadas_por_visitante';
    public $timestamps = false;
    public $incrementing = false;
    /**
     * @var array
     */
    protected $fillable = ['estado','actividades_realizadas_id','otro'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function actividadesRealizada()
    {
        return $this->belongsTo('App\ActividadesRealizada', 'actividades_realizadas_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function visitante()
    {
        return $this->belongsTo('App\Visitante');
    }
}
