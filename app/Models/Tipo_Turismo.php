<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property CategoriaTurismo[] $categoriaTurismos
 * @property TipoTurismoConIdioma[] $tipoTurismoConIdiomas
 * @property int $id
 * @property string $user_update
 * @property boolean $estado
 * @property string $created_at
 * @property string $updated_at
 * @property string $user_create
 * @property string $icono
 * @property string $portada
 * @property string $color
 */
class Tipo_Turismo extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'tipo_turismo';

    /**
     * @var array
     */
    protected $fillable = ['user_update', 'estado', 'created_at', 'updated_at', 'user_create', 'icono', 'portada', 'color'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function categoriaTurismos()
    {
        return $this->hasMany('App\Models\CategoriaTurismo');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tipoTurismoConIdiomas()
    {
        return $this->hasMany('App\Models\Tipo_Turismo_Con_Idioma','tipo_turismo_id');
    }
}
