<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property PerfilesUsuariosConProveedore[] $perfilesUsuariosConProveedores
 * @property PerfilesUsuariosConEvento[] $perfilesUsuariosConEventos
 * @property PerfilesUsuariosConIdioma[] $perfilesUsuariosConIdiomas
 * @property PerfilesUsuariosConAtraccione[] $perfilesUsuariosConAtracciones
 * @property PerfilesUsuariosConActividade[] $perfilesUsuariosConActividades
 * @property int $id
 * @property string $user_create
 * @property string $user_update
 * @property boolean $estado
 * @property string $created_at
 * @property string $updated_at
 */
class Perfil_Usuario extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'perfiles_usuarios';

    /**
     * @var array
     */
    protected $fillable = ['user_create', 'user_update', 'estado', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function perfilesUsuariosConProveedores()
    {
        return $this->belongsToMany('App\Models\Proveedor', 'perfiles_usuarios_con_proveedores', 'perfiles_usuarios_id', 'proveedores_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function perfilesUsuariosConEventos()
    {
        return $this->belongsToMany('App\Models\Perfil_Usuario', 'perfiles_usuarios_con_eventos', 'perfiles_usuarios_id', 'eventos_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function perfilesUsuariosConIdiomas()
    {
        return $this->hasMany('App\Models\Perfil_Usuario_Con_Idioma', 'perfiles_usuarios_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function perfilesUsuariosConAtracciones()
    {
        return $this->belongsToMany('App\Models\Perfil_Usuario', 'perfiles_usuarios_con_atracciones', 'perfiles_usuarios_id', 'atracciones_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function perfilesUsuariosConActividades()
    {
       return $this->belongsToMany('App\Models\Perfil_Usuario_Con_Actividad', 'perfiles_usuarios_con_actividades', 'perfiles_usuarios_id', 'actividades_id');
    }
}
