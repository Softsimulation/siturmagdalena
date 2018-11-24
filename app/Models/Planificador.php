<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property AspNetUser $aspNetUser
 * @property PlanificadorProveedore[] $planificadorProveedores
 * @property PlanificadorEvento[] $planificadorEventos
 * @property PlanificadorAtraccione[] $planificadorAtracciones
 * @property PlanificadorActividade[] $planificadorActividades
 * @property int $id
 * @property string $usuario_id
 * @property string $fecha_inicio
 * @property string $fecha_fin
 * @property string $nombre
 */
class Planificador extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'planificador';
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = ['usuario_id', 'fecha_inicio', 'fecha_fin', 'nombre'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function aspNetUser()
    {
        return $this->belongsTo('App\AspNetUser', 'usuario_id', '"Id"');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function planificadorProveedores()
    {
        return $this->hasMany('App\Models\Planificador_Proveedor');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function planificadorEventos()
    {
        return $this->hasMany('App\Models\Planificador_Evento');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function planificadorAtracciones()
    {
        return $this->hasMany('App\Models\Planificador_Atraccion');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function planificadorActividades()
    {
        return $this->hasMany('App\Models\Planificador_Actividad');
    }
}
