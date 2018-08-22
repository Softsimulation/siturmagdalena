<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property MultimediaRuta[] $multimediaRutas
 * @property RutasConAtraccione[] $rutasConAtracciones
 * @property RutasConIdioma[] $rutasConIdiomas
 * @property int $id
 * @property string $user_update
 * @property boolean $estado
 * @property string $created_at
 * @property string $updated_at
 * @property string $user_create
 * @property string $portada
 */
class Ruta extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['user_update', 'estado', 'created_at', 'updated_at', 'user_create', 'portada'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function multimediaRutas()
    {
        return $this->hasMany('App\Models\Multimedia_Ruta');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rutasConAtracciones()
    {
        return $this->hasMany('App\Models\Ruta_Con_Atraccion');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rutasConIdiomas()
    {
        return $this->hasMany('App\Models\Ruta_Con_Idioma');
    }
}
