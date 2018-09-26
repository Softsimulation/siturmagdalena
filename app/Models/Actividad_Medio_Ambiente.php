<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property ActividadesAmbientalesPst[] $actividadesAmbientalesPsts
 * @property ActividadesAmbientalesCasa[] $actividadesAmbientalesCasas
 * @property int $id
 * @property string $nombre
 * @property string $user_create
 * @property boolean $estado
 * @property string $updated_at
 * @property string $created_at
 * @property string $user_update
 */
class Actividad_Medio_Ambiente extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'actividades_medio_ambientes';

    /**
     * @var array
     */
    protected $fillable = ['es_hogar','nombre', 'user_create', 'estado', 'updated_at', 'created_at', 'user_update'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function actividadesAmbientalesPsts()
    {
        return $this->hasMany('App\ActividadesAmbientalesPst');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function actividadesAmbientalesCasas()
    {
        return $this->hasMany('App\ActividadesAmbientalesCasa');
    }
}
