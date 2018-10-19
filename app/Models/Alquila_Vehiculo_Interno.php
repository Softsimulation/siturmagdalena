<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Viaje $viaje
 * @property int $viaje_id
 * @property boolean $alquilado_magdalena
 */
class Alquila_Vehiculo_Interno extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'alquila_vehiculo_interno';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'viaje_id';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    protected $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['alquilado_magdalena'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function viaje()
    {
        return $this->belongsTo('App\Viaje');
    }
}
