<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property DMotivosViaje $dMotivosViaje
 * @property DMunicipiosMagdalena $dMunicipiosMagdalena
 * @property DOpcionesNacimiento $dOpcionesNacimiento
 * @property DRangoEdade $dRangoEdade
 * @property DResidenciaVisitante $dResidenciaVisitante
 * @property DSexo $dSexo
 * @property DTiempo $dTiempo
 * @property DTiposAlojamiento $dTiposAlojamiento
 * @property int $id
 * @property int $motivo_id
 * @property int $municipios_magdalena_id
 * @property int $opciones_nacimiento_id
 * @property int $rango_edades_id
 * @property int $residencia_visitante_id
 * @property int $sexos_id
 * @property int $tiempo_id
 * @property int $tipos_alojamiento_id
 * @property float $media_acotada
 * @property float $moda
 * @property float $mediana
 * @property float $promedio
 * @property int $cantidad_datos
 * @property string $user_create
 * @property string $user_update
 * @property boolean $estado
 * @property string $created_at
 * @property string $updated_at
 */
class H_Duracion_Media_Estancia_Receptor extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'h_duracion_media_estancia_receptor';

    /**
     * @var array
     */
    protected $fillable = ['motivo_id', 'municipios_magdalena_id', 'opciones_nacimiento_id', 'rango_edades_id', 'residencia_visitante_id', 'sexos_id', 'tiempo_id', 'tipos_alojamiento_id', 'media_acotada', 'moda', 'mediana', 'promedio', 'cantidad_datos', 'user_create', 'user_update', 'estado', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dMotivosViaje()
    {
        return $this->belongsTo('App\DMotivosViaje', 'motivo_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dMunicipiosMagdalena()
    {
        return $this->belongsTo('App\DMunicipiosMagdalena', 'municipios_magdalena_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dOpcionesNacimiento()
    {
        return $this->belongsTo('App\DOpcionesNacimiento', 'opciones_nacimiento_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dRangoEdade()
    {
        return $this->belongsTo('App\DRangoEdade', 'rango_edades_id');
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
        return $this->belongsTo('App\DSexo', 'sexos_id');
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
        return $this->belongsTo('App\DTiposAlojamiento', 'tipos_alojamiento_id');
    }
}
