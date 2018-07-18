<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property MediosCapacitacionesEncuesta[] $mediosCapacitacionesEncuestas
 * @property int $id
 * @property string $nombre
 * @property string $created_at
 * @property string $updated_at
 * @property boolean $estado
 * @property string $user_create
 * @property string $user_update
 */
class Medio_Capacitacion extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'medios_capacitaciones';

    /**
     * @var array
     */
    protected $fillable = ['nombre', 'created_at', 'updated_at', 'estado', 'user_create', 'user_update'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mediosCapacitacionesEncuestas()
    {
        return $this->hasMany('App\Models\MediosCapacitacionesEncuesta', 'medio_capacitacion_id');
    }
}
