<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Visitante[] $visitantes
 * @property Viaje[] $viajes
 * @property int $id
 * @property string $nombre
 * @property string $user_create
 * @property string $user_update
 * @property string $created_at
 * @property string $updated_at
 * @property boolean $estado
 */
class Redes_Sociales extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'redes_sociales';

    /**
     * @var array
     */
    protected $fillable = ['nombre', 'user_create', 'user_update', 'created_at', 'updated_at', 'estado'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function visitantes()
    {
        return $this->belongsToMany('App\Visitante', 'redes_sociales_visitante', 'redes_sociales_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function viajes()
    {
        return $this->belongsToMany('App\Viaje', 'redes_sociales_viajeros', 'redes_sociales_id', 'viajero_id');
    }
}
