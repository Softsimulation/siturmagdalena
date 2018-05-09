<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property HEmpleadosDominioIngle[] $hEmpleadosDominioIngles
 * @property HPromedioSalarialGrupo[] $hPromedioSalarialGrupos
 * @property HVinculacionLaboral[] $hVinculacionLaborals
 * @property HJornadaLaboral[] $hJornadaLaborals
 * @property int $id
 * @property string $trimestre
 * @property string $trimester
 * @property int $numeroMes
 * @property int $año
 * @property string $user_create
 * @property string $user_update
 * @property boolean $estado
 * @property string $created_at
 * @property string $updated_at
 */
class D_Tiempo_Empleo extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'd_tiempo_empleo';

    /**
     * @var array
     */
    protected $fillable = ['trimestre', 'trimester', 'numeroMes', 'año', 'user_create', 'user_update', 'estado', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hEmpleadosDominioIngles()
    {
        return $this->hasMany('App\HEmpleadosDominioIngle', 'tiempo_empleo_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hPromedioSalarialGrupos()
    {
        return $this->hasMany('App\HPromedioSalarialGrupo', 'tiempo_empleo_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hVinculacionLaborals()
    {
        return $this->hasMany('App\HVinculacionLaboral', 'tiempo_empleo_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hJornadaLaborals()
    {
        return $this->hasMany('App\HJornadaLaboral', 'tiempo_empleo_id');
    }
}
