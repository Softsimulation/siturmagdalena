<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property HNumeroEmpleado[] $hNumeroEmpleados
 * @property int $id
 * @property string $nombre
 * @property string $name
 * @property string $created_at
 * @property string $updated_at
 * @property string $user_create
 * @property string $user_update
 * @property boolean $estado
 */
class D_Destino_Proveedor extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'd_destino_proveedor';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    protected $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['nombre', 'name', 'created_at', 'updated_at', 'user_create', 'user_update', 'estado'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hNumeroEmpleados()
    {
        return $this->hasMany('App\HNumeroEmpleado', 'destino_proveedor_id');
    }
}
