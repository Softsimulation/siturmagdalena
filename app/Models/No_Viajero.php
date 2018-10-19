<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property MotivoNoViaje $motivoNoViaje
 * @property Persona $persona
 * @property int $persona_id
 * @property int $motivo_no_viaje_id
 */
class No_Viajero extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'no_viajeros';
    public $timestamps=false;

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'persona_id';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['motivo_no_viaje_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function motivoNoViaje()
    {
        return $this->belongsTo('App\MotivoNoViaje');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function persona()
    {
        return $this->belongsTo('App\Persona');
    }
}
