<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Idioma $idioma
 * @property TiposTransporte $tiposTransporte
 * @property int $id
 * @property int $idiomas_id
 * @property int $tipos_transporte_id
 * @property string $nombre
 */
class Tipo_Transporte_Con_Idioma extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'tipos_transporte_con_idiomas';

    /**
     * @var array
     */
    protected $fillable = ['idiomas_id', 'tipos_transporte_id', 'nombre'];

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
    public function tiposTransporte()
    {
        return $this->belongsTo('App\Models\Tipo_Transporte');
    }
}
