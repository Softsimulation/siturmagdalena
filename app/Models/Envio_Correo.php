<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Visitante $visitante
 * @property int $id
 * @property int $visitante_id
 * @property string $fecha_envio
 * @property string $mensaje
 */
class Envio_Correo extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'envios_correos';

    /**
     * @var array
     */
    protected $fillable = ['visitante_id', 'fecha_envio', 'mensaje'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function visitante()
    {
        return $this->belongsTo('App\Visitante');
    }
}
