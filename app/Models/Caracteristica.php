<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property TipoCaracteristica $tipoCaracteristica
 * @property ProveedoresCaracteristica[] $proveedoresCaracteristicas
 * @property CaracteristicasConIdioma[] $caracteristicasConIdiomas
 * @property int $id
 * @property int $tipo_caracteristica_id
 * @property string $user_update
 * @property boolean $estado
 * @property string $created_at
 * @property string $updated_at
 * @property string $user_create
 */
class Caracteristica extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['tipo_caracteristica_id', 'user_update', 'estado', 'created_at', 'updated_at', 'user_create'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tipoCaracteristica()
    {
        return $this->belongsTo('App\TipoCaracteristica');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function proveedoresCaracteristicas()
    {
        return $this->hasMany('App\ProveedoresCaracteristica', 'caracteristicas_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function caracteristicasConIdiomas()
    {
        return $this->hasMany('App\CaracteristicasConIdioma', 'caracteristicas_id');
    }
}
