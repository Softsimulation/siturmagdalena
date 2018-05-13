<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property ElementosRepresentativo $elementosRepresentativo
 * @property Idioma $idioma
 * @property int $id
 * @property int $elementos_representativos_id
 * @property int $idiomas_id
 * @property string $nombre
 */
class Elemento_Representativo_Con_Idioma extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'elementos_representativos_con_idiomas';

    /**
     * @var array
     */
    protected $fillable = ['elementos_representativos_id', 'idiomas_id', 'nombre'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function elementosRepresentativo()
    {
        return $this->belongsTo('App\ElementosRepresentativo', 'elementos_representativos_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function idioma()
    {
        return $this->belongsTo('App\Models\Idioma', 'idiomas_id');
    }
}
