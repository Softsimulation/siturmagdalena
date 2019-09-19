<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Viaje $viaje
 * @property int $viajes_id
 * @property string $nombre
 */
class Otra_Fuente_Informacion_Durante_Viaje_Interno extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'otras_fuentes_informacion_durante_viaje_interno';
    public $timestamps=false;

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
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['nombre'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function viaje()
    {
        return $this->belongsTo('App\Viaje', 'viajes_id');
    }
}
