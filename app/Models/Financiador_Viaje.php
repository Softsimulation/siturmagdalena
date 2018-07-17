<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Viaje[] $viajes
 * @property Visitante[] $visitantes
 * @property FinanciadoresViajesConIdioma[] $financiadoresViajesConIdiomas
 * @property int $id
 * @property string $user_create
 * @property string $user_update
 * @property string $created_at
 * @property string $updated_at
 * @property boolean $estado
 */
class Financiador_Viaje extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'financiadores_viajes';

    /**
     * @var array
     */
    protected $fillable = ['user_create', 'user_update', 'created_at', 'updated_at', 'estado'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function viajes()
    {
        return $this->belongsToMany('App\Models\Viaje', 'viajes_financiadores', 'financiadores_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function visitantes()
    {
        return $this->belongsToMany('App\Models\Visitante', 'visitante_gastos_pagados', 'financiadores_viajes_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function financiadoresViajesConIdiomas()
    {
        return $this->hasMany('App\Models\Financiador_Viaje_Con_Idioma', 'financiadores_viaje_id');
    }
}
