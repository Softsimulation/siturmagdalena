<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Idioma $idioma
 * @property OpcionesActividadesRealizada $opcionesActividadesRealizada
 * @property int $id
 * @property int $idioma_id
 * @property int $opciones_actividad_realizada_id
 * @property string $nombre
 * @property string $user_create
 * @property string $updated_at
 * @property string $created_at
 * @property boolean $estado
 * @property string $user_update
 */
class Opcion_Actividad_Realizada_Con_Idioma extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'opciones_actividades_realizadas_idiomas';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['idioma_id', 'opciones_actividad_realizada_id', 'nombre', 'user_create', 'updated_at', 'created_at', 'estado', 'user_update'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function idioma()
    {
        return $this->belongsTo('App\Models\Idioma');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function opcionesActividadesRealizada()
    {
        return $this->belongsTo('App\Models\Opcion_Actividad_Realizada', 'opciones_actividad_realizada_id');
    }
}
