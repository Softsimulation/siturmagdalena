<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property GruposViaje[] $gruposViajes
 * @property int $id
 * @property string $nombre
 * @property string $user_create
 * @property string $updated_at
 * @property boolean $estado
 * @property string $created_at
 */
class Lugar_Aplicacion_Encuesta extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'lugares_aplicacion_encuesta';

    /**
     * @var array
     */
    protected $fillable = ['nombre', 'user_create', 'updated_at', 'estado', 'created_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function gruposViajes()
    {
        return $this->hasMany('App\GruposViaje', 'lugar_aplicacion_id');
    }
}
