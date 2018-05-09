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
 * @property string $name
 * @property string $user_update
 * @property boolean $estado
 * @property string $created_at
 * @property string $updated_at
 * @property string $user_create
 */
class D_Sexo extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'd_sexos';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    protected $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['nombre', 'name', 'user_update', 'estado', 'created_at', 'updated_at', 'user_create'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hAlojamientosInternoEmisors()
    {
        return $this->hasMany('App\HAlojamientosInternoEmisor', 'sexo_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hAlojamientosReceptors()
    {
        return $this->hasMany('App\HAlojamientosReceptor', 'sexo_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hDuracionMediaEstanciaEstablecimientoNoComercials()
    {
        return $this->hasMany('App\HDuracionMediaEstanciaEstablecimientoNoComercial', 'sexo_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hDuracionMediaEstanciaEstablecimientoComercials()
    {
        return $this->hasMany('App\HDuracionMediaEstanciaEstablecimientoComercial', 'sexo_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hDuracionMediaEstanciaInternoEmisors()
    {
        return $this->hasMany('App\HDuracionMediaEstanciaInternoEmisor', 'sexo_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hDuracionMediaEstanciaReceptors()
    {
        return $this->hasMany('App\HDuracionMediaEstanciaReceptor', 'sexos_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hGastoMedioTotalReceptors()
    {
        return $this->hasMany('App\HGastoMedioTotalReceptor', 'sexo_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hGastoMedioTotalInternoEmisors()
    {
        return $this->hasMany('App\HGastoMedioTotalInternoEmisor', 'sexo_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hGastoMedioReceptors()
    {
        return $this->hasMany('App\HGastoMedioReceptor', 'sexo_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hMedioTransporteInternoEmisors()
    {
        return $this->hasMany('App\HMedioTransporteInternoEmisor', 'sexo_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hMotivosViajesReceptors()
    {
        return $this->hasMany('App\HMotivosViajesReceptor', 'sexo_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hMedioTransporteReceptors()
    {
        return $this->hasMany('App\HMedioTransporteReceptor', 'sexo_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hMotivosViajesInternoEmisors()
    {
        return $this->hasMany('App\HMotivosViajesInternoEmisor', 'sexo_id');
    }
}
