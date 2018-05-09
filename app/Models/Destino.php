<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property TipoDestino $tipoDestino
 * @property ComentariosDestino[] $comentariosDestinos
 * @property DestinoConIdioma[] $destinoConIdiomas
 * @property MultimediaDestino[] $multimediaDestinos
 * @property Sectore[] $sectores
 * @property DatoRnt[] $datoRnts
 * @property int $id
 * @property int $tipo_destino_id
 * @property string $latitud
 * @property string $longitud
 * @property float $calificacion_legusto
 * @property float $calificacion_llegar
 * @property float $calificacion_recomendar
 * @property float $calificacion_volveria
 * @property string $user_update
 * @property boolean $estado
 * @property string $created_at
 * @property string $updated_at
 * @property string $user_create
 */
class Destino extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'destino';

    /**
     * @var array
     */
    protected $fillable = ['tipo_destino_id', 'latitud', 'longitud', 'calificacion_legusto', 'calificacion_llegar', 'calificacion_recomendar', 'calificacion_volveria', 'user_update', 'estado', 'created_at', 'updated_at', 'user_create'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tipoDestino()
    {
        return $this->belongsTo('App\TipoDestino');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comentariosDestinos()
    {
        return $this->hasMany('App\ComentariosDestino', 'destinos_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function destinoConIdiomas()
    {
        return $this->hasMany('App\DestinoConIdioma');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function multimediaDestinos()
    {
        return $this->hasMany('App\MultimediaDestino');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sectores()
    {
        return $this->hasMany('App\Sectore');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function datoRnts()
    {
        return $this->hasMany('App\DatoRnt');
    }
}
