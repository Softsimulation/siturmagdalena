<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property BeneficiosEconomicosTemporadaPst[] $beneficiosEconomicosTemporadaPsts
 * @property FactoresCalidadTurismo[] $factoresCalidadTurismos
 * @property BeneficiosSocioculturale[] $beneficiosSocioculturales
 * @property int $id
 * @property string $nombre
 * @property string $user_update
 * @property string $updated_at
 * @property string $created_at
 * @property string $user_create
 * @property boolean $estado
 */
class Calificacion_Factor extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'calificaciones_factores';

    /**
     * @var array
     */
    protected $fillable = ['nombre', 'user_update', 'updated_at', 'created_at', 'user_create', 'estado'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function beneficiosEconomicosTemporadaPsts()
    {
        return $this->hasMany('App\BeneficiosEconomicosTemporadaPst', 'calificacion_factores_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function factoresCalidadTurismos()
    {
        return $this->hasMany('App\FactoresCalidadTurismo', 'calificaciones_factor_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function beneficiosSocioculturales()
    {
        return $this->hasMany('App\BeneficiosSocioculturale', 'calificacion_factores_id');
    }
}
