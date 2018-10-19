<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Idioma $idioma
 * @property TiposViaje $tiposViaje
 * @property int $id
 * @property int $idiomas_id
 * @property int $tipo_viaje_id
 * @property string $nombre
 */
class Tipo_Viaje_Con_Idioma extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'tipos_viaje_con_idiomas';

    /**
     * @var array
     */
    protected $fillable = ['idiomas_id', 'tipo_viaje_id', 'nombre'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function idioma()
    {
        return $this->belongsTo('App\Models\Idioma', 'idiomas_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tiposViaje()
    {
        return $this->belongsTo('App\Models\TipoViaje', 'tipo_viaje_id');
    }
}
