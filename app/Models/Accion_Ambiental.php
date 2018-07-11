<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property TiposAccione $tiposAccione
 * @property AccionesAmbientalesCasa[] $accionesAmbientalesCasas
 * @property int $id
 * @property int $tipo_accion_id
 * @property string $nombre
 * @property string $user_create
 * @property string $user_update
 * @property string $created_at
 * @property boolean $estado
 * @property string $updated_at
 */
class Accion_Ambiental extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'acciones_ambientales';

    /**
     * @var array
     */
    protected $fillable = ['tipo_accion_id', 'nombre', 'user_create', 'user_update', 'created_at', 'estado', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tiposAccione()
    {
        return $this->belongsTo('App\TiposAccione', 'tipo_accion_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function accionesAmbientalesCasas()
    {
        return $this->hasMany('App\AccionesAmbientalesCasa', 'acciones_ambital_id');
    }
}
