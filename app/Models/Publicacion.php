<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property CategoriaDocumento $categoriaDocumento
 * @property TipoDocumento $tipoDocumento
 * @property PublicacionesIdioma[] $publicacionesIdiomas
 * @property int $id
 * @property int $categoria_doucmento_id
 * @property int $tipo_documento_id
 * @property string $autores
 * @property int $volumen
 * @property string $portada
 * @property string $ruta
 * @property string $fecha_creacion
 * @property string $fecha_publicacion
 * @property string $updated_at
 * @property string $user_create
 * @property string $user_update
 * @property boolean $estado
 * @property string $created_at
 */
class Publicacion extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'publicaciones';

    /**
     * @var array
     */
    protected $fillable = ['categoria_doucmento_id', 'tipo_documento_id', 'autores', 'volumen', 'portada', 'ruta', 'fecha_creacion', 'fecha_publicacion', 'updated_at', 'user_create', 'user_update', 'estado', 'created_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function categoriaDocumento()
    {
        return $this->belongsTo('App\CategoriaDocumento', 'categoria_doucmento_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tipoDocumento()
    {
        return $this->belongsTo('App\TipoDocumento');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function publicacionesIdiomas()
    {
        return $this->hasMany('App\PublicacionesIdioma', 'publicaciones_id');
    }
}
