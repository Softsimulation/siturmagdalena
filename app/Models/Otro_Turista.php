<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Visitante $visitante
 * @property int $visitante_id
 * @property int $numero_otros
 */
class Otro_Turista extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'otros_turistas';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'visitante_id';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    protected $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['numero_otros'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function visitante()
    {
        return $this->belongsTo('App\Visitante');
    }
}
