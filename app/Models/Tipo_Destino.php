<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Destino[] $destinos
 * @property TipoDestinoConIdioma[] $tipoDestinoConIdiomas
 * @property int $id
 * @property string $user_update
 * @property boolean $estado
 * @property string $created_at
 * @property string $updated_at
 * @property string $user_create
 */
class Tipo_Destino extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'tipo_destino';

    /**
     * @var array
     */
    protected $fillable = ['user_update', 'estado', 'created_at', 'updated_at', 'user_create'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function destinos()
    {
        return $this->hasMany('App\Models\Destino');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tipoDestinoConIdiomas()
    {
        return $this->hasMany('App\Models\Tipo_Destino_Con_Idioma', 'tipo_destino_id');
    }
}
