<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Sitio $sitio
 * @property AtraccionesConTipo[] $atraccionesConTipos
 * @property AtraccionesConIdioma[] $atraccionesConIdiomas
 * @property Visitante[] $visitantes
 * @property AtraccionesPorTipoActividadesRealizada[] $atraccionesPorTipoActividadesRealizadas
 * @property AspNetUser[] $aspNetUsers
 * @property CategoriaTurismoConAtraccione[] $categoriaTurismoConAtracciones
 * @property ComentariosAtraccione[] $comentariosAtracciones
 * @property PerfilesUsuariosConAtraccione[] $perfilesUsuariosConAtracciones
 * @property RutasConAtraccione[] $rutasConAtracciones
 * @property PlanificadorAtraccione[] $planificadorAtracciones
 * @property int $id
 * @property int $sitios_id
 * @property string $telefono
 * @property string $sitio_web
 * @property float $valor_min
 * @property float $valor_max
 * @property float $calificacion_legusto
 * @property float $calificacion_llegar
 * @property float $calificacion_recomendar
 * @property float $calificacion_volveria
 * @property boolean $estado
 * @property string $created_at
 * @property string $updated_at
 * @property string $user_create
 * @property string $user_update
 */
class Atracciones extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['sitios_id', 'telefono', 'sitio_web', 'valor_min', 'valor_max', 'calificacion_legusto', 'calificacion_llegar', 'calificacion_recomendar', 'calificacion_volveria', 'estado', 'created_at', 'updated_at', 'user_create', 'user_update'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sitio()
    {
        return $this->belongsTo('App\Models\Sitio', 'sitios_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function atraccionesConTipos()
    {
        return $this->hasMany('App\AtraccionesConTipo', 'atracciones_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function atraccionesConIdiomas()
    {
        return $this->hasMany('App\AtraccionesConIdioma', 'atracciones_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function visitantes()
    {
        return $this->belongsToMany('App\Models\Visitante', 'atracciones_favoritas_visitante', 'atraccion_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function atraccionesPorTipoActividadesRealizadas()
    {
        return $this->hasMany('App\AtraccionesPorTipoActividadesRealizada', 'atraccion_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function aspNetUsers()
    {
        return $this->belongsToMany('App\AspNetUser', 'atracciones_favoritas', 'atracciones_id', 'usuario_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function categoriaTurismoConAtracciones()
    {
        return $this->hasMany('App\CategoriaTurismoConAtraccione', 'atracciones_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comentariosAtracciones()
    {
        return $this->hasMany('App\ComentariosAtraccione', 'atraccion_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function perfilesUsuariosConAtracciones()
    {
        return $this->hasMany('App\PerfilesUsuariosConAtraccione', 'atracciones_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rutasConAtracciones()
    {
        return $this->hasMany('App\RutasConAtraccione', 'atraccion_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function planificadorAtracciones()
    {
        return $this->hasMany('App\PlanificadorAtraccione', 'atracciones_id');
    }
}
