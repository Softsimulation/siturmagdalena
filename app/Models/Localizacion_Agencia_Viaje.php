<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property OpcionesLugare $opcionesLugare
 * @property VisitantePaqueteTuristico $visitantePaqueteTuristico
 * @property int $visitante_id
 * @property int $opcion_lugar_id
 */
class Localizacion_Agencia_Viaje extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'localizacion_agencia_viaje';

    /**
     * @var array
     */
    protected $fillable = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function opcionesLugare()
    {
        return $this->belongsTo('App\OpcionesLugare', 'opcion_lugar_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function visitantePaqueteTuristico()
    {
        return $this->belongsTo('App\VisitantePaqueteTuristico', 'visitante_id', 'visitante_id');
    }
}
