<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Idioma $idioma
 * @property TipoDestino $tipoDestino
 * @property int $id
 * @property int $idiomas_id
 * @property int $tipo_destino_id
 * @property string $nombre
 */
class Tipo_Destino_Con_Idioma extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'tipo_destino_con_idiomas';

    /**
     * @var array
     */
    protected $fillable = ['idiomas_id', 'tipo_destino_id', 'nombre'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function idioma()
    {
        return $this->belongsTo('App\Idioma', 'idiomas_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tipoDestino()
    {
        return $this->belongsTo('App\TipoDestino');
    }
}
