<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Publicacione[] $publicaciones
 * @property TipoDocumentoIdioma[] $tipoDocumentoIdiomas
 * @property int $id
 * @property string $updated_at
 * @property string $user_create
 * @property string $user_update
 * @property boolean $estado
 * @property string $created_at
 */
class Tipo_Documento extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'tipo_documento';

    /**
     * @var array
     */
    protected $fillable = ['updated_at', 'user_create', 'user_update', 'estado', 'created_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function publicaciones()
    {
        return $this->hasMany('App\Publicacione');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tipoDocumentoIdiomas()
    {
        return $this->hasMany('App\Models\Tipo_Documento_Idioma', 'tipo_documento_id');
    }
}
