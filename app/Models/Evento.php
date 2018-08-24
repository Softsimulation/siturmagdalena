<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property TipoEvento $tipoEvento
 * @property CategoriaTurismoConEvento[] $categoriaTurismoConEventos
 * @property EventosConIdioma[] $eventosConIdiomas
 * @property AspNetUser[] $aspNetUsers
 * @property MultimediaEvento[] $multimediaEventos
 * @property PerfilesUsuariosConEvento[] $perfilesUsuariosConEventos
 * @property PlanificadorEvento[] $planificadorEventos
 * @property SitiosConEvento[] $sitiosConEventos
 * @property int $id
 * @property int $tipo_eventos_id
 * @property string $telefono
 * @property string $web
 * @property string $fecha_in
 * @property string $fecha_fin
 * @property float $valor_min
 * @property float $valor_max
 * @property boolean $estado
 * @property string $created_at
 * @property string $updated_at
 * @property string $user_create
 * @property string $user_update
 */
class Evento extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['tipo_eventos_id', 'telefono', 'web', 'fecha_in', 'fecha_fin', 'valor_min', 'valor_max', 'estado', 'created_at', 'updated_at', 'user_create', 'user_update'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tipoEvento()
    {
        return $this->belongsTo('App\Models\Tipo_Evento', 'tipo_eventos_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function categoriaTurismoConEventos()
    {
        return $this->belongsToMany('App\Models\Categoria_Turismo', 'categoria_turismo_con_eventos', 'eventos_id', 'categoria_turismo_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function eventosConIdiomas()
    {
        return $this->hasMany('App\Models\Evento_Con_Idioma', 'eventos_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function aspNetUsers()
    {
        return $this->belongsToMany('App\Models\AspNetUser', 'eventos_favoritas', 'eventos_id', 'usuario_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function multimediaEventos()
    {
        return $this->hasMany('App\Models\Multimedia_Evento', 'eventos_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function perfilesUsuariosConEventos()
    {
        return $this->belongsToMany('App\Models\Perfil_Usuario', 'perfiles_usuarios_con_eventos', 'eventos_id', 'perfiles_usuarios_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function planificadorEventos()
    {
        return $this->hasMany('App\Models\PlanificadorEvento', 'eventos_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sitiosConEventos()
    {
        return $this->belongsToMany('App\Models\Sitio', 'sitios_con_eventos', 'eventos_id', 'sitios_id');
    }
}
