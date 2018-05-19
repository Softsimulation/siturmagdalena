<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property ViajeExcursion[] $viajeExcursions
 * @property int $id
 * @property string $nombre
 * @property boolean $estado
 * @property string $user_create
 * @property string $user_update
 * @property string $created_at
 * @property string $updated_at
 */
class Ubicacion_Agencia_Viaje extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'ubicacion_agencia_viajes';

    /**
     * @var array
     */
    protected $fillable = ['nombre', 'estado', 'user_create', 'user_update', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function viajeExcursions()
    {
        return $this->belongsToMany('App\ViajeExcursion', 'lugar_agencia_viaje', 'ubicacion_agencia_viajes_id');
    }
}
