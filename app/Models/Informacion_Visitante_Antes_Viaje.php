<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property FuentesInformacionAntesViaje $fuentesInformacionAntesViaje
 * @property Visitante $visitante
 * @property int $visitante_id
 * @property int $fuentes_informacion_antes_viaje
 */
class Informacion_Visitante_Antes_Viaje extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'informacion_visitante_antes_viaje';

    /**
     * @var array
     */
    protected $fillable = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function fuentesInformacionAntesViaje()
    {
        return $this->belongsTo('App\FuentesInformacionAntesViaje', 'fuentes_informacion_antes_viaje');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function visitante()
    {
        return $this->belongsTo('App\Visitante');
    }
}
