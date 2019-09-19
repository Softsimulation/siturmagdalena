<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property CategoriaDocumento $categoriaDocumento
 * @property Idioma $idioma
 * @property int $categoria_documento_id
 * @property int $idioma_id
 * @property string $nombre
 */
class Categoria_Documento_Idioma extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'categoria_documento_idioma';

    /**
     * @var array
     */
    protected $fillable = ['nombre'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function categoriaDocumento()
    {
        return $this->belongsTo('App\Models\Categoria_Documento');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function idioma()
    {
        return $this->belongsTo('App\Idioma');
    }
}
