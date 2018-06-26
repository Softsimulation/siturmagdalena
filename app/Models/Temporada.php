<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Edificacione[] $edificaciones
 * @property int $id
 * @property string $nombre
 * @property string $name
 * @property string $user_update
 * @property string $updated_at
 * @property boolean $estado
 * @property string $created_at
 * @property string $user_create
 * @property string $fecha_ini
 * @property string $fecha_fin
 */
class Temporada extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['nombre', 'name', 'user_update', 'updated_at', 'estado', 'created_at', 'user_create', 'fecha_ini', 'fecha_fin'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function edificaciones()
    {
        return $this->hasMany('App\Edificacione');
    }
}
