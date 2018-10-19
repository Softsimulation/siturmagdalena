<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property DEstrato $dEstrato
 * @property DEstablecimientosNoComercial $dEstablecimientosNoComercial
 * @property DMotivosViaje $dMotivosViaje
 * @property DMunicipiosMagdalena $dMunicipiosMagdalena
 * @property DNivelEducacion $dNivelEducacion
 * @property DRangoEdade $dRangoEdade
 * @property DSexo $dSexo
 * @property DTiempoInterno $dTiempoInterno
 * @property integer $id
 * @property int $estratos_id
 * @property int $establecimiento_no_comercial_id
 * @property int $motivo_viaje_id
 * @property int $municipios_magdalena_id
 * @property int $nivel_educacion_id
 * @property int $rango_edad_id
 * @property int $sexo_id
 * @property int $tiempo_interno_id
 * @property float $media_acotada
 * @property int $cantidad
 * @property float $media
 * @property float $mediana
 * @property float $moda
 * @property boolean $es_interno
 */
class H_Duracion_Media_Estancia_Establecimiento_No_Comercial extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'h_duracion_media_estancia_establecimiento_no_comercial';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['estratos_id', 'establecimiento_no_comercial_id', 'motivo_viaje_id', 'municipios_magdalena_id', 'nivel_educacion_id', 'rango_edad_id', 'sexo_id', 'tiempo_interno_id', 'media_acotada', 'cantidad', 'media', 'mediana', 'moda', 'es_interno'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dEstrato()
    {
        return $this->belongsTo('App\DEstrato', 'estratos_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dEstablecimientosNoComercial()
    {
        return $this->belongsTo('App\DEstablecimientosNoComercial', 'establecimiento_no_comercial_id');
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
        return $this->belongsTo('App\DMunicipiosMagdalena', 'municipios_magdalena_id');
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
