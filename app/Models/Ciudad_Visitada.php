<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Municipio $municipio
 * @property TiposAlojamiento $tiposAlojamiento
 * @property Viaje $viaje
 * @property int $viajes_id
 * @property int $tipo_alojamientos_id
 * @property int $municipio_id
 * @property boolean $destino_principal
 * @property int $numero_noches
 */
class Ciudad_Visitada extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'ciudades_visitadas';
    public $timestamps = false;
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['destino_principal', 'numero_noches','municipio_id','viajes_id','tipo_alojamientos_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function municipio()
    {
         return $this->belongsTo('App\Models\Municipio');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tiposAlojamiento()
    {
        return $this->belongsTo('App\TiposAlojamiento', 'tipo_alojamientos_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function viaje()
    {
        return $this->belongsTo('App\Models\Viaje', 'viajes_id');
    }
}
