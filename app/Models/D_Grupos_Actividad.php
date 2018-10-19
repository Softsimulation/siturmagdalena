<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property HEmpleadosDominioIngle[] $hEmpleadosDominioIngles
 * @property HNumeroVacante[] $hNumeroVacantes
 * @property HPromedioSalarialGrupo[] $hPromedioSalarialGrupos
 * @property int $id
 * @property string $nombre
 * @property string $name
 * @property boolean $estado
 * @property string $created_at
 * @property string $updated_at
 * @property string $user_create
 * @property string $user_update
 */
class D_Grupos_Actividad extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'd_grupos_actividad';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    protected $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['nombre', 'name', 'estado', 'created_at', 'updated_at', 'user_create', 'user_update'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hEmpleadosDominioIngles()
    {
        return $this->hasMany('App\HEmpleadosDominioIngle', 'grupos_actividad_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hNumeroVacantes()
    {
        return $this->hasMany('App\HNumeroVacante', 'grupos_actividad_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hPromedioSalarialGrupos()
    {
        return $this->hasMany('App\HPromedioSalarialGrupo', 'grupo_actividad_id');
    }
}
