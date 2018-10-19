<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Idioma $idioma
 * @property TipoCaracteristica $tipoCaracteristica
 * @property int $id
 * @property int $idiomas_id
 * @property int $tipo_caracteristica_id
 * @property string $nombre
 */
class Tipo_Caracteristica_Con_Idioma extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'tipo_caracteristica_con_idiomas';

    /**
     * @var array
     */
    protected $fillable = ['idiomas_id', 'tipo_caracteristica_id', 'nombre'];

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
    public function tipoCaracteristica()
    {
        return $this->belongsTo('App\TipoCaracteristica');
    }
}
