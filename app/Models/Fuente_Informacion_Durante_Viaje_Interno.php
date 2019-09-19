<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property FuentesInformacionDuranteViaje $fuentesInformacionDuranteViaje
 * @property Viaje $viaje
 * @property int $fuente_informacion_durante_id
 * @property int $viajes_id
 */
class Fuente_Informacion_Durante_Viaje_Interno extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'fuentes_informacion_durante_viajes_interno';
    protected $primaryKey = 'viajes_id';


    /**
     * @var array
     */
    protected $fillable = [];
    public $timestamps=false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function fuentesInformacionDuranteViaje()
    {
        return $this->belongsTo('App\Models\Fuente_Informacion_Durante_Viaje_Con_Idioma', 'fuente_informacion_durante_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function viaje()
    {
        return $this->belongsTo('App\Viaje', 'viajes_id');
    }
}
