<?php

namespace App;

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

    /**
     * @var array
     */
    protected $fillable = ['destino_principal', 'numero_noches'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function municipio()
    {
        return $this->belongsTo('App\Municipio');
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
        return $this->belongsTo('App\Viaje', 'viajes_id');
    }
}
