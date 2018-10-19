<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property FactoresCalidad[] $factoresCalidads
 * @property int $id
 * @property string $nombre
 * @property string $user_update
 * @property string $updated_at
 * @property string $created_at
 * @property string $user_create
 * @property boolean $estado
 */
class Tipo_Factor extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'tipos_factores';

    /**
     * @var array
     */
    protected $fillable = ['nombre', 'user_update', 'updated_at', 'created_at', 'user_create', 'estado'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function factoresCalidads()
    {
        return $this->hasMany('App\FactoresCalidad', 'tipo_factor_id');
    }
}
