<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Hogare $hogare
 * @property NivelEducacion $nivelEducacion
 * @property MotivoNoViaje[] $motivoNoViajes
 * @property Viaje[] $viajes
 * @property int $id
 * @property int $hogar_id
 * @property int $nivel_educacion
 * @property string $nombre
 * @property boolean $jefe_hogar
 * @property boolean $sexo
 * @property int $edad
 * @property string $celular
 * @property string $email
 * @property boolean $es_viajero
 */
class Persona extends Model
{
    public $timestamps=false;
    /**
     * @var array
     */
    protected $fillable = ['hogar_id', 'nivel_educacion', 'nombre', 'jefe_hogar', 'sexo', 'edad', 'celular', 'email', 'es_viajero'];

    
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function hogare()
    {
        return $this->belongsTo('App\Models\Hogar', 'hogar_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function nivelEducacion()
    {
        return $this->belongsTo('App\NivelEducacion', 'nivel_educacion');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function motivoNoViajes()
    {
        return $this->hasMany('App\Models\No_Viajero', 'persona_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function viajes()
    {
        return $this->hasMany('App\Models\Viaje', 'personas_id');
    }
    
    
}
