<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property ActividadesRealizada $actividadesRealizada
 * @property SubOpcionesActividadesRealizadasInterno[] $subOpcionesActividadesRealizadasInternos
 * @property Viaje[] $viajes
 * @property int $id
 * @property int $actividad_realizada_id
 * @property string $nombre
 * @property string $user_update
 * @property string $updated_at
 * @property string $user_create
 * @property boolean $estado
 * @property string $created_at
 */
class Opcion_Actividad_Realizada_Interno extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'opciones_actividades_realizadas_interno';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['actividad_realizada_id', 'nombre', 'user_update', 'updated_at', 'user_create', 'estado', 'created_at'];

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
    public function subOpcionesActividadesRealizadasInternos()
    {
        return $this->hasMany('App\Models\Sub_Opcion_Actividad_Realizada_Interno', 'opciones_actividades_realizada_interno_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function viajes()
    {
        return $this->belongsToMany('App\Models\Viaje', 'opciones_actividades_realizada_viajero');
    }
}
