<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Idioma $idioma
 * @property Rubro $rubro
 * @property int $id
 * @property int $idiomas_id
 * @property int $rubros_id
 * @property string $nombre
 */
class Rubro_Con_Idioma extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'rubros_con_idiomas';

    /**
     * @var array
     */
    protected $fillable = ['idiomas_id', 'rubros_id', 'nombre'];

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
    public function rubro()
    {
        return $this->belongsTo('App\Models\Rubro', 'rubros_id');
    }
}
