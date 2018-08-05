<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Evento $evento
 * @property Idioma $idioma
 * @property int $id
 * @property int $eventos_id
 * @property int $idiomas_id
 * @property string $nombre
 * @property string $descripcion
 * @property string $horario
 * @property string $edicion
 */
class Evento_Con_Idioma extends Model
{
    /**
     * The timestamps.
     * 
     * @var bool
     */   
    public $timestamps = false;
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'eventos_con_idiomas';

    /**
     * @var array
     */
    protected $fillable = ['eventos_id', 'idiomas_id', 'nombre', 'descripcion', 'horario', 'edicion'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function evento()
    {
        return $this->belongsTo('App\Models\Evento', 'eventos_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function idioma()
    {
        return $this->belongsTo('App\Models\Idioma', 'idiomas_id');
    }
}
