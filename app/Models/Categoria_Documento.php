<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Publicacione[] $publicaciones
 * @property CategoriaDocumentoIdioma[] $categoriaDocumentoIdiomas
 * @property int $id
 * @property string $user_update
 * @property string $updated_at
 * @property string $user_create
 * @property boolean $estado
 * @property string $created_at
 */
class Categoria_Documento extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'categoria_documento';

    /**
     * @var array
     */
    protected $fillable = ['user_update', 'updated_at', 'user_create', 'estado', 'created_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function publicaciones()
    {
        return $this->hasMany('App\Models\Publicacion', 'categoria_doucmento_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function categoriaDocumentoIdiomas()
    {
        return $this->hasMany('App\Models\Categoria_Documento_Idioma', 'categoria_documento_id');
    }
}
