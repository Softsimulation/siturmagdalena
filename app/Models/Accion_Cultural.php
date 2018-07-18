<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property AccionesCulturalesPst[] $accionesCulturalesPsts
 * @property AccionesCulturaresCasa[] $accionesCulturaresCasas
 * @property int $id
 * @property string $nombre
 * @property string $created_at
 * @property string $user_create
 * @property boolean $estado
 * @property string $user_update
 * @property string $updated_at
 * @property int $peso
 */
class Accion_Cultural extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'acciones_culturales';

    /**
     * @var array
     */
    protected $fillable = ['nombre', 'created_at', 'user_create', 'estado', 'user_update', 'updated_at', 'peso'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function accionesCulturalesPsts()
    {
        return $this->hasMany('App\AccionesCulturalesPst', 'acciones_culturales_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function Casa_Sostenibilidad()
    {
        return $this->belongsToMany('App\Models\Casa_Sostenibilidad','acciones_culturares_casas','acciones_culturales_id','casas_sostenibilidad_id');
    }
}
