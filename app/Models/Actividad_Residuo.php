<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property ActividadesResiduosPst[] $actividadesResiduosPsts
 * @property int $id
 * @property string $nombre
 * @property boolean $estado
 * @property string $created_at
 * @property string $updated_at
 * @property string $user_create
 * @property string $user_update
 */
class Actividad_Residuo extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'actividades_residuos';

    /**
     * @var array
     */
    protected $fillable = ['nombre', 'estado', 'created_at', 'updated_at', 'user_create', 'user_update'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function actividadesResiduosPsts()
    {
        return $this->hasMany('App\ActividadesResiduosPst');
    }
}
