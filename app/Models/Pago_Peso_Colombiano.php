<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property ViajeExcursion $viajeExcursion
 * @property int $viajes_id
 * @property boolean $es_efectivo
 */
class Pago_Peso_Colombiano extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'pago_pesos_colombianos';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'viajes_id';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public  $incrementing = false;
    public  $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = ['es_efectivo'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function viajeExcursion()
    {
        return $this->belongsTo('App\Models\ViajeExcursion', 'viajes_id', 'viajes_id');
    }
}
