<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Idioma $idioma
 * @property MotivosViaje $motivosViaje
 * @property int $id
 * @property int $idiomas_id
 * @property int $motivo_viaje_id
 * @property string $nombre
 */
class Motivo_Viaje_Con_Idioma extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'motivos_viaje_con_idiomas';

    /**
     * @var array
     */
    protected $fillable = ['idiomas_id', 'motivo_viaje_id', 'nombre'];

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
    public function motivosViaje()
    {
        return $this->belongsTo('App\Models\MotivosViaje', 'motivo_viaje_id');
    }
}
