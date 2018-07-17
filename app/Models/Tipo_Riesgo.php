<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property CategoriasRiesgo $categoriasRiesgo
 * @property RiesgosTurismo[] $riesgosTurismos
 * @property int $id
 * @property int $categorias_riesgo_id
 * @property string $nombre
 * @property string $user_create
 * @property boolean $estado
 * @property string $updated_at
 * @property string $created_at
 * @property string $user_update
 * @property int $peso
 */
class Tipo_Riesgo extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'tipos_riesgos';

    /**
     * @var array
     */
    protected $fillable = ['categorias_riesgo_id', 'nombre', 'user_create', 'estado', 'updated_at', 'created_at', 'user_update', 'peso'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function categoriasRiesgo()
    {
        return $this->belongsTo('App\CategoriasRiesgo');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function riesgosTurismos()
    {
        return $this->hasMany('App\RiesgosTurismo');
    }
}
