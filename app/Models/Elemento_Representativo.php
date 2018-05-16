<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Visitante[] $visitantes
 * @property ElementosRepresentativosConIdioma[] $elementosRepresentativosConIdiomas
 * @property int $id
 * @property string $user_create
 * @property string $user_update
 * @property string $created_at
 * @property string $updated_at
 * @property boolean $estado
 */
class Elemento_Representativo extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'elementos_representativos';

    /**
     * @var array
     */
    protected $fillable = ['user_create', 'user_update', 'created_at', 'updated_at', 'estado'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function visitantes()
    {
        return $this->belongsToMany('App\Visitante', 'elementos_representativos_favoritos', 'elementos_representativos_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function elementosRepresentativosConIdiomas()
    {
        return $this->hasMany('App\Models\Elemento_Representativo_Con_Idioma', 'elementos_representativos_id');
    }
}
