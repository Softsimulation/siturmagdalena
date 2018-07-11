<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property BeneficiosEconomicosTemporadaPst[] $beneficiosEconomicosTemporadaPsts
 * @property BeneficiosSocioculturale[] $beneficiosSocioculturales
 * @property int $id
 * @property string $nombre
 * @property boolean $tipo_temporada
 * @property boolean $tipo_beneficio
 * @property string $user_update
 * @property string $updated_at
 * @property string $created_at
 * @property string $user_create
 * @property boolean $estado
 */
class Beneficio extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['nombre', 'tipo_temporada', 'tipo_beneficio', 'user_update', 'updated_at', 'created_at', 'user_create', 'estado'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function beneficiosEconomicosTemporadaPsts()
    {
        return $this->hasMany('App\BeneficiosEconomicosTemporadaPst');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function beneficiosSocioculturales()
    {
        return $this->hasMany('App\BeneficiosSocioculturale');
    }
}
