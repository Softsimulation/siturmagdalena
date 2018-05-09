<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Visitante[] $visitantes
 * @property Visitante[] $visitantes
 * @property TiposTransporteConIdioma[] $tiposTransporteConIdiomas
 * @property Viaje[] $viajes
 * @property int $id
 * @property string $user_update
 * @property string $created_at
 * @property string $updated_at
 * @property boolean $estado
 * @property string $user_create
 */
class Tipo_Transporte extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'tipos_transporte';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    protected $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['user_update', 'created_at', 'updated_at', 'estado', 'user_create'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function visitantes()
    {
        return $this->hasMany('App\Visitante', 'transporte_interno');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function visitantes()
    {
        return $this->hasMany('App\Visitante', 'transporte_llegada');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tiposTransporteConIdiomas()
    {
        return $this->hasMany('App\TiposTransporteConIdioma');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function viajes()
    {
        return $this->hasMany('App\Viaje', 'tipo_transporte_id');
    }
}
