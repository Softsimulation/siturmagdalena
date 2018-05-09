<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Municipio $municipio
 * @property VisitantePaqueteTuristico $visitantePaqueteTuristico
 * @property int $visitante_id
 * @property int $municipios_id
 */
class Municipio_Paquete_Turistico extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'municipios_paquete_turistico';

    /**
     * @var array
     */
    protected $fillable = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function municipio()
    {
        return $this->belongsTo('App\Municipio', 'municipios_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function visitantePaqueteTuristico()
    {
        return $this->belongsTo('App\VisitantePaqueteTuristico', 'visitante_id', 'visitante_id');
    }
}
