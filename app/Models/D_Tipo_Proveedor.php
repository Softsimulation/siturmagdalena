<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property HCapacidadRestaurante[] $hCapacidadRestaurantes
 * @property HEmpleadosDominioIngle[] $hEmpleadosDominioIngles
 * @property HNumeroVacante[] $hNumeroVacantes
 * @property HNumeroEmpleado[] $hNumeroEmpleados
 * @property HNumeroEstablecimiento[] $hNumeroEstablecimientos
 * @property HOcupacionHotele[] $hOcupacionHoteles
 * @property HServiciosTuristicosAgencia[] $hServiciosTuristicosAgencias
 * @property HPromedioSalarialGrupo[] $hPromedioSalarialGrupos
 * @property HVinculacionLaboral[] $hVinculacionLaborals
 * @property HViajesEmisoresAgencia[] $hViajesEmisoresAgencias
 * @property HViajesInternosAgencia[] $hViajesInternosAgencias
 * @property HJornadaLaboral[] $hJornadaLaborals
 * @property int $id
 * @property string $tipo
 * @property string $subtipo
 * @property string $type
 * @property string $subtype
 * @property string $user_create
 * @property string $user_update
 * @property boolean $estado
 * @property string $created_at
 * @property string $updated_at
 */
class D_Tipo_Proveedor extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'd_tipos_proveedores';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    protected $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['tipo', 'subtipo', 'type', 'subtype', 'user_create', 'user_update', 'estado', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hCapacidadRestaurantes()
    {
        return $this->hasMany('App\HCapacidadRestaurante', 'tipo_proveedor_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hEmpleadosDominioIngles()
    {
        return $this->hasMany('App\HEmpleadosDominioIngle', 'tipo_proveedor_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hNumeroVacantes()
    {
        return $this->hasMany('App\HNumeroVacante', 'tipo_proveedor_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hNumeroEmpleados()
    {
        return $this->hasMany('App\HNumeroEmpleado', 'tipo_proveedor_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hNumeroEstablecimientos()
    {
        return $this->hasMany('App\HNumeroEstablecimiento', 'tipo_proveedor_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hOcupacionHoteles()
    {
        return $this->hasMany('App\HOcupacionHotele', 'tipo_proveedor_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hServiciosTuristicosAgencias()
    {
        return $this->hasMany('App\HServiciosTuristicosAgencia', 'tipo_proveedor_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hPromedioSalarialGrupos()
    {
        return $this->hasMany('App\HPromedioSalarialGrupo', 'tipo_proveedor_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hVinculacionLaborals()
    {
        return $this->hasMany('App\HVinculacionLaboral', 'tipo_proveedor_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hViajesEmisoresAgencias()
    {
        return $this->hasMany('App\HViajesEmisoresAgencia', 'tipo_proveedor_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hViajesInternosAgencias()
    {
        return $this->hasMany('App\HViajesInternosAgencia', 'tipo_proveedor_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hJornadaLaborals()
    {
        return $this->hasMany('App\HJornadaLaboral', 'tipo_proveedor_id');
    }
}
