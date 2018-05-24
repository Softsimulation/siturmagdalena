<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Viaje[] $viajes
 * @property Visitante[] $visitantes
 * @property FuenteInformacionAntesViajeConIdioma[] $fuenteInformacionAntesViajeConIdiomas
 * @property int $id
 * @property string $user_create
 * @property string $user_update
 * @property string $created_at
 * @property string $updated_at
 * @property boolean $estado
 */
class Fuente_Informacion_Antes_Viaje extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'fuentes_informacion_antes_viaje';

    /**
     * @var array
     */
    protected $fillable = ['user_create', 'user_update', 'created_at', 'updated_at', 'estado'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function viajes()
    {
        return $this->belongsToMany('App\Viaje', 'fuentes_informacion_antes_viajes_interno', 'fuentes_informacion_antes_id', 'viajes_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function visitantes()
    {
        return $this->belongsToMany('App\Visitante', 'informacion_visitante_antes_viaje', 'fuentes_informacion_antes_viaje');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function fuenteInformacionAntesViajeConIdiomas()
    {
        return $this->hasMany('App\Models\Fuente_Informacion_Antes_Viaje_Con_Idioma','fuentes_informacion_antes_viaje_id');
    }
}
