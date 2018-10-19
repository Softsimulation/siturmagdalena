<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property ViajesGastosInterno[] $viajesGastosInternos
 * @property int $id
 * @property string $nombre
 * @property boolean $estado
 * @property string $user_create
 * @property string $user_update
 * @property string $created_at
 * @property string $updated_at
 */
class Rubro_Interno extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'rubro_interno';

    /**
     * @var array
     */
    protected $fillable = ['nombre', 'estado', 'user_create', 'user_update', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function viajesGastosInternos()
    {
        return $this->hasMany('App\Models\Viaje_Gasto_Interno', 'rubros_id');
    }
}
