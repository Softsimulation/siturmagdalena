<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property HabitacionesDiscapacidade[] $habitacionesDiscapacidades
 * @property int $id
 * @property string $nombre
 * @property string $user_update
 * @property boolean $estado
 * @property string $created_at
 * @property string $user_create
 * @property string $updated_at
 */
class Tipo_Discapacidad extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'tipos_discapacidades';

    /**
     * @var array
     */
    protected $fillable = ['nombre', 'user_update', 'estado', 'created_at', 'user_create', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function habitacionesDiscapacidades()
    {
        return $this->hasMany('App\HabitacionesDiscapacidade', 'tipos_discapacidad_id');
    }
}
