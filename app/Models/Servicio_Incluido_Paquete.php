<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property ServiciosPaquete $serviciosPaquete
 * @property VisitantePaqueteTuristico $visitantePaqueteTuristico
 * @property int $visitante_id
 * @property int $servicios_paquete_id
 */
class Servicio_Incluido_Paquete extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'servicios_incluidos_paquete';

    /**
     * @var array
     */
    protected $fillable = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function serviciosPaquete()
    {
        return $this->belongsTo('App\ServiciosPaquete');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function visitantePaqueteTuristico()
    {
        return $this->belongsTo('App\VisitantePaqueteTuristico', 'visitante_id', 'visitante_id');
    }
}
