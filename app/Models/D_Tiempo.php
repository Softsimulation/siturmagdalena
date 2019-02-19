<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property HCapacidadRestaurante[] $hCapacidadRestaurantes
 * @property HAlojamientosReceptor[] $hAlojamientosReceptors
 * @property HDuracionMediaEstanciaReceptor[] $hDuracionMediaEstanciaReceptors
 * @property HGastoMedioTotalReceptor[] $hGastoMedioTotalReceptors
 * @property HGastoMedioReceptor[] $hGastoMedioReceptors
 * @property HNumeroVacante[] $hNumeroVacantes
 * @property HMotivosViajesReceptor[] $hMotivosViajesReceptors
 * @property HNumeroEmpleado[] $hNumeroEmpleados
 * @property HNumeroEstablecimiento[] $hNumeroEstablecimientos
 * @property HOcupacionHotele[] $hOcupacionHoteles
 * @property HServiciosTuristicosAgencia[] $hServiciosTuristicosAgencias
 * @property HTamañoGrupoViajeReceptor[] $hTamañoGrupoViajeReceptors
 * @property HViajesEmisoresAgencia[] $hViajesEmisoresAgencias
 * @property HViajesInternosAgencia[] $hViajesInternosAgencias
 * @property HMedioTransporteReceptor[] $hMedioTransporteReceptors
 * @property int $id
 * @property string $meses
 * @property string $month
 * @property int $años
 * @property string $user_update
 * @property boolean $estado
 * @property string $created_at
 * @property string $updated_at
 * @property string $user_create
 */
class D_Tiempo extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'd_tiempo';

    /**
     * @var array
     */
    protected $fillable = ['meses', 'month', 'años', 'user_update', 'estado', 'created_at', 'updated_at', 'user_create'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hCapacidadRestaurantes()
    {
        return $this->hasMany('App\HCapacidadRestaurante', 'tiempo_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hAlojamientosReceptors()
    {
        return $this->hasMany('App\HAlojamientosReceptor', 'tiempo_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hDuracionMediaEstanciaReceptors()
    {
        return $this->hasMany('App\HDuracionMediaEstanciaReceptor', 'tiempo_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hGastoMedioTotalReceptors()
    {
        return $this->hasMany('App\HGastoMedioTotalReceptor', 'tiempo_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hGastoMedioReceptors()
    {
        return $this->hasMany('App\HGastoMedioReceptor', 'tiempo_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hNumeroVacantes()
    {
        return $this->hasMany('App\HNumeroVacante', 'tiempo_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hMotivosViajesReceptors()
    {
        return $this->hasMany('App\HMotivosViajesReceptor', 'tiempo_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hNumeroEmpleados()
    {
        return $this->hasMany('App\HNumeroEmpleado', 'tiempo_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hNumeroEstablecimientos()
    {
        return $this->hasMany('App\HNumeroEstablecimiento', 'tiempo_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hOcupacionHoteles()
    {
        return $this->hasMany('App\HOcupacionHotele', 'tiempo_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hServiciosTuristicosAgencias()
    {
        return $this->hasMany('App\HServiciosTuristicosAgencia', 'tiempo_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hTamañoGrupoViajeReceptors()
    {
        return $this->hasMany('App\HTamañoGrupoViajeReceptor', 'tiempo_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hViajesEmisoresAgencias()
    {
        return $this->hasMany('App\HViajesEmisoresAgencia', 'tiempo_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hViajesInternosAgencias()
    {
        return $this->hasMany('App\HViajesInternosAgencia', 'tiempo_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hMedioTransporteReceptors()
    {
        return $this->hasMany('App\HMedioTransporteReceptor', 'tiempo_id');
    }
}
