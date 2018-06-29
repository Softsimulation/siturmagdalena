<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property CalificacionExperienciaInterno[] $calificacionExperienciaInternos
 * @property int $id
 * @property boolean $experiencias
 * @property string $items
 * @property string $user_create
 * @property string $user_update
 * @property string $created_at
 * @property string $updated_at
 * @property boolean $estado
 */
class Experiencia_Departamento extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'experiencias_departamento';

    /**
     * @var array
     */
    protected $fillable = ['experiencias', 'items', 'user_create', 'user_update', 'created_at', 'updated_at', 'estado'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function calificacionExperienciaInternos()
    {
        return $this->hasMany('App\CalificacionExperienciaInterno');
    }
    
    
}
