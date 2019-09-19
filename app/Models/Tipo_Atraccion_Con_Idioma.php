<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Idioma $idioma
 * @property TipoAtraccione $tipoAtraccione
 * @property int $id
 * @property int $idiomas_id
 * @property int $tipo_atracciones_id
 * @property string $nombre
 */
class Tipo_Atraccion_Con_Idioma extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'tipo_atracciones_con_idiomas';

    /**
     * @var array
     */
    protected $fillable = ['idiomas_id', 'tipo_atracciones_id', 'nombre'];

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
    public function tipoAtraccione()
    {
        return $this->belongsTo('App\Models\Tipo_Atraccion', 'tipo_atracciones_id');
    }
}
