<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property GruposViaje[] $gruposViajes
 * @property TiposViajeConIdioma[] $tiposViajeConIdiomas
 * @property int $id
 * @property string $updated_at
 * @property boolean $estado
 * @property string $created_at
 * @property string $user_create
 * @property string $user_update
 */
class Tipo_Viaje extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'tipos_viaje';

    /**
     * @var array
     */
    protected $fillable = ['updated_at', 'estado', 'created_at', 'user_create', 'user_update'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function gruposViajes()
    {
        return $this->hasMany('App\Models\GruposViaje', 'tipo_viaje_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tiposViajeConIdiomas()
    {
        return $this->hasMany('App\Models\Tipo_Viaje_Con_Idioma', 'tipo_viaje_id');
    }
}
