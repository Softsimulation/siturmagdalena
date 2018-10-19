<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property HCapacidadRestaurante[] $hCapacidadRestaurantes
 * @property HEmpleadosDominioIngle[] $hEmpleadosDominioIngles
 * @property HNumeroVacante[] $hNumeroVacantes
 * @property HNumeroEstablecimiento[] $hNumeroEstablecimientos
 * @property HOcupacionHotele[] $hOcupacionHoteles
 * @property HServiciosTuristicosAgencia[] $hServiciosTuristicosAgencias
 * @property HPromedioSalarialGrupo[] $hPromedioSalarialGrupos
 * @property HVinculacionLaboral[] $hVinculacionLaborals
 * @property HViajesEmisoresAgencia[] $hViajesEmisoresAgencias
 * @property HViajesInternosAgencia[] $hViajesInternosAgencias
 * @property HJornadaLaboral[] $hJornadaLaborals
 * @property int $id
 * @property string $sector
 * @property string $destino
 * @property string $sector_ingles
 * @property string $destination
 * @property string $updated_at
 * @property string $user_create
 * @property string $user_update
 * @property boolean $estado
 * @property string $created_at
 */
class D_Ubicacion_Proveedor extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'd_ubicacion_proveedor';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    protected $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['sector', 'destino', 'sector_ingles', 'destination', 'updated_at', 'user_create', 'user_update', 'estado', 'created_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hCapacidadRestaurantes()
    {
        return $this->hasMany('App\HCapacidadRestaurante', 'ubicacion_proveedor_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hEmpleadosDominioIngles()
    {
        return $this->hasMany('App\HEmpleadosDominioIngle', 'ubicacion_proveedor_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hNumeroVacantes()
    {
        return $this->hasMany('App\HNumeroVacante', 'ubicacion_proveedor_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hNumeroEstablecimientos()
    {
        return $this->hasMany('App\HNumeroEstablecimiento', 'ubicacion_proveedor');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hOcupacionHoteles()
    {
        return $this->hasMany('App\HOcupacionHotele', 'ubicacion_proveedor_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hServiciosTuristicosAgencias()
    {
        return $this->hasMany('App\HServiciosTuristicosAgencia', 'ubicacion_proveedor');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hPromedioSalarialGrupos()
    {
        return $this->hasMany('App\HPromedioSalarialGrupo', 'ubicacion_proveedor_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hVinculacionLaborals()
    {
        return $this->hasMany('App\HVinculacionLaboral', 'ubicacion_proveedor_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hViajesEmisoresAgencias()
    {
        return $this->hasMany('App\HViajesEmisoresAgencia', 'ubicacion_proveedor');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hViajesInternosAgencias()
    {
        return $this->hasMany('App\HViajesInternosAgencia', 'ubicacion_proveedor');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hJornadaLaborals()
    {
        return $this->hasMany('App\HJornadaLaboral', 'ubicacion_proveedor_id');
    }
}
