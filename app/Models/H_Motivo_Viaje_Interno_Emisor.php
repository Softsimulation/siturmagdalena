<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property DEstrato $dEstrato
 * @property DMotivosViaje $dMotivosViaje
 * @property DMunicipiosMagdalena $dMunicipiosMagdalena
 * @property DNivelEducacion $dNivelEducacion
 * @property DRangoEdade $dRangoEdade
 * @property DSexo $dSexo
 * @property DTiempoInterno $dTiempoInterno
 * @property int $id
 * @property int $estrato_id
 * @property int $motivo_viaje_id
 * @property int $municipio_magdalena_id
 * @property int $nivel_educacion_id
 * @property int $rango_edad_id
 * @property int $sexo_id
 * @property int $tiempo_interno_id
 * @property float $frecuencia
 * @property boolean $es_interno
 * @property string $user_create
 * @property string $user_update
 * @property boolean $estado
 * @property string $created_at
 * @property string $updated_at
 */
class H_Motivo_Viaje_Interno_Emisor extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'h_motivos_viajes_interno_emisor';

    /**
     * @var array
     */
    protected $fillable = ['estrato_id', 'motivo_viaje_id', 'municipio_magdalena_id', 'nivel_educacion_id', 'rango_edad_id', 'sexo_id', 'tiempo_interno_id', 'frecuencia', 'es_interno', 'user_create', 'user_update', 'estado', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dEstrato()
    {
        return $this->belongsTo('App\DEstrato', 'estrato_id');
    }

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
    public function dMunicipiosMagdalena()
    {
        return $this->belongsTo('App\DMunicipiosMagdalena', 'municipio_magdalena_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dNivelEducacion()
    {
        return $this->belongsTo('App\DNivelEducacion', 'nivel_educacion_id');
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
    public function dSexo()
    {
        return $this->belongsTo('App\DSexo', 'sexo_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dTiempoInterno()
    {
        return $this->belongsTo('App\DTiempoInterno', 'tiempo_interno_id');
    }
}
