<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property ActividadesRealizada[] $actividadesRealizadas
 * @property AtraccionesConTipo[] $atraccionesConTipos
 * @property LugaresVisitado[] $lugaresVisitados
 * @property LugaresVisitadosInterno[] $lugaresVisitadosInternos
 * @property TipoAtraccionesConIdioma[] $tipoAtraccionesConIdiomas
 * @property int $id
 * @property boolean $estado
 * @property string $created_at
 * @property string $updated_at
 * @property string $user_create
 * @property string $user_update
 */
class Tipo_Atraccion extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'tipo_atracciones';

    /**
     * @var array
     */
    protected $fillable = ['estado', 'created_at', 'updated_at', 'user_create', 'user_update'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function actividadesRealizadas()
    {
        return $this->belongsToMany('App\Models\Actividad_Realizada', 'actividades_realizadas_atraccion', 'tipo_atraccion_id', 'actividades_realizadas_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function atraccionesConTipos()
    {
        return $this->belongsToMany('App\Models\Atracciones', 'atracciones_con_tipo', 'tipo_atracciones_id', 'atracciones_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function lugaresVisitados()
    {
        return $this->hasMany('App\LugaresVisitado', 'tipo_atraccion_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function lugaresVisitadosInternos()
    {
        return $this->hasMany('App\LugaresVisitadosInterno', 'tipo_atraccion_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tipoAtraccionesConIdiomas()
    {
        return $this->hasMany('App\Models\Tipo_Atraccion_Con_Idioma', 'tipo_atracciones_id');
    }
}
