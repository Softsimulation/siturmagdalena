<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property HAlojamientosInternoEmisor[] $hAlojamientosInternoEmisors
 * @property HDuracionMediaEstanciaEstablecimientoNoComercial[] $hDuracionMediaEstanciaEstablecimientoNoComercials
 * @property HDuracionMediaEstanciaEstablecimientoComercial[] $hDuracionMediaEstanciaEstablecimientoComercials
 * @property HDuracionMediaEstanciaInternoEmisor[] $hDuracionMediaEstanciaInternoEmisors
 * @property HGastoMedioTotalInternoEmisor[] $hGastoMedioTotalInternoEmisors
 * @property HMedioTransporteInternoEmisor[] $hMedioTransporteInternoEmisors
 * @property HMotivosViajesInternoEmisor[] $hMotivosViajesInternoEmisors
 * @property int $id
 * @property string $estrato
 * @property string $user_create
 * @property string $user_update
 * @property boolean $estado
 * @property string $created_at
 * @property string $updated_at
 */
class D_Estrato extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'd_estratos';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    protected $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['estrato', 'user_create', 'user_update', 'estado', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hAlojamientosInternoEmisors()
    {
        return $this->hasMany('App\HAlojamientosInternoEmisor', 'estrato_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hDuracionMediaEstanciaEstablecimientoNoComercials()
    {
        return $this->hasMany('App\HDuracionMediaEstanciaEstablecimientoNoComercial', 'estratos_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hDuracionMediaEstanciaEstablecimientoComercials()
    {
        return $this->hasMany('App\HDuracionMediaEstanciaEstablecimientoComercial', 'estratos_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hDuracionMediaEstanciaInternoEmisors()
    {
        return $this->hasMany('App\HDuracionMediaEstanciaInternoEmisor', 'estratos_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hGastoMedioTotalInternoEmisors()
    {
        return $this->hasMany('App\HGastoMedioTotalInternoEmisor', 'estrato_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hMedioTransporteInternoEmisors()
    {
        return $this->hasMany('App\HMedioTransporteInternoEmisor', 'estrato_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hMotivosViajesInternoEmisors()
    {
        return $this->hasMany('App\HMotivosViajesInternoEmisor', 'estrato_id');
    }
}
