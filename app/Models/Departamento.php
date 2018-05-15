<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Paise $paise
 * @property Municipio[] $municipios
 * @property int $id
 * @property int $pais_id
 * @property string $nombre
 * @property string $updated_at
 * @property boolean $estado
 * @property string $created_at
 * @property string $user_create
 * @property string $user_update
 */
class Departamento extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['pais_id', 'nombre', 'updated_at', 'estado', 'created_at', 'user_create', 'user_update'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function paise()
    {
        return $this->belongsTo('App\Models\Paise', 'Pais');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function municipios()
    {
        return $this->hasMany('App\Models\Municipio');
    }
}
