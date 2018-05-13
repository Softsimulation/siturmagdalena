<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Idioma $idioma
 * @property VolveriaVisitar $volveriaVisitar
 * @property int $id
 * @property int $idiomas_id
 * @property int $volveria_visitar_id
 * @property string $nombre
 */
class Volveria_Visitar_Con_Idioma extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'volveria_visitar_con_idiomas';

    /**
     * @var array
     */
    protected $fillable = ['idiomas_id', 'volveria_visitar_id', 'nombre'];

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
    public function volveriaVisitar()
    {
        return $this->belongsTo('App\VolveriaVisitar');
    }
}
