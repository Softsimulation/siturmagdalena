<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property OpcionesLugare $opcionesLugare
 * @property Visitante $visitante
 * @property int $visitante_id
 * @property int $opciones_lugares_id
 */
class Visitante_Alquila_Vehiculo extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'visitante_alquila_vehiculo';

    /**
     * @var array
     */
    protected $fillable = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function opcionesLugare()
    {
        return $this->belongsTo('App\OpcionesLugare', 'opciones_lugares_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function visitante()
    {
        return $this->belongsTo('App\Visitante');
    }
}
