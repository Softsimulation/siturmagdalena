<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Viaje[] $viajes
 * @property FuentesInformacionDuranteViajeConIdioma[] $fuentesInformacionDuranteViajeConIdiomas
 * @property Visitante[] $visitantes
 * @property int $id
 * @property string $user_create
 * @property string $user_update
 * @property string $created_at
 * @property string $updated_at
 * @property boolean $estado
 */
class Fuente_Informacion_Durante_Viaje extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'fuentes_informacion_durante_viaje';

    /**
     * @var array
     */
    protected $fillable = ['user_create', 'user_update', 'created_at', 'updated_at', 'estado'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function viajes()
    {
        return $this->belongsToMany('App\Viaje', 'fuentes_informacion_durante_viajes_interno', 'fuente_informacion_durante_id', 'viajes_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function fuentesInformacionDuranteViajeConIdiomas()
    {
        return $this->hasMany('App\Models\Fuente_Informacion_Durante_Viaje_Con_Idioma', 'fuente_informacion_durante_viaje_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function visitantes()
    {
        return $this->belongsToMany('App\Visitante', 'informacion_visitante_durante_viaje', 'fuente_informacion_durante_viaje_id');
    }
}
