<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property GastosVisitante[] $gastosVisitantes
 * @property RubrosConIdioma[] $rubrosConIdiomas
 * @property int $id
 * @property string $user_update
 * @property string $created_at
 * @property string $updated_at
 * @property boolean $estado
 * @property string $user_create
 */
class Rubro extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['user_update', 'created_at', 'updated_at', 'estado', 'user_create'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function gastosVisitantes()
    {
        return $this->hasMany('App\Models\Gasto_Visitante', 'rubros_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rubrosConIdiomas()
    {
        return $this->hasMany('App\Models\Rubro_Con_Idioma', 'rubros_id');
    }
}
