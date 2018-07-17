<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property GastosVisitante[] $gastosVisitantes
 * @property GastosVisitante[] $gastosVisitantes
 * @property ViajeExcursion[] $viajeExcursions
 * @property VisitantePaqueteTuristico[] $visitantePaqueteTuristicos
 * @property DivisasConIdioma[] $divisasConIdiomas
 * @property int $id
 * @property string $user_create
 * @property string $user_update
 * @property string $created_at
 * @property string $updated_at
 * @property boolean $estado
 */
class Divisa extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['user_create', 'user_update', 'created_at', 'updated_at', 'estado'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function gastosVisitantesFue()
    {
        return $this->hasMany('App\Models\Gasto_Visitante', 'divisas_fuera');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
     /*
    public function gastosVisitantes()
    {
        return $this->hasMany('App\Models\Gasto_Visitante', 'divisas_magdalena');
    }
    */
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function viajeExcursions()
    {
        return $this->hasMany('App\Models\ViajeExcursion', 'divisas_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function visitantePaqueteTuristicos()
    {
        return $this->hasMany('App\Models\VisitantePaqueteTuristico', 'divisas_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function divisasConIdiomas()
    {
        return $this->hasMany('App\Models\Divisa_Con_Idioma', 'divisas_id');
    }
}
