<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Evento[] $eventos
 * @property TipoEventosConIdioma[] $tipoEventosConIdiomas
 * @property int $id
 * @property string $user_update
 * @property boolean $estado
 * @property string $created_at
 * @property string $updated_at
 * @property string $user_create
 */
class Tipo_Evento extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'tipo_eventos';

    /**
     * @var array
     */
    protected $fillable = ['user_update', 'estado', 'created_at', 'updated_at', 'user_create'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function eventos()
    {
        return $this->hasMany('App\Models\Evento', 'tipo_eventos_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tipoEventosConIdiomas()
    {
        return $this->hasMany('App\Models\Tipo_Evento_Con_Idioma', 'tipo_evento_id');
    }
}
