<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property ActividadesRealizada $actividadesRealizada
 * @property OpcionesActividadesRealizadasIdioma[] $opcionesActividadesRealizadasIdiomas
 * @property SubOpcionesActividadesRealizada[] $subOpcionesActividadesRealizadas
 * @property Visitante[] $visitantes
 * @property Visitante[] $visitantes
 * @property int $id
 * @property int $actividad_realizada_id
 * @property string $user_update
 * @property string $user_create
 * @property string $updated_at
 * @property string $created_at
 * @property boolean $estado
 */
class Opcion_Actividad_Realizada extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'opciones_actividades_realizadas';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['actividad_realizada_id', 'user_update', 'user_create', 'updated_at', 'created_at', 'estado'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function actividadesRealizada()
    {
        return $this->belongsTo('App\Models\Actividad_Realizada', 'actividad_realizada_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function opcionesActividadesRealizadasIdiomas()
    {
        return $this->hasMany('App\Models\Opcion_Actividad_Realizada_Con_Idioma', 'opciones_actividad_realizada_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function visitantes()
    {
        return $this->belongsToMany('App\Visitante', 'opciones_actividades_realizadas_por_visitantes', 'opciones_activades_realizada_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    
}
