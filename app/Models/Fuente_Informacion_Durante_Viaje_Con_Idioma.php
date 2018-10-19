<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property FuentesInformacionDuranteViaje $fuentesInformacionDuranteViaje
 * @property Idioma $idioma
 * @property int $id
 * @property int $fuente_informacion_durante_viaje_id
 * @property int $idiomas_id
 * @property string $nombre
 */
class Fuente_Informacion_Durante_Viaje_Con_Idioma extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'fuentes_informacion_durante_viaje_con_idiomas';

    /**
     * @var array
     */
    protected $fillable = ['fuente_informacion_durante_viaje_id', 'idiomas_id', 'nombre'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function fuentesInformacionDuranteViaje()
    {
        return $this->belongsTo('App\Models\Fuente_Informacion_Durante_Viaje', 'fuente_informacion_durante_viaje_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function idioma()
    {
        return $this->belongsTo('App\Models\Idioma', 'idiomas_id');
    }
}
