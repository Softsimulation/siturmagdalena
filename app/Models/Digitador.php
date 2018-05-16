<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property AspNetUser $aspNetUser
 * @property GruposViaje[] $gruposViajes
 * @property HistorialEncuestaInterno[] $historialEncuestaInternos
 * @property Hogare[] $hogares
 * @property HistorialEncuestum[] $historialEncuestas
 * @property Visitante[] $visitantes
 * @property Visitante[] $visitantes
 * @property Viaje[] $viajes
 * @property Viaje[] $viajes
 * @property int $id
 * @property string $user_id
 * @property string $codigo
 */
class Digitador extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'digitadores';

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'codigo'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function aspNetUser()
    {
        return $this->belongsTo('App\Models\AspNetUser', 'user_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function gruposViajes()
    {
        return $this->hasMany('App\GruposViaje', 'digitador_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function historialEncuestaInternos()
    {
        return $this->hasMany('App\HistorialEncuestaInterno', 'digitador_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hogares()
    {
        return $this->hasMany('App\Hogare', 'digitadores_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function historialEncuestas()
    {
        return $this->hasMany('App\HistorialEncuestum', 'usuario_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function visitantes()
    {
        return $this->hasMany('App\Visitante', 'encuestador_creada');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function visitantes2()
    {
        return $this->hasMany('App\Visitante', 'digitada');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function viajes()
    {
        return $this->hasMany('App\Viaje', 'digitada_por');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function viajes2()
    {
        return $this->hasMany('App\Viaje', 'creada_por');
    }
}
