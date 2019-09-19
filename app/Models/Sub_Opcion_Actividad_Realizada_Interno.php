<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property OpcionesActividadesRealizadasInterno $opcionesActividadesRealizadasInterno
 * @property Viaje[] $viajes
 * @property int $id
 * @property int $opciones_actividades_realizada_interno_id
 * @property string $nombre
 * @property string $user_update
 * @property string $updated_at
 * @property string $created_at
 * @property boolean $estado
 * @property string $user_create
 */
class Sub_Opcion_Actividad_Realizada_Interno extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'sub_opciones_actividades_realizadas_interno';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['opciones_actividades_realizada_interno_id', 'nombre', 'user_update', 'updated_at', 'created_at', 'estado', 'user_create'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function opcionesActividadesRealizadasInterno()
    {
        return $this->belongsTo('App\Models\Opcion_Actividad_Realizada_Interno', 'opciones_actividades_realizada_interno_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function viajes()
    {
        return $this->belongsToMany('App\Models\Viaje', 'sub_opciones_act_realizadas_interno_viajes', 'sub_opciones_actividades_realizada_interno_id');
    }
}
