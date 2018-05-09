<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property FuentesInformacionDuranteViaje $fuentesInformacionDuranteViaje
 * @property Visitante $visitante
 * @property int $visitante_id
 * @property int $fuente_informacion_durante_viaje_id
 */
class Informacion_Visitante_Durante_Viaje extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'informacion_visitante_durante_viaje';

    /**
     * @var array
     */
    protected $fillable = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function fuentesInformacionDuranteViaje()
    {
        return $this->belongsTo('App\FuentesInformacionDuranteViaje', 'fuente_informacion_durante_viaje_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function visitante()
    {
        return $this->belongsTo('App\Visitante');
    }
}
