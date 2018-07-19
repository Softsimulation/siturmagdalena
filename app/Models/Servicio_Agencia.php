<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property ViajesTurismo[] $viajesTurismos
 * @property int $id
 * @property string $nombre
 */
class Servicio_Agencia extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'servicios_agencias';

    /**
     * @var array
     */
    protected $fillable = ['nombre'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function viajesTurismos()
    {
        return $this->belongsToMany('App\Models\ViajesTurismo', 'servicios_agencias_has_viaje_turismo', 'servicios_agencias_id', 'viaje_turismo_id');
    }
}
