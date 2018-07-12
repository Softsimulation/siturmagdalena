<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property ClasificacionesProveedoresPst[] $clasificacionesProveedoresPsts
 * @property int $id
 * @property string $nombre
 * @property string $user_create
 * @property boolean $estado
 * @property string $user_update
 * @property string $updated_at
 * @property string $created_at
 */
class Clasificacion_Proveedor extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'clasificaciones_proveedores';

    /**
     * @var array
     */
    protected $fillable = ['nombre', 'user_create', 'estado', 'user_update', 'updated_at', 'created_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function clasificacionesProveedoresPsts()
    {
        return $this->hasMany('App\ClasificacionesProveedoresPst', 'clasificaciones_proveedor_id');
    }
}
