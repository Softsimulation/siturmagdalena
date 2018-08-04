<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Idioma $idioma
 * @property TipoEvento $tipoEvento
 * @property int $id
 * @property int $idiomas_id
 * @property int $tipo_evento_id
 * @property string $nombre
 */
class Tipo_Evento_Con_Idioma extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'tipo_eventos_con_idiomas';

    /**
     * @var array
     */
    protected $fillable = ['idiomas_id', 'tipo_evento_id', 'nombre'];

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
    public function tipoEvento()
    {
        return $this->belongsTo('App\Models\Tipo_Evento');
    }
}
