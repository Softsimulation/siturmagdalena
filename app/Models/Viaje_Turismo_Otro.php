<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property ViajesTurismo $viajesTurismo
 * @property int $viajes_turismo_id
 * @property string $otro
 */
class Viaje_Turismo_Otro extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
     public $timestamps = false;
     public $incrementing = false;
    protected $table = 'viajes_turismos_otro';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'viajes_turismo_id';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    //protected $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['otro'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function viajesTurismo()
    {
        return $this->belongsTo('App\Models\Viaje_Turismo');
    }
}
