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
class Servicio_Paquete_Interno extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'servicios_paquete_interno';

    /**
     * @var array
     */
    protected $fillable = ['nombre', 'estado', 'user_create', 'user_update', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function viajeExcursions()
    {
        return $this->belongsToMany('App\ViajeExcursion', 'servicios_excursion_incluidos_interno', 'servicios_paquete_id', 'viajes_id');
    }
}
