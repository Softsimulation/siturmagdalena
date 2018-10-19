<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property CalificacionExperienciaInterno[] $calificacionExperienciaInternos
 * @property int $id
 * @property string $valor
 * @property string $user_create
 * @property string $user_update
 * @property string $created_at
 * @property string $updated_at
 * @property boolean $estado
 */
class Valor_Calificacion extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'valor_calificacion';

    /**
     * @var array
     */
    protected $fillable = ['valor', 'user_create', 'user_update', 'created_at', 'updated_at', 'estado'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function calificacionExperienciaInternos()
    {
        return $this->hasMany('App\CalificacionExperienciaInterno');
    }
}
