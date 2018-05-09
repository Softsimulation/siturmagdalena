<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Evento $evento
 * @property Sitio $sitio
 * @property int $id
 * @property int $eventos_id
 * @property int $sitios_id
 */
class Sitio_Con_Evento extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'sitios_con_eventos';

    /**
     * @var array
     */
    protected $fillable = ['eventos_id', 'sitios_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function evento()
    {
        return $this->belongsTo('App\Evento', 'eventos_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sitio()
    {
        return $this->belongsTo('App\Sitio', 'sitios_id');
    }
}
