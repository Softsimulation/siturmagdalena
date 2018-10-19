<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Idioma $idioma
 * @property ServiciosPaquete $serviciosPaquete
 * @property int $id
 * @property int $idiomas_id
 * @property int $servicios_paquete_id
 * @property string $nombre
 */
class Servicio_Paquete_Con_Idioma extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'servicios_paquete_con_idiomas';

    /**
     * @var array
     */
    protected $fillable = ['idiomas_id', 'servicios_paquete_id', 'nombre'];

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
    public function serviciosPaquete()
    {
        return $this->belongsTo('App\ServiciosPaquete');
    }
}
