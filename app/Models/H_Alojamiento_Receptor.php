<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property DMotivosViaje $dMotivosViaje
 * @property DRangoEdade $dRangoEdade
 * @property DResidenciaVisitante $dResidenciaVisitante
 * @property DSexo $dSexo
 * @property DTiempo $dTiempo
 * @property DTiposAlojamiento $dTiposAlojamiento
 * @property int $id
 * @property int $motivo_viaje_id
 * @property int $rango_edad_id
 * @property int $residencia_visitante_id
 * @property int $sexo_id
 * @property int $tiempo_id
 * @property int $tipo_alojamiento_id
 * @property float $frecuencia
 * @property string $user_create
 * @property string $user_update
 * @property boolean $estado
 * @property string $created_at
 * @property string $updated_at
 */
class H_Alojamiento_Receptor extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'h_alojamientos_receptor';

    /**
     * @var array
     */
    protected $fillable = ['motivo_viaje_id', 'rango_edad_id', 'residencia_visitante_id', 'sexo_id', 'tiempo_id', 'tipo_alojamiento_id', 'frecuencia', 'user_create', 'user_update', 'estado', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dMotivosViaje()
    {
        return $this->belongsTo('App\DMotivosViaje', 'motivo_viaje_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dRangoEdade()
    {
        return $this->belongsTo('App\DRangoEdade', 'rango_edad_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dResidenciaVisitante()
    {
        return $this->belongsTo('App\DResidenciaVisitante', 'residencia_visitante_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dSexo()
    {
        return $this->belongsTo('App\DSexo', 'sexo_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dTiempo()
    {
        return $this->belongsTo('App\DTiempo', 'tiempo_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dTiposAlojamiento()
    {
        return $this->belongsTo('App\DTiposAlojamiento', 'tipo_alojamiento_id');
    }
}
