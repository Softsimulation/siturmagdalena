<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property AspectosSeleccionPst[] $aspectosSeleccionPsts
 * @property int $id
 * @property string $nombre
 * @property boolean $estado
 * @property string $created_at
 * @property string $user_update
 * @property string $updated_at
 * @property string $user_create
 */
class Aspecto_Seleccion_Proveedor extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'aspectos_seleccion_proveedores';

    /**
     * @var array
     */
    protected $fillable = ['nombre', 'estado', 'created_at', 'user_update', 'updated_at', 'user_create'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function aspectosSeleccionPsts()
    {
        return $this->hasMany('App\AspectosSeleccionPst', 'aspectos_seleccion_proveedor_id');
    }
}
