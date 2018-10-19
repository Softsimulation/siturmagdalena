<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Edificacione[] $edificaciones
 * @property int $id
 * @property string $nombre
 * @property string $user_update
 * @property string $updated_at
 * @property boolean $estado
 * @property string $created_at
 * @property string $user_create
 */
class Estrato extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['nombre', 'user_update', 'updated_at', 'estado', 'created_at', 'user_create'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function edificaciones()
    {
        return $this->hasMany('App\Edificacione');
    }
}
