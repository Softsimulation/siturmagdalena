<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property SitiosParaEncuesta $sitiosParaEncuesta
 * @property int $id
 * @property int $sitios_para_encuesta_id
 * @property string $mensaje
 * @property string $fecha
 */
class Envio_Correo_Oferta extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'envio_correos_oferta';

    /**
     * @var array
     */
    protected $fillable = ['sitios_para_encuesta_id', 'mensaje', 'fecha'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sitiosParaEncuesta()
    {
        return $this->belongsTo('App\SitiosParaEncuesta');
    }
}
