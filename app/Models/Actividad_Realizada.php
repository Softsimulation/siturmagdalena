<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property TipoAtraccione[] $tipoAtracciones
 * @property ActividadesRealizadasInterno[] $actividadesRealizadasInternos
 * @property ActividadesRealizadasPorVisitante[] $actividadesRealizadasPorVisitantes
 * @property ActividadesRealizadasConIdioma[] $actividadesRealizadasConIdiomas
 * @property Actividade[] $actividades
 * @property int $id
 * @property string $user_update
 * @property string $created_at
 * @property string $updated_at
 * @property boolean $estado
 * @property string $user_create
 */
class Actividad_Realizada extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'actividades_realizadas';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['user_update', 'created_at', 'updated_at', 'estado', 'user_create'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tipoAtracciones()
    {
        return $this->belongsToMany('App\TipoAtraccione', 'actividades_realizadas_atraccion', 'actividades_realizadas_id', 'tipo_atraccion_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function actividadesRealizadasInternos()
    {
        return $this->hasMany('App\Models\ActividadesRealizadasInterno', 'actividades_realizadas_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function actividadesRealizadasPorVisitantes()
    {
        return $this->hasMany('App\ActividadesRealizadasPorVisitante', 'actividades_realizadas_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function actividadesRealizadasConIdiomas()
    {
        return $this->hasMany('App\Models\Actividad_Realizada_Con_Idioma', 'actividad_realizada_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function actividades()
    {
        return $this->belongsToMany('App\Actividade', 'actividades_realizadas_con_actividades', 'actividades_realizadas_id', 'actividad_id');
    }
    
    public function opciones()
    {
        return $this->hasMany('App\Models\Opcion_Actividad_Realizada', 'actividad_realizada_id');
    }
    
}
