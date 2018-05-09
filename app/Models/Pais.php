<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Departamento[] $departamentos
 * @property PaisesConIdioma[] $paisesConIdiomas
 * @property Visitante[] $visitantes
 * @property int $id
 * @property string $user_create
 * @property string $user_update
 * @property boolean $estado
 * @property string $updated_at
 * @property string $created_at
 */
class Pais extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'paises';

    /**
     * @var array
     */
    protected $fillable = ['user_create', 'user_update', 'estado', 'updated_at', 'created_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function departamentos()
    {
        return $this->hasMany('App\Departamento', 'pais_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function paisesConIdiomas()
    {
        return $this->hasMany('App\Models\Pais_Con_Idioma', 'pais_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function visitantes()
    {
        return $this->hasMany('App\Visitante', 'pais_nacimiento');
    }
}
