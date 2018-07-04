<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property EsquemasPst[] $esquemasPsts
 * @property int $id
 * @property string $nombre
 * @property string $user_update
 * @property boolean $estado
 * @property string $created_at
 * @property string $user_create
 * @property string $updated_at
 */
class Esquema_Accesible extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'esquemas_accesibles';

    /**
     * @var array
     */
    protected $fillable = ['nombre', 'user_update', 'estado', 'created_at', 'user_create', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function esquemasPsts()
    {
        return $this->hasMany('App\EsquemasPst');
    }
}
