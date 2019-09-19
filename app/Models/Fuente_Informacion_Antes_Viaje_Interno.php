<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property FuentesInformacionAntesViaje $fuentesInformacionAntesViaje
 * @property Viaje $viaje
 * @property int $fuentes_informacion_antes_id
 * @property int $viajes_id
 */
class Fuente_Informacion_Antes_Viaje_Interno extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'fuentes_informacion_antes_viajes_interno';
    protected $primaryKey = 'viajes_id';
    public $timestamps=false;

    /**
     * @var array
     */
    protected $fillable = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function fuentesInformacionAntesViaje()
    {
        return $this->belongsTo('App\FuentesInformacionAntesViaje', 'fuentes_informacion_antes_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function viaje()
    {
        return $this->belongsTo('App\Viaje', 'viajes_id');
    }
}
