<?php

namespace App;

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
        return $this->hasMany('App\PersonasDestinoConViajesTurismo', 'viajes_turismos_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function planesSantamartum()
    {
        return $this->hasOne('App\PlanesSantamartum', 'viajes_turismos_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function serviciosAgencias()
    {
        return $this->belongsToMany('App\ServiciosAgencia', 'servicios_agencias_has_viaje_turismo', 'viaje_turismo_id', 'servicios_agencias_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function viajesTurismosOtro()
    {
        return $this->hasOne('App\ViajesTurismosOtro', 'viajes_turismo_id');
    }
}
