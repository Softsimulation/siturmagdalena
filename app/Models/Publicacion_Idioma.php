<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Idioma $idioma
 * @property Publicacione $publicacione
 * @property int $publicaciones_id
 * @property int $idioma_id
 * @property string $palabrasclaves
 * @property string $nombre
 * @property string $descripcion
 */
class Publicacion_Idioma extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'publicaciones_idioma';

    /**
     * @var array
     */
    protected $fillable = ['palabrasclaves', 'nombre', 'descripcion'];

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
    public function publicacione()
    {
        return $this->belongsTo('App\Publicacione', 'publicaciones_id');
    }
}
