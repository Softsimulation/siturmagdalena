<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property CategoriaTurismoConActividade[] $categoriaTurismoConActividades
 * @property ComentariosActividad[] $comentariosActividads
 * @property MultimediasActividade[] $multimediasActividades
 * @property PerfilesUsuariosConActividade[] $perfilesUsuariosConActividades
 * @property SitiosConActividade[] $sitiosConActividades
 * @property ActividadesConIdioma[] $actividadesConIdiomas
 * @property AspNetUser[] $aspNetUsers
 * @property ActividadesRealizada[] $actividadesRealizadas
 * @property PlanificadorActividade[] $planificadorActividades
 * @property int $id
 * @property float $calificacion_legusto
 * @property float $calificacion_llegar
 * @property float $calificacion_recomendar
 * @property float $calificacion_volveria
 * @property float $valor_min
 * @property float $valor_max
 * @property boolean $estado
 * @property string $created_at
 * @property string $updated_at
 * @property string $user_create
 * @property string $user_update
 */
class Actividad extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'actividades';

    /**
     * @var array
     */
    protected $fillable = ['calificacion_legusto', 'calificacion_llegar', 'calificacion_recomendar', 'calificacion_volveria', 'valor_min', 'valor_max', 'estado', 'created_at', 'updated_at', 'user_create', 'user_update'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function categoriaTurismoConActividades()
    {
        return $this->belongsToMany('App\Models\Categoria_Turismo', 'categoria_turismo_con_actividades', 'actividades_id', 'categoria_turismo_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comentariosActividads()
    {
        return $this->hasMany('App\ComentariosActividad', 'actividad_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function multimediasActividades()
    {
        return $this->hasMany('App\Models\Multimedia_Actividad', 'actividades_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function perfilesUsuariosConActividades()
    {
        return $this->belongsToMany('App\Models\Perfil_Usuario', 'perfiles_usuarios_con_actividades', 'actividades_id', 'perfiles_usuarios_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sitiosConActividades()
    {
        return $this->belongsToMany('App\Models\Sitio', 'sitios_con_actividades', 'actividades_id', 'sitios_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function actividadesConIdiomas()
    {
        return $this->hasMany('App\Models\Actividad_Con_Idioma', 'actividades_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function aspNetUsers()
    {
        return $this->belongsToMany('App\AspNetUser', 'actividades_favoritas', 'actividades_id', 'usuario_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function actividadesRealizadas()
    {
        return $this->belongsToMany('App\ActividadesRealizada', 'actividades_realizadas_con_actividades', 'actividad_id', 'actividades_realizadas_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function planificadorActividades()
    {
        return $this->hasMany('App\PlanificadorActividade', 'actividades_id');
    }
}
