<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Idioma $idioma
 * @property Ruta $ruta
 * @property int $id
 * @property int $idioma_id
 * @property int $ruta_id
 * @property string $nombre
 * @property string $descripcion
 * @property string $recomendacion
 */
class Ruta_Con_Idioma extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'rutas_con_idiomas';

    /**
     * @var array
     */
    protected $fillable = ['idioma_id', 'ruta_id', 'nombre', 'descripcion', 'recomendacion'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function idioma()
    {
        return $this->belongsTo('App\Idioma');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ruta()
    {
        return $this->belongsTo('App\Ruta');
    }
}
