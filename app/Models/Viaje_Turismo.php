<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Encuesta $encuesta
 * @property PersonasDestinoConViajesTurismo[] $personasDestinoConViajesTurismos
 * @property PlanesSantamartum $planesSantamartum
 * @property ServiciosAgencia[] $serviciosAgencias
 * @property ViajesTurismosOtro $viajesTurismosOtro
 * @property int $id
 * @property int $encuestas_id
 * @property integer $ofreceplanes
 */
class Viaje_Turismo extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
     public $timestamps = false;
     //public $incrementing = false;
    protected $table = 'viajes_turismos';
    

    /**
     * @var array
     */
    protected $fillable = ['encuestas_id', 'ofreceplanes'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function encuesta()
    {
        return $this->belongsTo('App\Encuesta', 'encuestas_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function personasDestinoConViajesTurismos()
    {
        return $this->hasMany('App\Models\Persona_Destino_Con_Viaje_Turismo', 'viajes_turismos_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function planesSantamarta()
    {
        return $this->hasOne('App\Models\Plan_Santamarta', 'viajes_turismos_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function serviciosAgencias()
    {
        return $this->belongsToMany('App\Models\Servicio_Agencia', 'servicios_agencias_has_viaje_turismo', 'viaje_turismo_id', 'servicios_agencias_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function viajesTurismosOtro()
    {
        return $this->hasOne('App\Models\Viaje_Turismo_Otro', 'viajes_turismo_id');
    }
}
