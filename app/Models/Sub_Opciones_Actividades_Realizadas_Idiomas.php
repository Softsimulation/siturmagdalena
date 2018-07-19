<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property SubOpcionesActividadesRealizada $subOpcionesActividadesRealizada
 * @property Idioma $idioma
 * @property int $id
 * @property int $sub_opciones_actividades_realizada_id
 * @property int $idioma_id
 * @property string $nombre
 * @property string $user_update
 * @property string $user_create
 * @property string $created_at
 * @property string $updated_at
 * @property boolean $estado
 */
class Sub_Opciones_Actividades_Realizadas_Idiomas extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'sub_opciones_actividades_realizadas_idiomas';

    /**
     * @var array
     */
    protected $fillable = ['sub_opciones_actividades_realizada_id', 'idioma_id', 'nombre', 'user_update', 'user_create', 'created_at', 'updated_at', 'estado'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subOpcionesActividadesRealizada()
    {
        return $this->belongsTo('App\SubOpcionesActividadesRealizada');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function idioma()
    {
        return $this->belongsTo('App\Models\Idioma');
    }
}
