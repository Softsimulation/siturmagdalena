<?php

namespace App;

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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function perfilesUsuariosConProveedores()
    {
        return $this->hasMany('App\PerfilesUsuariosConProveedore', 'perfiles_usuarios_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function perfilesUsuariosConEventos()
    {
        return $this->hasMany('App\PerfilesUsuariosConEvento', 'perfiles_usuarios_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function perfilesUsuariosConIdiomas()
    {
        return $this->hasMany('App\PerfilesUsuariosConIdioma', 'perfiles_usuarios_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function perfilesUsuariosConAtracciones()
    {
        return $this->hasMany('App\PerfilesUsuariosConAtraccione', 'perfiles_usuarios_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function perfilesUsuariosConActividades()
    {
        return $this->hasMany('App\PerfilesUsuariosConActividade', 'perfiles_usuarios_id');
    }
}
