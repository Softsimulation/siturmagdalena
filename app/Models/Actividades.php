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
class Actividades extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['calificacion_legusto', 'calificacion_llegar', 'calificacion_recomendar', 'calificacion_volveria', 'valor_min', 'valor_max', 'estado', 'created_at', 'updated_at', 'user_create', 'user_update'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function categoriaTurismoConActividades()
    {
        return $this->hasMany('App\Models\Categoria_Turismo_Con_Actividad', 'actividades_id');
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
    
    public function multimedia()
    {
        return $this->multimediasActividades();
    }
    
    public function getPortadaAttribute()
    {
        return $this->multimedia()->where('portada',true)->first();
        
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function perfilesUsuariosConActividades()
    {
        return $this->hasMany('App\PerfilesUsuariosConActividade', 'actividades_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function sitiosConActividades()
    {
        return $this->belongsToMany('App\Models\Sitio', 'sitios_con_actividades', 'actividades_id', 'sitios_id');
    }
    
    
    public function destino()
    {
        return $this->sitiosConActividades();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function actividadesConIdiomas()
    {
        return $this->hasMany('App\Models\Actividad_Con_Idioma', 'actividades_id');
    }
    
    public function langContent()
    {
        return $this->actividadesConIdiomas();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function aspNetUsers()
    {
        return $this->belongsToMany('App\Models\AspNetUser', 'actividades_favoritas', 'actividades_id', 'usuario_id');
    }
    
    public function esFavorito()
    {
        return $this->aspNetUsers();
    }
    
    public function getEsfavoritoAttribute()
    {
        return count($this->esFavorito()->get());
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
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function actividadesProveedores()
    {
        return $this->belongsToMany('App\Models\Actividades', 'actividades_proveedores', 'actividad_id', 'proveedor_id');
    }
}
