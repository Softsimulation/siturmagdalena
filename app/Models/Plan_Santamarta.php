<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property ViajesTurismo $viajesTurismo
 * @property int $viajes_turismos_id
 * @property float $numero
 * @property float $residentes
 * @property float $noresidentes
 * @property float $extrajeros
 */
class Plan_Santamarta extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'planes_santamarta';
    public $timestamps = false;

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'viajes_turismos_id';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    //protected $incrementing = false;
    public $incrementing = false;
    /**
     * @var array
     */
    protected $fillable = ['numero', 'residentes', 'noresidentes', 'extrajeros'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function viajesTurismo()
    {
        return $this->belongsTo('App\ViajesTurismo', 'viajes_turismos_id');
    }
}
