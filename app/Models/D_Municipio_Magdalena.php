<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property HAlojamientosInternoEmisor[] $hAlojamientosInternoEmisors
 * @property HDuracionMediaEstanciaEstablecimientoNoComercial[] $hDuracionMediaEstanciaEstablecimientoNoComercials
 * @property HDuracionMediaEstanciaEstablecimientoComercial[] $hDuracionMediaEstanciaEstablecimientoComercials
 * @property HDuracionMediaEstanciaInternoEmisor[] $hDuracionMediaEstanciaInternoEmisors
 * @property HDuracionMediaEstanciaReceptor[] $hDuracionMediaEstanciaReceptors
 * @property HGastoMedioTotalInternoEmisor[] $hGastoMedioTotalInternoEmisors
 * @property HMedioTransporteInternoEmisor[] $hMedioTransporteInternoEmisors
 * @property HMotivosViajesInternoEmisor[] $hMotivosViajesInternoEmisors
 * @property int $id
 * @property string $nombre
 * @property string $user_update
 * @property boolean $estado
 * @property string $created_at
 * @property string $updated_at
 * @property string $user_create
 */
class D_Municipio_Magdalena extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'd_municipios_magdalena';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    protected $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['nombre', 'user_update', 'estado', 'created_at', 'updated_at', 'user_create'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hAlojamientosInternoEmisors()
    {
        return $this->hasMany('App\HAlojamientosInternoEmisor', 'municipio_magdalena_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hDuracionMediaEstanciaEstablecimientoNoComercials()
    {
        return $this->hasMany('App\HDuracionMediaEstanciaEstablecimientoNoComercial', 'municipios_magdalena_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hDuracionMediaEstanciaEstablecimientoComercials()
    {
        return $this->hasMany('App\HDuracionMediaEstanciaEstablecimientoComercial', 'municipios_magdalena_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hDuracionMediaEstanciaInternoEmisors()
    {
        return $this->hasMany('App\HDuracionMediaEstanciaInternoEmisor', 'municipios_magdalena_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hDuracionMediaEstanciaReceptors()
    {
        return $this->hasMany('App\HDuracionMediaEstanciaReceptor', 'municipios_magdalena_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hGastoMedioTotalInternoEmisors()
    {
        return $this->hasMany('App\HGastoMedioTotalInternoEmisor', 'municipio_magdalena_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hMedioTransporteInternoEmisors()
    {
        return $this->hasMany('App\HMedioTransporteInternoEmisor', 'municipio_magdalena_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hMotivosViajesInternoEmisors()
    {
        return $this->hasMany('App\HMotivosViajesInternoEmisor', 'municipio_magdalena_id');
    }
}
