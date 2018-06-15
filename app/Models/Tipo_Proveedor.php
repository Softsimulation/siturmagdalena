<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property CategoriaProveedore[] $categoriaProveedores
 * @property TipoProveedoresConIdioma[] $tipoProveedoresConIdiomas
 * @property TipoCaracteristica[] $tipoCaracteristicas
 * @property int $id
 * @property string $user_update
 * @property boolean $estado
 * @property string $created_at
 * @property string $updated_at
 * @property string $user_create
 * @property string $icono_lejos
 * @property string $icono_cerca
 * @property string $icono_menu
 */
class Tipo_Proveedor extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'tipo_proveedores';

    /**
     * @var array
     */
    protected $fillable = ['user_update', 'estado', 'created_at', 'updated_at', 'user_create', 'icono_lejos', 'icono_cerca', 'icono_menu'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function categoriaProveedores()
    {
        return $this->hasMany('App\CategoriaProveedore', 'tipo_proveedores_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tipoProveedoresConIdiomas()
    {
        return $this->hasMany('App\TipoProveedoresConIdioma', 'tipo_proveedores_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tipoCaracteristicas()
    {
        return $this->hasMany('App\TipoCaracteristica', 'tipo_proveedor_id');
    }
}
