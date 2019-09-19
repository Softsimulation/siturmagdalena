<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Proveedor $proveedor
 * @property int $id
 * @property int $proveedor_id
 * @property string $ruta
 * @property boolean $tipo
 * @property boolean $portada
 * @property string $user_create
 * @property string $user_update
 * @property boolean $estado
 * @property string $created_at
 * @property string $updated_at
 */
class Multimedia_Proveedor extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'multimedias_proveedores';

    /**
     * @var array
     */
    protected $fillable = ['proveedor_id', 'ruta', 'tipo', 'portada', 'user_create', 'user_update', 'estado', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function proveedor()
    {
        return $this->belongsTo('App\Modelss\Proveedor', 'proveedor_id');
    }
}
