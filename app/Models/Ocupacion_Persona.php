<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Visitante[] $visitantes
 * @property int $id
 * @property string $nombre
 * @property string $created_at
 * @property string $updated_at
 * @property string $user_create
 * @property string $user_update
 * @property boolean $estado
 */
class Ocupacion_Persona extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'ocupaciones_personas';

    /**
     * @var array
     */
    protected $fillable = ['nombre', 'created_at', 'updated_at', 'user_create', 'user_update', 'estado'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function visitantes()
    {
        return $this->hasMany('App\Visitante', 'ocupacion_persona_id');
    }
}
