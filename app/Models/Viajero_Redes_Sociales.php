<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Viaje $viaje
 * @property int $viajes_id
 * @property string $nombre_facebook
 * @property string $nombre_twitter
 */
class Viajero_Redes_Sociales extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'viajero_redes_sociales';
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
    protected $fillable = ['nombre_facebook', 'nombre_twitter'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function viaje()
    {
        return $this->belongsTo('App\Viaje', 'viajes_id');
    }
}
