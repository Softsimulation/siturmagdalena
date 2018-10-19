<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property ActividadesRealizada $actividadesRealizada
 * @property Viaje $viaje
 * @property int $actividades_realizadas_id
 * @property int $viajes_id
 * @property boolean $estado
 */
class Actividad_Realizada_Interno extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'actividades_realizadas_interno';
    public $timestamps = false;
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['estado','viajes_id','actividades_realizadas_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function actividadesRealizada()
    {
        return $this->belongsTo('App\Models\Actividades_Realizada', 'actividades_realizadas_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function viaje()
    {
        return $this->belongsTo('App\Models\Viaje', 'viajes_id');
    }
}
