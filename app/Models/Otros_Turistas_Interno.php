<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Viaje $viaje
 * @property int $viaje_id
 * @property int $numero
 */
class Otros_Turistas_Interno extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'otros_turistas_interno';

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
    protected $fillable = ['numero'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function viaje()
    {
        return $this->belongsTo('App\Viaje');
    }
}
