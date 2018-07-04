<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property MotivosResponsabilidadesPst[] $motivosResponsabilidadesPsts
 * @property int $id
 * @property string $nombre
 * @property string $created_at
 * @property string $user_create
 * @property boolean $estado
 * @property string $updated_at
 * @property string $user_update
 */
class Motivo_Responsabilidad extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'motivos_responsabilidades';

    /**
     * @var array
     */
    protected $fillable = ['nombre', 'created_at', 'user_create', 'estado', 'updated_at', 'user_update'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function motivosResponsabilidadesPsts()
    {
        return $this->hasMany('App\MotivosResponsabilidadesPst', 'motivos_responsabilidades_id');
    }
}
