<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Persona[] $personas
 * @property int $id
 * @property string $nombre
 * @property string $user_create
 * @property string $user_update
 * @property string $updated_at
 * @property boolean $estado
 * @property string $created_at
 */
class Nivel_Educacion extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'nivel_educacion';

    /**
     * @var array
     */
    protected $fillable = ['nombre', 'user_create', 'user_update', 'updated_at', 'estado', 'created_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function personas()
    {
        return $this->hasMany('App\Persona', 'nivel_educacion');
    }
}
