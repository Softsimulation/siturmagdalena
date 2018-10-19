<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Idioma $idioma
 * @property TiposAlojamiento $tiposAlojamiento
 * @property int $id
 * @property int $idiomas_id
 * @property int $tipos_alojamientos_id
 * @property string $nombre
 */
class Tipo_Alojamiento_Con_Idioma extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'tipos_alojamiento_con_idiomas';

    /**
     * @var array
     */
    protected $fillable = ['idiomas_id', 'tipos_alojamientos_id', 'nombre'];

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
    public function tiposAlojamiento()
    {
        return $this->belongsTo('App\Models\TiposAlojamiento', 'tipos_alojamientos_id');
    }
}
