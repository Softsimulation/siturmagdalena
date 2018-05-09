<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Persona[] $personas
 * @property int $id
 * @property string $nombre
 * @property string $created_at
 * @property string $user_create
 * @property string $user_update
 * @property string $updated_at
 * @property boolean $estado
 */
class Motivo_No_Viaje extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'motivo_no_viajes';

    /**
     * @var array
     */
    protected $fillable = ['nombre', 'created_at', 'user_create', 'user_update', 'updated_at', 'estado'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function personas()
    {
        return $this->belongsToMany('App\Persona', 'no_viajeros');
    }
}
