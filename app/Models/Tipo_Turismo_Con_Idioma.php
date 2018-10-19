<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Idioma $idioma
 * @property TipoTurismo $tipoTurismo
 * @property int $id
 * @property int $idiomas_id
 * @property int $tipo_turismo_id
 * @property string $nombre
 */
class Tipo_Turismo_Con_Idioma extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'tipo_turismo_con_idiomas';

    /**
     * @var array
     */
    protected $fillable = ['idiomas_id', 'tipo_turismo_id', 'nombre'];

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
    public function tipoTurismo()
    {
        return $this->belongsTo('App\Models\Tipo_Turismo', 'tipo_turismo_id');
    }
}
