<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property TipoProveedore $tipoProveedore
 * @property CategoriaProveedoresConIdioma[] $categoriaProveedoresConIdiomas
 * @property Proveedore[] $proveedores
 * @property DatoRnt[] $datoRnts
 * @property int $id
 * @property int $tipo_proveedores_id
 * @property string $user_update
 * @property boolean $estado
 * @property string $created_at
 * @property string $updated_at
 * @property string $user_create
 */
class Categoria_Proveedor extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'categoria_proveedores';

    /**
     * @var array
     */
    protected $fillable = ['tipo_proveedores_id', 'user_update', 'estado', 'created_at', 'updated_at', 'user_create'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tipoProveedore()
    {
        return $this->belongsTo('App\Models\Tipo_Proveedor', 'tipo_proveedores_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function categoriaProveedoresConIdiomas()
    {
        return $this->hasMany('App\Models\Categoria_Proveedor_Con_Idioma', 'categoria_proveedores_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function proveedores()
    {
        return $this->hasMany('App\Models\Proveedor', 'categoria_proveedores_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function datoRnts()
    {
        return $this->hasMany('App\DatoRnt', 'tipos_proveedor_id');
    }
}
