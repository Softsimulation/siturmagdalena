<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property HAlojamientosInternoEmisor[] $hAlojamientosInternoEmisors
 * @property HAlojamientosReceptor[] $hAlojamientosReceptors
 * @property HDuracionMediaEstanciaEstablecimientoNoComercial[] $hDuracionMediaEstanciaEstablecimientoNoComercials
 * @property HDuracionMediaEstanciaEstablecimientoComercial[] $hDuracionMediaEstanciaEstablecimientoComercials
 * @property HDuracionMediaEstanciaInternoEmisor[] $hDuracionMediaEstanciaInternoEmisors
 * @property HDuracionMediaEstanciaReceptor[] $hDuracionMediaEstanciaReceptors
 * @property HGastoMedioTotalReceptor[] $hGastoMedioTotalReceptors
 * @property HGastoMedioTotalInternoEmisor[] $hGastoMedioTotalInternoEmisors
 * @property HGastoMedioReceptor[] $hGastoMedioReceptors
 * @property HMedioTransporteInternoEmisor[] $hMedioTransporteInternoEmisors
 * @property HMotivosViajesReceptor[] $hMotivosViajesReceptors
 * @property HMedioTransporteReceptor[] $hMedioTransporteReceptors
 * @property HMotivosViajesInternoEmisor[] $hMotivosViajesInternoEmisors
 * @property int $id
 * @property string $nombre
 * @property string $user_update
 * @property boolean $estado
 * @property string $created_at
 * @property string $updated_at
 * @property string $user_create
 * @property int $valormin
 * @property int $valormax
 */
class D_Rango_Edad extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'd_rango_edades';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    protected $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['nombre', 'user_update', 'estado', 'created_at', 'updated_at', 'user_create', 'valormin', 'valormax'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hAlojamientosInternoEmisors()
    {
        return $this->hasMany('App\HAlojamientosInternoEmisor', 'rango_edad_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hAlojamientosReceptors()
    {
        return $this->hasMany('App\HAlojamientosReceptor', 'rango_edad_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hDuracionMediaEstanciaEstablecimientoNoComercials()
    {
        return $this->hasMany('App\HDuracionMediaEstanciaEstablecimientoNoComercial', 'rango_edad_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hDuracionMediaEstanciaEstablecimientoComercials()
    {
        return $this->hasMany('App\HDuracionMediaEstanciaEstablecimientoComercial', 'rango_edad_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hDuracionMediaEstanciaInternoEmisors()
    {
        return $this->hasMany('App\HDuracionMediaEstanciaInternoEmisor', 'rango_edad_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hDuracionMediaEstanciaReceptors()
    {
        return $this->hasMany('App\HDuracionMediaEstanciaReceptor', 'rango_edades_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hGastoMedioTotalReceptors()
    {
        return $this->hasMany('App\HGastoMedioTotalReceptor', 'rango_edades_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hGastoMedioTotalInternoEmisors()
    {
        return $this->hasMany('App\HGastoMedioTotalInternoEmisor', 'rango_edad_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hGastoMedioReceptors()
    {
        return $this->hasMany('App\HGastoMedioReceptor', 'rango_edades_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hMedioTransporteInternoEmisors()
    {
        return $this->hasMany('App\HMedioTransporteInternoEmisor', 'rango_edad_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hMotivosViajesReceptors()
    {
        return $this->hasMany('App\HMotivosViajesReceptor', 'rango_edades_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hMedioTransporteReceptors()
    {
        return $this->hasMany('App\HMedioTransporteReceptor', 'rango_edades_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hMotivosViajesInternoEmisors()
    {
        return $this->hasMany('App\HMotivosViajesInternoEmisor', 'rango_edad_id');
    }
}
