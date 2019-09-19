<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property FuentesInformacionAntesViaje $fuentesInformacionAntesViaje
 * @property int $id
 * @property int $fuentes_informacion_antes_viaje_id
 * @property string $nombre
 * @property int $idiomas_id
 */
class Fuente_Informacion_Antes_Viaje_Con_Idioma extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'fuente_informacion_antes_viaje_con_idiomas';

    /**
     * @var array
     */
    protected $fillable = ['fuentes_informacion_antes_viaje_id', 'nombre', 'idiomas_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function fuentesInformacionAntesViaje()
    {
        return $this->belongsTo('App\Models\Fuente_Informacion_Antes_Viaje','fuentes_informacion_antes_viaje_id');
    }
    public function idioma()
    {
        return $this->belongsTo('App\Models\Idioma','idiomas_id');
    }
    
    
}
