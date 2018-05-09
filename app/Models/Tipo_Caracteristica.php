<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property TipoProveedore $tipoProveedore
 * @property Caracteristica[] $caracteristicas
 * @property TipoCaracteristicaConIdioma[] $tipoCaracteristicaConIdiomas
 * @property int $id
 * @property int $tipo_proveedor_id
 * @property string $user_create
 * @property string $user_update
 * @property boolean $estado
 * @property string $created_at
 * @property string $updated_at
 */
class Tipo_Caracteristica extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'tipo_caracteristica';

    /**
     * @var array
     */
    protected $fillable = ['tipo_proveedor_id', 'user_create', 'user_update', 'estado', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tipoProveedore()
    {
        return $this->belongsTo('App\TipoProveedore', 'tipo_proveedor_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function caracteristicas()
    {
        return $this->hasMany('App\Caracteristica');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tipoCaracteristicaConIdiomas()
    {
        return $this->hasMany('App\TipoCaracteristicaConIdioma');
    }
}
