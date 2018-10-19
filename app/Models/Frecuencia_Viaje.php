<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Viaje[] $viajes
 * @property int $id
 * @property string $frecuencia
 * @property string $user_create
 * @property string $user_update
 * @property string $updated_at
 * @property boolean $estado
 * @property string $created_at
 */
class Frecuencia_Viaje extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'frecuencia_viaje';

    /**
     * @var array
     */
    protected $fillable = ['frecuencia', 'user_create', 'user_update', 'updated_at', 'estado', 'created_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function viajes()
    {
        return $this->hasMany('App\Models\Viaje', 'frecuencia_id');
    }
}
