<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Municipio $municipio
 * @property TiposAlojamiento $tiposAlojamiento
 * @property Visitante $visitante
 * @property int $municipios_id
 * @property int $visitante_id
 * @property int $tipo_alojamiento_id
 * @property int $numero_noches
 * @property boolean $destino_principal
 */
class Municipio_Visitado_Magdalena extends Model
{
    public $timestamps = false;
    public $incrementing = false;
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'municipios_visitados_magdalena';

    /**
     * @var array
     */
    protected $fillable = ['tipo_alojamiento_id', 'numero_noches', 'destino_principal','visitante_id','municipios_id'];

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
    public function tiposAlojamiento()
    {
        return $this->belongsTo('App\TiposAlojamiento', 'tipo_alojamiento_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function visitante()
    {
        return $this->belongsTo('App\Visitante');
    }
}
