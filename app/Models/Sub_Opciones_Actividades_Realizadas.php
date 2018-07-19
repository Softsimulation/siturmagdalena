<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property OpcionesActividadesRealizada $opcionesActividadesRealizada
 * @property SubOpcionesActividadesRealizadasIdioma[] $subOpcionesActividadesRealizadasIdiomas
 * @property Visitante[] $visitantes
 * @property int $id
 * @property int $opciones_actividades_realizada_id
 * @property string $user_create
 * @property string $updated_at
 * @property string $created_at
 * @property boolean $estado
 * @property string $user_update
 */
class Sub_Opciones_Actividades_Realizadas extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'sub_opciones_actividades_realizadas';

    /**
     * @var array
     */
    protected $fillable = ['opciones_actividades_realizada_id', 'user_create', 'updated_at', 'created_at', 'estado', 'user_update'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function opcionesActividadesRealizada()
    {
        return $this->belongsTo('App\Models\Opcion_Actividad_Realizada');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subOpcionesActividadesRealizadasIdiomas()
    {
        return $this->hasMany('App\Models\Sub_Opciones_Actividades_Realizadas_Idiomas','sub_opciones_actividades_realizada_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function visitantes()
    {
        return $this->belongsToMany('App\Models\Visitante', 'sub_opciones_actividades_realizadas_por_visitantes');
    }
}
