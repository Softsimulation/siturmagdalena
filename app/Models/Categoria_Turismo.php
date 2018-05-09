<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property TipoTurismo $tipoTurismo
 * @property CategoriaTurismoConIdioma[] $categoriaTurismoConIdiomas
 * @property CategoriaTurismoConEvento[] $categoriaTurismoConEventos
 * @property CategoriaTurismoConProveedore[] $categoriaTurismoConProveedores
 * @property CategoriaTurismoConActividade[] $categoriaTurismoConActividades
 * @property CategoriaTurismoConAtraccione[] $categoriaTurismoConAtracciones
 * @property int $id
 * @property int $tipo_turismo_id
 * @property string $user_update
 * @property boolean $estado
 * @property string $created_at
 * @property string $updated_at
 * @property string $user_create
 */
class Categoria_Turismo extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'categoria_turismo';

    /**
     * @var array
     */
    protected $fillable = ['tipo_turismo_id', 'user_update', 'estado', 'created_at', 'updated_at', 'user_create'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tipoTurismo()
    {
        return $this->belongsTo('App\TipoTurismo');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function categoriaTurismoConIdiomas()
    {
        return $this->hasMany('App\CategoriaTurismoConIdioma');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function categoriaTurismoConEventos()
    {
        return $this->hasMany('App\CategoriaTurismoConEvento');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function categoriaTurismoConProveedores()
    {
        return $this->hasMany('App\CategoriaTurismoConProveedore');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function categoriaTurismoConActividades()
    {
        return $this->hasMany('App\CategoriaTurismoConActividade');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function categoriaTurismoConAtracciones()
    {
        return $this->hasMany('App\CategoriaTurismoConAtraccione');
    }
}
