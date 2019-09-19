<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property MotivosViajeConIdioma[] $motivosViajeConIdiomas
 * @property Visitante[] $visitantes
 * @property Viaje[] $viajes
 * @property int $id
 * @property string $updated_at
 * @property boolean $estado
 * @property string $created_at
 * @property string $user_create
 * @property string $user_update
 */
class Motivo_Viaje extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'motivos_viaje';

    /**
     * @var array
     */
    protected $fillable = ['updated_at', 'estado', 'created_at', 'user_create', 'user_update'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function motivosViajeConIdiomas()
    {
        return $this->hasMany('App\Models\Motivo_Viaje_Con_Idioma', 'motivo_viaje_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function visitantes()
    {
        return $this->hasMany('App\Visitante', 'motivo_viaje');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function viajes()
    {
        return $this->hasMany('App\Models\Viaje', 'motivo_viaje_id');
    }
}
