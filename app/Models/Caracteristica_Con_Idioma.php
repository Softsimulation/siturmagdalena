<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Caracteristica $caracteristica
 * @property Idioma $idioma
 * @property int $id
 * @property int $caracteristicas_id
 * @property int $idiomas_id
 * @property string $nombre
 */
class Caracteristica_Con_Idioma extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'caracteristicas_con_idiomas';

    /**
     * @var array
     */
    protected $fillable = ['caracteristicas_id', 'idiomas_id', 'nombre'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function caracteristica()
    {
        return $this->belongsTo('App\Caracteristica', 'caracteristicas_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function idioma()
    {
        return $this->belongsTo('App\Idioma', 'idiomas_id');
    }
}
