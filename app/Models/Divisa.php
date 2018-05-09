<?php

namespace App;

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
    public function gastosVisitantes()
    {
        return $this->hasMany('App\GastosVisitante', 'divisas_fuera');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function gastosVisitantes()
    {
        return $this->hasMany('App\GastosVisitante', 'divisas_magdalena');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function viajeExcursions()
    {
        return $this->hasMany('App\ViajeExcursion', 'divisas_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function visitantePaqueteTuristicos()
    {
        return $this->hasMany('App\VisitantePaqueteTuristico', 'divisas_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function divisasConIdiomas()
    {
        return $this->hasMany('App\DivisasConIdioma', 'divisas_id');
    }
}
